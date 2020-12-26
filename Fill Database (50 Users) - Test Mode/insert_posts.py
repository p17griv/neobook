from connect_to_db import ini_conn_with_neo4j
import time
import random


# Send cypher query with all information for the post
def create_post(tx, owner, id, txt, img, tmstmp, likes):
    cypher_query = "MATCH (u:User) WHERE u.id = $owner\n" \
                   "CREATE (u)-[r:UPLOADS]->(p:Post {id: $id, text: $txt, imageUrl: $img, timestamp: $tmstmp, " \
                   "likesCount: $likes}) "
    tx.run(cypher_query, owner=owner, id=id, txt=txt, img=img, tmstmp=tmstmp, likes=likes)


# Get a random text from 'posts_text.txt'
def produce_post_text():
    while True:
        random_post_text = random.choice(list(open('../Data/posts_text.txt', encoding='utf8')))
        if len(random_post_text) > 1:
            return random_post_text


# Get an random image URL from the 'SBU_captioned_photo_dataset_urls.txt' or
# return '-' (post won't have an image) with 50% probability
def produce_post_image_url():
    if random.randint(0, 1) == 0:
        return random.choice(list(open('../Data/SBU_captioned_photo_dataset_urls.txt')))
    else:
        return '-'


# Generate a random timestamp from 2018 to 2020 in 'yyyy/mm/'dd hh:mm' format
def produce_post_timestamp():
    year = random.randint(2018, 2020)
    month = random.randint(1, 12)

    if month == 2:
        day = random.randint(1, 29)
    else:
        day = random.randint(1, 31)

    hour = random.randint(0, 23)
    minute = random.randint(1, 59)

    if month < 10:
        month = '0' + str(month)
    if day < 10:
        day = '0' + str(day)
    if hour < 10:
        hour = '0' + str(hour)
    if minute < 10:
        minute = '0' + str(minute)

    return str(year) + '/' + str(month) + '/' + str(day) + ' ' + str(hour) + ':' + str(minute)


if __name__ == '__main__':
    start_time = time.time()
    driver = ini_conn_with_neo4j()
    min_posts = 1
    max_posts = 4
    try:
        min_posts = int(input("Give the minimum number of users' posts: "))
        mas_posts = int(input("Give the maximum number of users' posts: "))
    except ValueError:
        print('Invalid inputs! Default values used.')

    with driver.session() as session:
        post_count = 0
        # For 50 users... - TEST MODE
        for user in range(0, 50):
            number_of_posts = random.randint(min_posts, mas_posts)  # ...generate a random number of posts

            # For each post generate random information
            for post in range(0, number_of_posts + 1):
                post_text = produce_post_text()
                post_image = produce_post_image_url()
                timestamp = produce_post_timestamp()
                likes_count = random.randint(0, 67)

                # Send query
                session.write_transaction(create_post, user, post_count, post_text, post_image, timestamp, likes_count)

                print(f'\rInserting post: {post} of user: {user} ({post_count + 1} total)', end="", flush=True)

                '''
                # Print generated information for debugging
                print(f'user: {user}\n'
                      f'\tid: {post_count}\n'
                      f'\ttext: {post_text}\n'
                      f'\timageUrl: {post_image}\n'
                      f'\ttimestamp: {timestamp}\n'
                      f'\tlikesCounter: {likes_count}')
                '''
                post_count += 1

    driver.close()
    print(f'\nElapsed: {round((time.time() - start_time) / 60, 2)} minutes')

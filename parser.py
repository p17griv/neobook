# from neo4j import GraphDatabase
import names
import random

'''
def ini_conn_with_neo4j():
    url = 'neo4j://localhost:7687'
    username = 'testuser'
    password = '123'
    return GraphDatabase.driver(url, auth=(username, password))
'''


def name_gender_age_generator():
    if random.randint(0, 1) == 0:
        return names.get_full_name(gender='male'), 'male', random.randint(18, 75)
    else:
        return names.get_full_name(gender='female'), 'female', random.randint(18, 75)


'''
def create_friend_of(tx, user1, user2):
    tx.run("CREATE (a:Person {id: $userid1 name: $user2 gender:})-[:FOLLOWS]->(f:Post {id: " "text: " " name: $user2}) ", user1=user1, user2=user2)
'''

if __name__ == '__main__':

    # driver = ini_conn_with_neo4j()

    with open('sample.txt') as txt_file:
        lines_read = 0

        for line in txt_file:
            lines_read += 1
            # print(f'\rReading: {lines_read} lines', end="", flush=True)

            try:
                user1 = int(line.split('\t')[0])
                user2 = int(line.split('\t')[1])

                print(f'{user1} follows --> {user2}')
                print(
                    f'{name_gender_age_generator()[0], name_gender_age_generator()[2]} follows --> {name_gender_age_generator()[0], name_gender_age_generator()[2]}')
                # with driver.session() as session:
                # session.write_transaction(create_friend_of, user1, user2)
            except ValueError:
                continue

    print(f'Total lines: {lines_read}')

    # driver.close()

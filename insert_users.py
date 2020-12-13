# from neo4j import GraphDatabase GG
import names
import random
import datetime
import time
import urllib.request
from urllib.request import Request

'''
def ini_conn_with_neo4j():
    url = 'neo4j://localhost:7687'
    username = 'testuser'
    password = '123'
    return GraphDatabase.driver(url, auth=(username, password))
'''


def produce_name_gender():
    if random.randint(0, 1) == 0:
        return names.get_full_name(gender='male'), 'male'
    else:
        return names.get_full_name(gender='female'), 'female'


def produce_phone_number():
    number = '69'
    for digit in range(0, 8):
        number += str(random.randint(0, 9))
    return number


def produce_birth_date():
    year = str(random.randint(1955, datetime.datetime.now().year - 18))
    month = random.randint(1, 12)

    if month < 10:
        month = '0' + str(month)
    else:
        month = str(month)

    if month == '02':
        day = random.randint(1, 29)
    else:
        day = random.randint(1, 31)

    if day < 10:
        day = '0' + str(day)
    else:
        day = str(day)

    return year + '/' + month + '/' + day


def produce_email(name, birth_date):
    providers = ['outlook', 'gmail', 'hotmail', 'yahoo']
    chars_from_name = random.randint(5, len(name))
    age = str(datetime.datetime.now().year - int(birth_date[0:4]))
    return name[:chars_from_name].lower().replace(' ', '') + age + '@' + providers[random.randint(0, 3)] + '.com'


def produce_interests():
    num_of_interests = random.randint(3, 8)

    return random.sample(list(open('Data/interests.txt')), num_of_interests)


def produce_cities():
    while True:
        random_row = random.choice(list(open('Data/world-cities.csv', encoding="utf8")))
        random_row = random_row.split(',')
        if random_row[0] != 'name':
            break
    return random_row[0], random_row[1], random_row[3]


def produce_languages():
    languages_list = ['Chinese', 'Spanish', 'Hindi', 'Arabic', 'Russian', 'Japanese', 'German', 'Portuguese', 'Italian',
                      'Turkish', 'French']
    user_languages = ['English']

    return user_languages + random.sample(languages_list, random.randint(0, 4))


def produce_profile_image_url(gnder):
    #if gnder == 'male':
        # req = Request('https://source.unsplash.com/featured/?man', headers={'User-Agent': 'Mozilla/5.0'})
        # req = Request('https://loremflickr.com/800/600/man', headers={'User-Agent': 'Mozilla/5.0'})
    #else:
        # req = Request('https://source.unsplash.com/featured/?woman', headers={'User-Agent': 'Mozilla/5.0'})
        # req = Request('https://loremflickr.com/800/600/woman', headers={'User-Agent': 'Mozilla/5.0'})
    req = Request('https://picsum.photos/800/600', headers={'User-Agent': 'Mozilla/5.0'})
    return urllib.request.urlopen(req).geturl()


'''
def create_friend_of(tx, user1, user2):
    tx.run("CREATE (a:Person {id: $userid1 name: $user2 gender:})-[:FOLLOWS]->(f:Post {id: " "text: " " name: $user2}) ", user1=user1, user2=user2)
'''

if __name__ == '__main__':
    start_time = time.time()
    # driver = ini_conn_with_neo4j()

    for user in range(0, 40):
        fullname = produce_name_gender()[0]
        gender = produce_name_gender()[1]
        phone = produce_phone_number()
        birthDate = produce_birth_date()
        email = produce_email(fullname, birthDate)
        interests = produce_interests()
        city = produce_cities()[0]
        country = produce_cities()[1]
        geonamecode = produce_cities()[2]
        languages = produce_languages()
        profileImageUrl = produce_profile_image_url(gender)

        print(f'id: {user}\n'
              f'fullname: {fullname}\n'
              f'gender: {gender}\n'
              f'phone: {phone}\n'
              f'birthDate: {birthDate}\n'
              f'email: {email}\n'
              f'interests: {interests}\n'
              f'city: {city}\n'
              f'country: {country}\n'
              f'geonamecode: {geonamecode}'
              f'languages: {languages}\n'
              f'profileImageUrl: {profileImageUrl}\n')

    '''
    print(f'{user1} follows --> {user2}')
    print(
        f'{name_gender_age_generator()[0], name_gender_age_generator()[2]} follows --> {name_gender_age_generator()[0], name_gender_age_generator()[2]}')
    # with driver.session() as session:
    # session.write_transaction(create_friend_of, user1, user2)
    '''

    # driver.close()
    print(f'Elapsed: {round((time.time() - start_time) / 60, 2)} minutes')

# from neo4j import GraphDatabase GG
import names
import random
import datetime
import time

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


'''
def create_friend_of(tx, user1, user2):
    tx.run("CREATE (a:Person {id: $userid1 name: $user2 gender:})-[:FOLLOWS]->(f:Post {id: " "text: " " name: $user2}) ", user1=user1, user2=user2)
'''

if __name__ == '__main__':
    start_time = time.time()
    # driver = ini_conn_with_neo4j()

    for user in range(0, 10000):
        print(f'id: {user}\n'
              f'fullname: {produce_name_gender()[0]}\n'
              f'gender: {produce_name_gender()[1]}\n'
              f'phone: {produce_phone_number()}\n'
              f'birthDate: {produce_birth_date()}\n')


        '''

        print(f'{user1} follows --> {user2}')
        print(
            f'{name_gender_age_generator()[0], name_gender_age_generator()[2]} follows --> {name_gender_age_generator()[0], name_gender_age_generator()[2]}')
        # with driver.session() as session:
        # session.write_transaction(create_friend_of, user1, user2)
        '''

    # driver.close()
    print(f'Elapsed: {round((time.time() - start_time) / 60, 2)} minutes')
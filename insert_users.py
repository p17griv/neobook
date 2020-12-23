from connect_to_db import ini_conn_with_neo4j
import names
import random
import datetime
import time
import hashlib


def create_user(tx, id, pwd, fn, gndr, phn, bd, eml, intrts, ct, ctr, lat, long, lng, prfimgurl):
    cypher_query = "CREATE (:User { id: $id, password: $pwd, fullname: $fn, gender: $gndr, phone: $phn, birthDate: " \
                   "$bd, email: $eml, interests: $intrts, city: $ct, country: $ctr, latitude: $lat, longitude: $long," \
                   "languages: $lng, profileImageUrl: $prfimgurl }) "
    tx.run(cypher_query, id=id, pwd=pwd, fn=fn, gndr=gndr, phn=phn, bd=bd, eml=eml, intrts=intrts, ct=ct, ctr=ctr,
           lat=lat, long=long, lng=lng, prfimgurl=prfimgurl)


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
        random_row = random.choice(list(open('Data/worldcities.csv', encoding='utf8')))
        random_row = random_row.split(',')
        if random_row[0] != 'city':
            break
    return random_row


def produce_languages():
    languages_list = ['Chinese', 'Spanish', 'Hindi', 'Arabic', 'Russian', 'Japanese', 'German', 'Portuguese', 'Italian',
                      'Turkish', 'French']
    user_languages = ['English']

    return user_languages + random.sample(languages_list, random.randint(0, 4))


def produce_profile_image_url(gnder):
    if gnder == 'male':
        return random.choice(list(open('Data/men_urls_unique.txt', encoding='utf8'))[1:])
    else:
        return random.choice(list(open('Data/women_urls_unique.txt', encoding='utf8'))[1:])


if __name__ == '__main__':
    start_time = time.time()
    driver = ini_conn_with_neo4j()

    with driver.session() as session:

        for user in range(0, 50):
            password = hashlib.sha256(str(user).encode()).hexdigest()
            fullname = produce_name_gender()[0]
            gender = produce_name_gender()[1]
            phone = produce_phone_number()
            birthDate = produce_birth_date()
            email = produce_email(fullname, birthDate)
            interests = produce_interests()
            random_place = produce_cities()
            city = random_place[1]
            country = random_place[4]
            latitude = random_place[2]
            longitude = random_place[3]
            languages = produce_languages()
            profileImageUrl = produce_profile_image_url(gender)

            session.write_transaction(create_user, user, password, fullname, gender, phone, birthDate, email, interests, city,
                                      country, latitude, longitude, languages, profileImageUrl)
            print(f'\rInserting user: {user}', end="", flush=True)

            '''
            print(f'id: {user}\n'
                  f'password: {password}\n'
                  f'fullname: {fullname}\n'
                  f'gender: {gender}\n'
                  f'phone: {phone}\n'
                  f'birthDate: {birthDate}\n'
                  f'email: {email}\n'
                  f'interests: {interests}\n'
                  f'city: {city}\n'
                  f'country: {country}\n'
                  f'lat: {latitude}\n'
                  f'long: {longitude}\n'
                  f'languages: {languages}\n'
                  f'produce_profile_image_url: {profileImageUrl}')
            '''
    driver.close()
    print(f'\nElapsed: {round((time.time() - start_time) / 60, 2)} minutes')

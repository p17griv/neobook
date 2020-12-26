from connect_to_db import ini_conn_with_neo4j
import names
import random
import datetime
import time
import hashlib


# Send cypher query with all the generated information
def create_user(tx, id, pwd, fn, gndr, phn, bd, eml, intrts, ct, ctr, lat, long, lng, prfimgurl):
    cypher_query = "CREATE (:User { id: $id, password: $pwd, fullname: $fn, gender: $gndr, phone: $phn, birthDate: " \
                   "$bd, email: $eml, interests: $intrts, city: $ct, country: $ctr, latitude: $lat, longitude: $long," \
                   "languages: $lng, profileImageUrl: $prfimgurl }) "
    tx.run(cypher_query, id=id, pwd=pwd, fn=fn, gndr=gndr, phn=phn, bd=bd, eml=eml, intrts=intrts, ct=ct, ctr=ctr,
           lat=lat, long=long, lng=lng, prfimgurl=prfimgurl)


# Generate a male or a female fullname with 50% chance
def produce_name_gender():
    if random.randint(0, 1) == 0:
        return names.get_full_name(gender='male'), 'male'
    else:
        return names.get_full_name(gender='female'), 'female'


# Generate a 10-digit phone number
def produce_phone_number():
    number = '69'  # Add '69' as the first 2 digits
    for digit in range(0, 8):
        number += str(random.randint(0, 9))  # Produce randomly the last 8 digits
    return number


# Create a random birth date from 1955 to current year - 18 in 'yyyy/mm/dd' format
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


# Generate a random email address based on the given name and birthdate
def produce_email(name, birth_date):
    providers = ['outlook', 'gmail', 'hotmail', 'yahoo']
    chars_from_name = random.randint(5, len(name))
    age = str(datetime.datetime.now().year - int(birth_date[0:4]))
    return name[:chars_from_name].lower().replace(' ', '') + age + '@' + providers[random.randint(0, 3)] + '.com'


# Get a random number of random interests from 'interests.txt'
def produce_interests():
    num_of_interests = random.randint(3, 8)

    return random.sample(list(open('../Data/interests.txt')), num_of_interests)


# Get a random row (city, country, longitude, latitude) from the 'worldcities.csv' file
def produce_cities():
    while True:
        random_row = random.choice(list(open('../Data/worldcities.csv', encoding='utf8')))
        random_row = random_row.split(',')
        if random_row[0] != 'city':
            break
    return random_row


# Get a random number of random languages
def produce_languages():
    languages_list = ['Chinese', 'Spanish', 'Hindi', 'Arabic', 'Russian', 'Japanese', 'German', 'Portuguese', 'Italian',
                      'Turkish', 'French']
    user_languages = ['English']  # Add 'English' as the first language

    return user_languages + random.sample(languages_list, random.randint(0, 4))


# Get a random image URL based on the given gender
def produce_profile_image_url(gnder):
    if gnder == 'male':
        return random.choice(list(open('../Data/men_urls_unique.txt', encoding='utf8'))[1:])
    else:
        return random.choice(list(open('../Data/women_urls_unique.txt', encoding='utf8'))[1:])


if __name__ == '__main__':
    start_time = time.time()
    driver = ini_conn_with_neo4j()

    with driver.session() as session:

        #  Generate inforamtion for 200,000 users
        for user in range(0, 200000):
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
                                      country, latitude, longitude, languages, profileImageUrl)  # Send query
            print(f'\rInserting user: {user}', end="", flush=True)

            '''
            # Print generated information for debugging
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

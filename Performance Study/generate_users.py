import random
import datetime
import time
import csv


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


if __name__ == '__main__':
    total_users = input('Number of users to generate: ')
    filename = f'users_{total_users}_bulk.csv'
    start_time = time.time()

    with open('Data/firstnames.csv', encoding='utf8') as firstnames_file, \
            open('Data/surnames.csv', encoding='utf8') as lastnames_file, \
            open('Data/worldcities.csv', encoding='utf8') as cities_file, \
            open(filename, 'w', encoding='utf8') as outfile:

        # Load files to memory
        reader = csv.reader(firstnames_file)
        firstnames = list(reader)
        reader = csv.reader(lastnames_file)
        lastnames = list(reader)
        reader = csv.reader(cities_file)
        cities = list(reader)

        #  Generate information for the users
        for user in range(0, int(total_users)):
            # Get a random row (firstname) from the 'firstnames.csv' file
            random_row = random.choice(firstnames)
            firstname = random_row[1].replace('"', '')

            gender = 'female'
            if random_row[3] == 'boy':
                gender = 'male'

            # Get a random row (lastname) from the 'surnames.csv' file
            random_row = random.choice(lastnames)
            lastname = random_row[0].replace('"', '')
            lastname = lastname[:1] + lastname[1:].lower()

            fullname = firstname + ' ' + lastname
            phone = produce_phone_number()
            birthDate = produce_birth_date()
            email = produce_email(fullname, birthDate)

            # Get a random row (city, country) from the 'worldcities.csv' file
            random_row = random.choice(cities)
            city = random_row[1]
            country = random_row[4]

            if user == 0:
                outfile.write('userId:ID,fullname,gender,birthdate,email,phone,ctry,city,:LABEL\n')
            outfile.write(f'{user},"{fullname}",{gender},{birthDate},{email},{phone},"{country}","{city}",User\n')

            print(f'\rInserting user: {user}', end="", flush=True)

    minutes = round((time.time() - start_time) / 60)
    seconds = round((minutes - round((time.time() - start_time) / 60, 2)) * 60)
    if seconds < 0:
        seconds *= -1
    print(f'\nElapsed: {minutes} minutes and {seconds} seconds')

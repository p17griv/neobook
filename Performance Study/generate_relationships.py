import random
import time

if __name__ == '__main__':
    total_users = input('Number of users: ')
    num_relationships = 100  # input('Number of relationships of a user: ')
    filename = f'{num_relationships}_relationships_of_{total_users}_users_bulk.csv'
    start_time = time.time()

    with open(filename, 'w') as outfile:

        for new_user in range(0, int(total_users)):
            if new_user == 0:
                outfile.write(':START_ID,:END_ID,:TYPE\n')
            print(f'\rCurrent user: {new_user}', end="", flush=True)
            for i in range(0, int(num_relationships)):
                user2 = random.randint(0, int(total_users))  # User2: The user that is followed by new_user
                outfile.write(f"{new_user},{user2},FOLLOWS\n")

    minutes = round((time.time() - start_time) / 60)
    seconds = round((minutes - round((time.time() - start_time) / 60, 2)) * 60)
    if seconds < 0:
        seconds *= -1
    print(f'\nElapsed: {minutes} minutes and {seconds} seconds')

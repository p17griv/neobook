import random
import time

if __name__ == '__main__':
    start_time = time.time()
    with open('Data/Slashdot0902.txt', 'r+') as txt_file:
        lines_read = 0
        last_user = -1

        for line in txt_file:
            lines_read += 1
            try:
                user1 = int(line.split('\t')[0])
                if user1 > last_user:
                    last_user = user1
            except ValueError:
                continue

        for new_user in range(last_user, 200000):
            print(f'\rCurrent user: {new_user}', end="", flush=True)
            num_of_follows = random.randint(7, 17)  # Number of users new_user is going to follow
            for i in range(0, num_of_follows):
                user2 = random.randint(0, new_user - 1)  # User2: The user that is followed by new_user
                txt_file.write(f"{new_user}\t{user2}\n")

    print(f'\nTotal lines: {lines_read}')
    print(f'Elapsed: {round((time.time() - start_time) / 60, 2)} minutes')

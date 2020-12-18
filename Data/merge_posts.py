import os
import csv

post_count = 0
for filename in os.listdir(os.getcwd()):
    with open(filename, 'r') as csv_file, open('posts.txt', 'a') as result_file:
        try:
            csv_reader = csv.reader(csv_file, delimiter=',')
            line_count = 0
            for line in csv_reader:
                if line_count != 0:
                    if len(line) > 5:
                        print(f'\rWriting: {post_count + 1} posts', end="", flush=True)
                        result_file.write(line[1].replace('\n', ' '))
                        result_file.write('\n')
                        post_count += 1
                line_count += 1
        except UnicodeDecodeError:
            pass

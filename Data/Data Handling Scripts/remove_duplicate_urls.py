
file = list(open('women_urls.txt'))
file2 = open('women_urls_unique.txt','w')
urls = []
count = 0

for line in file:
    if line not in urls:
        urls.append(line)
        count += 1
        file2.write(line)
print(count)

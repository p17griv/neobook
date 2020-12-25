import urllib.request
from urllib.request import Request


men_urls = open('men_urls.txt', 'a')
women_urls = open('women_urls.txt', 'a')
count = 0
while count < 5160:
    req = Request('https://source.unsplash.com/featured/?man', headers={'User-Agent': 'Mozilla/5.0'})
    men_urls.write(f'{urllib.request.urlopen(req).geturl()}\n')
    req = Request('https://source.unsplash.com/featured/?woman', headers={'User-Agent': 'Mozilla/5.0'})
    women_urls.write(f'{urllib.request.urlopen(req).geturl()}\n')
    print(f'\rProgress: {count} / 10000', end="", flush=True)
    count += 1

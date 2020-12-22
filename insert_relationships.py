from connect_to_db import ini_conn_with_neo4j
import time


def create_relationship_of(tx, usr1, usr2):
    cypher_query = f'MATCH (u1:User) WHERE u1.id = {usr1} \n' \
                   f'MATCH (u2:User) WHERE u2.id = {usr2} \n' \
                   'CREATE (u1)-[:FOLLOWS]->(u2)'
    tx.run(cypher_query)


if __name__ == '__main__':
    start_time = time.time()
    driver = ini_conn_with_neo4j()

    with open('Data/Slashdot0902.txt') as txt_file, driver.session() as session:
        lines_read = 0

        for line in txt_file:
            lines_read += 1

            if line[0] != '#':
                user1 = line.split('\t')[0]
                user2 = line.split('\t')[1]
                if int(user1) == int(user2):
                    continue
                if user1 == '50':  # test mode
                    break
                if int(user2) > 49:  # test mode
                    continue

                print(f'\rInserting: {lines_read} relationships', end="", flush=True)
                session.write_transaction(create_relationship_of, user1, user2)
                # print(f'{user1} follows --> {user2}')

    driver.close()
    print(f'\nElapsed: {round((time.time() - start_time) / 60, 2)} minutes')

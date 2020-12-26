from connect_to_db import ini_conn_with_neo4j
import time


# Send cypher query with the users' ids to create relationships
def create_relationship_of(tx, usr1, usr2):
    cypher_query = f'MATCH (u1:User) WHERE u1.id = {usr1} \n' \
                   f'MATCH (u2:User) WHERE u2.id = {usr2} \n' \
                   'CREATE (u1)-[:FOLLOWS]->(u2)'
    tx.run(cypher_query)


if __name__ == '__main__':
    start_time = time.time()
    driver = ini_conn_with_neo4j()

    # Based on the relationships from 'Slashdot0902.txt' file
    with open('../Data/Slashdot0902.txt') as txt_file, driver.session() as session:
        lines_read = 0

        # For each relationship - line in the file
        for line in txt_file:
            lines_read += 1

            # Ignore the comments - first line
            if line[0] != '#':
                user1 = line.split('\t')[0]
                user2 = line.split('\t')[1]

                # Ignore self-follow relations
                if int(user1) == int(user2):
                    continue
                if user1 == '50':  # TEST MODE
                    break
                if int(user2) > 49:  # TEST MODE
                    continue

                print(f'\rInserting: {lines_read} relationships', end="", flush=True)
                session.write_transaction(create_relationship_of, user1, user2)  # Send the query

                '''
                # Print the relation for debugging
                print(f'{user1} follows --> {user2}')
                '''

    driver.close()
    print(f'\nElapsed: {round((time.time() - start_time) / 60, 2)} minutes')

from neo4j import GraphDatabase
import datetime


# Establish a connection to the Neo4j database
def ini_conn_with_neo4j():
    url = 'bolt://localhost:7687'
    username = 'neo4j'
    password = 'test'
    return GraphDatabase.driver(url, auth=(username, password))


def send_query(tx, choice):
    if choice == 1:
        cypher_query = 'MATCH (n:User {ctry:"United Kingdom"}) RETURN n'
    elif choice == 2:
        cypher_query = 'MATCH (n:User {ctry:"United Kingdom"})-[:FOLLOWS]->(m:User {ctry:"United Kingdom"}) RETURN n,m'
    else:
        cypher_query = 'MATCH (n:User {ctry:"United Kingdom"})-[:FOLLOWS]->' \
                       '(m:User {ctry:"United Kingdom"})-[:FOLLOWS]->' \
                       '(l:User {ctry:"United Kingdom"})-[:FOLLOWS]->(n) RETURN n,m,l'
    return tx.run(cypher_query)


if __name__ == '__main__':

    driver = ini_conn_with_neo4j()
    for query in range(0, 3):
        print(f'\nQuery: {query + 1}')

        with driver.session() as session:
            print('warming up cache...')
            for i in range(0, 3):
                if i == 0:
                    start_time = datetime.datetime.now()  # Count the time of the first run - no cache
                    result = session.write_transaction(send_query, query + 1)  # Execute query
                    end_time = datetime.datetime.now()

                    time_diff = (end_time - start_time)
                    execution_time = time_diff.total_seconds()
                    print(f'No-cache time: {round(execution_time, 5)}')
                else:
                    result = session.write_transaction(send_query, query + 1)

            times = []
            for i in range(0, 10):
                print(f'\rRun: {i + 1}', end="", flush=True)
                start_time = datetime.datetime.now()  # Start counting the time of the current run

                result = session.write_transaction(send_query, query + 1)  # Execute query

                end_time = datetime.datetime.now()

                time_diff = (end_time - start_time)
                execution_time = time_diff.total_seconds()
                # print(f'\nRun: {i+1} Time: {execution_time} seconds')
                times.append(execution_time)

        print(f'\nAverage time): {round(sum(times) / len(times), 5)}')


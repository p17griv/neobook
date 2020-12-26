from neo4j import GraphDatabase


# Establish a connection to the Neo4j database
def ini_conn_with_neo4j():
    url = 'bolt://localhost:7687'
    username = 'neo4j'
    password = 'neobook'
    return GraphDatabase.driver(url, auth=(username, password))

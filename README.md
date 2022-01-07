***

![](https://github.com/p17griv/neobook/blob/main/app/images/logo.png)

# NeoBook
#### A simple social network that uses a Neo4j graph database!

***

**NeoBook** is a student project for "Big Data" course of department of Informatics - Ionian University, made by [Pashalis Grivas](https://github.com/p17griv) and [George Gerarchakis](https://github.com/p17gera). The main goal of this project is to create a use case of [Neo4j Graph Platform](https://neo4j.com/) and demonstrate it's capabilities by building a simple Social Network Application - Website, **"NeoBook"**. Specifically, **200,000** nodes with ```User``` label and properties with dummy data and **2,360,494** relationships with  ```FOLLOWS``` label were created in order to prove Neo4j's capabilities.

Finally, a comparison of Neo4j's performance was conducted by [executing 3 different queries](https://github.com/p17griv/neobook/blob/main/Performance%20Study/query.py) of various complexities on two different systems with NeoBook's dummy data. Study's results can be found in this [Report](https://docs.google.com/viewer?url=https://raw.githubusercontent.com/p17griv/neobook/main/Performance%20Study/Report.pdf) (Greek).

## [Data Sources](https://github.com/p17griv/neobook/wiki/Data-Sources)
## [Installation Guide](https://github.com/p17griv/neobook/wiki/Installation-Guide)
## [App Functions & Cypher Queries](https://github.com/p17griv/neobook/wiki/App-Functionality-&-Cypher-Queries)
## [User Interface](https://github.com/p17griv/neobook/wiki/User-Interface)

### About [Neo4j](https://neo4j.com/)
*Neo4j is a native graph database, built from the ground up to leverage not only data but also data relationships. Neo4j connects data as it’s stored, enabling queries never before imagined, at speeds never thought possible.*

### Project Stages
1. Find a dataset with relationships between users of a social network.
2. Plan the functions of the application and the Schema of the Database.
3. Find the data sources where nodes' (users & posts) properties will get their values.
4. Write scripts (python) in order to assign information to users and posts, insert them into the database by sending the appropriate [Cypher](https://neo4j.com/developer/cypher/) queries.
5. Write scripts (python) in order to insert the relationships between users and posts into the databaseby sending the appropriate Cypher queries.
6. Create the application stracture using PHP and write the appropriate Cypher queries at the appropriate sections of the web pages.

### Documentation - References

- [Neo4j Getting Started](https://neo4j.com/docs/pdf/neo4j-getting-started-4.2.pdf)
- [Neo4j Cypher Manual](https://neo4j.com/docs/pdf/neo4j-cypher-manual-4.2.pdf)
- [Getting Started with Neo4j](https://neo4j.com/developer/get-started/)
- [Neo4j Cypher Refcard](https://neo4j.com/docs/cypher-refcard/current/)

-----------------------------------------------------

#### Database - Graph Schema:

![Db Schema](https://github.com/p17griv/neobook/blob/main/imgs/db_schema.png)

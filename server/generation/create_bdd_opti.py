import mysql.connector
import time
#  connexion bdd
hostname = "localhost" 
username = "root"  
password = "root" 


connexion = mysql.connector.connect(host=hostname,user=username,password=password)


if not connexion.is_connected():
    raise Exception("Échec de la connexion à la base de données")

# Création
database = "tower_defense" 
sql_create_db = f"CREATE DATABASE IF NOT EXISTS {database}"
cursor = connexion.cursor()
cursor.execute(sql_create_db)
print("Base de données créée avec succès !")

# Sélection bdd crée
connexion.database = database

# ____________________TABLES_________________________________________
tables = {
    "user": """CREATE TABLE IF NOT EXISTS users (
        ID_user INT AUTO_INCREMENT PRIMARY KEY,
        user_name VARCHAR(255),
        mdp VARCHAR(255),
        email VARCHAR(255),
        tel VARCHAR(20),
        photo_profil VARCHAR(255)
    )""",
    "partie_lambda": """CREATE TABLE IF NOT EXISTS partie_lambda (
        ID_partie INT AUTO_INCREMENT PRIMARY KEY,
        ID_user INT,
        parties_jouees INT,
        nombre_vagues_totales INT,
        nombre_monstre_total INT,
        monstres_tues_individuel INT,
        temps_total_partie INT,
        tours_construites_total INT,
        tours_individuel_total INT,
        tune_totale INT,
        score INT,
        duree_jeu INT,
        win BOOLEAN,
        FOREIGN KEY (ID_user) REFERENCES users(ID_user)
    )""",
    "historique_générale": """CREATE TABLE IF NOT EXISTS historique_générale (
        ID_historique INT AUTO_INCREMENT PRIMARY KEY,
        ID_partie INT,
        ID_user INT,
        FOREIGN KEY (ID_partie) REFERENCES partie_lambda(ID_partie),
        FOREIGN KEY (ID_user) REFERENCES users(ID_user)
    )""",
    "statistiques_user": """CREATE TABLE IF NOT EXISTS statistiques_user (
        ID_statistique INT AUTO_INCREMENT PRIMARY KEY,
        ID_user INT,
        moyenne_parties_jouees DECIMAL(10, 2),
        moyenne_nombre_vagues_totales DECIMAL(10, 2),
        moyenne_nombre_monstre_total DECIMAL(10, 2),
        moyenne_monstres_tues_individuel DECIMAL(10, 2),
        moyenne_temps_total_partie DECIMAL(10, 2),
        moyenne_tours_construites_total DECIMAL(10, 2),
        moyenne_tours_individuel_total DECIMAL(10, 2),
        moyenne_tune_totale DECIMAL(10, 2),
        moyenne_score DECIMAL(10, 2),
        moyenne_duree_jeu DECIMAL(10, 2),
        moyenne_win DECIMAL(10, 2),
        FOREIGN KEY (ID_user) REFERENCES users(ID_user)
    )""",
    "forum": """CREATE TABLE IF NOT EXISTS forum (
        ID_forum INT AUTO_INCREMENT PRIMARY KEY,
        Forum_titre VARCHAR(255)
    )""",
    "post": """CREATE TABLE IF NOT EXISTS post (
        ID_post INT AUTO_INCREMENT PRIMARY KEY,
        ID_user INT,
        ID_forum INT,
        Post VARCHAR(255),
        titre VARCHAR(255),
        Timestamp TIMESTAMP,
        FOREIGN KEY (ID_user) REFERENCES users(ID_user),
        FOREIGN KEY (ID_forum) REFERENCES forum(ID_forum)
    )""",
    "commentaire": """CREATE TABLE IF NOT EXISTS commentaire (
        ID_commentaire INT AUTO_INCREMENT PRIMARY KEY,
        ID_user INT,
        ID_post INT,
        commentaire VARCHAR(255),
        Timestamp TIMESTAMP,
        FOREIGN KEY (ID_user) REFERENCES users(ID_user),
        FOREIGN KEY (ID_post) REFERENCES post(ID_post)
    )""",
    "discussion_mp": """CREATE TABLE IF NOT EXISTS discussion_mp (
        ID_discussion INT AUTO_INCREMENT PRIMARY KEY,
        ID_user1 INT,
        FOREIGN KEY (ID_user1) REFERENCES users(ID_user),
        ID_user2 INT,
        FOREIGN KEY (ID_user2) REFERENCES users(ID_user)
    )""",
    "message": """CREATE TABLE IF NOT EXISTS message (
        ID_message INT AUTO_INCREMENT PRIMARY KEY,
        timestamp TIMESTAMP,
        ID_user INT,
        FOREIGN KEY (ID_user) REFERENCES users(ID_user),
        contenu VARCHAR(255),
        ID_discussion INT,
        FOREIGN KEY (ID_discussion) REFERENCES discussion_mp(ID_discussion)
    )""",
    "discussion_historique": """CREATE TABLE IF NOT EXISTS discussion_historique (
        ID_historique INT AUTO_INCREMENT PRIMARY KEY,
        ID_discussion INT,
        FOREIGN KEY (ID_discussion) REFERENCES discussion_mp(ID_discussion)
    )""",
    "Relations": """CREATE TABLE IF NOT EXISTS Relations (
        ID_Relations INT AUTO_INCREMENT PRIMARY KEY,
        nature Varchar(15), 
        ID_user1 INT,
        FOREIGN KEY (ID_user1) REFERENCES users(ID_user),
        ID_user2 INT,
        FOREIGN KEY (ID_user2) REFERENCES users(ID_user),
        timestamp TIMESTAMP
    )""",
    "insertion": """INSERT INTO discussion_mp (ID_discussion) Values (0)"""
}


def create_tables(tables, connexion):
    cursor = connexion.cursor()
    for table, sql in tables.items():
        try:
            cursor.execute(sql)
            print(f"Table '{table}' créée avec succès!")
        except mysql.connector.Error as error:
            print(f"Erreur lors de la création de la table '{table}': {error}")
        connexion.commit()
        time.sleep(10) 

    cursor.close()


create_tables(tables, connexion)

connexion.close()  

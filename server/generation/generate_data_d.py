import random
from datetime import datetime, timedelta
import mysql.connector

# Connexion à la base de données
hostname = "localhost"
username = "root"
password = "root"
database = "tower_defense"

connexion = mysql.connector.connect(host=hostname, user=username, password=password, database=database)

if not connexion.is_connected():
    raise Exception("Échec de la connexion à la base de données")

cursor = connexion.cursor()

# Fonction pour générer une date aléatoire dans une plage donnée
def random_date(start_date, end_date):
    time_between = end_date - start_date
    random_number_of_days = random.randrange(time_between.days)
    random_date = start_date + timedelta(days=random_number_of_days)
    return random_date

# Fonction pour générer des données aléatoires pour la table "users"
def generate_user_data():
    user_names = ["John", "Jane", "Alice", "Bob", "Emma", "David"]
    emails = ["john@example.com", "jane@example.com", "alice@example.com", "bob@example.com", "emma@example.com", "david@example.com"]
    tel_numbers = ["1234567890", "9876543210", "5555555555", "9999999999", "1111111111", "4444444444"]

    user_name = random.choice(user_names)
    email = random.choice(emails)
    tel = random.choice(tel_numbers)
    photo_profil = f"{user_name}.jpg"

    return (user_name, email, tel, photo_profil)

# Génération de données aléatoires pour la table "users"
users = []
for _ in range(5):
    users_data = generate_user_data()
    query = "INSERT INTO users (user_name, email, tel, photo_profil) VALUES (%s, %s, %s, %s)"
    cursor.execute(query, users_data)
    users.append(cursor.lastrowid)

connexion.commit()
print("Données générées pour la table 'users'")

# Fonction pour générer des données aléatoires pour la table "relations"
def generate_relations_data(user_ids):
    relations = ["ami", "ennemi", "connaissance"]

    nature = random.choice(relations)
    user_id1 = random.choice(user_ids)
    user_id2 = random.choice(user_ids)
    timestamp = random_date(datetime(2021, 1, 1), datetime(2022, 12, 31))

    return (nature, user_id1, user_id2, timestamp)

# Génération de données aléatoires pour la table "relations"
for _ in range(50):
    relations_data = generate_relations_data(users)
    query = "INSERT INTO relations (nature, ID_user1, ID_user2, timestamp) VALUES (%s, %s, %s, %s)"
    cursor.execute(query, relations_data)

connexion.commit()
print("Données générées pour la table 'relations'")

connexion.close()

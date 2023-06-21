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

# Fonction pour générer une date aléatoire dans une plage donnée
def random_date(start_date, end_date):
    time_between = end_date - start_date
    random_number_of_days = random.randrange(time_between.days)
    random_date = start_date + timedelta(days=random_number_of_days)
    return random_date

# Fonction pour générer des données aléatoires pour la table "discussion_mp"
def generate_discussion_mp_data(user_ids):
    user_id1 = random.choice(user_ids)
    user_id2 = random.choice(user_ids)

    return (user_id1, user_id2)

# Fonction pour générer des données aléatoires pour la table "message"
def generate_message_data(user_ids, discussion_ids):
    message_contents = ["Salut !", "Comment ça va ?", "As-tu vu le dernier film ?", "Je suis disponible demain soir.", "Je ne peux pas y aller, désolé."]

    timestamp = random_date(datetime(2021, 1, 1), datetime(2022, 12, 31))
    user_id = random.choice(user_ids)
    contenu = random.choice(message_contents)
    discussion_id = random.choice(discussion_ids)

    return (timestamp, user_id, contenu, discussion_id)

# Fonction pour générer des données aléatoires pour la table "discussion_historique"
def generate_discussion_historique_data(discussion_ids):
    discussion_id = random.choice(discussion_ids)

    return (discussion_id,)

# Fonction pour générer des données aléatoires pour la table "user_discussion_historique"
def generate_user_discussion_historique_data(user_ids, discussion_ids):
    user_id = random.choice(user_ids)
    discussion_id = random.choice(discussion_ids)

    return (user_id, discussion_id)

# Génération de données aléatoires pour la table "users"
users = []
for _ in range(5):
    user_data = generate_user_data()
    query = "INSERT INTO users (user_name, email, tel, photo_profil) VALUES (%s, %s, %s, %s)"
    cursor.execute(query, user_data)
    users.append(cursor.lastrowid)

connexion.commit()
print("Données générées pour la table 'users'")

# Génération de données aléatoires pour la table "discussion_mp"
discussions = []
for _ in range(10):
    discussion_mp_data = generate_discussion_mp_data(users)
    query = "INSERT INTO discussion_mp (ID_user1, ID_user2) VALUES (%s, %s)"
    cursor.execute(query, discussion_mp_data)
    discussions.append(cursor.lastrowid)

connexion.commit()
print("Données générées pour la table 'discussion_mp'")

# Génération de données aléatoires pour la table "message"
for _ in range(50):
    message_data = generate_message_data(users, discussions)
    query = "INSERT INTO message (timestamp, ID_user, contenu, ID_discussion) VALUES (%s, %s, %s, %s)"
    cursor.execute(query, message_data)

connexion.commit()
print("Données générées pour la table 'message'")

# Génération de données aléatoires pour la table "discussion_historique"
for _ in range(10):
    discussion_historique_data = generate_discussion_historique_data(discussions)
    query = "INSERT INTO discussion_historique (ID_discussion) VALUES (%s)"
    cursor.execute(query, discussion_historique_data)

connexion.commit()
print("Données générées pour la table 'discussion_historique'")

# Génération de données aléatoires pour la table "user_discussion_historique"
for _ in range(20):
    user_discussion_historique_data = generate_user_discussion_historique_data(users, discussions)
    query = "INSERT INTO discussion_historique (ID_user, ID_discussion) VALUES (%s, %s)"
    cursor.execute(query, user_discussion_historique_data)

connexion.commit()
print("Données générées pour la table 'user_discussion_historique'")

connexion.close()

import random
from datetime import datetime, timedelta
import mysql.connector

# Connexion à la base de données
hostname = "localhost"
username = "root"
password = ""
database = "tower_defense"

connexion = mysql.connector.connect(host=hostname, user=username, password=password, database=database)

if not connexion.is_connected():
    raise Exception("Échec de la connexion à la base de données")

cursor = connexion.cursor()
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

# Fonction pour générer des données aléatoires pour la table "forum"
def generate_forum_data():
    forum_titres = ["Général", "Stratégies", "Problèmes techniques", "Suggestions", "Communauté"]

    forum_titre = random.choice(forum_titres)

    return (forum_titre,)

# Fonction pour générer des données aléatoires pour la table "post"
def generate_post_data(user_ids, forum_ids):
    post_contents = ["Bonjour à tous !", "J'ai besoin d'aide.", "Voici ma stratégie gagnante.", "Quelqu'un a rencontré ce bug ?", "J'ai une suggestion pour améliorer le jeu."]

    user_id = random.choice(user_ids)
    forum_id = random.choice(forum_ids)
    post = random.choice(post_contents)
    titre = "Post #" + str(random.randint(1, 100))
    timestamp = random_date(datetime(2021, 1, 1), datetime(2022, 12, 31))

    return (user_id, forum_id, post, titre, timestamp)

# Fonction pour générer des données aléatoires pour la table "commentaire"
def generate_commentaire_data(user_ids, post_ids):
    commentaire_contents = ["Je suis d'accord avec toi.", "Je ne suis pas sûr de comprendre.", "Très intéressant !", "Merci pour le partage.", "Je vais essayer ça."]

    user_id = random.choice(user_ids)
    post_id = random.choice(post_ids)
    commentaire = random.choice(commentaire_contents)
    timestamp = random_date(datetime(2021, 1, 1), datetime(2022, 12, 31))

    return (user_id, post_id, commentaire, timestamp)

# Génération de données aléatoires pour la table "user"
users = []
for _ in range(5):
    user_data = generate_user_data()
    query = "INSERT INTO user (user_name, email, tel, photo_profil) VALUES (%s, %s, %s, %s)"
    cursor.execute(query, user_data)
    users.append(cursor.lastrowid)

connexion.commit()
print("Données générées pour la table 'user'")
# Génération de données aléatoires pour la table "forum"
forums = []
for _ in range(5):
    forum_data = generate_forum_data()
    query = "INSERT INTO forum (forum_titre) VALUES (%s)"
    cursor.execute(query, forum_data)
    forums.append(cursor.lastrowid)

connexion.commit()
print("Données générées pour la table 'forum'")

# Génération de données aléatoires pour la table "post"
posts = []
for _ in range(50):
    post_data = generate_post_data(users, forums)
    query = "INSERT INTO post (ID_user, ID_forum, post, titre, timestamp) VALUES (%s, %s, %s, %s, %s)"
    cursor.execute(query, post_data)
    posts.append(cursor.lastrowid)

connexion.commit()
print("Données générées pour la table 'post'")

# Génération de données aléatoires pour la table "commentaire"
for _ in range(100):
    commentaire_data = generate_commentaire_data(users, posts)
    query = "INSERT INTO commentaire (ID_user, ID_post, commentaire, timestamp) VALUES (%s, %s, %s, %s)"
    cursor.execute(query, commentaire_data)

connexion.commit()
print("Données générées pour la table 'commentaire'")

connexion.close()
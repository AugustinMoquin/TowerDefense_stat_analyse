import random
from datetime import datetime, timedelta
import mysql.connector
import time
# Connexion à la base de données
hostname = "localhost"
username = "root"
password = ""
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

# Fonction pour générer des données aléatoires pour la table "user"
def generate_user_data():
    user_names = ["John", "Jane", "Alice", "Bob", "Emma", "David"]
    emails = ["john@example.com", "jane@example.com", "alice@example.com", "bob@example.com", "emma@example.com", "david@example.com"]
    tel_numbers = ["1234567890", "9876543210", "5555555555", "9999999999", "1111111111", "4444444444"]

    user_name = random.choice(user_names)
    email = random.choice(emails)
    tel = random.choice(tel_numbers)
    photo_profil = f"{user_name}.jpg"

    return (user_name, email, tel, photo_profil)

# Fonction pour générer des données aléatoires pour la table "historique_parties_user"
def generate_historique_parties_user_data(partie_ids, user_ids):
    partie_id = random.choice(partie_ids)
    user_id = random.choice(user_ids)

    return (partie_id, user_id)
# Fonction pour générer des données aléatoires pour la table "partie_lambda"
def generate_partie_lambda_data(user_ids):
    parties_jouees = random.randint(1, 10)
    nombre_vagues_totales = random.randint(10, 50)
    nombre_monstre_total = random.randint(100, 500)
    monstres_tues_individuel = random.randint(50, 200)
    temps_total_partie = random.randint(300, 1800)
    tours_construites_total = random.randint(10, 100)
    tours_individuel_total = random.randint(1, 10)
    tune_totale = random.randint(1000, 5000)
    score = random.randint(100, 1000)
    duree_jeu = random.randint(1, 3)
    win = random.choice([True, False])
    user_id = random.choice(user_ids)

    return (user_id, parties_jouees, nombre_vagues_totales, nombre_monstre_total, monstres_tues_individuel,
            temps_total_partie, tours_construites_total, tours_individuel_total, tune_totale, score, duree_jeu, win)
# Fonction pour générer des données aléatoires pour la table "statistiques_user"
def generate_statistiques_user_data(user_ids):
    moyenne_parties_jouees = round(random.uniform(1, 10), 2)
    moyenne_nombre_vagues_totales = round(random.uniform(10, 50), 2)
    moyenne_nombre_monstre_total = round(random.uniform(100, 500), 2)
    moyenne_monstres_tues_individuel = round(random.uniform(50, 200), 2)
    moyenne_temps_total_partie = round(random.uniform(300, 1800), 2)
    moyenne_tours_construites_total = round(random.uniform(10, 100), 2)
    moyenne_tours_individuel_total = round(random.uniform(1, 10), 2)
    moyenne_tune_totale = round(random.uniform(1000, 5000), 2)
    moyenne_score = round(random.uniform(100, 1000), 2)
    moyenne_duree_jeu = round(random.uniform(1, 3), 2)
    moyenne_win = round(random.uniform(0, 1), 2)
    user_id = random.choice(user_ids)

    return (user_id, moyenne_parties_jouees, moyenne_nombre_vagues_totales, moyenne_nombre_monstre_total,
            moyenne_monstres_tues_individuel, moyenne_temps_total_partie, moyenne_tours_construites_total,
            moyenne_tours_individuel_total, moyenne_tune_totale, moyenne_score, moyenne_duree_jeu, moyenne_win)


users = []
for _ in range(5):
    user_data = generate_user_data()
    users.append(user_data)
    time.sleep(2)  

parties = []
for _ in range(10):
    partie_data = generate_partie_lambda_data(users)
    parties.append(partie_data)
    time.sleep(2)  

#  table "historique_parties_user"
historique_parties_user_data = []
for _ in range(3):
    data = generate_historique_parties_user_data(parties, users)
    historique_parties_user_data.append(data)
    time.sleep(2)  

query = "INSERT INTO historique_parties_user (ID_partie, ID_user) VALUES (%s, %s)"
cursor.executemany(query, historique_parties_user_data)
connexion.commit()
print("Données générées pour la table 'historique_parties_user'")

# table "statistiques_user"
statistiques_user_data = []
for _ in range(3):
    data = generate_statistiques_user_data(users)
    statistiques_user_data.append(data)
    time.sleep(2)  

query = "INSERT INTO statistiques_user (ID_user, moyenne_parties_jouees, moyenne_nombre_vagues_totales, " \
        "moyenne_nombre_monstre_total, moyenne_monstres_tues_individuel, moyenne_temps_total_partie, " \
        "moyenne_tours_construites_total, moyenne_tours_individuel_total, moyenne_tune_totale, moyenne_score, " \
        "moyenne_duree_jeu, moyenne_win) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
cursor.executemany(query, statistiques_user_data)
connexion.commit()
print("Données générées pour la table 'statistiques_user'")


print("Données générées pour la table 'statistiques_user'")

# T-WEB-501-LYO_1

Pour mettre en place le projet :
 - ouvrir un terminal
 - naviguer jusque dans le projet
 - éxécuter en premier le script de création "sudo mysql < create_db.sql"
 - éxécuter le deuxième script "sudo mysql < populate_JobBoard.sql"
 - rester à la racine du projet et effectuer la commande "php -S localhost:5000"
 - Aller sur http://localhost:5000/index.html ou http://localhost:5000

## step 01 

La base de données est un server MYSQL.

Le script "create_db.sql" permet de créer la base de données, les utilisateurs et les tables.
Le script "populate_JobBoard.sql" permet de créer les données nécéssaires pour avoir une utilisation basique du site.

Ces deux fichiers se trouvent à la racine du projet.

## step 02 & step 03

Le bouton readme est créé dynamiquement grâce au fichier ["script.js"](./script.js) qui se trouve à la racine du projet. Il est lié au fichier ["index.html"](./index.html). Pour voir les détails de l'annonce, on ajoute ou retire la classe "description-open" qui change la max-height sur la balise "p".


## step 04 

Tout le backend ce situe dans le dossier [/api](./api/).
 - Dans le dossier [/connexion/index.php](./api/connexion/index.php) on y fait les requêtes qui permette d'authentifier un utilisateur.

 - Dans le dossier [/inscription/index.php](./api/inscription/index.php) on y fait les requêtes qui permette d'inscrire un utilisateur.

 - Dans le dossier [/postuler/index.php](./api/postuler/index.php) on y fait les requêtes qui permette de récupérer, d'ajouter et de supprimer les utilisateurs qui postulent aux annonces.

 - Dans le dossier [/user/index.php](./api/user/index.php) on y fait les requêtes qui permette de supprimer un utilisateur ou de le mettre à jours.

Les technologies qu'on a décidé d'utiliser sont html, css javascript pour la partie front end.
Pour la partie back end on a décidé d'utiliser du PHP et pour la base de données on utilise MYSQL.

## step 05

Lorsque que l'on clique sur le bouton postuler de la page ["index.html"](./index.html) cela nous redirige vers une page qui nous donne plus de détails sur l'annonce et un bouton pour postuler à cette annonce. Cette page ce se trouve ["/views/annonce/index.html"](./views/annonce/index.html).

## step 06

Pour l'authentification on utilise le bearer token. Pour savoir si l'utilisateur est connecté côté client on vérifie juste s'il un cookie existe avec la clé token.

Pour vérifé l'authentification côté server on récupère le cookie qui est automatiquement envoyé en faisant une requête et on vérifie s'il existe dans la base de données.

Le token est généré au moment de la création d'un compte dans ["/api/inscription/index.php"](./api/inscription/index.php) et est ensuite stocké dans la base de données dans la table peoples.

Au moment de la connexion d'un utilisateur (['ici'](./api/connexion/index.php)), si celui si est validé on envoie le token qui lui est associé dans la table peoples et il est stocké côté client dans un cookie.

Les identifiants des comptes créer par défaut:
 - "Nom" "Mot de passe"
 - "admin@gmail.com" - "admin"
 - "alexis@gmail.com" - "alexis"
 - "fethi@gmail.com" - "fethi"

## step 07 

Pour avoir accès à la page admin, il faut ce connecté via un compte admin uniquement.
Par défaut un compte est créée avec le script ["populate_JobBoard.sql"](./populate_JobBoard.sql). Les identifiants des comptes sont :
 - Nom: "admin@gmail.com" 
 - Mot de passe: "admin"

Au moment de la connexion de l'utilisateur on stock un cookie pour savoir s'il on est admin ou pas.
On fait aussi une vérification avec le token côté serveur.

 Malheureusement on a pas pu intégrer toutes les fonctionnalités.

## step 08 

Le site est responsive avec un menu de navigation qui se transforme en menu burger lorsque que l'on est sur mobile.
Les fichiers ["script.js"](./script.js) et ["style.css"](./style.css) sont accessibles depuis toutes les autres pages et permettent de faire fonctionner la barre de navigation. Cela permet d'évité la dupplication de code.

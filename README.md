
# Projet : Application de gestion de crise

  

SPILMONT FRANCOIS

  

SAKER LUCAS

  

FRANCOIS JULES

  

MANGENOT ALEX

  

CE PROJET A ÉTÉ RÉALISÉ EN GROUPE EN UTILISANT L'EXTENSION ``LIVESHARE`` DE VISUAL STUDIO CODE, LES COMMITS ONT DONC ÉTÉ GÉNÉRÉS PAR UNE PERSONNE MAIS LE TRAVAIL RÉALISÉ EST UN TRAVAIL DE GROUPE

  
  

## Installation du projet

### ⚠️ Version docker

Ce projet s'installe grâce à docker, c'est le seul prérequis à l'installation de ce projet.

  

- Une fois docker installé, lance le
- clonez le projet `git clone https://github.com/SpilmontFrancois/ProgWebServ.git`
- Dans un terminal ouvert dans ./TP4/project/api installez le projet avec `docker-compose up --build`
- Prenez un café ☕
- Créez la base de données avec 
	- `docker exec -it progwebserv_db_1 /bin/bash`
	- ``mysql --user=root --password < /var/www/data/createdatabase.sql `` et utilisez le mot de passe ``example``
- Lors de la première instalation mettez à jour les dépendance avec le container `progwebserv_composer_1` 

### ✔️ Version manuelle

Si l'installation avec docker ne vous permet pas d'utiliser notre application, vous pouvez l'initialiser manuellement comme suit :

Initialisation :
- Dans le dossier ``/TP4/project/api`` copiez le fichier ``.env.example`` en un nouveau fichier ``.env`` et réglez les paramètres suivants :
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=nomBDD
    - DB_USERNAME=root
    - DB_PASSWORD=
- Créez votre base de données en respectant le nom donné dans le .env
- Dans le dossier ``/TP4/project/api`` lancez la commande ``composer up``
- Dans le dossier ``/TP4/project/api`` lancez la commande ``php artisan migrate:fresh``
- Dans le dossier ``/TP4/project/client`` lancez la commande ``npm i``


Run :
- Démarrez votre MySQL
- Dans le dossier ``/TP4/project/api`` lancez la commande ``php -S 127.0.0.1:8001 -t public``
- Démarrez votre serveur local afin d'accéder à la page ``{IP}:{PORT}/TP4/project/client/index.html``

## Fonctionnalités

- Connexion et inscription
- A partir de cette page vous pouvez vous connecter et naviguer entre les diffèrentes pages du site :
	- une page map pour voir les utilisateurs contaminés
	- un page profil pour voir et modifier ses informations
	- une page message pour dialoguer avec les autres utilisateurs
- utilisateur de démo (si installation avec docker) :
	- afin de tester l'application, vous pouvez vous connecter au profil de jean-michel deut avec les identifiants suivants :
		- login : jm2
		- pass : mdp
	- Ou encore avec david hun :
		- login : dav
		- pass : mdp 
  
## Outils de développement
- Nos tests se lancent avec la commande ``php artisan test ``
depuis le dossier``
/TP4/project/api``
    -   Le lancement des test utilise un refresh de la base de données, pensez donc à lancer mysql pour exécuter les tests sur une autre base sans affecter l'environnement de production. L'accès à cette bdd ce configure dans ./api/.env
-	Notre linter se lance avec la commande : ``npx eslint nomfichier.js``


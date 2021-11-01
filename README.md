
# Projet : Application de gestion de crise

  

SPILMONT FRANCOIS

  

SAKER LUCAS

  

FRANCOIS JULES

  

MANGENOT ALEX

  

CE PROJET A ÉTÉ RÉALISÉ EN GROUPE EN UTILISANT L'EXTENSION ``LIVESHARE`` DE VISUAL STUDIO CODE, LES COMMITS ONT DONC ÉTÉ GÉNÉRÉS PAR UNE PERSONNE MAIS LE TRAVAIL RÉALISÉ EST UN TRAVAIL DE GROUPE

  
  

## Installation du projet

Ce projet s'installe grâce à docker, c'est le seul prérequis à l'installation de ce projet.

  

- Une fois docker installé, lance le
- clonez le projet `git clone https://github.com/SpilmontFrancois/ProgWebServ.git`
- Dans un terminal ouvert dans ./TP4/project/api installez le projet avec `docker-compose up --build`
- Prenez un café ☕
- Créez la base de données avec 
	- `docker exec -it progwebserv_db_1 /bin/bash`
	- ``mysql --user=root --password < /var/www/data/createdatabase.sql `` et utilisez le mot de passe ``example``
- Lors de la première instalation mettez à jour les dépendance avec le container `progwebserv_composer_1`


-Linter :
 

## Fonctionnalités et routes

- Connexion et inscription : http://127.0.0.1:5500/client/pages/login.html
- A partir de cette page vous pouvez vous connecter et naviguer entre les diffèrentes pages du site :
	- une page map pour voir les utilisateurs contaminés
	- un page profile pour voire et modifier ses informations
	- une page message pour dialoguer avec les autres utilisateurs
- utilisateur de démo :
	- afin de tester l'application, vous pouvez vous connecter au profile de jean-michel deut avec les identifiants suivants :
		- login : jm2
		- pass : mdp
	- Ou encore avec david hun :
		- login : dav
		- pass : mdp 
  
## Outils de développement
- Nos tests se lancent avec la commande ``php artisan test ./tests``dans``
./api``
	-	Pensez à lancer mysql pour exécuter les tests sur une autre base sans affecter l'environnement de production. L'accès à cette bdd ce configure dans ./api/.env
-	Notre linter se lance avec la commande : ``npx eslint nomfichier.js`` dans````


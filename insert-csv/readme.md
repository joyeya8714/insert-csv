# Test technique GAC

## Versions

* Apache : 2.4.46
* PHP : 7.4.9
* MySQL : 5.7.31

## Librairies externes

* Bootstrap CSS/JS
* Jquery

## Installation

* cloner le projet dans un repertoire
* ajouter le vhost suivant (customiser le chemin suivant votre cas) :
```
<VirtualHost *:80>
	ServerName insert-csv.test
	DocumentRoot "c:/wamp64/www/insert-csv/public"
	<Directory  "c:/wamp64/www/insert-csv/public/">
		Options +Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Require local
	</Directory>
</VirtualHost>

```
* Redémarrer les DNS
* accéder à cette page : http://insert-csv.test/ 

## Précisions

* développement fait pour un usage IHM en partant du principe que le fichier n'est pas sur le server et qu'il est uploadé par l'utilisateur
* plusieurs méthodes ont été implémentées, celle utilisée est d'insert plusieurs lignes d'un coup
* structure BDD dans `/Database/db_structure.sql`

## Améliorations possibles

* historiser les uploads de fichiers, le temps pris, l'ip, date/heure...
* recharger en ajax les données des requêtes
* splitter la vue en plusieurs templates
* amélioration des perfs : rabbitMq ou custom Queue
* insertion en bdd d'un fichier déjà présent sur le serveur => plus rapide, pas d'upload, juste passer par FOpen ou autre similaire
* mettre en place des règles plus poussées de validation des données (voir lesquelles garder suivant certaines conditions)
* passer les librairies utilisées en Vendor

____________________________________________
Temps de dev total actuel : 15h
From Scrath
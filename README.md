# Quai Antique

Projet étudiant d'un site de restaurant "Le Quai Antique", dans le cadre de l'ECF "Évaluation En Cours de Formation - TP DIRECCTE - Eté 2023"

Ce projet utilise Symfony 6.2 avec symfony CLI 5.5.1, MAMP pour le serveur mySQL ainsi que PHP 8.2.3.

## Contexte

Projet étudiant d'une application web de gestion du restaurant "Le Quai Antique". 
Un des employés a accès à une page d'administration pour modifier les informations du site (Menu, horaires, ...). 
Le site sert aussi à la gestion des réservations des clients. Un client peut créer son compte, modifier ses informations, réserver une table. 
La gestion des réservations est gérée en fonction du nombre de places disponibles, modifiable par l'administrateur.

## Installation en local 

Dans le repertoire souhaité de votre local : 
```
git clone (URL de ce repo)
```

Changez le nom du fichier "env.local.text" par ".env.local".  
Modifier le pour y mettre vos identifiants MAMP. 

Ensuite tapez les commandes :
```
npm install
npm run build
composer install
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

Le projet est prêt à être lancé, vous pouvez démarrer le serveur symfony avec :
```
symfony serve:start
```

Un Restaurant ainsi qu'un admin ont été créé, les identifiants pour se connecter sont :  
ID: admin@admin.com  
MDP: adminadmin

C'est prêt, vous pouvez maintenant parcourir le site, réserver et créer votre compte utilisateur.

# Quai Antique

Projet étudiant d'un site de restaurant "Le Quai Antique", dans le cadre de l'ECF "Évaluation En Cours de Formation - TP DIRECCTE - Eté 2023"

Ce projet utilise Symfony 6.2 avec symfony CLI 5.5.1, MAMP pour le serveur mySQL ainsi que PHP 8.2.3.


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
```

Le projet est prêt à être lancé, vous pouvez démarrer le serveur symfony avec :
```
symfony serve:start
```

Pour finir d'initialiser le projet il faut créer l'administrateur pour créer le restaurant en base de donnée. 
Aller sur le site et créez un compte avec :

* Prénom : admin
* Nom : admin
* Mail : admin@admin.com
* Mot de passe : "Choisirmdp"

Ensuite, copiez/collez la commande disponible dans le fichier SetAdmin.text dans votre invite de commande.
Le compte est à présent administateur. 

Dans le DashBoard admin, vous devez créer un nouveaux restaurant (Vous pouvez choisir les valeurs):
* name: "Quai Antique"
* seatingCapacity: 100

C'est prêt, vous pouvez maintenant parcourir le site, réserver et créer votre compte utilisateur.
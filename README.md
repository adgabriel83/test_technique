- Technologies utilisées :

    Framework PHP Symfony 6 / PHP 8.1 / Mariadb

- Démarrage de l'application :

    docker-compose up --build

- Lancement des fixtures :

    php bin/console doctrine:fixtures:load

- Url de l'application :

    http://localhost:8080

- Liste des fonctionalités demandées :

Voir les clients avec plus de 30 matériels dont le matériel vendu est supérieur à 30000 euros :
    http://localhost:8080/client/app_client_filtre/30/30000
Formulaire de saisie de matériel à un client :
    http://localhost:8080/lien/new
Page qui calcule et affiche les totaux vendus pour chaque client, avec le client le plus rentable :
    Le plus rentable en haut de liste sur http://localhost:8080/client/app_client_filtre/
    http://localhost:8080/client/
Ajouter quelques vérifications et retours utilisateur en javascript sur les formulaires permettant de contrôler la saisie :
    http://localhost:8080/materiel/new
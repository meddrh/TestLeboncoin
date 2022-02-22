# Arborescence de projet
![Capture d’écran de 2022-02-23 00-10-48](https://user-images.githubusercontent.com/18338944/155235543-d72b6bc7-e89c-4ac6-8a89-30dc44ebc35c.png)

- Le premier dossier advertProject c'est le code source du projet.
- Le deuxième dossier php contient l'image php 7.4 avec Apache.


# Conception

![](../../Images/Capture d’écran de 2022-02-22 23-58-20.png)

# Installation

Il vous faut au moins :
- [Docker] (https://docs.docker.com/engine/install/)

# Lancement

Pour lancer le projet, il faut le cloner a l'aide de l'invite de commande :
```
 git clone https://github.com/meddrh/testLeboncoin.git test-leboncoin 
 
 cd test-leboncoin
 
 $ docker-compose build
 
 $ docker exec -it www_docker_symfony bash (si besoin d'utiliser le shell du conteneur “www”)
 
 /var/www# $ cd advertProject/
 
 /var/www/advertProject# composer install

```
On crée le fichier .env.local en remplacant l'url de connexion par :
```
DATABASE_URL=mysql://root:@db_docker_symfony:3306/advertProject?serverVersion=5.7  (j'autorise les comptes sans mot de passe Nous ne somme pas en production !)
```
Ensuite on lance la commande dans le contenneur wwww :
```
/var/www/advertProject# make db  (j'ai créé un fichier makeFile pour créé la bdd de dev et de test et les remplir avec des fitures)
```

# Fonctions LEVENSHTEIN :

- Ajouter les deux fonctions ci-dessous à la table advertProject :

```
DELIMITER $$
CREATE DEFINER=`root`@`%` FUNCTION `levenshtein`(`s1` VARCHAR(255), `s2` VARCHAR(255)) RETURNS int
    DETERMINISTIC
BEGIN
        DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
        DECLARE s1_char CHAR;
        -- max strlen=255
        DECLARE cv0, cv1 VARBINARY(256);

        SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;

        IF s1 = s2 THEN
            RETURN 0;
        ELSEIF s1_len = 0 THEN
            RETURN s2_len;
        ELSEIF s2_len = 0 THEN
            RETURN s1_len;
        ELSE
            WHILE j <= s2_len DO
                SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
            END WHILE;
            WHILE i <= s1_len DO
                SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
                WHILE j <= s2_len DO
                    SET c = c + 1;
                    IF s1_char = SUBSTRING(s2, j, 1) THEN
                        SET cost = 0; ELSE SET cost = 1;
                    END IF;
                    SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
                    IF c > c_temp THEN SET c = c_temp; END IF;
                    SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
                    IF c > c_temp THEN
                        SET c = c_temp;
                    END IF;
                    SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
                END WHILE;
                SET cv1 = cv0, i = i + 1;
            END WHILE;
        END IF;
        RETURN c;
    END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`%` FUNCTION `levenshtein_ratio`(`s1` VARCHAR(255), `s2` VARCHAR(255)) RETURNS int
    DETERMINISTIC
BEGIN
    DECLARE s1_len, s2_len, max_len INT;
    SET s1_len = LENGTH(s1), s2_len = LENGTH(s2);
    IF s1_len > s2_len THEN 
      SET max_len = s1_len; 
    ELSE 
      SET max_len = s2_len; 
    END IF;
    RETURN ROUND((1 - LEVENSHTEIN(s1, s2) / max_len) * 100);
  END$$
DELIMITER ;
```

# Accéder à l'application

Vous pouvez maintenant accéder à l'application via : http://127.0.0.1:8741/

# Liste des endpoints


|         Endpoint         |   Method   |                        Description                         |
|:------------------------:|:----------:|:----------------------------------------------------------:|
|     /api/advert/{id}     |    GET     |                Réccupération d'une annonce                 |
|       /api/advert        |    POST    |                   Création d'une annonce                   |
|     /api/advert/{id}     | Put, PATCH |   Modification complète ou bien partielle d'une annonce    |
|     /api/advert/{id}     |   DELETE   |                 Suppression d'une annonce                  |
| /api/advert/model/{name} |    GET     | réccupération d'un modèle qui match avec la data de la bdd |

# Test API CURL

```
curl -i -H "Content-Type: application/json" -X POST -d '{"Title":"Dalton","Content":"joe","Category":"1","Model":"5"}' http://localhost/api/advert      
```
![](../../Images/Capture d’écran de 2022-02-23 15-23-32.png)
```
curl -i http://localhost/api/advert/1

```
![](../../Images/Capture d’écran de 2022-02-23 15-20-41.png)

```
 curl -i -H "Content-Type: application/json" -X PUT -d '{"Title":"updated title", "Content": "updated content", "Category": "2"}' http://localhost/api/advert/1
```
![](../../Images/Capture d’écran de 2022-02-23 15-32-26.png)
```
curl -i -H "Content-Type: application/json" -X "DELETE" http://localhost/api/advert/1
```
![](../../Images/Capture d’écran de 2022-02-23 15-34-09.png)
# Test API PHPUNIT

Lancement de tests :
```
$ docker exec -it www_docker_symfony bash
```
```
$ /var/www# $ cd advertProject/
```
```
$ /var/www/advertProject#  php bin/phpunit
```
![](../../Images/Capture d’écran de 2022-02-23 15-35-19.png)

# Doc API

http://127.0.0.1:8741/api/doc

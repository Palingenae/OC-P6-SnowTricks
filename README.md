# OpenClassrooms Project 6 : SnowTricks

6th project for @OpenClassrooms' cursus. This one uses Symfony.

## Analysis
| Platform | Result |
|------|--------|
| Codacy | [![Codacy Badge](https://app.codacy.com/project/badge/Grade/db77c0db756542e0b5ea8054dd594d4b)](https://www.codacy.com/gh/Palingenae/OC-P6-SnowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Palingenae/OC-P6-SnowTricks&amp;utm_campaign=Badge_Grade) |

----- 
## How to install it
Docker has been used for this project's environment, thus, if you use Docker in your everyday workflow, it should be easy to install it although there aren't any Makefile.

Used ports : 
- 8080 for adminer container
- 1080 for maildev container
- 3306 for mysql container
- none for node container
- 80 for php / nginx container

1. Create a .env file using those values. User and Password are the same everywhere (excluding website's back-office)
   ```env
    MYSQL_USER=olivia #Or the name of your choice
    MYSQL_PASSWORD=password
    MYSQL_DATABASE=snowtricks
    MYSQL_ROOT_PASSWORD=root
    ```

2. Launch Docker
Apply those commands in your terminal :

    2.1 Launch containers
    ```
    docker-compose build && docker-compose up -d
    ```

    2.2 Install PHP bundles
    ```
    docker-compose exec php composer install
    ```
    
3. **Create database tables**.
Database is already created.

Migrate:
```
$ bin/console doctrine:migration:migrate
```

Create fixtures:
```
$ bin/console doctrine:fixtures:load
```

In case of doubt, feel free to use
```
$ bin/console list
```

Admin password is `adminPassword` and users' password is `userPassword`.
Jimmy Sweat's profile is created by default in the fixtures.
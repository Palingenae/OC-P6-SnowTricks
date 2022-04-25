# OpenClassrooms Project 6 : SnowTricks

6th project for @OpenClassrooms' cursus. This one uses Symfony.

## Analysis
| Platform | Result |
|------|--------|
| Codacy | [![Codacy Badge](https://app.codacy.com/project/badge/Grade/db77c0db756542e0b5ea8054dd594d4b)](https://www.codacy.com/gh/Palingenae/OC-P6-SnowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Palingenae/OC-P6-SnowTricks&amp;utm_campaign=Badge_Grade) |

----- 
## How to install it with Docker
Docker has been used for this project's environment, thus, if you use Docker in your everyday workflow, it should be easy to install it although there aren't any Makefile.

Used ports : 
- 8080 for adminer container
- 1080 for maildev container
- 3306 for mysql container
- none for node container
- 80 for php / nginx container

1. Create a .env file by using `make env` using those values. User and Password are the same everywhere (excluding website's back-office)
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

In Docker, you can directly use containers' terminal. To do so, you can use this command from your Operating-System terminal:
```
$ docker-compose exec php exec bash
```

From there, you can execute the next three commands:

**Migrate**:
```
$ bin/console doctrine:migration:migrate
```

**Create fixtures**:
```
$ bin/console doctrine:fixtures:load
```

**In case of doubt, feel free to use**
```
$ bin/console list
```

Admin password is `adminPassword` and users' password is `userPassword`.
Jimmy Sweat's profile is created by default in the fixtures.

It is also important to note that there is a Makefile at the root of the project. In there, you can find commands such as 
```
$ make dev
```

You can use `make help` to list the available commands.

---

## Install it without docker
Symfony is agnostic, so you can install directly on a machine in order to develop using the framework.

`app/` folder contains Symfony with Symfony Encore. To use Symfony Encore, NodeJS is required on your system without docker.

Select all `app/` content (it is advised to copy-paste the content), and move / paste in the adequate folders. There might be a need to proceed to some configuration. For instance, database and mails.

Check database URL in `app/.env`.
For emails, you can use (Mailgun)[https://www.mailgun.com/]. It relies on APIs. You could either use your domain address with a DNS MX entry from your registrar or Gmail.


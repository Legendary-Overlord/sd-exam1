# TEAM

* **Gallego Mateo**
* **Gironza Cristian**
* **Zuñiga Santiago**

![TEAM](https://enterprisersproject.com/sites/default/files/styles/large/public/images/cio_devops_trends.png?itok=kQgVjVLc)

To take on the job, the team made up of the 3 participants divided the problem into 2 large parts of the problem, having all the roles of both **Developer** and **Tester**.
# 1.	Desarrollo de la apliación web

![WEBAPP](https://aprendecomohacerlo.com/wp-content/uploads/2021/02/web-app-actualizada-funciona-crear.jpg)

## Steps to deploy the web application

* Create docker volume that persists
* Dowload FTP server from docker hub that run on persisten volume

It is in charge of transporting the files and saving them, This uses a configuration file that contains the environment variables, with the configuration the FTP server works correctly
https://github.com/Legendary-Overlord/sd-exam1/blob/master/ftpserver/config.env

* Dowload PHP wih apache server from docker

It is in charge of the backend, it contains a functioning skeleton to expose an API-Rest that in turn exposes endpoints.

**GET** Download the file
**POST** Upload the file 

**user/download** Endpoint to use Get
**user/upload** Endpoint to use Get

## Simple REST API BACKEND PHP
## Setting Up the Skeleton

![Skeleton PHP](https://github.com/Legendary-Overlord/sd-exam1/blob/master/resources/Skeleton.png)

* **index.php:** the entry-point of our application. It will act as a front-controller of our application.
* **inc/config.php:** holds the configuration information of our application. Mainly, it will hold the database credentials.
* **inc/bootstrap.php:** used to bootstrap our application by including the necessary files.
* **Model/Database.php:** the database access layer which will be used to interact with the underlying MySQL database.
* **Model/UserModel.php:** the User model file which implements the necessary methods to interact with the users table in the MySQL database.
* **Controller/Api/BaseController.php:** a base controller file which holds common utility methods.
* **Controller/Api/UserController.php:** the User controller file which holds the necessary application code to entertain REST API calls.


https://code.tutsplus.com/tutorials/how-to-build-a-simple-rest-api-in-php--cms-37000

To deploy **Dockers**, we use **Docker compose**. This can create a file to define the services. With a single command, you can get it all up and running or take it down.

![Compose](https://jhymer.dev/content/images/size/w2000/2020/05/docker-compose-1.png)

In order to test the operation of the web application, without the need for a Frontend, the **Postman** program was used

# 2.	Services for the use of the web application






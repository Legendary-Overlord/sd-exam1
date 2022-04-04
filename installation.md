# TEAM

* **Gallego Mateo**
* **Gironza Cristian**
* **Zuñiga Santiago**

![TEAM](https://www.google.com/url?sa=i&url=https%3A%2F%2Fenterprisersproject.com%2Farticle%2F2020%2F7%2Fdevops-great-teams&psig=AOvVaw2vK-o9-30bm5X9qHt6vF6b&ust=1649200461799000&source=images&cd=vfe&ved=0CAcQjRxqFwoTCJixhdPE-_YCFQAAAAAdAAAAABAJ)

# Create docker volume that persists
docker volume create sdexam1


# Download Samba image from docker hub that runs on the persistent volume
docker run -d -p 139:139 -p 445:445 --hostname samba-db -e TZ=America/Bogota -v sdexam1:/share/folder elswork/samba -u "$(id -u):$(id -g):$(id -un):$(id -gn):sambapassword" -s "SmbShare:/share/folder:rw:$(id -un)"

![Docker and volume](https://static.packt-cdn.com/products/9781787125230/graphics/assets/5f3a0690-1315-4540-9950-55179a4a1574.png)

# Simple REST API BACKEND PHP
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
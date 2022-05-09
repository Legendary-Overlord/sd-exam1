# TEAM

* **Gallego Mateo**
* **Gironza Cristian**
* **Zuñiga Santiago**

![TEAM](https://enterprisersproject.com/sites/default/files/styles/large/public/images/cio_devops_trends.png?itok=kQgVjVLc)

# Create docker volume that persists
``` 
docker volume create sdexam1 
```

# Consul
For registry an discovery service we use **Consul by HashiCorp**. Here we register all of the containers automatically using **Registrator** and a single Consul node that will be consul-server.

### 1. Deploy Consul-server
first we need deploy the Consul server. for this is necessary execute the following command:
``docker run -d -p 8500:8500 -p 8600/udp  
-p 8400:8400 --name consul-server --network back-tier gliderlabs/consul-server -node myconsul -bootstrap``

### 2. Deploy Registrator
to automatically add containers to consul we need deploy the Registrator, for this we will need to obtein IP address from the consul-server.  
first execute ``docker ps``  and take the id from the container consul-server. second we execute the following command to obtain the ip address using the container id previously obtained:

``docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' container_name_or_id``

Lastly we run the Register using the obtain ip address and the following command:

``docker run -d --network back-tier -v /var/run/docker.sock:/tmp/docker.sock  gliderlabs/registrator -ip ip_obtained consul://ip_opbtained:8500``

### 3. Add services
To add services to our consul-server we need add the following environment variables when you run each container:

- SERVICE_80_NAME=your_service_name
- SERVICE_80_ID=your_service_id
- SERVICE_80_CHECK_HTTP=true
- SERVICE_80_CHECK_HTTP=/

example:

``docker run -d -p 20-21:20-21 -p 21000-21010:21000-21010 --network back-tier --name ftpserver --env-file ftpserver/config.env delfer/alpine-ftp-server``

# Download Samba image from docker hub that runs on the persistent volume
```
docker run -d -p 139:139 -p 445:445 --hostname samba-db -e TZ=America/Bogota -v sdexam1:/share/folder elswork/samba -u "$(id -u):$(id -g):$(id -un):$(id -gn):sambapassword" -s "SmbShare:/share/folder:rw:$(id -un)"
```

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

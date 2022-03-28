#Create docker volume that persists
docker volume create sdexam1

#Download Samba image from docker hub that runs on the persistent volume
docker run -d -p 139:139 -p 445:445 --hostname samba-db -e TZ=Europe/Madrid -v sdexam1:/share/folder elswork/samba -u $(id -u):$(id -g):$(id -un):$(id -gn):sambapassword" -s "SmbShare:/share/folder:rw:$(id -un)"

Simple REST API BACKEND PHP
https://code.tutsplus.com/tutorials/how-to-build-a-simple-rest-api-in-php--cms-37000
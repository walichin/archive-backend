docker stop photo-adm
docker rm photo-adm
docker build -t photo-adm-app .
docker run -p 80:80 -d --name photo-adm photo-adm-app

# docker exec -it photo-adm bash



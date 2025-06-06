# Zoho API development assignment

1. run this command from project directory: 

`sudo docker compose up --build`

2. after starting the application run these commands (get id of the zoho-crm container through docker ps):

`sudo docker exec -it container-id-of-zoho-crm-container php artisan migrate:fresh --seed`
`sudo docker exec -it container-id-of-zoho-crm-container php artisan storage:link`

3. Site is accessible at http://127.0.0.1:8000/

# Author
Danil Lebediantsev, snakee0101@gmail.com
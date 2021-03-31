
# Prerequisites
1. Have docker installed

### The Process below requires a good network connnection

## starting the system
Open CMD through the vaccine_trial folder, and enter;  "  docker-compose up  -d  ".
You should see the terminal printing a few messages in green. Once this is done, you may then enter " 127.0.0.1:8080/ " in your web browser. 


## How to Access the database and import vaccine.sql
Launch phpmyadmin panel from 127.0.0.1:8089
This will open a login form that needs to connect to MySQL container.
Check your ip adress with commands `ifconfig(for linux)  or ipconfig(on windows)`
Having the ip adress the login credentials will be as follows:

server: `your_ip:3307        eg.192.168.43.143:3307`
user: `root`
password: `covidapp`

After successful login. Create a new database named `vaccine`. 
Then proceed to import the `vaccine.sql` file in the database folder

### Note
 Since the system is running on docker data may be lost when the containers stop running.
 To avoid this always export your database into `vaccine.sql` every time that you wish to stop the containers. The next time you start the containers you will only need to create database `vaccine` and then import the `vaccine.sql` file you exported.

## How to Access the app
To run the app on the browser open 127.0.0.1:8080
Admin Email: admin@gmail.com
Admin Password: admin1234 





Then run these commands to install the required packages

- `docker-compose run --rm composer install`
- `docker-compose run --rm npm run install`
- `docker-compose run --rm npm run dev`






# I. Introduction
### 1. Description

The Corn Chat is a one-on-one chatting application with key features including:

- **User authentication**: Login and account registration for new users.
- **Profile management**: Update personal information such as name, avatar, and password.
- **Friend system**: Send and accept friend requests within the app.
- **Real-time messaging**: Exchange text and images with friends, with chat history saved for future logins.
- **Notifications**: Receive alerts for friend activity (online status, new friend requests, and unsent messages). Users can also enable sound notifications for new messages.

### 2. Requirement
##### 2.1. Program language
- PHP 8.2 (or higher)
- HTML5
- JavaScript
- CSS
------------

##### 2.2. Libraries
- Ratchet
- Firebase/PHP-JWT
- Coundinary PHP

------------

#### 2.3. Tools
- Composer
- XAMPP (my option)
- MySQL server
# II. Setting up the Development Environment (with XAMPP)
### 1. Setting up project
##### 1.1. Prerequisites:
- The development environment must support **bash**
- Installed the **XAMPP** (the highest version is recommended).

------------


##### 1.2. Setting up project:
- Step 1: open the folder htdocs from the path (/xampp/htdocs).
- Step 2: use the command line to clone the KVN repository with the following command: *git clone https://github.com/thaingocphu0803/websocket-php.git*
- Step 3: create config.php in KVN_todolist follow the path (/xampp/htdoc/websocket-php/).
- Step 4: add constant variables in to config.php follow the table below:

| Name  | Purpose  |
| ------------ | ------------ |
| DB_HOST|The server hosting the database, used to configure the PDO connection|
|DB_NAME|The name of the database which the application connects is used to config PDO connection|
|USER_NAME|The user with access privileges to the database is used to config PDO connection|
|PASSWORD|The password for database user is used to config PDO connection|
|DOMAIN_NAME|The domain name is used to set the *Access-Control-Allow-Methods* for CORS policies|
|JWT_KEY|The secret key is a critical part of both encoding (signing) and decoding a JWT token. While it can be any string, it should be written manually as a strong, unpredictable, and sufficiently long string that combines uppercase and lowercase letters, numbers, and special characters.|
|CLOUD_NAME|which is provied by couldinary to connect with couldinary API|
|CLOUD_API_KEY|which is provied by couldinary to connect with couldinary API|
|CLOUD_API_SECRET|which is provied by couldinary to connect with couldinary API|

------------

### 2. Config Virtual Host
##### 2.1. Setting up the local domain:
- Step 1: open Notepad (or any text editor) as Administrator(or root on Linux).
- Step 2: open the **hosts** file from the path *C:/Windows/System32/drivers/etc/hosts* (/etc/hosts on Linux).
- Step 3: add the entries to map local domain name (example: *127.0.0.1 yourdomain.local*).

------------


##### 2.2. Setting up the Virtual Host:
- Step 1: open the **httpd-vhosts.conf** file located in */xampp/apache/conf/extra/httpd-vhosts.config*.
- Step 2: add a Virtual Host configuration as shown below:
		<VirtualHost *:80>
			ServerAdmin example@gmail.com
			DocumentRoot "/xampp/htdocs/websocket-php/public"
			ServerName yourdomain.local
			<Directory "/xampp/htdocs/websocket-php/public">
				Options Indexes FollowSymLinks
				AllowOverride All
				Require all granted
			</Directory>
		</VirtualHost>
- Step 3: save editing and restart Apache in XAMPP controll panel to apply the change.
- Step 4: visit the local domain (example: http://yourdomain.local) in the browser to check if everything is set up correctly.

### 3. Starting project
##### 3.1. Import table into Database.
To import the websocket-php.sql file into your MySQL database

------------

##### 3.2. Install Dependencies and Start WebSocket Server
- Step 1: Open Command Prompt and navigate to the websocket-php root directory. 	
	> cd path/to/websocket-php

- Step 2: Install dependencies using Composer.
	> cd composer install

- Step 3: Navigate to the WebSocket source directory
	> cd src/Websocket

- Step 4: Start the WebSocket server
	> php chat_server.php 

- step5: Open or reload the application to start using the chat system

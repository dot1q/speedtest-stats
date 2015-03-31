# Readme for Speedtest 
Purpose: The purpose of this project is to allow customers of OOKLA speedtest services graph data gathered during speedtests to their servers. This package will provide a MYSQL driven database and PHP frontend to display and manipulate the data. 

This project was made for the City of Sandy to graph average speeds of our competitors. While I could have made a single PHP file that did the same exact thing, I attempted to create a dynamic site that would allow me to graph data from any provider from any city, state or country. I felt that this little project would only get a little use from SandyNet, and should be public for other to use if they wish to visually see their data. 
#Setup
###Prerequisites-
The following packages must be installed on the server, and available for use:
* A webserver (such as Apache)
* MYSQL
* PHP (at least v5)

It is also assumed that you know enought about a linux environment to add databases, setup a websever and configure some options in PHP.

After the site and database have been setup, you will need to install jpgraph and place it in the jpgraph directory in the projects HTML files. Details on the installation process are below. 
###Installation process
1.  Navigate to your publicly web accessible location (eg: /var/www)
2. Copy down files to the location you would like everything to be in
3. Using phpmyadmin or the mysql interface create a database and execute this statement to create the proper table 
```
DROP TABLE `tbl_data`;
CREATE TABLE `tbl_data` (
	`id` INT(6) AUTO_INCREMENT PRIMARY KEY,
	`CLIENT_IP` VARCHAR(255) NOT NULL,
	`CLIENT_CITY` VARCHAR(255) NOT NULL,
	`CLIENT_REGION` VARCHAR(255) NOT NULL,
	`CLIENT_COUNTRY` VARCHAR(255) NOT NULL,
	`ISP` VARCHAR(255) NOT NULL,
	`CLIENT_LATITUDE` VARCHAR(255) NOT NULL,
	`CLIENT_LONGITUDE` VARCHAR(255) NOT NULL,
	`TEST_DATE` VARCHAR(255) NOT NULL,
	`SERVER_NAME` VARCHAR(255) NOT NULL,
	`DOWNLOAD_KBPS` VARCHAR(255) NOT NULL,
	`UPLOAD_KBPS` VARCHAR(255) NOT NULL,
	`LATENCY` VARCHAR(255) NOT NULL,
	`CLIENT_BROWSER` VARCHAR(255) NOT NULL,
	`CLIENT_OPERATING_SYSTEM` VARCHAR(255) NOT NULL,
	`USER_AGENT` VARCHAR(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```
If you didn't already notice, the table name is tbl_data. Please don't change this, unless you want to edit every php file later to use it. (Maybe in the future I'll make it a config option, but at this time it is not)

There is folder called jpgraph, head on over to http://jpgraph.net/download/ and download the file, then extract the contents to the jpgraph folder. When done, your structure should be like:
* jpgraph
  * src/
  * docs/
  * VERSION
  * README

Finally, from your terminal, issue a mv command on ini.config.php and rename it as config.php
```
mv ini.config.php config.php
```
Then edit the variables using your favorite text editor
```
$config['db_host'] = "localhost";
$config['db_name'] = "database-name";
$config['db_user'] = "database-username";
$config['db_pass'] = "database-password";
```
and
```
$config['header-title'] = "Your Company name";
```
Anything within double quotes is what you change

Once you have completed all of these steps your site should be working properly. Navigate to the upload CSV button on the menu bar, and upload the CSV file provided by OOKLA from reporting.ookla.com

Your graphs should render on the fly, and everything should work. If any issues are found please report them to the bugtracker and I will fix them up. 

##Other Fixes

A couple of things have popped up during the configuration that are out of the ordinary. 

### JpGraph Error: 25128
This issue can be fixed by following the guide here: http://colekcolek.com/2012/05/16/how-to-fix-jpgraph-error-the-function-imageantialias-is-not-available/

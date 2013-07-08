#WAMP

**WAMP + phpunit + latest version php + zendframework + fix localhost**

For all step will assume you have installed your wamp server in C:/wamp 

**Legend**

- wamp installation folder as "wamp"
- any version in use as "version"
- windows dir as "windows dir"

##WAMP - Fix localhost

###First step to "fix localhost"...

####...Create a php virtual host for localhost

Go to wamp > bin > apache > apache version > conf > extra, open the file named httpd-vhosts.conf

add this lines:

```
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot C:/wamp/www
    SetEnv APPLICATION_ENV "development"
    <Directory C:/wamp/www>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>

```

then save and close this file.

Go to wamp > bin > apache > apache version > conf, open the file named httpd.conf

uncomment this line:

```
LoadModule rewrite_module modules/mod_rewrite.so
```

and uncomment this line: 

```
Include conf/extra/httpd-vhosts.conf
```

then save and close this file.


###Second step to "fix localhost"...

####...redirect 127.0.0.1 to localhost

Open your favorite text editor (or the default win) by right click > administrator.

Go to files > open (in this text editor) and search/goto > windows dir > system32 > Drivers > etc, open the file named hosts

add this line:

```
127.0.0.1	localhost
```

then save and close this file > restart your computer.


Now you can use localhost in place of 127.0.0.1 and this tech fix the "localhost" in the wamp button in the task bar. Now, you can work with each project directly placed in different folder in wamp > www dir.

remark: if something goes wrong, put wamp online, after offline, then restart wamp.


##WAMP - add a virtual host for each project

###First step to "add a virtual host"...

####...create a php virtual host for your project

Go to wamp > bin > apache > apache version > conf > extra, open the file named httpd-vhosts.conf

after these lines

```
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot C:/wamp/www
    SetEnv APPLICATION_ENV "development"
    <Directory C:/wamp/www>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

add these kind of lines:

```
<VirtualHost *:80>
    ServerName projectname.localhost
    DocumentRoot C:/wamp/www/project-name-folder
    SetEnv APPLICATION_ENV "development"
    <Directory C:/wamp/www/project-name-folder>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

then save and close this file.


remark: to adapt -> "projectname" as the url name of your choice to access to the project and "project-name-folder" must match "your project name folder".


###Second step to "add a virtual host"...

####...add a domain mapping for your project

Open your favorite text editor (or the default win) by right click > administrator.

Go to files > open (in this text editor) and search/goto > windows dir > system32 > Drivers > etc, open the file named hosts

and add this line:

```
127.0.0.1	projectname.localhost localhost
```

then save and close this file > restart your computer.


Now you can use projectname.localhost as transparent url access for your project folder system placed in wamp > www dir.

##WAMP - fix latest version of php

remark before continue: If you need a previous version of php, you can use simply the wamp module installer for each version http://www.wampserver.com/ > download addons.

**fix the latest version of php is necessary in some case, when the php version delivered with the last wamp version is inferior of the version you need - e.g. when I write these line wamp is delivered with php 5.4.3 and PHPUnit need something like php 5.4.7+**.

**If it's the fact**

Go to link http://windows.php.net/download/

then, download only the zip file (of the version you need) > uncompress the zip

Take a lot of care of the structure after uncompression and before copy/past

remark: I say that because sometimes, some zip extractors create a new folder like this /php-5.X-blabla/php-5.X-blabla/all_needed_.dll's_and_more_in

Right click and /copy the folder, only from folder "php-5.X-blabla" placed just before /all_needed_.dll_and_more_in

Go to wamp > bin > php > php version, and /past your /copy

rename this folder by (e.g. for me) php5.4.17

Go to your latest version of php (in the same place) > /copy wampserver.conf, return to folder of your new php version then /past the wampserver.conf 

remark: work for me @ this time but maybe from a branche to another of a php version control, maybe this kind of tech can't work correctly without radical changes in wamp, apache and/or in this file.

Now, go to and click on wamp in the task bar > php > php.ini, search with your text editor

```
extension_dir =
```

replace its content by (e.g. for me and my new version of php)

```
extension_dir = "C:/wamp/bin/php/php5.4.17/ext/"
```

then, restart wamp
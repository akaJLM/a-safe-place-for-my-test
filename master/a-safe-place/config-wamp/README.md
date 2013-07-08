#WAMP
=====

**WAMP + phpunit + latest version php + zendframework + fix localhost**

For alls tep will assume you have installed your wamp server in C:/wamp 

**Legend**

- installation folder as "wamp"
- any version in use as "version"
- windows dir as "windows dir"

##WAMP - Fix localhost
-----

**First step, create a php virtual host for localhost**

Go to wamp > bin > apache > apache version > conf > extra, open the file named httpd-vhosts.conf

- add this lines:

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

- then save and close this file.


- Go to wamp > bin > apache > apache version > conf, open the file named httpd.conf

- uncomment this line:

```
LoadModule rewrite_module modules/mod_rewrite.so
```
- and uncomment this line: 

```
Include conf/extra/httpd-vhosts.conf
```

- then save and close this file.



**Second step, redirect 127.0.0.1 to localhost**


Open your favorite text editor (or the default win) by right click > administrator.

Go to files > open in this text editor and search/goto > windows dir > system32 > Drivers > etc, open the file named hosts

- and add this line:

```
127.0.0.1	localhost
```

- then save and close this file > restart your computer.

Now you can use localhost in place of 127.0.0.1 and this tech fix the "localhost" in the wamp button in the task bar. Now, you can work with each project directly placed in different folder in wamp > www dir.

remark: if something goes wrong, put wamp online, after offline, then restart wamp.


##WAMP - add a virstual host for each project.
-----

**First step, create a php virtual host for your project**

Go to wamp > bin > apache > apache version > conf > extra, open the file named httpd-vhosts.conf

- after this line

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

- add this kind of lines:

```
<VirtualHost *:80>
    ServerName projectname.localhost
    DocumentRoot C:/wamp/www/project-name
    SetEnv APPLICATION_ENV "development"
    <Directory C:/wamp/www/project-name>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

- then save and close this file.


**Second step, add a mapping rule for projectname.localhost**


Open your favorite text editor (or the default win) by right click > administrator.

Go to files > open in this text editor and search/goto > windows dir > system32 > Drivers > etc, open the file named hosts

- and add this line:

```
127.0.0.1	zf2-tutorial.localhost localhost
```

- then save and close this file > restart your computer.


Now you can use projectname.localhost as transparent rule for the main project folder placed in wamp > www dir.
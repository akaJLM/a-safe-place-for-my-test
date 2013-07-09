#WampServer and Zend Framework 2

## configure environment wamp

Resume
---

**A good way for zend framework 2 installation, using wamp**

Step
---

1 Install wamp, only the x86 version because the latest version of php is already most recent on x86 with wamp (usefull or mendatory to use PHPUnit). After installation, activate rewrite_module @ wamp icon in the task bar > apache > modules

2 Go to wamp > bin > php > php version folder, open the file php.ini and uncomment one line, usefull for the command line with composer.phar and others .phar (don't use the icon wamp in the task bar, it's not the same effect, one is for php as module of the http server, this other php.ini is for php as php application, only this change work for cli request).

```
extension=php_openssl.dll
```
3 Download composer.phar http://getcomposer.org/

4 Download zftool.phar https://packages.zendframework.com/zftool.phar

5 Download and install http://getcomposer.org/Composer-Setup.exe to fix the windows path environment (I think this exe file fix all your php.phar files)

6 Follow the instruction (the only one thing requested @ the installation is to match correctly the wamp directory of php.exe like wamp > bin > php > php version > php.exe)

remark: if you don't need extra install, you can define the variable path yourself or use all phar command in your shell with .\ before the.phar, and the command line run correctly

e.g.

```
cd c:/wamp/www
php .\composer.phar self-update
```

7 After downloading, put composer.phar and zftool.phar to the www directory of wamp

8 Download and install the github/shell @ http://windows.github.com/ (or another shell)

9 Go to > wamp > bin > apache > apache version > conf folder, open the file httpd.conf and uncomment the line

```
Include conf/extra/httpd-vhosts.conf
```

10 Start your Git shell or your shell

11 command line now...

```
cd c:/wamp/www
php zftool.phar create project c:/wamp/www/zf2
```

```
cd ./zf2
php composer.phar self-update
php composer.phar install
```

12 Go to > wamp > bin > apache > apache version > conf > extra folder, open the file httpd-vhosts.conf and add

```
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot "c:/wamp/www"
    SetEnv APPLICATION_ENV "development"
    <Directory c:/wamp/www>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerName zf2.localhost
    DocumentRoot "c:/wamp/www/zf2/public"
    SetEnv APPLICATION_ENV "development"
    <Directory c:/wamp/www/zf2/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

13 Open as administrator (right click) your text editor and open the file > windows > system32 > Drivers > etc > hosts and add the line

```
127.0.0.1	localhost
127.0.0.1	zf2.localhost localhost
```

14 Restart your computer (mendatory)

15 Start now your wamp server, open your browser and visit `zf2.localhost` - Welcome to Zend Framework coders !


**From now, it's a few step to start any project with zf2, just create the project with the step 11 (just choose another folder name) and also step 12 + 13 (just add a virtual host but just choose another folderpath name and another domain.localhost name)**

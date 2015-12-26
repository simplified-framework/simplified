Welcome to Simplified
---------------------

Simplified is a MVC (Model/View/Controller) framework written in PHP and it's key feature is to be simply,
be smart and work with most installable Composer components/libraries. It comes with url routing, a database 
ORM layer, support for simple PHP templates and support for twig and at last a integrated form builder.

###### Installation
To install the Simplified framework you need to install (if not already) Composer at first:

    $>php -r "readfile('https://getcomposer.org/installer');" | php 
    $>sudo mv composer.phar /usr/local/bin/composer 
    $>sudo chmod 775 /usr/local/bin/composer 

Once Composer is installed, you can start the Simplified installation process:

    $>composer create-project simplified/simplified YOUR_DIRECTORY "1.0.*"

###### Simplified on your web server
The Simplified framework runs at best on apache web servers, here you need to activate the mod_rewrite module
in the server configuration. If it's activated, you can view your installation on the url http://localhost or
directly on your web server providers url.

###### What's next?
At first, you need to know something about your application environment.

There is support for our tool named "Simplified Build" too, look at https://www.npmjs.com/package/simplified-build 
for the installation and usage.


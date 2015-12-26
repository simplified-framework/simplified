Welcome to Simplified
---------------------

Simplified is a MVC (Model/View/Controller) framework written in PHP and it's key feature is to be simply,
be smart and work with most installable Composer components/libraries. It comes with url routing, a database 
ORM layer, support for simple PHP templates and support for twig and at last a integrated form builder.

##### Installation
To install the Simplified framework you need to install (if not already) Composer at first:

    $>php -r "readfile('https://getcomposer.org/installer');" | php 
    $>sudo mv composer.phar /usr/local/bin/composer 
    $>sudo chmod 775 /usr/local/bin/composer 

Once Composer is installed, you can start the Simplified installation process:

    $>composer create-project simplified/simplified YOUR_DIRECTORY "1.0.*"

##### Simplified on your web server
The Simplified framework runs at best on apache web servers, here you need to activate the mod_rewrite module
in the server configuration. If it's activated, you can view your installation on the url http://localhost or
directly on your web server providers url.

##### What's next?
At first, you need to know something about your application environment. To keep things simple and developer friendly,
we have created a directory structure to point you to several things:

  - __app__
     - __config__  
       Used for your application configurations
     - __controllers__  
       Used for controllers
     - __database__  
       Used for migrations and seeds
     - __i18n__  
       Used for language translations
     - __models__  
       Used for databse models
     - __resources__  
       Used for views assets(scripts, (s)css and less files) and third party vendor files
     - __storage__  
       Used to store user sessions, sqlite databases and template cache files
  - __public__  
       The place where the index.php, .htaccess and generated css files/images are
  - __vendor__  
    component sub directories
     
##### Database configuration
To configure your database you have to edit/add a item in the configuration array.  
The first key is to make sure, the configuration can be found via a unique name, use "default" if you want this 
configuration as your default one. To setup other configurations, give them a name and tell the database connection this 
name - or set the connection name in your database model class.

##### Language configuration
To configure translations, simply set the language variable to the one you want to use, and the default as fallback.

##### Providers configuration

##### Routes configuration
To configure the application's routes - the ones that are responsable to answer network requests - is very simple
and easy to understand.

There is support for our tool named "Simplified Build" too, look at https://www.npmjs.com/package/simplified-build 
for the installation and usage.


# Welcome to Zuha
A collection of ever expanding functionality to rapidly build new sites.

Including content management, project management, invoicing, customer relationship management (CRM), ecommerce, multi-user blogs, social networking, video recording, and even more.

Built on an MVC framework (CakePHP), by a CakePHP contributor.


## Installation

* Create a database and save the login details. (host, db name, user, password)

* Upload the files to a supported server. 
* * Php 5.3 is required. 
* * mod_rewrite and .htaccess must be turned on

* Visit the domain that points to the directory Zuha was uploaded to.

## Security Issues

* After upload (before install) for additional security you can open sites.default/core.php and change the values for Security.salt, and Security.cipherSeed.
 
* After install, you can update InstallController to remove 'index' and 'site' from allowedActions array.


## Reporting issues

[Submit Issues on Github.com](https://github.com/zuha/zuha/issues) 

## Versions

Beta

## License

GPL Version 3
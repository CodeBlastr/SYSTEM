# Welcome to Zuha
A collection of ever expanding functionality to rapidly build new sites.

Including content management, project management, invoicing, customer relationship management (CRM), ecommerce, multi-user blogs, social networking, video recording, and even more.

Built on an MVC framework (CakePHP), by a CakePHP contributor.


## Installation

* Download the files OR BETTER if you plan to contribute, do a clone of the repository.

* * Clone using the command `git clone git://github.com/zuha/Zuha.git [REPLACE WITH DESIRED INSTALL DIRECTORY PATH]`

* * Php 5.3 is required, and MySQL 5+. 

* * mod_rewrite and .htaccess must be turned on

* * * Should have write permissions for all of the directories in "/app/tmp" and the "sites" directory. 

* Create a domain or subdomain name that points to the directory the files are saved to. (**IMPORTANT : You can NOT install to a subfolder.  Like example.com/zuha**, However you can install with a subdomain, like zuha.localhost, just plain localhost, zuha.example.com, or example.com)

* * for help creating a subdomain on mac : http://decoding.wordpress.com/2009/04/06/how-to-edit-the-hosts-file-in-mac-os-x-leopard/

* * for help creating a subdomain on windows : http://digitalpbk.blogspot.com/2007/01/making-subdomains-on-localhost.html

* Create a database and keep the login details handy. (host, db name, user, password)

* Visit the domain created in step two, and follow the prompts. 

* * Depending on your system, you may be prompted to update folder permissions at this point.  

## Security Issues

* After upload (before install) for additional security you can open sites.default/core.php and change the values for Security.salt, and Security.cipherSeed.
 
* After install, you can update InstallController to remove 'index' and 'site' from allowedActions array.

## Reporting issues

[Submit Issues on Github.com](https://github.com/zuha/zuha/issues) 

## Versions

Beta

## License

GPL Version 3
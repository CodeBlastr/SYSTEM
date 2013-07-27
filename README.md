# Welcome to Zuha

A collection of ever expanding functionality to rapidly build new sites.

Including content management, project management, invoicing, customer relationship management (CRM), ecommerce, multi-user blogs, social networking, video recording, and even more.

Built on an MVC framework (CakePHP), by a CakePHP contributor.


## Installation

1. Download the files *OR BETTER* if you plan to contribute, do a clone of the repository.
    * Clone using the command `git clone git@github.com:zuha/Zuha.git [REPLACE WITH DESIRED INSTALL DIRECTORY PATH]`
    * Note : Php 5.3+ is required, and MySQL 5+. 
    * Note : mod_rewrite and .htaccess must be turned on
+ Create a domain or subdomain name that points to the directory the files are saved to. 
    * **IMPORTANT : You can NOT install to a subfolder.  Like example.com/zuha**, only domains like example.localhost, localhost, example.com, subdomain.example.com
    * [For help creating a subdomain on localhost for mac](http://decoding.wordpress.com/2009/04/06/how-to-edit-the-hosts-file-in-mac-os-x-leopard/)
    * [For help creating a subdomain on localhost for windows](http://digitalpbk.blogspot.com/2007/01/making-subdomains-on-localhost.html)
+ Create a database and keep the login details handy. (host, db name, user, password)
+ Visit the domain created in step two, and follow the prompts. 
    * Depending on your system, you may be prompted to update folder permissions at this point for the "/app/tmp" and the "sites" directories.

## Optional Upgrade

1. There are a number of very useful additions listed [here](https://github.com/zuha/Zuha/wiki/Plugin-List)
+ You can pull one or all public plugins with git using these commands : 
    * Pull One
        * `git submodule update --init [PATH TO SUBMODULE]`
        * Ex. `git submodule update --init app/Plugin/Blogs`
    * Pull All
        * `git submodule update --init`, 
+ After you have successfully pulled one or many plugins go to [YOUR DOMAIN]/install to activate the individual plugins you wish to use.

## Security Issues

* After upload *(before install)* for additional security you can open sites.default/core.php and change the values for Security.salt, and Security.cipherSeed.  If you do this after install, you will not be able to login with the admin user your created during install.

## Reporting issues

[Submit Issues on Github.com](https://github.com/zuha/zuha/issues) 

## Versions

Version 1

## License

GPL Version 3

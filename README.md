# Welcome to Zuha (By: Buildrr)

A collection of ever expanding functionality to rapidly build new sites.

Including content management, project management, invoicing, customer relationship management (CRM), ecommerce, multi-user blogs, social networking, video recording, and even more.

Built on an MVC framework (CakePHP), by a CakePHP contributor.


## Git Clone Installation
1. Clone using the command `git clone git@github.com:zuha/Zuha.git [REPLACE WITH DESIRED INSTALL DIRECTORY PATH]`
+ Point a domain or subdomain to the directory the files were cloned to. 
+ Create a database and keep the login details handy. (host, db name, user, password)
+ Visit the domain created in step two, and follow the prompts.

## Download Installation
1. Download the files to zip and unpack.
+ Point a domain or subdomain to the directory the zip was unpacked to. 
+ Create a database and keep the login details handy. (host, db name, user, password)
+ Visit the domain created in step two, and follow the prompts.

## Optional Upgrade(s)
1. There are a number of very useful additions listed [here](https://github.com/zuha/Zuha/wiki/Plugin-List)
+ You can pull one or all public plugins with git using these commands : 
    * Pull One
        * `git submodule update --init [PATH TO SUBMODULE]`
        * Ex. `git submodule update --init app/Plugin/Blogs`
    * Pull All
        * `git submodule update --init`, 
+ After you have successfully pulled one or many plugins go to [YOUR DOMAIN]/install to activate the individual plugins you wish to use.

## Security Issues
* Before install, for additional security you can open sites.default/core.php and change the values for Security.salt, and Security.cipherSeed.  If you do this after install, you will not be able to login with the admin user your created during install.

## Troubleshooting
* **IMPORTANT : You can NOT install to a subfolder.  Like example.com/zuha**, only domains like example.localhost, localhost, example.com, subdomain.example.com
* Only tested on : PHP 5.3, PHP 5.5, MySQL 5, XAMPP, WAMP, AWS Bitnami Apache Install
* mod_rewrite and .htaccess Apache modules must be turned on and available.
* [For help creating a subdomain on localhost for mac](http://decoding.wordpress.com/2009/04/06/how-to-edit-the-hosts-file-in-mac-os-x-leopard/)
* [For help creating a subdomain on localhost for windows](http://digitalpbk.blogspot.com/2007/01/making-subdomains-on-localhost.html)
* If you download (instead of clone) be sure hidden files like .htaccess make it to the directory your domain or subdomain points to. 
* Depending on your system, you may be prompted to update folder permissions after download.

## Reporting issues

[Submit Issues on Github.com](https://github.com/zuha/zuha/issues) 

## Versions

[Latest Stable](https://github.com/zuha/Zuha/archive/master.zip)

## License

GPL Version 3

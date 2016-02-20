# Welcome (By: Buildrr)

A collection of ever expanding functionality to rapidly build new sites.

Including content management, project management, invoicing, customer relationship management (CRM), ecommerce, multi-user blogs, social networking, video recording, and even more.

Built on an MVC framework (CakePHP), by a CakePHP contributor.


## Git Clone Installation
1. Clone using the command `git clone git@github.com:zuha/Zuha.git [INSERT DESIRED INSTALL DIRECTORY PATH OR LEAVE BLANK TO INSTALL TO zuha FOLDER]`
+ use the command `cd [INSTALL DIRECTORY]`
+ use the command `git submodule update --init` IMPORTANT : Do not visit the site before running this, it will make this command fail.
+ use the command `git submodule foreach -q --recursive 'branch="$(git config -f $toplevel/.gitmodules submodule.$name.branch)"; [ "$branch" = "" ] && git checkout master || git checkout $branch'`
+ Point a domain or subdomain to the directory the files were cloned to. 
+ Create a database and keep the login details handy. (host, db name, user, password)
+ Visit the domain created in step two, and follow the prompts.

## Download Installation
1. Downloading might be possible, but is not supported. 

## Security Issues
* Before install, for additional security you can open sites.default/core.php and change the values for Security.salt, and Security.cipherSeed.  If you do this after install, you will not be able to login with the admin user your created during install.

## Troubleshooting
* **IMPORTANT : You can NOT install to a subfolder.  Like example.com/zuha**, only domains like example.localhost, localhost, example.com, subdomain.example.com
* Only tested on : PHP 5.4, PHP 5.5, MySQL 5, XAMPP, WAMP, AWS Bitnami Apache Install
* mod_rewrite and .htaccess Apache modules must be turned on and available.
* [For help creating a subdomain on localhost for mac](http://decoding.wordpress.com/2009/04/06/how-to-edit-the-hosts-file-in-mac-os-x-leopard/)
* [For help creating a subdomain on localhost for windows](http://digitalpbk.blogspot.com/2007/01/making-subdomains-on-localhost.html)
* Depending on your system, you may be prompted to update folder permissions after download.

## Reporting issues

[Submit Issues on Github.com](https://github.com/zuha/zuha/issues) 

## Versions

[Latest Stable](https://github.com/zuha/Zuha/archive/master.zip)

## License

GPL Version 3

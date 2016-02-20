# Buildrr PLATFORM <sup><sub>(by: [buildrr.com](https://buildrr.com))</sub></sup>

A collection of ever expanding functionality to rapidly build new sites.

Including content management, project management, invoicing, customer relationship management (CRM), ecommerce, multi-user blogs, social networking, video recording, and even more.

Built on an MVC framework (CakePHP 2.X), by a CakePHP contributor.


## Installation
Installation is not supported.

<!---
## Security Issues
* Before install, for additional security you can open sites.default/core.php and change the values for Security.salt, and Security.cipherSeed.  If you do this after install, you will not be able to login with the admin user your created during install.

## Troubleshooting
* **IMPORTANT : You can NOT install to a subfolder.  Like example.com/platform**, only domains like example.localhost, localhost, example.com, subdomain.example.com
* Only tested on : PHP 5.4, PHP 5.5, MySQL 5, XAMPP, WAMP, AWS Bitnami Apache Install
* mod_rewrite and .htaccess Apache modules must be turned on and available.
* [For help creating a subdomain on localhost for mac](http://decoding.wordpress.com/2009/04/06/how-to-edit-the-hosts-file-in-mac-os-x-leopard/)
* [For help creating a subdomain on localhost for windows](http://digitalpbk.blogspot.com/2007/01/making-subdomains-on-localhost.html)
* Depending on your system, you may be prompted to update folder permissions after download.
-->
## Reporting issues

[Submit Issues on Github.com](https://github.com/CodeBlastr/PLATFORM/issues) 

## Versions

[Latest Stable](https://github.com/CodeBlastr/PLATFORM/archive/master.zip)

## License

GPL Version 3
<!---
## future note for nginx

instead of the built in .htaccess (which doesn't work on nginx)

add this to the necessary .conf file (the correct conf file can vary too much to put a path here)

```
	location ~ "^(.*/)?\.git/" {
		return 403;
	}
	
	autoindex off;
	
	location / {
		rewrite ^/$ /app/webroot/ break;
		rewrite ^(.*)$ /app/webroot/$1 break;
	}
```
-->
####

Zuha is capable of hosting an unlimited number of sites from a single install. By editing the /sites/bootstrap.php file and telling it which domain resolve to which sites folder you can use the core app files and over write any core app files from within the site folder so that you can host multiple sites and yet still have full customization of each site.

Example : 

$domains['domain.localhost'] = 'domain.com';
$domains['dev.domain.com'] = 'domain.com';
$domains['www.domain.com'] = 'domain.com';
$domains['domain.com'] = 'domain.com';

Where $domains equals a key => value array where the key is the actual address that will appear in the browser address bar, and the value is the name of the folder in the sites directory which holds the site configuration and customization. 
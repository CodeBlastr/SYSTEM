# Welcome to Zuha
A collection of ever expanding functionality to rapidly build new sites.

Including content management, project management, invoicing, customer relationship management (CRM), ecommerce, multi-user blogs, social networking, video recording, and even more.

Built on an MVC framework (CakePHP), by a CakePHP contributor.


## Installation

Install the git
download git from: http://code.google.com/p/msysgit

Run Git setup.

In select component box click the "Advanced Context Menu radio button"

In Adjusting Your Path enviroment Box clik the "Run git from the windows Command Prompt" Then next 

In configuring the line ending conversions click the "Checkout as-is, commit Unix-style line endings" then next

open wamp server.

Then www. directory 

then right click on www folder goto bash

In command promet type :- git clone --help

Copy the foldar path from the github.com

Again in command prompt type for the cloning: git clone and folder path like (git clone git@github.snnsun20/zuha.git zuha)  
 
Then type Yes and continue connecting. 

Now come the the github.com and Edit your profile. 

In profile click the "SSH keys" then click the SSH key. Then right click on generating SSH keys and open it another Tab.

Now go to command promet type: cd~/.ssh 

then we will be in ~/.ssh 

now run the "ls" command to liss all the subdirectories in the current dirctoriy

now type ssh-keygen -t rsa -C "snnsun20@gmail.com"    put your email to generate public/Private RSA key pair.

now come to C:\  then domcument and settings follow the generated path in Git command prompt then click the .ssh folder in folder click Id_rsa file open with it Notepad. Copy all text from notepad id_rsa file

Now come on Github.com then Edit profile then SSH key now click on the "Add SSh Key" then "Title" and "Key" box will be open then in "Title" Put like Work Computer 
and in "Key" Paste the copy content from the "Id_rsa" file.  Now click on "Add key" to verify this process Confirm and put your password and confirm it.  Now the SSH key is generated. 

Now type of command prompt : cd/C/wamp/www  for come to www folder 

Now type : ls command to listing the directory  

Now type : git config --global user.name "Suraj"       for register user name

Now type : git config --global user.email snnsun20@gmail.com      for register email 

Now type : git clone git@github.com:snnsun20/Zuha.git zuha   folder path from github.com to make clone 

now type : cd zuha 

now type : git submodule update --init


Now right click on the Wamp server then Apache  then go to httpd.conf file open it and end of the file put after Include "c:/wamp/allias/"
 
<virtualHost ":80>
serverName localhost
DocumentRoot "c:\wamp\www\zuha"
DirectoryIndex index.php index.html index.html index.htm index.shtml 
</virtualHost>

Save the file 

Now restart the wamp server

Now go to http://localhost/install/site

Now every thing has been set up.


IMP Note: 
1. mod_rewrite (or rewrite_module) has to be on.
2. php 5.3 must be enabled
3. cannot be a subdiretory of a domain (eg. localhost, example.com must resolve to the zuha folder)
4. run the commands..
--- git clone <repo url> <directory>
--- git submodule update --init


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
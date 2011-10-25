<div id='pages-users-register'>
	<h1>Create Your Profile</h1>
	
<?php
$appId = Configure::read('Facebook.appId');
?>
<iframe src='http://www.facebook.com/plugins/registration.php?
             client_id=<?php echo $appId ?>&
             redirect_uri=<?php echo urlencode('http://' . $_SERVER['SERVER_NAME'] . '/facebook/facebook/register') ?>&
             fields=[{"name":"name"}, {"name":"first_name"}, {"name":"last_name"}, {"name":"username", "description":"Username", "type":"text"}, {"name":"password"}, {"name":"gender"}, {"name":"email"}, {"name":"birthday"}, {"name":"location"}]'
        scrolling="auto"
        frameborder="no"
        style="border:none"
        allowTransparency="true"
        width="100%"
        height="620">
</iframe>
</div>

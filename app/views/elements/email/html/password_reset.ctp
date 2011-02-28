Dear <?php echo $name?>,
<br></br><br></br>
    A reset of your password was requested.
<br></br><br></br>
    To complete the reset please follow the link below or copy it to your browser addres bar:
<br></br><br></br>
<?php echo Router::url(array('controller'=>'users', 'action'=>'reset_password', $key), true); ?><br></br>
If you have received this message in error please ignore, the link will be invalid in three days.

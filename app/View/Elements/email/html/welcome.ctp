Dear <?php echo $name?>,
<br></br><br></br>
    Congratulations! You have created an account with us.
<br></br><br></br>
    To complete the registration please activate your account by following the link below or by copying it to your browser:
<br></br><br></br>
<?php echo Router::url(array('controller'=>'users', 'action'=>'reset_password', $key), true); ?>

<br></br>
If you have received this message in error please ignore, the link will be unusable in three days.
<br></br><br></br>
    Thank you for registering with us and welcome to the community.
<?php
    echo $form->create('User', array('action' => 'login'));
    echo $form->input('username');
    echo $form->input('password');
    echo $form->end('Login');
?>
<?php # pr($menu); // the acl menu (only pages which this user has permission to access are linked to) ?>
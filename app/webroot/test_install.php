<?php
		
		$_POST['host'] = 'localhost';
		$_POST['login'] = 'root';
		$_POST['password'] = '';
		$_POST ['database'] = 'veevee';

		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://veevee.localhost/index.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		echo($response);	
?>
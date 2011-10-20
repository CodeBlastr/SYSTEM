
 <p>This email is notification that a new issue has been assigned to you. </p>
 
 <p>Subject: <?php echo $message['name']; ?></p>
  <p>Description: <?php echo substr($message['description'], 0, 100); ?></p>
  <p>Go To : <a href="<?php echo $_SERVER['HTTP_HOST'].$message['url']; ?>">Project Issue</a></p> 
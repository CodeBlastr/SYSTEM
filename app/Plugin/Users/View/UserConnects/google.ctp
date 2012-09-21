<?php 
if (empty($this->request->query['code'])) { ?> 
	<a href="https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=568942586542.apps.googleusercontent.com&approval_prompt=force&access_type=offline&scope=https://www.googleapis.com/auth/analytics.readonly+https://www.googleapis.com/auth/calendar+https://www.google.com/m8/feeds/+https://www.googleapis.com/auth/drive+https://www.googleapis.com/auth/drive.file+https://mail.google.com/mail/feed/atom+https://www.googleapis.com/auth/plus.me+https://www.googleapis.com/auth/tasks+https://www.google.com/webmasters/tools/feeds/&redirect_uri=http://www2.razorit.com/users/user_connects/google&state=%2Fcontacts%2Fcontacts%2Fimport%2Fgoogle">Authorize Google (note: state = the redirect page)</a>
<?php
} else {
	echo 'this is the post authorization';
}?>
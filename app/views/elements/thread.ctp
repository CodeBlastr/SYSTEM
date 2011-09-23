<?php
// setup defaults
#$data;
#$modelName;
#$fieldName;
#$level;
App::import('Helper', 'Thread');
$thread = new ThreadHelper;
echo $thread->show($name, $data); 
?>
<h2>Submit a Video</h2>

<?php
echo $this->Form->create('Video', array('type' => 'file'));
echo $this->Form->input('Video.submittedfile', array('between'=>'<br />','type'=>'file', 'label' => 'Upload a file from your computer:'));
echo $this->Form->input('Video.submittedurl', array('between'=>'<br />','type'=>'text', 'label' => 'Enter the URL of a file that is already online:'));
echo $this->Form->end('Submit');
?>
<?php

		echo '<div id="userEditThumb">';
	        echo $this->Element('thumb', array('thumbLink' => '', 'thumbLinkOptions' => array('style' => 'color: #333;font-size: 10px;'), 'model' => $model, 'foreignKey' => $foreignKey), array('plugin' => 'Galleries'));
	        echo $this->Html->link('Change Photo', '/', array('id' => 'userEditThumbLink', 'class' => 'toggleClick', 'data-target' => '#GalleryEditForm')); 
	   echo '</div>';
			
	        echo $this->Form->create('Gallery', array('url' => '/galleries/galleries/mythumb', 'enctype' => 'multipart/form-data'));
	        echo $this->Form->input('GalleryImage.is_thumb', array('type' => 'hidden', 'value' => 1));
	        echo $this->Form->input('GalleryImage.filename', array('label' => 'Choose image', 'type' => 'file'));
		    echo $this->Form->input('Gallery.model', array('type' => 'hidden', 'value' => $model));
	    	echo $this->Form->input('Gallery.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
	    	echo $this->Form->end('Upload'); 
<?php
echo $this->Form->create('Alias');
echo $this->Form->input('Alias.name');
echo $this->Form->input('Alias.plugin');
echo $this->Form->input('Alias.controller');
echo $this->Form->input('Alias.action');
echo $this->Form->input('Alias.value');
echo $this->Form->end('Save');
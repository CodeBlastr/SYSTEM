<h1>Followers</h1>

<table>
  <?php foreach($dat as $f):?>
  <tr>
    <td><?php echo $this->Element('thumb', array('model' => 'User', 'foreignKey' => $f['User']['id']), array('plugin' => 'galleries')); echo $f['User']['username'];?></td>
  </tr>
  
  <?php endforeach;?>
</table>

<h1>Followers</h1>

<table>
  <?php foreach($dat as $f):?>
  <tr>
    <td><?php echo $f['User']['username'];?></td>
  </tr>
  
  <?php endforeach;?>
</table>

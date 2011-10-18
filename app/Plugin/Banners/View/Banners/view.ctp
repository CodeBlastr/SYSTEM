<div class="banners view">
  <h2>
    <?php  __('Banner');?>
  </h2>
  <?php echo $this->element('thumb', array('plugin' => 'galleries',
 'model' => 'Banner', 'foreignKey' => $banner['Banner']['id'], 
'thumbSize' => 'small', 'thumbLink' => '#'));  ?>
  <table>
    <tr>
      <td><div class="th2">
          <?php echo __('Id'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['id']; ?> </div></td>
    </tr>
    <tr>
      <td><?php echo __('Name'); ?></td>
      <td><?php echo $banner['Banner']['name']; ?></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Description'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['description']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Banner Position'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $this->Html->link($banner['Banner']['banner_position_id'], 
			array('controller' => 'banner_positions', 'action' => 'view', $banner['Banner']['banner_position_id'])); ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Schedule Start Date'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['schedule_start_date']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Schedule End Date'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['schedule_end_date']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Type'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['type']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Gender'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['gender']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Age Group'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['age_group']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Price'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['price']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Redumption Url'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['redemption_url']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Discount Price'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['discount_price']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Discount Percentage'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['discount_percentage']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Is Published'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['is_published']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Created'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['created']; ?> </div></td>
    </tr>
    <tr>
      <td><div class="th2">
          <?php echo __('Modified'); ?>
        </div></td>
      <td><div class="th2"> <?php echo $banner['Banner']['modified']; ?> </div></td>
    </tr>
  </table>
</div>
<div class="actions">
  <ul>
    <li><?php echo $this->Html->link(__('Edit Banner', true), array('action' => 'edit', $banner['Banner']['id'])); ?> </li>
    <li><?php echo $this->Html->link(__('Delete Banner', true), array('action' => 'delete', $banner['Banner']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $banner['Banner']['id'])); ?> </li>
    <li><?php echo $this->Html->link(__('Banner Reports', true), array('action' => 'reports', $banner['Banner']['id'])); ?> </li>
  </ul>
</div>

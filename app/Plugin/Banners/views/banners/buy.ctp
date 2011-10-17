<?php 
/**
 * 
 * 
 * @todo	We should have a separate view file for each banner type, and let the controller pick which view file to display.  That will allow us to keep the html separate for each banner type.
 */
?>
<?php 
	echo $this->Html->script('admin/jquery-ui-1.8.13.custom.min');
	echo $this->Html->css('admin/jquery-ui-1.8.13.custom');
	echo $this->Form->create('Banner');
?>
<h1><?php __($this->request->params['named']['bannerType'].' Ad Builder'); ?></h1>
<fieldset id="step1">
  <?php
	echo $this->Form->hidden('banner_position_id', array('value' => $bannerPositionId));
	echo $this->Form->hidden('customer_id', array('value' => $this->Session->read('Auth.User.id'))); 
	echo $this->Form->input('location', array('empty' => true, 'class' => 'text-1 BannerLocation', 
			'div' => array('class' => 'text-inputs')));
	echo $this->Html->link('Place Offer', '#', array('id' => 'go', 'class' => 'submit1'));
	?>
</fieldset>
<fieldset id="step2" style="display:none">
  <fieldset>
    <table>
      <tr>
        <td>Location:</td>
        <td><div id = "selected_location"></div></td>
      </tr>
    </table>
  </fieldset>
  <!-- week/month fields for advertiser -->
  <?php echo $this->element('buy_period', array('plugin' => 'banners', 'instance' => 2)); 	
	  echo $this->Form->input('schedule_start_date', array('type' => 'text', 'label' => 'Choose Date', 'id' => 'BannerStartDate', 'class' => 'text-1'));
	  echo $this->Form->input('schedule_end_date', array('type' => 'text', 'id' => 'BannerEndDate')); ?>
  <div id="BannerDemographic" style="display:none"></div>
  <fieldset id = "selection" style="display:none">
    <table>
      <tr></tr>
      <tr>
        <th> Selected Gender</th>
        <th>Selected Age Group</th>
      </tr>
      <tr>
        <td><?php echo $this->Form->input('Banner.gender', array('readonly'=>true,
						    				'id'=>'BannerGender', 'div'=>false, 'label'=>false, 
						    				'style' => 'text-align:center;width:180px'))?></td>
        <td><?php echo $this->Form->input('Banner.age_group', array('readonly'=>true,
						    					'id'=>'BannerAgeGroup', 'div'=>false, 'label'=>false,
					    						'style' => 'text-align:center;width:180px'))?></td>
      </tr>
    </table>
    <input type="submit" value="Purchase" class="submit1" name="Purchase">
  </fieldset>
</fieldset>
<script>
$('#BannerLocation').change(function(){
	$('#selected_location').html($('#BannerLocation').val());
});

// on GO button click  
$('#go').click(function(e){
	e.preventDefault();
	
	completed = true;
	$(".BannerLocation").each(function() {
		if ($(this).val() == '') {
			completed = false;
		}
	})
	if (completed) {
		$('#step1').hide();
		$('#step2').show();
	} 
});

$('.BannerDemographicAgeGroupM').live('click',function() {
	$('#BannerAgeGroup').val($(this).val());
	$('#BannerGender').val('M');	
});

$('.BannerDemographicAgeGroupF').live('click',function() {
	$('#BannerAgeGroup').val($(this).val());
	$('#BannerGender').val('F');	
});

// get selected time slot option for Advertizer 
var dateOption = '';
$('.BannerDateOption').click(function() {
	dateOption = $(this).attr("value");
	$('.BannerDateOption').removeClass('submit1');
	$('.BannerDateOption').addClass('submit2');
	$(this).removeClass('submit2');
	$(this).addClass('submit1');
});

// datepicker for date selection
$('#BannerStartDate').datepicker({
	dateFormat: 'yy-mm-dd',
	yearRange: '2011:2020',
	changeMonth: true,
	changeYear: true,
	// on date select 
	onSelect: function(dateText, inst) {

		// if dateOption for week/month is selected
		if(dateOption){
			var date = Date.parse(dateText);
			if(dateOption == 'week') {
				date += (86400000 * 6) ;
			} else if(dateOption == 'month') { 
				date += (86400000 * 30) ; 
			}
			// calculate end date and set the value 
			var dt2 =new Date(date);
			end_date = dt2.getFullYear()+ '-' + (parseInt(dt2.getMonth())+1) + '-' + dt2.getDate() ;
			$('#BannerEndDate').val(end_date);
		} else {
			$('#BannerEndDate').val(dateText);
		}
		// ajax call according to given data to fetch available slots
		$.ajax({
	        type: "POST",
	        data: $('#BannerBuyForm').serialize(),
			url: "/banners/banners/get_avaialable_slots/" ,
	        dataType: "text",						 
	        success:function(data){
				response(data)
	        }
	    });
	}
});

function response(data) {
	if (data.length > 0) {
		var response = JSON.parse(data);
		$(':button').attr('disabled', false);
		str = '	<label>Choose Demographic</label><table cellspacing="0" cellpadding="0" border="0">		<tbody><tr>			<th>';
		str += '<div class="th1"><label value="M" class="BannerDemographicGender" for="BannerGender">Males</label>';
		str +='</div></th><th><div class="th1"><label value="F" class="BannerDemographicGender" for="BannerGender">Females</label>';								
		str +='	</div></th></tr>';
		$.each(response, function(i, item) {
			str += '<tr>';
			str += '<td><div style="height: 40px;" class="th2">';
				if(item.M == '1') {
					str += '<button style="margin-left: 40px;" class="BannerDemographicAgeGroupM submit2" value="' + i + '" type="button">'+ i + '</button>';
				} else {
					str += '<div style="color: red; line-height: 70px; height: 38px;">';
				}
		str += '</div></td>';
		
		str += '<td><div style="height: 40px;" class="th2">';
				if(item.F == '1') {
					str += '<button style="margin-left: 40px;" class="BannerDemographicAgeGroupF submit2" value="' + i + '" type="button">'+ i + '</button>';
				} else {
					str += '<div style="color: red; line-height: 70px; height: 38px;">';
				}
			str += '</div></td>';
			str += '</tr>';
		});
		str += '<tr><td colspan="2"></td></tr>';
		str += '</tbody></table>';
		$('#BannerDemographic').html(str);
		$('#BannerDemographic').show();
		$('#selection').show();
	}
}

</script>

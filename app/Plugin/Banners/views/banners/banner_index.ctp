<div class="banners index form">
  <?php 
 		echo $this->Html->script('system/jquery.validate.min');
		echo $this->Form->create('Banner');
	?>
  <div id="jags"></div>
  <div id="nav"> <?php echo $this->Html->image("../images/banner.png");?> </div>
  <div id="step1">
    <div id="content">
      <h2>Please select Demographic</h2>
      <div id="summary">
        <p>...and we will serve up a Daily Deal appropriate tailored just for you!</p>
      </div>
      <?php echo $this->Form->hidden('gender'); 
				echo $this->Form->input('email', array('class' => 'required email'));
				echo $this->Form->submit('Male', array('value' => 'M', 'id' => 'male',
												'class' => 'BannerDemographicGender demographic'));
				echo $this->Form->submit('Female', array('value' => 'F', 
												'class' => 'BannerDemographicGender demographic'));
				?> </div>
  </div>
  <div id="step2" style="display:none">
    <div id="content">
      <h2>Please select Demographic</h2>
      <div id="summary">
        <p>...and we will serve up a Daily Deal appropriate tailored just for you!</p>
      </div>
      <?php
						echo $this->Form->hidden('age_group');  	
						foreach($age_group as $ageGroup) {
								echo $this->Form->submit($ageGroup, array('value' => $ageGroup, 
									'class' => 'BannerDemographicAgeGroup demographic'));
						}
						if(isset($this->params['named']['location'])){
							echo $this->Form->hidden('location', array('value' => $this->params['named']['location']));	
						} else {
							echo $this->Form->hidden('location', array('value' => $location));					
						}	
					?>
    </div>
  </div>
</div>
<script type="text/javascript">
$().ready(function() {	
	$("#BannerBannerIndexForm").validate();
});
</script>

<script>

//on gender selection 
$('.BannerDemographicGender').click(function(e) {
	if ($("#BannerBannerIndexForm").valid()) {
		e.preventDefault();
		var value = $(this).attr("value") ;
		$('#BannerGender').val(value[0]);
		$('#step1').hide();
		$('#step2').show();
	}
});

//on age group selection
$('.BannerDemographicAgeGroup').click(function(e) {
	e.preventDefault();
	var value = $(this).attr("value") ;
	$('#BannerAgeGroup').val(value);
	// ajax call to save demographics in sessions 
	$.ajax({
        type: "POST",
        data: $('#BannerBannerIndexForm').serialize(),
		url: "/banners/banners/banner_index/" ,
        dataType: "text",						 
        success:function(){
			$('#step2').hide();
			<?php 
				if(defined('__ELEMENT_BANNERS_POSITIONS_2')) {
					extract(unserialize(constant('__ELEMENT_BANNERS_POSITIONS_2')));
				} else if (defined('__ELEMENT_BANNERS_POSITIONS')) {
					extract(unserialize(__ELEMENT_BANNERS_POSITIONS));
				}
				$bannerType = !empty($bannerType) ? $bannerType : null;
			?>
			window.location.href = "/banners/banners/view_offer/bannerType:<?php echo $bannerType; ?>" ;
		}
    });	
});


//Find Deal Click 
$('.BannerLocation').click(function(e) {
	e.preventDefault();
	// ajax call to save demographics in sessions 
	$.ajax({
        type: "POST",
        data: $('#BannerBannerIndexForm').serialize(),
		url: "/banners/banners/banner_index/" ,
        dataType: "text",						 
        success:function(){
			$('#step3').hide();
			window.location.href = "/banners/banners/view_offer";
		}
    });	
});
</script>

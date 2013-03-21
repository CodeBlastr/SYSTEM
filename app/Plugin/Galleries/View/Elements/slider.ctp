<?php
// get rid of this file 12/27/2012 RK
// additional files needed for Nivo Slider display
echo $this->Html->script('/galleries/js/nivoslider/jquery.nivo.slider.pack');
echo $this->Html->css('/galleries/css/nivoslider/nivo-slider');
?>

        <div class="slider-wrapper" style="margin: 10px auto; width: 910px;">
            <div class="ribbon"></div>
            <div id="slider" class="nivoSlider">
                <img src="/theme/default/images/slider/slide1.png" alt="" />
                <img src="/theme/default/images/slider/slide2.png" alt="" />
                <img src="/theme/default/images/slider/slide3.png" alt="" />
                <img src="/theme/default/images/slider/slide4.png" alt="" />
                <img src="/theme/default/images/slider/slide5.png" alt="" />
                <img src="/theme/default/images/slider/slide6.png" alt="" />
                <img src="/theme/default/images/slider/slide7.png" alt="" />
            </div>
        </div>

    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider({
          controlNav: false,
          effect: 'sliceDown'
        });
    });
    </script>
    

<div class="slide-wrapper">
<div class="slide-container">
<div id="slides">
<div class="slides_container">
<div class="slide"><a href="#" target="_blank" title="title1"><img alt="Slide 1" src="/theme/default/upload/1/img/slide-1.jpg" style="width: 630px; height: 396px;" /></a>

<div class="caption">
<p>finding a home was never this easy</p>
</div>
</div>

<div class="slide"><a href="#" target="_blank" title="title2"><img alt="Slide 2" src="/theme/default/upload/1/img/slide-2.jpg" style="width: 630px; height: 396px;" /></a>

<div class="caption">
<p>lorem ipsum dolor</p>
</div>
</div>

<div class="slide"><a href="#" target="_blank" title="title3"><img alt="Slide 3" src="/theme/default/upload/1/img/slide-3.jpg" style="width: 630px; height: 396px;" /></a>

<div class="caption">
<p>finding a home was never this easy</p>
</div>
</div>
</div>
</div>
</div>
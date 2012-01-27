<?PHP
# additional files needed for Nivo Slider display
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
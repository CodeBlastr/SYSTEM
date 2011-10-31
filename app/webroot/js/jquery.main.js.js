// page init
jQuery(function() {
	initNav();
	initCufon();
	initPie();
	initGallery();
})

// cufon init
function initCufon() {
	Cufon.replace('.about h3, .info-container .heading h3,.sign-holder .info', { fontFamily: 'Avalon Medium', hover: true });
	Cufon.replace('.box .warning', { fontFamily: 'Bell MT', hover: true });
	Cufon.replace('.entry-section p', { textShadow: '#333 1px 1px', fontFamily: 'Axure Handwriting', hover: true });
	Cufon.replace('#main h2, .contact-block h3', { textShadow: '#000 2px 2px', fontFamily: 'Arial Rounded MT Bold', hover: true });
	Cufon.replace('#main .text-section h3 span,#main .text-section h3 em,.text-section ul .num', { textShadow: '#fff 2px 2px', fontFamily: 'Arial Rounded MT Bold', hover: true });
}

// pie init
function initPie() {
	if(window.PIE) {
		jQuery('#header, .text, .submit, #nav, .gallery, #nav a, .text-block, .block, .info-area, .info-container, .photo').each(function() {
			PIE.attach(this);
		});
	}
}

// autoscaling navigation init
function initNav() {
	initAutoScalingNav({
		menuId: "nav",
		sideClasses: true,
		minPaddings: 10,
		spacing: 2
	});
}

// gallery init
function initGallery() {
	jQuery('.gallery').gallery({
		listOfSlides: 'ul > li',
		slideElement: 1,
		autoRotation: 4000,
		nextBtn: 'a.btn-next',
		prevBtn: 'a.btn-previous'
	});
}

// autoscaling navigation
function initAutoScalingNav(o) {
	if (!o.menuId) o.menuId = "nav";
	if (!o.tag) o.tag = "a";
	if (!o.spacing) o.spacing = 0;
	if (!o.constant) o.constant = 0;
	if (!o.minPaddings) o.minPaddings = 0;
	if (!o.liHovering) o.liHovering = false;
	if (!o.sideClasses) o.sideClasses = false;
	if (!o.equalLinks) o.equalLinks = false;
	if (!o.flexible) o.flexible = false;
	var nav = document.getElementById(o.menuId);
	if(nav) {
		nav.className += " scaling-active";
		var lis = nav.getElementsByTagName("li");
		var asFl = [];
		var lisFl = [];
		var width = 0;
		for (var i=0, j=0; i<lis.length; i++) {
			if(lis[i].parentNode == nav) {
				var t = lis[i].getElementsByTagName(o.tag).item(0);
				asFl.push(t);
				asFl[j++].width = t.offsetWidth;
				lisFl.push(lis[i]);
				if(width < t.offsetWidth) width = t.offsetWidth;
			}
			if(o.liHovering) {
				lis[i].onmouseover = function() {
					this.className += " hover";
				}
				lis[i].onmouseout = function() {
					this.className = this.className.replace("hover", "");
				}
			}
		}
		var menuWidth = nav.clientWidth - asFl.length*o.spacing - o.constant;
		if(o.equalLinks && width * asFl.length < menuWidth) {
			for (var i=0; i<asFl.length; i++) {
				asFl[i].width = width;
			}
		}
		width = getItemsWidth(asFl);
		if(width < menuWidth) {
			var version = navigator.userAgent.toLowerCase();
			for (var i=0; getItemsWidth(asFl) < menuWidth; i++) {
				asFl[i].width++;
				if(!o.flexible) {
					asFl[i].style.width = asFl[i].width + "px";
				}
				if(i >= asFl.length-1) i=-1;
			}
			if(o.flexible) {
				for (var i=0; i<asFl.length; i++) {
					width = (asFl[i].width - o.spacing - o.constant/asFl.length)/menuWidth*100;
					if(i != asFl.length-1) {
						lisFl[i].style.width = width + "%";
					}
					else {
						if(navigator.appName.indexOf("Microsoft Internet Explorer") == -1 || version.indexOf("msie 8") != -1 || version.indexOf("msie 9") != -1)
							lisFl[i].style.width = width + "%";
					}
				}
			}
		}
		else if(o.minPaddings > 0) {
			for (var i=0; i<asFl.length; i++) {
				asFl[i].style.paddingLeft = o.minPaddings + "px";
				asFl[i].style.paddingRight = o.minPaddings + "px";
			}
		}
		if(o.sideClasses) {
			lisFl[0].className += " first-child";
			lisFl[0].getElementsByTagName(o.tag).item(0).className += " first-child-a";
			lisFl[lisFl.length-1].className += " last-child";
			lisFl[lisFl.length-1].getElementsByTagName(o.tag).item(0).className += " last-child-a";
		}
		nav.className += " scaling-ready";
	}
	function getItemsWidth(a) {
		var w = 0;
		for(var q=0; q<a.length; q++) {
			w += a[q].width;
		}
		return w;
	}
}

// scroll gallery
(function($) {
	$.fn.gallery = function(options) { return new Gallery(this.get(0), options); };
	function Gallery(context, options) { this.init(context, options); };
	Gallery.prototype = {
		options:{},
		init: function (context, options){
			this.options = $.extend({
				infinite: true,								//true = infinite gallery
				duration: 700,									//duration of effect it 1000 = 1sec
				slideElement: 1,								//number of elements for a slide
				autoRotation: 5000,							//false = option is disabled; 1000 = 1sec
				effect: false,									//false = slide; true = fade
				listOfSlides: 'ul > li',						//elements galleries
				switcher: false,								//false = option is disabled; 'ul > li' = elements switcher
				disableBtn: false,								//false = option is disabled; 'hidden' = class adds an buttons "prev" and "next"
				nextBtn: 'a.link-next, a.btn-next, a.next',		//button "next"
				prevBtn: 'a.link-prev, a.btn-prev, a.prev',		//button "prev"
				circle: true,									//true = cyclic gallery; false = not cyclic gallery
				direction: false,								//false = horizontal; true = vertical
				event: 'click',									//event for the buttons and switcher
				IE: false,										//forced off effect it "fade" in IE
				autoHeight: false								//auto height on fade
			}, options || {});
			var _el = $(context).find(this.options.listOfSlides);
			if (this.options.effect) this.list = _el;
			else this.list = _el.parent();
			this.switcher = $(context).find(this.options.switcher);
			this.nextBtn = $(context).find(this.options.nextBtn);
			this.prevBtn = $(context).find(this.options.prevBtn);
			this.count = _el.index(_el.filter(':last'));
			
			if (this.options.switcher) this.active = this.switcher.index(this.switcher.filter('.active:eq(0)'));
			else this.active = _el.index(_el.filter('.active:eq(0)'));
			if (this.active < 0) this.active = 0;
			this.last = this.active;
			
			this.woh = _el.outerWidth(true);
			if (!this.options.direction) this.installDirections(this.list.parent().width());
			else {
				this.woh = _el.outerHeight(true);
				this.installDirections(this.list.parent().height());
			}
			
			if (!this.options.effect) {
				this.rew = this.count - this.wrapHolderW + 1;
				if (!this.options.direction) this.anim = '{marginLeft: -(this.woh * this.active)}';
				else this.anim = '{marginTop: -(this.woh * this.active)}';
				eval('this.list.css('+this.anim+')');
			}
			else {
				this.rew = this.count;
				this.list.css({opacity: 0}).removeClass('active').eq(this.active).addClass('active').css({opacity: 1}).css('opacity', 'auto');
				this.switcher.removeClass('active').eq(this.active).addClass('active');
				if(this.options.autoHeight) this.list.parent().css({height: this.list.eq(this.active).outerHeight()});
			}
			this.flag = true;
			if (this.options.infinite){
				this.count++;
				this.active += this.count;
				this.list.append(_el.clone());
				this.list.append(_el.clone());
				eval('this.list.css('+this.anim+')');
			}
			
			this.initEvent(this, this.nextBtn, true);
			this.initEvent(this, this.prevBtn, false);
			if (this.options.disableBtn) this.initDisableBtn();
			if (this.options.autoRotation) this.runTimer(this);
			if (this.options.switcher) this.initEventSwitcher(this, this.switcher);
		},
		initDisableBtn: function(){
			this.prevBtn.removeClass('prev-'+this.options.disableBtn);
			this.nextBtn.removeClass('next-'+this.options.disableBtn);
			if (this.active == 0 || this.count+1 == this.wrapHolderW) this.prevBtn.addClass('prev-'+this.options.disableBtn);
			if (this.active == 0 && this.count == 1 || this.count+1 <= this.wrapHolderW) this.nextBtn.addClass('next-'+this.options.disableBtn);
			if (this.active == this.rew) this.nextBtn.addClass('next-'+this.options.disableBtn);
		},
		installDirections: function(temp){
			this.wrapHolderW = Math.ceil(temp / this.woh);
			if (((this.wrapHolderW - 1) * this.woh + this.woh / 2) > temp) this.wrapHolderW--;
		},
		fadeElement: function(){
			if ($.browser.msie && this.options.IE){
				this.list.eq(this.last).css({opacity:0});
				this.list.removeClass('active').eq(this.active).addClass('active').css({opacity:'auto'});
			}
			else{
				this.list.eq(this.last).stop().animate({opacity:0}, {queue:false, duration: this.options.duration});
				this.list.removeClass('active').eq(this.active).addClass('active').stop().animate({
					opacity:1
				}, {queue:false, duration: this.options.duration, complete: function(){
					$(this).css('opacity','auto');
				}});
			}
			if(this.options.autoHeight) this.list.parent().stop().animate({height: this.list.eq(this.active).outerHeight()}, {queue:false, duration: this.options.duration});
			if (this.options.switcher) this.switcher.removeClass('active').eq(this.active).addClass('active');
			this.last = this.active;
		},
		scrollElement: function($this){
			if (!$this.options.infinite) eval('$this.list.stop().animate('+$this.anim+', {queue:false, duration: $this.options.duration});');
			else eval('$this.list.stop().animate('+$this.anim+', $this.options.duration, function(){ $this.flag = true });');
			if ($this.options.switcher) $this.switcher.removeClass('active').eq($this.active / $this.options.slideElement).addClass('active');
		},
		runTimer: function($this){
			if($this._t) clearTimeout($this._t);
			$this._t = setInterval(function(){
				if ($this.options.infinite) $this.flag = false;
				$this.toPrepare($this, true);
			}, this.options.autoRotation);
		},
		initEventSwitcher: function($this, el){
			el.bind($this.options.event, function(){
				$this.active = $this.switcher.index($(this)) * $this.options.slideElement;
				if($this._t) clearTimeout($this._t);
				if ($this.options.disableBtn) $this.initDisableBtn();
				if (!$this.options.effect) $this.scrollElement($this);
				else $this.fadeElement();
				if ($this.options.autoRotation) $this.runTimer($this);
				return false;
			});
		},
		initEvent: function($this, addEventEl, dir){
			addEventEl.bind($this.options.event, function(){
				if ($this.flag){
					if ($this.options.infinite) $this.flag = false;
					if($this._t) clearTimeout($this._t);
					$this.toPrepare($this, dir);
					if ($this.options.autoRotation) $this.runTimer($this);
				}
				return false;
			});
		},
		toPrepare: function($this, side){
			if (!$this.options.infinite){
				if (($this.active == $this.rew) && $this.options.circle && side) $this.active = -$this.options.slideElement;
				if (($this.active == 0) && $this.options.circle && !side) $this.active = $this.rew + $this.options.slideElement;
				for (var i = 0; i < $this.options.slideElement; i++){
					if (side) { if ($this.active + 1 <= $this.rew) $this.active++; }
					else { if ($this.active - 1 >= 0) $this.active--; }
				};
			}
			else{
				if ($this.active >= $this.count + $this.count && side) $this.active -= $this.count;
				if ($this.active <= $this.count-1 && !side) $this.active += $this.count;
				eval('$this.list.css('+$this.anim+')');
				if (side) $this.active += $this.options.slideElement;
				else $this.active -= $this.options.slideElement;
			}
			if (this.options.disableBtn) this.initDisableBtn();
			if (!$this.options.effect) $this.scrollElement($this);
			else $this.fadeElement();
		},
		stop: function(){
			if (this._t) clearTimeout(this._t);
		},
		play: function(){
			if (this._t) clearTimeout(this._t);
			if (this.options.autoRotation) this.runTimer(this);
		}
	}
}(jQuery));
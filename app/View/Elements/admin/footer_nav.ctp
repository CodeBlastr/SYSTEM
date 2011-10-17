<div id="awesomeFooter">
  <div class="gridContainer" id="footer">
    <div class="gridRow">
      <div class="footerHeading">
        <ul class="loggedIn <?php if(!$this->Session->read('Auth.User')) { echo 'hide'; } ?>">
          <li><?php echo $this->Element('snpsht', array('useGallery' => true, 'userId' => $this->Session->read('Auth.User.id'), 'thumbAlt' => $this->Session->read('Auth.User.username'), 'thumbTitle' => $this->Session->read('Auth.User.username'), array('plugin' => 'users'))); ?></li>
          <li><span>Welcome <span><?php echo $this->Session->read('Auth.User.username'); ?></span></span> </li>
          <li><a href="/users/users/logout"><span>Logout</span></a> </li>
          <li><a href="/admin/settings"><span><?php echo 'Zuha Version: '.__SYSTEM_ZUHA_DB_VERSION; ?></span></a></li>
        </ul>
        <ul class="loggedOut <?php if($this->Session->read('Auth.User.username')) { echo 'hide'; } ?> ">
          <li> <a href="/users/users/register"><span>Sign Up</span></a></li>
          <li><a href="/users/users/login"><span>Sign In</span></a></li>
        </ul>
        <ul>
        	<?php /* foreach ($editorUserRoles as $role) : ?>
        	<li><a href="/users/user_roles/display_role/<?php echo $role; ?>">View page as <?php echo Inflector::singularize($role); ?></li>
            <?php endforeach; */ ?>
        	<li><a href="#" id="helpOpen">Turn Help Text On</a></li>
        </ul>
      </div>
    </div>
  </div>
  <!--div class="gridContainer" id="footerMenu">
    <div class="gridRow">
      <div class="gridCol2">
        <ul>
          <li class="heading"> <a href="#" title="Features"> <strong>Promo</strong> </a> </li>
          <li><a href="#">Promotions Links</a></li>
        </ul>
      </div>
      <div class="gridCol2">
        <ul class="noHeading">
          <li><a href="#">More Promo Links</a></li>
        </ul>
      </div>
      <div class="gridCol2">
        <ul>
          <li class="heading"> <a href="#"> <strong>More</strong> </a> </li>
          <li><a href="#">more</a></li>
        </ul>
      </div>
      <div class="gridCol2">
        <ul>
          <li class="heading"> <a href="#" title="Prices"> <strong>Prices</strong> </a> </li>
          <li><a href="#" title="Free">Free</a></li>
          <li><a href="#" title="Pay as you Go">Pay As You Go</a></li>
          <li><a href="#" title="Pay Monthly">Pay Monthly</a></li>
          <li><a href="#" title="Customization Credit">Customization Credit</a></li>
        </ul>
      </div>
      <div class="gridCol2">
        <ul>
          <li class="heading"> <a href="#" title="zuha Store"> <strong>zuha Store</strong> </a> </li>
          <li><a href="#">Category Link</a></li>
        </ul>
      </div>
      <div class="gridCol2">
        <ul>
          <li class="heading"><a href="#" title="Support"><strong>Support</strong></a></li>
          <li><a href="#">Support Links</a></li>
        </ul>
      </div>
    </div>
  </div-->
  <div class="gridContainer" id="bottomNavigation">
    <div class="gridRow">
      <div class="gridCol12">
        <!--div id="footerNavigation"> <a href="http://zuha.org/">About us</a> - <a href="http://zuha.org/">Blogs</a> - <a href="http://zuha.org/">Developers</a> - <a href="http://zuha.org/">Jobs</a> - <a href="http://zuha.org/">Rates</a></div-->
        <div id="legalLinks"> <a href="http://zuha.org/">Privacy policy</a> - <a href="http://zuha.org">Legal</a> <span>&copy; 2010 Zuha Foundation</span> <a id="fontSize1">A</a> <a id="fontSize2">A</a> <a id="fontSize3">A</a></div>
      </div>
    </div>
  </div>
</div>
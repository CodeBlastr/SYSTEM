<div id="awesomeFooter">
  <div class="gridContainer" id="footer">
    <div class="gridRow">
      <?php if($this->Session->read('Auth.User')) : ?>
      <div class="footerHeading">
        <ul class="loggedIn">
          <li><?php echo $this->Element('snpsht', array('useGallery' => true, 'userId' => $this->Session->read('Auth.User.id'), 'thumbAlt' => $this->Session->read('Auth.User.username'), 'thumbTitle' => $this->Session->read('Auth.User.username')), array('plugin' => 'Users')); ?></li>
          <li><span>Welcome <span><?php echo $this->Html->link($this->Session->read('Auth.User.username'), array('plugin' => 'users', 'controller' => 'users', 'action' => 'my')); ?></span></span> </li>
          <li><a href="/users/users/logout"><span>Logout</span></a> </li>
        </ul>
      </div>
      <?php else : ?>
      <div class="footerHeading">
        <ul class="loggedOut <?php if($this->Session->read('Auth.User.username')) { echo 'hide'; } ?> ">
          <li> <a href="/users/users/register"><span>Sign Up</span></a></li>
          <li><a href="/users/users/login"><span>Sign In</span></a></li>
        </ul>
      </div>
      <?php endif; ?>
    </div>
    <a href="http://www.zuha.com/"><img id="zuhaLogo" src="/img/admin/logo.png" alt="Zuha Small Business Management" /></a>
    <div id="bottomNavigation">
      <div class="gridRow">
        <div class="gridCol12"> 
          <div id="legalLinks"> <a href="/admin/settings"><span><?php echo defined('__SYSTEM_ZUHA_DB_VERSION') ? 'Zuha Version: '.__SYSTEM_ZUHA_DB_VERSION : 'Version undefined'; ?></span></a> <a href="#" id="helpOpen">Turn Help Text On</a> </div>
          <div id="legalLinks"> <a href="http://zuha.org/">Privacy policy</a> - <a href="http://zuha.org">Legal</a> <span>&copy; 2010 Zuha Foundation</span> <a id="fontSize1">A</a> <a id="fontSize2">A</a> <a id="fontSize3">A</a></div>
        </div>
      </div>
    </div>
  </div>
</div>

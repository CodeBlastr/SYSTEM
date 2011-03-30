<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
<?php echo $html->charset(); ?>
<title><?php echo $title_for_layout; __(' : Zuha Business Management'); ?></title>
<!--[if lt IE 7]><?php echo $this->Html->css('lt7'); ?><![endif]-->
<?php
		echo $this->Html->meta('icon');		
		echo $this->Html->css('admin');	
		
		echo $this->Html->script('jquery-1.4.2.min');
		echo $this->Html->script('admin/ifixpng');
		
		echo $this->Html->script('jquery.jeditable');
		echo $this->Html->script('admin/admin');
		echo $this->Html->script('admin/jquery-ui-1.8.custom.min');
		
		echo $scripts_for_layout;  // to use this specify false for the 'in-line' argument when you put javascript into views -- that will cause your view javascript to be pushed to the <head> ie. $javascript->codeBlock($functionForExemple, array('inline'=>false));

	?>
<!-- Default JS -->
<?php 
?>
</head>
<body class="<?php echo $this->params['controller']; ?><?php if($session->read('Auth.User')) : __(' authorized'); else : __(' restricted'); endif; ?>">
<div id="awesomeHeader">
  <header>
    <div id="header">
      <div class="middleContent">
        <div id="secure">
          <div class="loggedIn <?php if(!$session->read('Auth.User')) { echo 'hidden'; } ?>"> <a href="/admin/settings"><span>Settings</span></a> <span class="verticalSeparator"></span> <a href="/admin/settings"><?php echo __SYSTEM_ZUHA_DB_VERSION; ?></a> <span class="verticalSeparator"></span> <a href="/admin/users/users/logout"><span>Logout</span></a> <span class="verticalSeparator"></span>
            <p>Welcome <span class="username"><?php echo $session->read('Auth.User.username'); ?></span></p>
            <?php echo $this->element('snpsht', array('plugin' => 'users', 'useGallery' => true, 'userId' => $session->read('Auth.User.id'), 'thumbAlt' => $session->read('Auth.User.username'), 'thumbTitle' => $session->read('Auth.User.username'))); ?> </div>
          <div class="default <?php if($session->read('Auth.User.username')) { echo 'hidden'; } ?>"> <a id="join" class="button2 altCta2" href="/users/add"><span>Sign Up</span></a> <a id="join" class="button2 altCta2" href="/users/login"><span>Sign In</span></a> </div>
        </div>
        <!-- secure -->
        <div id="zuhaLogo" class="ir"><a href="/admin"> <span></span></a> </div>
        <div id="globalNav">
          <nav>
            <ul>              
            <li id="HTMLID" class="first fourColumns"> <a href="/admin" title="All features">Dashboard<span></span></a>
                <div class="pointer"></div>
                <div class="sub">
                  <div class="menu">
                    <ul>
                      <li class="title">Permissions</li>
                      <li><a href="/admin/permissions/acores">Permissions</a></li>
                    </ul>
                    <ul>
                      <li class="title">Settings</li>
                      <li><a href="/admin/settings">System Settings</a></li>
                    </ul>
                    <ul>
                      <li class="title">Reports</li>
                      <li><a href="/admin/reports">Analytics</a></li>
                      <li><a href="/admin/reports">Reports</a></li>
                    </ul>
                    <p class="otherFeatures"><a href="/" title="Public Site">Public Site</a></p>
                  </div>
                </div>
              </li>
              <li class="twoColumn"> <a href="/admin/projects" title="Users">Users<span></span></a>
                <div class="pointer"></div>
                <div class="sub">
                  <div class="menu">
                    <ul>
                      <li class="title">Social</li>
                      <li><a href="/admin/users/">All Users</a></li>
                      <li><a href="/admin/users/profiles/">Profiles</a></li>
                      <li><a href="/admin/users/user_groups">Groups</a></li>
                      <li><a href="/admin/users/user_statuses">Statuses</a></li>
                      <li><a href="/admin/users/user_walls">Walls</a></li>
                      <li><a href="/admin/messages">Messages</a></li>
                    </ul>
                    <ul>
                      <li class="title">Feedback</li>
                      <li><a href="/admin/comments">Comments</a></li>
                      <li><a href="/admin/ratings">Ratings</a></li>
                      <li><a href="/admin/tickets">Tickets</a></li>
                      <li><a href="/admin/invite">Invites</a></li>
                    </ul>
                    <p class="otherFeatures"><a href="#" title="Users Dashboard">Users Dashboard</a></p>
                  </div>
                </div>
              </li>
              <li class="singleColumn"> <a href="/admin/notifications/notification_templates" title="Marketing">Marketing<span></span></a>
                <div class="pointer"></div>
                <div class="sub">
                  <div class="menu">
                    <ul>
                      <li><a href="/admin/notifications/notification_templates">Notifications</a></li>
                      <li><a href="/admin/conditions">Conditions</a></li>
                      <li><a href="/admin/workflows">Workflows</a></li>
                    </ul>
                    <p class="otherFeatures"><a href="#" title="Marketing Dashboard">Marketing Dashboard</a></p>
                  </div>
                </div>
              </li>
              <li class="fourColumns"> <a href="/admin/contacts" title="Contacts">Contacts<span></span></a>
                <div class="pointer"></div>
                <div class="sub">
                  <div class="menu">
                    <ul>
                      <li class="title">Contacts</li>
                      <li><a href="/admin/contacts">All Contacts</a></li>
                      <li><a href="/admin/contacts/contact_people">People</a></li>
                      <li><a href="/admin/contacts/contact_companies">Companies</a></li>
                    </ul>
                    <ul>
                      <li class="title">Actions</li>
                      <li><a href="/admin/contacts/contact_opportunities">Opportunities</a></li>
                      <li><a href="/admin/contacts/contact_activities">Activities</a></li>
                    </ul>
                    <ul>
                      <li class="title">Users</li>
                      <li><a href="/admin/users">Users</a></li>
                    </ul>
                    <p class="otherFeatures"><a href="#" title="Contacts Dashboard">Contacts Dashboard</a></p>
                  </div>
                </div>
              </li>
              <li class="singleColumn"> <a href="/admin/projects" title="Projects">Projects<span></span></a>
                <div class="pointer"></div>
                <div class="sub">
                  <div class="menu">
                    <ul>
                      <li><a href="/admin/projects">Projects</a></li>
                      <li><a href="/admin/timesheets">Timesheets</a></li>
                      <li><a href="/admin/tickets">Tickets</a></li>
                      <li><a href="/admin/tasks">Tasks</a></li>
                      <li><a href="/admin/estimates">Estimates</a></li>
                      <li><a href="/admin/priorities">Priorities</a></li>
                    </ul>
                    <p class="otherFeatures"><a href="#" title="Projects Dashboard">Projects Dashboard</a></p>
                  </div>
                </div>
              </li>
              <li class="singleColumn"> <a href="/admin/catalogs" title="Accessories homepage">Ecommerce<span></span></a>
                <div class="pointer"></div>
                <div class="sub">
                  <div class="menu">
                    <ul>
                      <li><a href="/admin/catalogs">Catalogs</a></li>
                      <li><a href="/admin/categories">Categories</a></li>
                      <li><a href="/admin/catalogs/catalog_items">Products</a></li>
                      <li><a href="/admin/order_items">Orders</a></li>
                      <li><a href="/admin/invoices">Invoices</a></li>
                    </ul>
                    <p class="otherFeatures"><a href="#" title="Ecommerce Dashboard">Ecommerce Dashboard</a></p>
                  </div>
                </div>
              </li>
              <li class="fourColumns"> <a href="/admin/webpages" title="Content">Content<span></span></a>
                <div class="pointer"></div>
                <div class="sub">
                  <div class="menu">
                    <ul>
                      <li class="title">Webpages</li>
                      <li><a href="/admin/webpages/type:pages/">Pages</a></li>
                      <li><a href="/admin/webpages/type:templates/">Templates</a></li>
                      <li class="separator"><a href="/admin/webpages/type:elements/">Elements</a></li>
                      <li><a href="/js/kcfinder/browse.php?type=images&kcfinderuploadDir=<?php echo SITE_DIR; ?>&CKEditor=WebpageContent&CKEditorFuncNum=4&langCode=en">File Manager</a></li>
                    </ul>
                    <ul>
                      <li class="title">Extensions</li>
                      <li><a href="/admin/blogs">Blogs</a></li>
                      <li ><a href="/admin/faqs">Faqs</a></li>
                      <li ><a href="/admin/forum/home">Forums</a></li>
                      <li ><a href="/admin/maps">Maps</a></li>
                      <li class="separator"><a href="/admin/wikis">Wikis</a></li>
                      <li><a href="/admin/forms">Forms</a></li>
                    </ul>
                    <ul>
                      <li class="title">Labels</li>
                      <li><a href="/admin/categories">Categories</a></li>
                      <li><a href="/admin/tags">Tags</a></li>
                      <li><a href="/admin/enumerations">Enumerations</a></li>
                    </ul>
                    <ul>
                      <li class="title">Elements</li>
                      <li><a href="/admin/favorites">Favorites</a></li>
                      <li><a href="/admin/galleries">Galleries</a></li>
                    </ul>
                    <p class="otherFeatures"><a href="#" title="Content Dashboard">Content Dashboard</a></p>
                  </div>
                </div>
              </li>
            </ul>
          </nav>
          <div class="searchfield">
            <form id="googleSearchForm" method="get" action="#">
              <input type="text" value="Search" id="googleInput" name="q" title="Search" class="grayOut toggleTitle" />
            </form>
            <!-- #googleSearchForm -->
          </div>
        </div>
      </div>
    </div>
  </header>
</div>
<?php $messaage = $session->flash(); if($messaage) { ?>
<div id="alertStripe">
  <div class="wrap">
    <div class="text"> <img src="/img/admin/alertstrip_tick_green.png" width="11" height="9" alt=""> <?php echo $messaage; ?></div>
  </div>
</div>
<?php } ?>
<?php $auth = $session->flash('auth'); if($auth) { ?>
<div id="alertStripe">
  <div class="wrap">
    <div class="text"> <img src="/img/admin/alertstrip_tick_green.png" width="11" height="9" alt=""> <?php echo $auth; ?> </div>
  </div>
</div>
<?php } ?>
<?php /*

<div id="promo">
  <div class="content textLeft"> <img src="/img/admin/960x278.jpg" width="960" height="278" alt="">
    <div id="planB">
      <div class="shopPromo">New wireless headset<br>
        <span class="special">Free delivery before Dec 31</span></div>
      <div class="title">
        <p class="price2 buy_now" id="prodPromo"><span class="buttonGreen"><a href="https://us.chatandvision.com/iTech-EasyChat-306/product_skype/add/10030-AA-NA" class="buynow" onclick="tt_Redirect(&#39;https://us.chatandvision.com/iTech-EasyChat-306/product_skype/add/10030-AA-NA&#39;);return false;" target="_blank"><span class="text">Buy now</span><span class="rs">&nbsp;</span></a></span>
        <p class="priceLrg">$49.99</p>
        </p>
        <script type="text/javascript"> $('#prodPromo').data('shop',{ ProdId: '10030-AA-NA', ShopId: '29659'});</script>
        <p><a href="http://shop.skype.com/headsets/wireless/itech-easychat-306/" class="lighter">Learn more</a></p>
      </div>
      <div class="credits" style="background-image: url(/i/images/backgrounds/header_twitter.jpg);color: #00AFF0;"> Follow us for promotions <span class="buttonSmall"> <a href="http://twitter.com/Skype" rel="external" class="blue"><span class="text">Go</span><span class="rs">&nbsp;</span></a> </span> </div>
      <div class="bundles" style="background-image: url(/i/images/backgrounds/header_bottom_RTX3088.png);">
        <div class="content"> Dualphone 3088<br>
          <span class="small">Price reduction</span> <span class="buttonSmall"> <a href="http://shop.skype.com/phones/cordless-router/rtx-dualphone-3088/" class="blue"><span class="text">Buy now</span><span class="rs">&nbsp;</span></a> </span> </div>
      </div>
    </div>
  </div>
</div>
<!-- #promo -->


<div id="productTypes">
  <div class="content2">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
        <tr>
          <td class="icon"><a href="http://shop.skype.com/headsets/"><img src="/img/admin/headsets.png" width="90" height="95" alt="" class="fix"></a></td>
          <td class="sml"><a href="http://shop.skype.com/headsets/">Headsets</a></td>
          <td class="icon"><a href="http://shop.skype.com/phones/"><img src="/img/admin/phones.png" width="90" height="95" alt="" class="fix"></a></td>
          <td class="sml"><a href="http://shop.skype.com/phones/">Phones</a></td>
          <td class="icon"><a href="http://shop.skype.com/webcams/"><img src="/img/admin/webcams.png" width="90" height="95" alt="" class="fix"></a></td>
          <td class="sml"><a href="http://shop.skype.com/webcams/">Webcams</a></td>
          <td class="icon"><a href="http://shop.skype.com/skype-for-tv/"><img src="/img/admin/skypetv.png" width="90" height="95" alt="" class="fix"></a></td>
          <td class="lrg"><a href="http://shop.skype.com/skype-for-tv/">Skype for TV</a></td>
          <td class="icon"><a href="http://shop.skype.com/extras/"><img src="/img/admin/extras.png" width="90" height="95" alt="" class="fix"></a></td>
          <td class="sml"><a href="http://shop.skype.com/extras/">Extras</a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!-- #productTypes  -->

*/ ?>
<div id="contentWrapper">
  <div class="contentHeading">
    <h1><?php echo $title_for_layout; ?></h1>
  </div>
  <div class="tabs"> <!--a href="#t1" rel="tabOne" class="active"> <span class="ls">&nbsp;</span> <span class="text">Sub Tab (ie. wikis)</span> <span class="rs">&nbsp;</span> </a> <a href="#t2" rel="tabTwo" class=""> <span class="ls">&nbsp;</span> <span class="text">Sub Tab (ie. user roles)</span> <span class="rs">&nbsp;</span> </a> <img class="fix shadow" id="bs" src="/img/admin/shadow_knowhow_top.png" width="899" height="10" alt=""--> </div>
  <div class="content">
    <div id="sideBar">
      <div id="sideBarArrow"> 
      	<img src="/img/admin/compare_bubble_alert_arrow.png" width="12" height="31" alt=""> 
      </div>
      <a href="#" class="close"></a> <?php echo (!empty($menu_for_layout) ? $menu_for_layout : ''); ?> 
    </div>
    <!-- #compareBubbleAlert -->
    <div id="tabOne" class="leftContent" style="display: block; ">
      <div id="compareChart">
        <div class="compareChartHeader">
          <ul>
            <li class="info">
              <h2>Explanation Text</h2>
              <p>Some text describing this section, so that its easy to use. (put an x button so that you can turn off hints if you want to.</p>
            </li>
          </ul>
        </div>
        <!-- #compareChartHeader -->
        <div class="contentSection">
          <?php echo $content_for_layout; ?>
          <!-- /info-block end -->
        </div>
        <!-- #compareChartContent -->
      </div>
      <!-- #compareChart -->
    </div>
    <div id="tabTwo" class="leftContent" style="display: none;">
      <div class="navigation">
        <ul class="left">
          <li><a href="#" rel="contentAtHome" class="active">Sub Tab</a></li>
          <li><a href="#" rel="contentAtWork">Sub Tab</a></li>
          <li><a href="#" rel="contentAnywhere">Sub Tab</a></li>
        </ul>
        <div class="clear"></div>
      </div>
      <div id="contentAtHome" class="tabcontent" style="display: block; ">
          <div class="info-block">
            <div class="title"> <strong class="status">Status: <span>Active</span></strong> <strong>Total Hours: <span>10.00</span></strong>
              <div class="drop-holder"> <strong>Sort by: <a href="#">Priority</a></strong>
                <ul class="drop">
                  <li><a href="#">Created Date</a></li>
                  <li><a href="#">Modified Date</a></li>
                  <li><a href="#">Complete Percent</a></li>
                  <li><a href="#">Estimated Hours</a></li>
                </ul>
              </div>
            </div>
            <!-- /title end -->
            <div class="post">
              <div class="image"> <img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
                <div class="drop-holder"> <a href="#" class="btn">jbyrnes</a>
                  <ul class="drop">
                    <li><a href="/users/users/view">View Profile</a></li>
                    <li><a href="#">Private Message</a></li>
                    <li><a href="#">User Role</a></li>
                  </ul>
                </div>
              </div>
              <!-- /image end -->
              <div class="text">
                <div class="links"> <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a> <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a> </div>
                <ul>
                  <li>Start: <span>2010-05-19</span></li>
                  <li>Due: <span>2010-05-20</span></li>
                  <li>Estimated Hrs: <span>8.00</span></li>
                  <li>Spent Hrs: <strong>14.42</strong></li>
                  <li>% Complete: <span>99</span></li>
                  <li>Modifiedt: <span>2010-05-19</span></li>
                  <li> Contact: <span>Water Heater Experts</span></li>
                </ul>
                <p>You've received source layered source files in a different email. Client would like you to install CMS Made </p>
                <div class="row"> <a href="#" class="add-note">ADD NOTE</a> <em>note added on 19 May at 5:30pm</em> <a href="#" class="expand">Expand</a> </div>
              </div>
            </div>
            <!-- /post end -->
            <div class="post post-reply"> <a href="#" class="close">Close</a>
              <div class="image"> <img src="/img/admin/img02.jpg" alt="image description" width="76" height="77" />
                <div class="drop-holder"> <a href="#" class="btn">todd</a>
                  <ul class="drop">
                    <li><a href="#">View Profile</a></li>
                    <li><a href="#">Private Message</a></li>
                    <li><a href="#">User Role</a></li>
                  </ul>
                </div>
              </div>
              <!-- /image end -->
              <div class="text">
                <p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
                <div class="row"> <a href="#" class="add-note">ADD NOTE</a> <em>note added on 19 May at 6:30pm</em> </div>
              </div>
            </div>
            <!-- /post post-reply end -->
            <div class="post">
              <div class="image"> <img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
                <div class="drop-holder"> <a href="#" class="btn">jbyrnes</a>
                  <ul class="drop">
                    <li><a href="#">View Profile</a></li>
                    <li><a href="#">Private Message</a></li>
                    <li><a href="#">User Role</a></li>
                  </ul>
                </div>
              </div>
              <!-- /image end -->
              <div class="text">
                <div class="links"> <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a> <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a> </div>
                <ul>
                  <li>Start: <span>2010-05-19</span></li>
                  <li>Due: <span>2010-05-20</span></li>
                  <li>Estimated Hrs: <span>8.00</span></li>
                  <li>Spent Hrs: <strong>14.42</strong></li>
                  <li>% Complete: <span>99</span></li>
                </ul>
                <p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
                <div class="row"> <a href="#" class="add-note">ADD NOTE</a> <em>note added on 19 May at 5:30pm</em> </div>
              </div>
            </div>
            <!-- /post end -->
            <div class="post">
              <div class="image"> <img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
                <div class="drop-holder"> <a href="#" class="btn">jbyrnes</a>
                  <ul class="drop">
                    <li><a href="#">View Profile</a></li>
                    <li><a href="#">Private Message</a></li>
                    <li><a href="#">User Role</a></li>
                  </ul>
                </div>
              </div>
              <!-- /image end -->
              <div class="text">
                <div class="links"> <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a> <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a> </div>
                <ul>
                  <li>Start: <span>2010-05-19</span></li>
                  <li>Due: <span>2010-05-20</span></li>
                  <li>Estimated Hrs: <span>8.00</span></li>
                  <li>Spent Hrs: <strong>14.42</strong></li>
                  <li>% Complete: <span>99</span></li>
                </ul>
                <p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
                <div class="row"> <a href="#" class="add-note">ADD NOTE</a> <em>note added on 19 May at 5:30pm</em> </div>
              </div>
            </div>
            <!-- /post end -->
          </div>
        <div class="clear"></div>
      </div>
      <div id="contentAtWork" class="tabcontent">
        <div class="mainContentArea">
          <p>put some content here, and some padding on the .mainContentArea </p>
        </div>
        <div class="clear"></div>
      </div>
      <div id="contentAnywhere" class="tabcontent">
        <div class="mainContentArea">
          <p>content, and some padding on the .mainContentArea </p>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <img src="/img/admin/shadow_knowhow_bottom.png" width="915" height="31" alt=""> </div>
</div>
<div id="awesomeFooter">
  <footer>
    <div class="gridContainer" id="footer">
      <div class="gridRow"> <span class="footerHeading">Grow w zuha</span> </div>
    </div>
    <div class="gridContainer" id="footerMenu">
      <nav>
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
      </nav>
    </div>
    <div class="gridContainer" id="bottomNavigation">
      <div class="gridRow">
        <div class="gridCol12">
          <form action="#" method="post" id="userPreferencesForm">
            <div id="footerNavigation">
              <select id="userLanguage" name="userLanguage">
                <option selected="selected" value="en-us">United States (English)</option>
              </select>
              <a href="http://zuha.org/">About us</a> - <a href="http://zuha.org/">Blogs</a> - <a href="http://zuha.org/">Developers</a> - <a href="http://zuha.org/">Jobs</a> - <a href="http://zuha.org/">Rates</a></div>
            <!-- #footerNavigation -->
            <div id="legalLinks"> <a href="http://zuha.org/">Privacy policy</a> - <a href="http://zuha.org">Legal</a> <span>&copy; 2010 Zuha Foundation</span> </div>
            <!-- #legalLinks -->
          </form>
          <!-- #userPreferencesForm -->
        </div>
      </div>
    </div>
    <!-- #bottomNavigation -->
  </footer>
</div>
<div class="wrapper">
  <div id="header">
    <div class="holder">
      <div id="loadingimg" style="display: none;"><?php echo $html->image('ajax-loader.gif'); ?></div>
      <div class="info"> </div>
    </div>
  </div>
</div>
<!-- /header end -->
<div id="main">
<div class="heading">
  <?php /*
					<div class="info-block">
						<div class="title">
							<strong class="status">Status: <span>Active</span></strong>
							<strong>Total Hours: <span>10.00</span></strong>
							<div class="drop-holder">
								<strong>Sort by:  <a href="#">Priority</a></strong>
								<ul class="drop">
									<li><a href="#">Created Date</a></li>
									<li><a href="#">Modified Date</a></li>
									<li><a href="#">Complete Percent</a></li>
									<li><a href="#">Estimated Hours</a></li>
								</ul>
							</div>
						</div><!-- /title end -->
						<div class="post">
							<div class="image">
								<img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
								<div class="drop-holder">
									<a href="#" class="btn">jbyrnes</a>
									<ul class="drop">
										<li><a href="#">View Profile</a></li>
										<li><a href="#">Private Message</a></li>
										<li><a href="#">User Role</a></li>
									</ul>
								</div>
							</div><!-- /image end -->
							<div class="text">
  							<div class="links">
  							  <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a>
  							  <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a>
  							</div>
								<ul>
									<li>Start: <span>2010-05-19</span></li>
									<li>Due: <span>2010-05-20</span></li>
									<li>Estimated Hrs: <span>8.00</span></li>
									<li>Spent Hrs: <strong>14.42</strong></li>
									<li>% Complete: <span>99</span></li>
									<li>Modifiedt:  <span>2010-05-19</span></li>
									<li> Contact: <span>Water Heater Experts</span></li>
								</ul>
								<p>You've received source layered source files in a different email. Client would like you to install CMS Made </p>
								<div class="row">
									<a href="#" class="add-note">ADD NOTE</a>
									<em>note added on 19 May at 5:30pm</em>
									<a href="#" class="expand">Expand</a>
								</div>
							</div>
						</div><!-- /post end -->
						<div class="post post-reply">
							<a href="#" class="close">Close</a>
							<div class="image">
								<img src="/img/admin/img02.jpg" alt="image description" width="76" height="77" />
								<div class="drop-holder">
									<a href="#" class="btn">todd</a>
									<ul class="drop">
										<li><a href="#">View Profile</a></li>
										<li><a href="#">Private Message</a></li>
										<li><a href="#">User Role</a></li>
									</ul>
								</div>
							</div><!-- /image end -->
							<div class="text">
								<p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
								<div class="row">
									<a href="#" class="add-note">ADD NOTE</a>
									<em>note added on 19 May at 6:30pm</em>
								</div>
							</div>
						</div><!-- /post post-reply end -->
						<div class="post">
							<div class="image">
								<img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
								<div class="drop-holder">
									<a href="#" class="btn">jbyrnes</a>
									<ul class="drop">
										<li><a href="#">View Profile</a></li>
										<li><a href="#">Private Message</a></li>
										<li><a href="#">User Role</a></li>
									</ul>
								</div>
							</div><!-- /image end -->
							<div class="text">
							  <div class="links">
							    <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a>
							    <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a>
							  </div>
								<ul>
									<li>Start: <span>2010-05-19</span></li>
									<li>Due: <span>2010-05-20</span></li>
									<li>Estimated Hrs: <span>8.00</span></li>
									<li>Spent Hrs: <strong>14.42</strong></li>
									<li>% Complete: <span>99</span></li>
								</ul>
								<p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
								<div class="row">
									<a href="#" class="add-note">ADD NOTE</a>
									<em>note added on 19 May at 5:30pm</em>
								</div>
							</div>
						</div><!-- /post end -->
						<div class="post">
							<div class="image">
								<img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" />
								<div class="drop-holder">
									<a href="#" class="btn">jbyrnes</a>
									<ul class="drop">
										<li><a href="#">View Profile</a></li>
										<li><a href="#">Private Message</a></li>
										<li><a href="#">User Role</a></li>
									</ul>
								</div>
							</div><!-- /image end -->
							<div class="text">
							  <div class="links">
							    <a href="" class="top-button"><img src="/img/admin/ico22.gif" /></a>
							    <a href="" class="botton-button"><img src="/img/admin/ico21.gif" /></a>
							  </div>
								<ul>
									<li>Start: <span>2010-05-19</span></li>
									<li>Due: <span>2010-05-20</span></li>
									<li>Estimated Hrs: <span>8.00</span></li>
									<li>Spent Hrs: <strong>14.42</strong></li>
									<li>% Complete: <span>99</span></li>
								</ul>
								<p>You've received source layered source files in a different email. Client would like you to install CMS Made Simple and put this template over it. We had mentioned that you would have this by 4:00 pm tomorrow. </p>
								<div class="row">
									<a href="#" class="add-note">ADD NOTE</a>
									<em>note added on 19 May at 5:30pm</em>
								</div>
							</div>
						</div><!-- /post end -->
					</div><!-- /info-block end --> */ ?>
</div>
<?php  echo $this->element('sql_dump'); ?>
</body>
</html>
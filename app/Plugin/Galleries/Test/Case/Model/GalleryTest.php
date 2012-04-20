<?php
App::uses('Gallery', 'Galleries.Model');

/**
 * Gallery Test Case
 *
 */
class GalleryTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.galleries.gallery', 'plugin.galleries.gallery_image', 'plugin.users.user', 'plugin.users.user_role', 'plugin.users.user_wall', 'plugin.contacts.contact', 'app.enumeration', 'plugin.contacts.contact_address', 'plugin.contacts.contact_detail', 'plugin.tasks.task', 'plugin.projects.project', 'plugin.projects.project_issue', 'plugin.timesheets.timesheet_time', 'plugin.timesheets.timesheet', 'app.timesheets_timesheet_time', 'plugin.projects.projects_member', 'plugin.users.user_group', 'plugin.users.users_user_group', 'plugin.users.user_group_wall_post', 'plugin.users.used', 'plugin.messages.message', 'plugin.tags.tag', 'plugin.tags.tagged', 'app.invoice', 'app.invoice_item', 'plugin.catalogs.catalog_item', 'plugin.catalogs.catalog', 'app.alias', 'plugin.catalogs.catalog_item_brand', 'plugin.categories.category', 'plugin.categories.category_option', 'plugin.categories.categorized_option', 'plugin.categories.categorized', 'app.location', 'plugin.orders.order_item', 'plugin.orders.order_payment', 'plugin.orders.order_transaction', 'plugin.orders.order_coupon', 'plugin.orders.order_shipment', 'plugin.catalogs.catalog_item_price', 'app.invoice_time', 'app.projects_watcher', 'plugin.wikis.wiki', 'plugin.wikis.wiki_page', 'plugin.wikis.wiki_content', 'plugin.wikis.wiki_content_version', 'app.projects_wiki', 'app.contacts_contact', 'plugin.users.user_status', 'plugin.users.user_follower');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Gallery = ClassRegistry::init('Gallery');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Gallery);

		parent::tearDown();
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}
/**
 * testMakeThumb method
 *
 * @return void
 */
	public function testMakeThumb() {

	}
/**
 * testTypes method
 *
 * @return void
 */
	public function testTypes() {

	}
}

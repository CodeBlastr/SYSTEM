<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo Router::url('/',true); ?></loc>
		<changefreq>daily</changefreq>
		<priority>1.0</priority>
	</url>
	<?php foreach ($users as $user):?>
	<url>
		<loc><?php echo Router::url(array('controller'=>'users','action'=>'view','id'=>$user['User']['id']),true); ?></loc>
		<lastmod><?php echo $time->toAtom($user['User']['last_login']); ?></lastmod>
		<priority>0.8</priority>
	</url>
	<?php endforeach; ?>
</urlset>
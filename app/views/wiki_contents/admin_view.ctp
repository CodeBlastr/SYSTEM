<div class="form">
<h2><?php echo str_replace('_', ' ', $wikiContent['WikiPage']['title']); ?></h2>

	<div class="wiki_page_content">
		<span id="wikicontent"><?php echo $wikiparser->render($wikiContent['WikiContent']['text']); ?></span>
		<p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'wiki_contents', 'action' => 'edit', $wikiContent['WikiPage']['wiki_id'], $wikiContent['WikiPage']['title'])); ?></p>
	</div>
</div>
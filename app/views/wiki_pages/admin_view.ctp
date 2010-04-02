<div class="form">
<h2><?php echo str_replace('_', ' ', $wikiPage['WikiPage']['title']); ?></h2>

	<div class="wiki_page_content">
		<span id="wikicontent"><?php ajax_add($wikiPage['WikiContent']['text']); ?></span>
		<p class="action"><?php echo $html->link(__('Edit', true), array('controller' => 'wiki_contents', 'action' => 'edit', $wikiPage['WikiPage']['wiki_id'], $wikiPage['WikiPage']['title'])); ?></p>
	</div>
</div>
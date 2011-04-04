<?php
/*echo $rss->header();

if (!isset($channel)) {
	$channel = array();
}
if (!isset($channel['title'])) {
	$channel['title'] = $title_for_layout;
}

echo $rss->document(
	$rss->channel(
		array(), $channel, $content_for_layout
	)
);
*/?>
<?php 
echo $this->Rss->header();
if (!isset($documentData)) {
    $documentData = array();
}
if (!isset($channelData)) {
    $channelData = array();
}
if (!isset($channelData['title'])) {
    $channelData['title'] = $title_for_layout;
} 
$channel = $this->Rss->channel(array(), $channelData, $content_for_layout);
echo $this->Rss->document($documentData,$channel);
?>
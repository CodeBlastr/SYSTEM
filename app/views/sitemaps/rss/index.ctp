<?php 
    $this->set('documentData', array(
        'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

    $this->set('channelData', array(
        'title' => __("Most Recent users", true),
        'link' => $this->Html->url('/', true),
        'description' => __("Most recent users.", true),
        'language' => 'en-us'));
?>
<?php 

    foreach ($users as $user) {
    	print_r($user);
        $userTime = strtotime($user['User']['created']);
        $userLink = array(
            'controller' => 'users/users',
            'action' => 'view',
            'year' => date('Y', $userTime),
            'month' => date('m', $userTime),
            'day' => date('d', $userTime),
            $user['User']['id']);
        // You should import Sanitize
        App::import('Sanitize');
        // This is the part where we clean the body text for output as the description 
        // of the rss item, this needs to have only text to make sure the feed validates
        $bodyText = preg_replace('=\(.*?\)=is', '', $user['User']['username']);
        $bodyText = $this->Text->stripLinks($bodyText);
        $bodyText = Sanitize::stripAll($bodyText);
        $bodyText = $this->Text->truncate($bodyText, 400, array(
            'ending' => '...',
            'exact'  => true,
            'html'   => true,
        ));

        echo $bodyText;
        echo  $this->Rss->item(array(), array(
            'title' => $user['User']['full_name'],
            'link' => $userLink,
            'guid' => array('url' => $userLink, 'isPermaLink' => 'true'),
            'description' =>  $bodyText,
            'dc:creator' => $user['User']['last_name'],
            'pubDate' => $user['User']['created']));
    }
?>
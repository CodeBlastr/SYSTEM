<?php 

class HtmlLinkRewrite extends CakeRoute {
 
    function match($url) {
		echo 'alsdkfjasldfj';
		pr($url);
		if ($url['plugin'] == $url['controller']) {
			unset($url['plugin']);
			$output = array();
			$named = array();
			foreach ($url as $key => $value) {
				if (!empty($url[0])) {
					$output[3] = $url[0];
				}
				
				if ($key == 'admin') {
					$output[0] = $key;
				} else if ($key == 'controller') {
					$output[1] = $value;
				} else if ($key == 'action') {
					$output[2] = $value;
				} else {
					$named[] = $key.':'.$value;
				}
			}
			ksort($output);
			$output = implode('/', $output);
			$output = $output.'/'.implode('/', $named);
			return $output;
		}
		
		$url = parent::match($url);
		if(empty($url)) {
			return false;
		}
        return false;
    }
 
}

?>
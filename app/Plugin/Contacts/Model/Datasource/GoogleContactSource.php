<?php
/*
$config = '';
Configure::write('Twitter.consumerKey', '');
Configure::write('Twitter.consumerSecret', ''); */


// Controller/TwitterController.php
//App::import('Vendor', 'OAuth/OAuthClient');
App::uses('OAuthClient', 'Vendor/OAuth');

class GoogleContactSource extends DataSource {
	

/**
 * Create our HttpSocket and handle any config tweaks.
 */
    public function __construct($config) {
        parent::__construct($config);
        $this->Http = new HttpSocket();
    }

  	private function createClient() {
    	return new OAuthClient('USyRjvOuSvFgakcSy2aUA', 'RzZ6eGSAkyX9glDyFHFNJX1FE26iVV0uunMzdMZkII');
  	}

/**
 * Implement the R in CRUD. Calls to ``Model::find()`` arrive here.
 */
    public function read(Model $Model, $data = array()) {
        /**
         * Here we do the actual count as instructed by our calculate()
         * method above. We could either check the remote source or some
         * other way to get the record count. Here we'll simply return 1 so
         * ``update()`` and ``delete()`` will assume the record exists.
         */
        if ($data['fields'] == 'COUNT') {
            return array(array(array('count' => 1)));
        }
        /**
         * Now we get, decode and return the remote data.
         */
        $data['conditions']['apiKey'] = $this->config['apiKey'];
        $json = $this->Http->get('http://example.com/api/list.json', $data['conditions']);
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return array($Model->alias => $res);
    }
}

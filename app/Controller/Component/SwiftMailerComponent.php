<?php
// File -> app/controllers/components/swift_mailer.php

/**
 * SwiftMailer Component based on 4.05 version,
 * this component is inspired by Matt Hugins the developer of
 * SwiftMailer v.3 component based on 3.xx version.
 *
 * @author Gediminas Morkevicius
 * @version 2.30
 * @license MIT
 * @category Components
 */

//required third party library "SwiftMailer" under GPL license
App::import('Vendor', 'Swift', array('file' => 'swift_mailer'.DS.'swift_required.php'));

class SwiftMailerComponent extends Object {
	/**
	 * Reference to controller
	 *
	 * @var Object
	 * @access Private
	 */
	var $__controller = null;
	/**
	 * List of plugins to load then sending email
	 *
	 * @var Array - list of plugins in pairs $pluginName/array($arg[0], $arg[...)
	 * @access Private
	 */
	var $__plugins = array();
	/**
	 * Email layout
	 *
	 * @var String
	 * @access Public
	 */
	var $layout = 'default';
	/**
	 * Path to the email template
	 *
	 * @var String
	 * @access Public
	 */
	var $viewPath = 'email';
	/**
	 * Send message as type:
	 * 		"html" - content type "html/text"
	 * 		"text" - content type "text/plain"
	 * 		"both" - both content types are included
	 *
	 * @var String
	 * @access Public
	 */
	var $sendAs = 'both';
	/**
	 * Charset for message body
	 *
	 * @var String
	 * @access Public
	 */
	var $bodyCharset = 'utf-8';
	/**
	 * Charset for message subject
	 *
	 * @var String
	 * @access Public
	 */
	var $subjectCharset = 'utf-8';
	/**
	 * SMTP Security type:
	 * 		"ssl" - security type
	 * 		"tls" - security type
	 *
	 * @var String
	 * @access Public
	 */
	var $smtpType = 'ssl';
	/**
	 * SMTP Username for connection
	 *
	 * @var String
	 * @access Public
	 */
	var $smtpUsername = 'email1@enbake.com';
	/**
	 * SMTP Password for connection
	 *
	 * @var String
	 * @access Public
	 */
	var $smtpPassword = 'testing';
	/**
	 * SMTP Host name connection
	 *
	 * @var String
	 * @access Public
	 */
	var $smtpHost = 'smtp.gmail.com';
	/**
	 * SMTP port (e.g.: 25 for open, 465 for ssl, etc.)
	 *
	 * @var Integer
	 * @access Public
	 */
	var $smtpPort = '465';
	/**
	 * Seconds before timeout occurs
	 *
	 * @var Integer
	 * @access Public
	 */
	var $smtpTimeout = 10;
	/**
	 * Sendmail command (e.g.: '/usr/sbin/sendmail -bs')
	 *
	 * @var String
	 * @access Public
	 */
	var $sendmailCmd = null;
	/**
	 * Email from address
	 *
	 * @var String
	 * @access Public
	 */
	var $from ='';
	/**
	 * Email from name
	 *
	 * @var String
	 * @access Public
	 */
	var $fromName = '';
	/**
	 * Recipients
	 *
	 * @var Mixed
	 * 		Array - address/name pairs (e.g.: array(example@address.com => name, ...)
	 * 		String - address to send email to
	 * @access Public
	 */
	var $to = null;
	/**
	 * CC recipients
	 *
	 * @var Mixed
	 * 		Array - address/name pairs (e.g.: array(example@address.com => name, ...)
	 * 		String - address to send email to
	 * @access Public
	 */
	var $cc = null;
	/**
	 * BCC recipients
	 *
	 * @var Mixed
	 * 		Array - address/name pairs (e.g.: array(example@address.com => name, ...)
	 * 		String - address to send email to
	 * @access Public
	 */
	var $bcc = null;
	/**
	 * List of files that should be attached to the email.
	 *
	 * @var array - list of file paths
	 * @access public
	 */
	var $attachments = array();
	/**
	 * When the email is opened, if the mail client supports it
	 * a notification will be sent to this address
	 *
	 * @var String - email address for notification
	 * @access Public
	 */
	var $readNotifyReceipt = null;
	/**
     * Reply to address
     *
     * @var Mixed
	 * 		Array - address/name pairs (e.g.: array(example@address.com => name, ...)
	 * 		String - address to send reply to
	 * @access Public
     */
    var $replyTo = null;
	/**
	 * Max length of email line
	 *
	 * @var Integer - length of line
	 * @access Public
	 */

	var $maxLineLength = 78;
	/**
	 * Array of errors refreshed after send function is executed
	 *
	 * @var Array - Error container
	 * @access Public
	 */
	var $postErrors = array();

	var $content = null; // todo: be removed temp for layout issue;
	/**
	 * Initialize component
	 *
	 * @param Object $controller reference to controller
	 * @access Public
	 */
	function initialize(&$controller) {				
		$this->__controller = $controller;
		# get the smtp settings (required for sending email)
		if (defined('__SYSTEM_SMTP')) :
			extract(unserialize(__SYSTEM_SMTP));
			$smtp = base64_decode($smtp);
			$smtp = Security::cipher($smtp, Configure::read('Security.iniSalt'));
			$smtp = parse_ini_string($smtp);
		endif;

		$this->smtpUsername = !empty($smtp['smtpUsername']) ? $smtp['smtpUsername'] : $this->smtpUsername;
		$this->smtpPassword = !empty($smtp['smtpPassword']) ? $smtp['smtpPassword'] : $this->smtpPassword;
		$this->smtpHost = !empty($smtp['smtpHost']) ? $smtp['smtpHost'] : $this->smtpHost;
		$this->smtpPort = !empty($smtp['smtpPort']) ? $smtp['smtpPort'] : $this->smtpPort;
		$this->from = !empty($smtp['from']) ? $smtp['from'] : $this->from;
		$this->fromName = !empty($smtp['fromName']) ? $smtp['fromName'] : $this->fromName;
	}
	function startup() { }
	function beforeRender() { }
	function beforeRedirect() { }
	function shutdown() { }

	/**
	 * Retrieves html/text or plain/text content from /app/views/elements/$this->viewPath/$type/$template.ctp
	 * and wraps it in layout /app/views/layouts/$this->viewPath/$type/$this->layout.ctp
	 *
	 * @param String $template - name of the template for content
	 * @param String $type - content type:
	 * 		html - html/text
	 * 		text - plain/text
	 * @return String content from template wraped in layout
	 * @access Protected
	 */
	function _emailBodyPart($template, $type = 'html') {
// @todo: temporary comment. Needto bring this back after finding out view rendering issue;
		$content = $this->content;
		/*$viewClass = $this->__controller->view;

		if ($viewClass != 'View') {
			if (strpos($viewClass, '.') !== false) {
				list($plugin, $viewClass) = explode('.', $viewClass);
			}
			$viewClass = $viewClass . 'View';
			App::import('View', $this->__controller->view);
		}
		$View = new $viewClass($this->__controller, false);
		$View->layout = $this->layout;

		$content = $View->element($this->viewPath.DS.$type.DS.$template, array('content' => ""), true);
		$View->layoutPath = $this->viewPath.DS.$type;
		$content = $View->renderLayout($content);
*/

		// Run content check callback
		$this->__runCallback($content, 'checkContent');

		return $content;
	}

	/**
	 * Sends Email depending on parameters specified, using method $method,
	 * mail template $view and subject $subject
	 *
	 * @param String $view - template for mail content
	 * @param String $subject - email message subject
	 * @param String $method - email message sending method, possible values are:
	 * 		"smtp" - Simple Mail Transfer Protocol method
	 * 		"sendmail" - Sendmail method http://www.sendmail.org/
	 * 		"native" - Native PHP mail method
	 * @return Integer - number of emails sent
	 * @access Public
	 */
	function send($view = 'default', $subject = '', $method = 'smtp') {
		// Check subject charset, asuming we are by default using "utf-8"
		if (strtolower($this->subjectCharset) != 'utf-8') {
			if (function_exists('mb_convert_encoding')) {
				//outlook uses subject in diferent encoding, this is the case to change it
				$subject = mb_convert_encoding($subject, $this->subjectCharset, 'utf-8');
			}
		}
		// Check if swift mailer is imported
		if (!class_exists('Swift_Message')) {
			throw new Exception('SwiftMailer was not included, check the path and filename');
		}

		// Create message
		$message = Swift_Message::newInstance($subject);

		// Run Init Callback
		$this->__runCallback($message, 'initializeMessage');

		$message->setCharset($this->subjectCharset);

		// Add html text
		if ($this->sendAs == 'both' || $this->sendAs == 'html') {
			$html_part = $this->_emailBodyPart($view, 'html');
			$message->addPart($html_part, 'text/html', $this->bodyCharset);
			unset($html_part);
		}

		// Add plain text or an alternative
		if ($this->sendAs == 'both' || $this->sendAs == 'text') {
			$text_part = $this->_emailBodyPart($view, 'text');
			$message->addPart($text_part, 'text/plain', $this->bodyCharset);
			unset($text_part);
		}

		// Add attachments if any
		if (!empty($this->attachments)) {
			foreach($this->attachments as $attachment) {
				if (!file_exists($attachment)) {
					continue;
				}
				$message->attach(Swift_Attachment::fromPath($attachment));
			}
		}

		// On read notification if supported
		if (!empty($this->readNotifyReceipt)) {
			$message->setReadReceiptTo($this->readNotifyReceipt);
		}

		$message->setMaxLineLength($this->maxLineLength);

		// Set the FROM address/name.
		$message->setFrom($this->from, $this->fromName);
		// Add all TO recipients.
		if (!empty($this->to)) {
			if (is_array($this->to)) {
				foreach($this->to as $address => $name) {
					$message->addTo($address, $name);
				}
			}
			else {
				$message->addTo($this->to);
			}
		}

		// Add all CC recipients.
		if (!empty($this->cc)) {
			if (is_array($this->cc)) {
				foreach($this->cc as $address => $name) {
					$message->addCc($address, $name);
				}
			}
			else {
				$message->addCc($this->cc);
			}
		}

		// Add all BCC recipients.
		if (!empty($this->bcc)) {
			if (is_array($this->bcc)) {
				foreach($this->bcc as $address => $name) {
					$message->addBcc($address, $name);
				}
			}
			else {
				$message->addBcc($this->bcc);
			}
		}

		// Set REPLY TO addresses
        if (!empty($this->replyTo)) {
        	if (is_array($this->replyTo)) {
				foreach($this->replyTo as $address => $name) {
					$message->addReplyTo($address, $name);
				}
			}
			else {
				$message->addReplyTo($this->replyTo);
			}
        }

		// Initializing mail method object with sending parameters
		$transport = null;
		switch ($method) {
			case 'smtp':
				$transport = Swift_SmtpTransport::newInstance($this->smtpHost, $this->smtpPort, $this->smtpType);
				$transport->setTimeout($this->smtpTimeout);
				if (!empty($this->smtpUsername)) {
					$transport->setUsername($this->smtpUsername);
					$transport->setPassword($this->smtpPassword);
				}
				break;
			case 'sendmail':
				$transport = Swift_SendmailTransport::newInstance($this->sendmailCmd);
				break;
			case 'native': default:
				$transport = Swift_MailTransport::newInstance();
				break;
		}

		// Initialize Mailer
		$mailer = Swift_Mailer::newInstance($transport);

		// Load plugins if any
		if (!empty($this->__plugins)) {
			foreach($this->__plugins as $name => $args) {
				$plugin_class = "Swift_Plugins_{$name}";
				if (!class_exists($plugin_class)) {
					throw new Exception("SwiftMailer library does not support this plugin: {$plugin_class}");
				}

				$plugin = null;
				switch(count($args)) {
					case 1:
						$plugin = new $plugin_class($args[0]);
						break;
					case 2:
						$plugin = new $plugin_class($args[0], $args[1]);
						break;
					case 3:
						$plugin = new $plugin_class($args[0], $args[1], $args[2]);
						break;
					case 4:
						$plugin = new $plugin_class($args[0], $args[1], $args[2], $args[3]);
						break;
					default:
						throw new Exception('SwiftMailer component plugin can register maximum of 4 arguments');
				}
				$mailer->registerPlugin($plugin);
			}
		}
		// Run Send Callback
		$this->__runCallback($message, 'beforeSend');

		// Attempt to send the email.
		return $mailer->send($message, $this->postErrors);
	}

	/**
	 * Registers a plugin supported by SwiftMailer
	 * function parameters are limited to 5
	 * first argument is plugin name (e.g.: if SwiftMailer plugin class is named "Swift_Plugins_AntiFloodPlugin",
	 * so you should pass name like "AntiFloodPlugin")
	 * All other Mixed arguments included in plugin creation call
	 *
	 * @return Integer 1 on success 0 on failure
	 */
	function registerPlugin() {
		if (func_num_args()) {
			$args = func_get_args();
			$this->__plugins[array_shift($args)] = $args;
			return true;
		}
		return false;
	}

	/**
	 * Run a specific by $type callback on controller
	 * who`s action is being executed. This functionality
	 * is used to perform additional specific methods
	 * if any is required
	 *
	 * @param mixed $object - object callback being executed on
	 * @param string $type - type of callback to run
	 * @return void
	 */
	function __runCallback(&$object, $type) {
		$call = '__'.$type.'On'.Inflector::camelize($this->__controller->action);
		if (method_exists($this->__controller, $call)) {
			$this->__controller->{$call}($object);
		}
	}
}
?>
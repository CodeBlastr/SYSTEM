<?php
App::uses('ErrorHandler', 'Error');

class AppErrorHandler extends ErrorHandler {


/**
 * An exact copy of the function in ErrorHandler except
 * for changes to the writing of error messages to the log file. 
 */
	public static function handleException(Exception $exception) {
		$config = Configure::read('Exception');
		if (!empty($config['log'])) {
			$message = sprintf("[%s] %s\n%s",
				get_class($exception),
				$exception->getMessage(),
				$exception->getTraceAsString()
			);
			
			get_class($exception) != 'MissingControllerException' ? CakeLog::write(LOG_ERR, $message) : null;
		}
		$renderer = $config['renderer'];
		if ($renderer !== 'ExceptionRenderer') {
			list($plugin, $renderer) = pluginSplit($renderer, true);
			App::uses($renderer, $plugin . 'Error');
		}
		try {
			$error = new $renderer($exception);
			$error->render();
		} catch (Exception $e) {
			set_error_handler(Configure::read('Error.handler')); // Should be using configured ErrorHandler
			Configure::write('Error.trace', false); // trace is useless here since it's internal
			$message = sprintf("[%s] %s\n%s", // Keeping same message format
				get_class($e),
				$e->getMessage(),
				$e->getTraceAsString()
			);
			trigger_error($message, E_USER_ERROR);
		}
	}


}
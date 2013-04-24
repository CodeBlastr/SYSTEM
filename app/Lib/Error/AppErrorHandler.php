<?php
App::uses('ErrorHandler', 'Error');

class AppErrorHandler extends ErrorHandler {


/**
 * An exact copy of the function in ErrorHandler except
 * for changes to the writing of error messages to the log file. 
 */
	public static function handleException(Exception $exception) {
		
		if ($exception instanceof MissingTableException) {
            return self::MissingTableException($exception);
        }
		
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
	
	
/** 
 * Handle mssing table exception in order to create the table if the plugin is loaded (typically triggered like this during upgrades)
 */
 	public static function MissingTableException ($exception) {	
		
		$exceptionMessage = $exception->getMessage();
		if(preg_match('/Table\s(\w*)\sfor model /', $exceptionMessage, $matches)) {
			$missingTableName = $matches[1];
			$missingTableSql = 'CREATE TABLE `' . $missingTableName . '` (`id` INT NOT NULL) ENGINE = MYISAM ;';
			$db = ConnectionManager::getDataSource('default');
			$db->execute($missingTableSql);
			SessionComponent::setFlash('Notice: The database table, `'.$missingTableName.'` was not found and has been recreated.');
			header('Location: //'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		}
		
		echo '<h1>We need to write a function for creating tables when they are not already there, if the plugin is loaded.</h1>';
		echo 'Use the getMessage() function to get the plugin name, and the table with some regex or something.<br />';
		echo 'CREATE TABLE `table_name` (`id` INT NOT NULL) ENGINE = MYISAM ; is the sql to run and then refresh the page to keep the upgrade running.';
		debug($exception->getMessage());
		break;
	}


}
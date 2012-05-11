<?php
class UpdateSchema extends Object {
	
	public function __construct($options = array()) {
		parent::__construct();
		$this->db = ConnectionManager::getDataSource('default');
	}
	
/**
 * Before method
 *
 * Creates a temp table to use in the copying of data for renamed columns
 * 
 * @param array
 * @return bool
 */
  	public function before($event) {
		if (!empty($event['update'])) {
			
			try {
				// drop the table zbk_oldname if it exists ( this was in the after(), and will probably go back, but for now, we leave it so that upgrades can be retrieved if it messes up data).
				$this->db->query('DROP TABLE `zbk_' . $event['update'] . '`;'); 
				return true;
			} catch (PDOException $e) {
				// continue; the table didn't exist, no biggie, we were deleting it anyway (We're glad you're not there dirty table)
			}
			
			if ($this->db->query('SELECT * FROM `' . $event['update'] . '`;')) {
				try {
					$this->db->execute('CREATE TABLE `zbk_' . $event['update'] . '` LIKE `' . $event['update'] . '`;');
					$this->db->execute('INSERT INTO `zbk_' . $event['update'] . '` SELECT * FROM `' . $event['update'] . '`;');
					return true;
				} catch (PDOException $e) {
					throw new Exception($event['update'] . ': ' . $e->getMessage());				
				}
			}
		} else {
			debug($event);
			break;
		}
		return true;
	}
	
/** 
 * After method
 *
 * Drops the temp table created, and refresh the page to clear the cache
 * 
 * @param array
 * @return bool
 */
  	public function after($event) {
		/*if (!empty($event['update'])) {
			try {
				//$this->db->query('DROP TABLE `zbk_' . $event['update'] . '`;'); 
				return true;
			} catch (PDOException $e) {
				throw new Exception($event['update'] . ': ' . $e->getMessage());
			}
		} else {
			debug($event);
			break;
		}*/
		return true;
	}
	
/** 
 * Rename method
 *
 * Handles when a column has been renamed, and copies any data from the old column to the new column
 * 
 * @param string
 * @param string  (old column name)
 * @param string  (new column name)
 * @return bool
 */
  	public function rename($event, $schema) {	
		if (!empty($schema[$event['update']])) { // ex. $schema['blog_posts'] 
			$table = $event['update'];
			$columns = $schema[$event['update']];
			foreach ($columns as $old => $new) {
				try {
					$column = $this->db->query('SHOW COLUMNS FROM `zbk_' . $table . '` LIKE \'' . $old . '\';');
				} catch (PDOException $e) { 
					// throw new Exception($e->getMessage()); // turn this on to debug
					continue;  // ignore this exception we just want to know if this column exists
				}
				if (!empty($column)) {
					try {
						$this->db->query('UPDATE `' . $table . '` AS `New` SET `New`.`' . $new . '` =  (SELECT `Temp`.`' . $old . '` FROM `zbk_' . $table . '` AS `Temp` WHERE `Temp`.`id` = `New`.`id`);');
						return true;
					} catch (PDOException $e) {
						throw new Exception($event['update'] . ': ' . $e->getMessage());				
					} 
				}
			} // end table loop
		}
		return true; // column doesn't exist it must have already been updated at some point
	}
}
        
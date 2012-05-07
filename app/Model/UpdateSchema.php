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
				$this->db->execute('CREATE TABLE `' . $event['update'] . '_temp` LIKE `' . $event['update'] . '`;');
				$this->db->execute('INSERT INTO `' . $event['update'] . '_temp` SELECT * FROM `' . $event['update'] . '`;');
				return true;
			} catch (PDOException $e) {
				throw new Exception($event['update'] . ': ' . $e->getMessage());				
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
		if (!empty($event['update'])) {
			try {
				$this->db->query('DROP TABLE `' . $event['update'] . '_temp`;');
				return true;
			} catch (PDOException $e) {
				throw new Exception($event['update'] . ': ' . $e->getMessage());
			}
		} else {
			debug($event);
			break;
		}
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
			$table = $schema[$event['update']];
			foreach ($table as $old => $new) {
				try {
					$column = $this->db->query('SHOW COLUMNS FROM `' . $table . '_temp` LIKE \'' . $old . '\';');
				} catch (PDOException $e) {
					//  $e->getMessage();  ignore this exception we just want to know if this column exists
				} 
				if (!empty($column)) {
					try {
						$this->db->query('UPDATE `' . $table . '` AS `New` SET `New`.`' . $new . '` =  (SELECT `Temp`.`' . $old . '` FROM `' . $table . '_temp` AS `Temp` WHERE `Temp`.`id` = `New`.`id`);');
						return true;
					} catch (PDOException $e) {
						throw new Exception($event['update'] . ': ' . $e->getMessage());				
					} 
				}
			}
		}
		return true; // column doesn't exist it must have already been updated at some point
	}
}
        
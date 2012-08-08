<?php
/**
* ownCloud - Background Job
*
* @author Jakob Sack
* @copyright 2012 Jakob Sack owncloud@jakobsack.de
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
*
*/

/**
 * This class manages our scheduled tasks.
 */
class OC_BackgroundJob_ScheduledTask{
	/**
	 * @brief Gets one scheduled task
	 * @param $id ID of the task
	 * @return associative array
	 */
	public static function find( $id ){
		$stmt = OC_DB::prepare( 'SELECT * FROM *PREFIX*scheduledtasks WHERE id = ?' );
		$result = $stmt->execute(array($id));
		return $result->fetchRow();
	}

	/**
	 * @brief Gets all scheduled tasks
	 * @return array with associative arrays
	 */
	public static function all(){
		// Array for objects
		$return = array();

		// Get Data
		$stmt = OC_DB::prepare( 'SELECT * FROM *PREFIX*scheduledtasks' );
		$result = $stmt->execute(array());
		while( $row = $result->fetchRow()){
			$return[] = $row;
		}

		// Und weg damit
		return $return;
	}

	/**
	 * @brief Gets all scheduled tasks of a specific app
	 * @param $app app name
	 * @return array with associative arrays
	 */
	public static function whereAppIs( $app ){
		// Array for objects
		$return = array();

		// Get Data
		$stmt = OC_DB::prepare( 'SELECT * FROM *PREFIX*scheduledtasks WHERE app = ?' );
		$result = $stmt->execute(array($app));
		while( $row = $result->fetchRow()){
			$return[] = $row;
		}

		// Und weg damit
		return $return;
	}

	/**
	 * @brief schedules a task
	 * @param $app app name
	 * @param $klass class name
	 * @param $method method name
	 * @param $parameters all useful data as text
	 * @return id of task
	 */
	public static function add( $task, $klass, $method, $parameters ){
		$stmt = OC_DB::prepare( 'INSERT INTO *PREFIX*scheduledtasks (app, klass, method, parameters) VALUES(?,?,?,?)' );
		$result = $stmt->execute(array($app, $klass, $method, $parameters, time));

		return OC_DB::insertid();
	}

	/**
	 * @brief deletes a scheduled task
	 * @param $id id of task
	 * @return true/false
	 *
	 * Deletes a report
	 */
	public static function delete( $id ){
		$stmt = OC_DB::prepare( 'DELETE FROM *PREFIX*scheduledtasks WHERE id = ?' );
		$result = $stmt->execute(array($id));

		return true;
	}
}

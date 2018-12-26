<?php
/**
* Facebook Pixel extension for the phpBB Forum Software package. <https://github.com/olalavui/phpbb-facebookpixel/>
* 
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbbvietnam\facebookpixel\migrations\v10x;

/**
* Migration stage 1: Initial data changes to the database
*/
class m1_initial_data extends \phpbb\db\migration\migration
{
	/**
	* Assign migration file dependencies for this migration
	*
	* @return array Array of migration files
	* @static
	* @access public
	*/
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	/**
	* Add Facebook Pixel data to the database.
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		return array(
			array('config.add', array('facebookpixel_id', '')),
		);
	}
}

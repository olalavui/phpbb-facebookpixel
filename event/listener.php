<?php
/**
* Facebook Pixel for phpBB 3.2.x
* Base on Google Analytics extension for the phpBB Forum Software package.
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbbvietnam\facebookpixel\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\config\config        $config             Config object
	* @param \phpbb\template\template    $template           Template object
	* @param \phpbb\user                 $user               User object
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add'	=> 'add_facebookpixel_configs',
			'core.page_header'					=> 'load_facebookpixel',
		);
	}

	/**
	* Load Facebook Pixel js code
	*
	* @return void
	* @access public
	*/
	public function load_facebookpixel()
	{
		$this->template->assign_vars(array(
			'FACEBOOKPIXEL_ID'			=> $this->config['facebookpixel_id'],
			'FACEBOOKPIXEL_USER_ID'		=> $this->user->data['user_id'],
		));
	}

	/**
	* Add config vars to ACP Board Settings
	*
	* @param \phpbb\event\data $event The event object
	* @return void
	* @access public
	*/
	public function add_facebookpixel_configs($event)
	{
		// Add a config to the settings mode, after warnings_expire_days
		if ($event['mode'] === 'settings' && isset($event['display_vars']['vars']['warnings_expire_days']))
		{
			// Load language file
			$this->user->add_lang_ext('phpbbvietnam/facebookpixel', 'facebookpixel_acp');

			// Store display_vars event in a local variable
			$display_vars = $event['display_vars'];

			// Define the new config vars
			$fb_config_vars = array(
				'legend_facebookpixel' => 'ACP_FACEBOOKPIXEL',
				'facebookpixel_id' => array(
					'lang'		=> 'ACP_FACEBOOKPIXEL_ID',
					'validate'	=> 'facebookpixel_id',
					'type'		=> 'text:40:20',
					'explain'	=> true,
				),
			);

			// Add the new config vars after warnings_expire_days in the display_vars config array
			$insert_after = array('after' => 'warnings_expire_days');
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $fb_config_vars, $insert_after);

			// Update the display_vars event with the new array
			$event['display_vars'] = $display_vars;
		}
	}
}

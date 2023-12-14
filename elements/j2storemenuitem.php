<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_j2store_categories
 * @author      Gopi
 * @copyright   Copyright (C) 2023 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.form.formfield');
class JFormFieldJ2StoreMenuItem extends JFormField
{

	protected $type = 'J2storemenuitem';
	/**
	 * Method to get the field input markup.
	 *
	 * @return  string	The field input markup.
	 * @since   1.6
	 */
	protected function getInput()
	{
		$app = J2Store::platform()->application();
		$options = array();
		$module_id = $app->input->getInt('id');
		$menus =JMenu::getInstance('site');
		$menu_id = null;
		$menuItems = array();
		foreach($menus->getMenu() as $item)
		{
			if($item->type== 'component'){
				if(isset($item->query['option']) && $item->query['option'] == 'com_j2store' ){
					if(isset($item->query['catid'])){
						$options[$item->id] = $item->title;
					}
				}
			}
		}
	 return JHTML::_('select.genericlist', $options, $this->name, array('class'=>"input"), 'value', 'text', $this->value);
	}

}


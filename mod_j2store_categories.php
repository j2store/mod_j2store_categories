<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_j2store_categories
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the helper functions only once
require_once __DIR__ . '/helper.php';
$list = ModJ2storeCategoriesHelper::getList($params);

if (!empty($list))
{
    require JModuleHelper::getLayoutPath('mod_j2store_categories', $params->get('layout', 'default'));
}

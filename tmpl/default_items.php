<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_j2store_categories
 * @author      Gopi
 * @copyright   Copyright (C) 2023 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$platform=J2Store::platform();
$app = $platform->application();
$active_id = $app->input->getInt('filter_catid', '');
$category_display_view = $params->get('category_display_view', 'list_view');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

if ($category_display_view === "grid_view") {
    $categories_per_row = $params->get('categories_per_row', '4');
    $col = round(12 / $categories_per_row);
    $row_class = ($params->get('category_bootstrap_version', 2) == 2) ? 'row-fluid' : 'row';
    $column_class = ($params->get('category_bootstrap_version', 2) == 2) ? 'span' . $col : 'col-md-' . $col;
    $init = 1;
    foreach ($list as $item) {
        if ($init == 1) {
            ?>
            <div class="<?php echo $row_class; ?> j2store-categories-module <?php echo $moduleclass_sfx; ?>">
            <?php
        }
        ?>
        <div class="<?php echo $column_class; if ($_SERVER['PHP_SELF'] ==  Joomla\CMS\Router\Route::_(ContentHelperRoute::getArticleRoute($item->id))) echo ' active'; ?>">
            <?php
            $image = J2Store::platform()->getImagePath($item->getParams->get('image'));
            $image_alt = $item->getParams->get('image_alt');
            $active = ($active_id == $item->id) ? 'active' : '';
            $image_height = $params->get('image_height', 40);
            $image_width = $params->get('image_width', 40);
            $itemid = isset($item->menu_id) ? $item->menu_id : $params->get('menuitem_id', '');
            if ($params->get('show_image', 0) && $image != '') {
                ?>
                <a href="<?php echo $platform->getProductUrl(array('j2storesource'=>'category','task'=>'browse','filter_catid'=>$item->id,'Itemid'=>$itemid)); ?>">
                    <img src="<?php echo $image; ?>" width="<?php echo $image_width; ?>"
                         height="<?php echo $image_height; ?>" border="0" alt="<?php echo $image_alt; ?>"/>
                </a>
            <?php } ?>
            <h<?php echo $params->get('item_heading'); ?>>
                <a href="<?php echo $platform->getProductUrl(array('j2storesource'=>'category','task'=>'browse','filter_catid'=>$item->id,'Itemid'=>$itemid)); ?>">
                    <?php echo $item->title; ?>
                    <?php if ($params->get('numitems')) : ?>
                        (<?php echo $item->numitems; ?>)
                    <?php endif; ?>
                </a>
            </h<?php echo $params->get('item_heading'); ?>>
            <?php if ($params->get('show_description', 0)) { ?>
                <?php echo JHtml::_('content.prepare', $item->description, '', 'mod_j2store_categories.products'); ?>
            <?php } ?>

            <?php if ($params->get('browse_link', 1)) { ?>
                <a href="<?php echo $platform->getProductUrl(array('j2storesource'=>'category','task'=>'browse','filter_catid'=>$item->id,'Itemid'=>$itemid)); ?>">
                    <?php echo JText::_('J2STORE_BROWSE_PRODUCTS'); ?>
                </a>
            <?php }; ?>
        </div>
        <?php
        $init++;
        if ($init > $categories_per_row) {
            $init = 1;
            ?>
            </div>
            <?php
        }
    }
} else {
    ?>
    <ul class="j2store-categories-module <?php echo $moduleclass_sfx; ?>">
        <?php
        foreach ($list as $item) {
            ?>
            <li class="<?php if ($_SERVER['PHP_SELF'] ==  Joomla\CMS\Router\Route::_(ContentHelperRoute::getArticleRoute($item->id))) echo 'active'; ?>">
                <?php
                $image = J2Store::platform()->getImagePath($item->getParams->get('image'));
                $image_alt = $item->getParams->get('image_alt');
                $active = ($active_id == $item->id) ? 'active' : '';
                $image_height = $params->get('image_height', 40);
                $image_width = $params->get('image_width', 40);
                $itemid = isset($item->menu_id) ? $item->menu_id : $params->get('menuitem_id', '');
                if ($params->get('show_image', 0) && $image != '') {
                    ?>
                    <a href="<?php echo $platform->getProductUrl(array('j2storesource'=>'category','task'=>'browse','filter_catid'=>$item->id,'Itemid'=>$itemid)); ?>">
                        <img src="<?php echo $image; ?>" width="<?php echo $image_width; ?>"
                             height="<?php echo $image_height; ?>" border="0" alt="<?php echo $image_alt; ?>"/>
                    </a>
                <?php } ?>
                <h<?php echo $params->get('item_heading'); ?>>
                    <a href="<?php echo $platform->getProductUrl(array('j2storesource'=>'category','task'=>'browse','filter_catid'=>$item->id,'Itemid'=>$itemid)); ?>">
                        <?php echo $item->title; ?>
                        <?php if ($params->get('numitems')) : ?>
                            (<?php echo $item->numitems; ?>)
                        <?php endif; ?>
                    </a>
                </h<?php echo $params->get('item_heading'); ?>>
                <?php if ($params->get('show_description', 0)) { ?>
                    <?php echo JHtml::_('content.prepare', $item->description, '', 'mod_j2store_categories.products'); ?>
                <?php } ?>

                <?php if ($params->get('browse_link', 1)) { ?>
                    <a href="<?php echo $platform->getProductUrl(array('j2storesource'=>'category','task'=>'browse','filter_catid'=>$item->id,'Itemid'=>$itemid)); ?>">
                        <?php echo JText::_('J2STORE_BROWSE_PRODUCTS'); ?>
                    </a>
                <?php };
                if (isset($item->children)) {
                    $temp = $list;
                    $list = $item->children;
                    require JModuleHelper::getLayoutPath('mod_j2store_categories', $params->get('layout', 'default') . '_items');
                    $list = $temp;
                }
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
}
?>

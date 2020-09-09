<?php	 	
defined('_JEXEC') or die('Restricted access');
error_reporting(E_ALL & ~E_NOTICE);    

if (!file_exists(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'jshopping.php')){
	JError::raiseError(500,"Please install component \"joomshopping\"");
} 

require_once (dirname(__FILE__).DS.'helper.php');

require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."factory.php"); 
require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."jtableauto.php");
require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'tables'.DS.'config.php'); 
require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."functions.php");
require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."multilangfield.php");

JSFactory::loadCssFiles();

$lang = JFactory::getLanguage();
if(file_exists(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS . 'lang'. DS . $lang->getTag() . '.php')) 
	require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS . 'lang'. DS . $lang->getTag() . '.php'); 
else 
	require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS . 'lang'.DS.'en-GB.php'); 

JTable::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'tables');

// Get params     
    $category_id = JRequest::getInt('category_id');
    $category = JTable::getInstance('category', 'jshop');

//$categories_arr = modODJShoppingCategoryHelper::getCatsArray($field_sort, $ordering, $category_id, $categories_id);


$html = modODJShoppingCategoryHelper::getCatsArray($params, $category_id, $category);


require JModuleHelper::getLayoutPath('mod_od_jshopping_cat', $params->get('layout', 'default'));

?>
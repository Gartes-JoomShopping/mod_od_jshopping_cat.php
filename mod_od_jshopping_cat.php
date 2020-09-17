<?php	 	
defined('_JEXEC') or die('Restricted access');

$__moduleName = 'mod_od_jshopping_cat';
$start = microtime(true);

$app  = \Joomla\CMS\Factory::getApplication();
$cache = \Joomla\CMS\Cache\Cache::getInstance(
    'output', array(
        'defaultgroup' => 'com_jce',
        'lifetime' => 9999999,
        'caching' => true
    )
);




$partsCache = [];
//$partsCache[] = JUri::getInstance()->toString();
$partsCache[] = $__moduleName;
$partsCache[] = $app->input->get('sitecountry' , 'moskva' );
$key = md5(serialize($partsCache));










$data  = $cache->get($key, $__moduleName);

if ($data) {
    echo $data;
    $delay = microtime(true) - $start;
//    echo "<br>$delay ms delay<br>";
    return ;
}


/*$client = new \Joomla\Application\Web\WebClient();
$mobile = $client->__get('mobile');
echo'<pre>';print_r( $mobile );echo'</pre>'.__FILE__.' '.__LINE__;
die(__FILE__ .' '. __LINE__ );*/




//error_reporting(E_ALL & ~E_NOTICE);



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





if ( is_array( $category_id ) ) {
    if (count($category_id) === 1 )
    {
        $category_id = $category_id[0];
    }else{
        return null  ;
    }#END IF

} #END IF

$html = modODJShoppingCategoryHelper::getCatsArray($params, $category_id, $category);
ob_start();

    require JModuleHelper::getLayoutPath('mod_od_jshopping_cat', $params->get('layout', 'default'));

$data = ob_get_contents();
ob_clean();
ob_end_clean();

$cache->store($data, $key, $__moduleName);
echo $data ;
$delay = microtime(true) - $start;

//echo "<br>$delay ms delay (in cache exception)<br>";
return ;



<?php	 	
defined('_JEXEC') or die('Restricted access');
error_reporting(E_ALL & ~E_NOTICE);

class modODJShoppingCategoryHelper{
	public static function getTreeCats($category, $params, $active_id, $parent_id = 0, $html = ''){
        $jshopConfig = JSFactory::getConfig();
		
		$html .= '<ul class="od'.$params->get('moduleclass_sfx', 'menu').'">';
		$rows  = $category->getSubCategories($parent_id, $params->get('category_sort', 'id'), $params->get('sort_order', 'asc'), 1);
		if(count($rows))
		foreach($rows as $row) {
		  if (in_array($row->category_id, array(857,810,1023))) continue;
			$child = $category->getSubCategories($row->category_id, $params->get('category_sort', 'id'), $params->get('sort_order', 'asc'), 1);
			
			$html .= '<li class="'.((in_array($row->category_id, $active_id) ? 'current' : '')).'">';
				$html .= '<a href="'.$row->category_link.'">';
					$html .= '<span>';
						$html .= $row->name;
						// Show counter
						if($params->get('counter', 0)) {
							$category->category_id = $row->category_id;
							$counter = $category->getCountProducts('');
							$html .= '<span class="counter"> ('.$counter.')</span>';
						}
					$html .= '</span>';
					if(count($child)) {
						$html .= '<i></i>';
					}
				$html .= '</a>';
				
				// Show child
				if(count($child)) {
					$CategoryHelper = new modODJShoppingCategoryHelper();
//					$html .= $CategoryHelper->getTreeCats($category, $params, $active_id, $row->category_id, '');
					
//                  Deprecated: Non-static method modODJShoppingCategoryHelper::getTreeCats()
//                  should not be called statically
//                  in /var/www/valery/data/www/kickstarter.com.ru/test/modules/mod_od_jshopping_cat/helper.php on line 40
					$html .= modODJShoppingCategoryHelper::getTreeCats($category, $params, $active_id, $row->category_id, '');
				}
			$html .= '</li>';
		}
		$html .= '<div style="clear: both;"></div></ul>';
		
		
		return $html;
    }
	
	/**
	 * @param $params
	 * @param $active_id
	 * @param $category
	 *
	 * @return string
	 *
	 * @since version
	 *   Deprecated: Non-static method modODJShoppingCategoryHelper::getCatsArray() should not be called statically
	 *   in /var/www/valery/data/www/kickstarter.com.ru/test/modules/mod_od_jshopping_cat/mod_od_jshopping_cat.php on line 34
	 */
	public static function getCatsArray($params, $active_id, $category)
	{


        $category->load($active_id);
    	$categories_id = $category->getTreeParentCategories();



    	
	   return modODJShoppingCategoryHelper::getTreeCats($category, $params, $categories_id);
    }
	
}

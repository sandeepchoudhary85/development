<?php /*

Template Name: sitemap
*/?>


<div class="sitemap">
<h3>Sitemap</h3>	
<?php
  
  $menu_name = 'primary';
$locations = get_nav_menu_locations();

//print_r($locations);
//Get the id of 'primary_menu'
 $menu_id = $locations[ $menu_name ] ;
//Returns a navigation menu object.
$menuObject = wp_get_nav_menu_object($menu_id);
// Retrieves all menu items of a navigation menu.
$current_menu = $menuObject->slug;
$array_menu = wp_get_nav_menu_items($current_menu);

$menu = array();
                    foreach ($array_menu as $m) {
                        if (empty($m->menu_item_parent)) {
                            $menu[$m->ID] = array();
                            $menu[$m->ID]['ID']      =   $m->ID;
                            $menu[$m->ID]['title']       =   $m->title;
                            $menu[$m->ID]['url']         =   $m->url;
                            $menu[$m->ID]['children']    =   array();
                        }
                    }
                    $submenu = array();
                    foreach ($array_menu as $m) {
                        if ($m->menu_item_parent) {
                        $submenu[$m->ID] = array();
                            $submenu[$m->ID]['ID']       =   $m->ID;
                            $submenu[$m->ID]['title']    =   $m->title;
                            $submenu[$m->ID]['url']  =   $m->url;
                           $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
                        }
                    }

//echo "<pre>"; print_r($menu);
echo "<ul class='sitemapmenu'>";

       foreach($menu as $menuitems){       

       		echo "<li class='parentmenu'><a href=''>".$menuitems['title']."</a>";

       		if($menuitems['children']){

       			echo "<ul class='submenuul'>";
       			foreach($menuitems['children'] as $child){

       				echo "<li class='submenu'>".$child['title']."</li>";
       			}

       			echo "</ul>";
       		}
echo "</li>";
?>

<?php } ?>
</ul>
</div>

<style>
	.sitemap{
    display: grid;
    place-items: center center;
  
}
.sitemapmenu li {
  padding: 9px 0;
  list-style-type: none;
}

.sitemapmenu li.active a {
  color: red;
  font-weight 700
}
li.parentmenu a {
    border: 1px solid;
    padding: 3%;
    text-decoration: none;
    background: #ed7304;
    color: #fff;
    font-size: 17px;
}

.submenuul {
  padding-left: 15px;
  padding-top: 5px;
}

.submenuul li {
  position: relative;
  border-left: 1px solid #000;
}

.submenuul li::before {
  position: relative;
  top: -4px;
  width: 15px;
  border-bottom: 1px solid #000;
  content: '';
  display: inline-block;
}

.submenuul li:last-of-type {
  border-left: none;
}

.submenuul li:last-of-type:after {
  position: absolute;
  left: 0;
  top: 0;
  height: 18px;
  border-left: 1px solid #000;
  content: '';
  display: inline-block;
}
</style>

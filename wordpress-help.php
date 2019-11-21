/******* Call page data from page id ******/

 $the_query = new WP_Query( 'page_id=2' );

 while ($the_query -> have_posts()) : $the_query -> the_post();

                    the_title();
                    the_post_thumbnail();
                    the_id();

      endwhile;

/******* Call page data from id ******/


/**********create Custom post with custom category********/

/**** Create Custome post type ***/


add_action('init', 'create_our_work');
function create_our_work() {
 
    register_post_type( 'our_work',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Our Work' ),
                'singular_name' => __( 'our_work' )
         ),
           'public' => true,
           'has_archive' => true,
           'rewrite' => array('slug' => 'our_work'),
           'supports'  => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),

        )
    );

    $labels = array(
	    'name' => _x( 'Our work Category', 'taxonomy general name' ),
	    'singular_name' => _x( 'our_work_category', 'taxonomy singular name' ),
	    'search_items' =>  __( 'Search Our work Categorys' ),
	    'popular_items' => __( 'Popular Our work Categorys' ),
	    'all_items' => __( 'All Our work Categorys' ),
	    'parent_item' => __( 'Parent Our work Category' ),
	    'parent_item_colon' => __( 'Parent Our work Category:' ),
	    'edit_item' => __( 'Edit Our work Category' ),
	    'update_item' => __( 'Update Our work Category' ),
	    'add_new_item' => __( 'Add New Our work Category' ),
	    'new_item_name' => __( 'New Our work Category Name' ),
  		);

     register_taxonomy('our_work_category',
     	array('our_work'), array(
		    'hierarchical' => true,
		    'labels' => $labels,
		    'show_ui' => true,
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'our_work_category' ),
		  )
     );
}
/**********create Custom post with custom category********/


/************ Create Custom Menu html structure ***********/

function topheadermenu(){

	$menu_name = 'menu-1';
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
	    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	  
	   

	   $menuitems = wp_get_nav_menu_items($menu->term_id);
	   //echo "<pre>";print_r($menu_items);
	   $count = 0;
	  $submenu = false;
	  //echo "<pre>"; print_r($menuitems['1']);

	  echo '<ul class="nav navbar-nav">';
	   foreach( $menuitems as $item ) { 

	   			  if($menuitems[$count + 1]->menu_item_parent == $item->ID)
		   			  {
		   			  		$dropdownclass= 'dropdown';
		   			  		$icon = '<b class="caret"></b>';
		   			  		$hrefclass = 'dropdown-toggle';	
		   			  }
		   			else{ 
			   				$dropdownclass= ''; 
			   				$icon = ''; 
			   				$hrefclass = '';	
			   			 }

				  $link = $item->url;
				  $title = $item->title;
				  // item does not have a parent so menu_item_parent equals 0 (false)
				  if ( !$item->menu_item_parent ) {
				      // save this id for later comparison with sub-menu items
				      $parent_id = $item->ID;

				      if ($getCurrenturl == $link) {
				          $activeClass = 'active';
				      } else {
				          $activeClass = '';
				      }
				 
				      echo '<li class="item '.$activeClass. " " .$dropdownclass .'"><a data-toggle="'.$dropdownclass.'" href="'.$link.'" class="title '.$hrefclass.'">'.$title. $icon.'</a>';
				 
				  } 

				  if ( $parent_id == $item->menu_item_parent ) {

				      if ( !$submenu ) {

				          	$submenu = true; 
				  
				      		echo '<ul class="dropdown-menu" role="menu"><li>';

				      	}

				    echo '<a href="'.$link.'" class="title">'. $title .'</a>';

				       if ( $menuitems[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ) { 

				     		 echo '</ul></li>';
				   
				      	$submenu = false;  

				      }
				  }
	
		$count++;}

		echo "</ul>";
	}
}

/************ Create Custom Menu html structure ***********/




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




/************************ Custom Add Mata Box ****************/


///// Add Related metabox for Resources post type


function resources_add_custom_box_for_related_post()
{
    $screens = ['resources', 'wporg_cpt'];
    foreach ($screens as $screen) {
        add_meta_box(
            'resources_related_box_id',           // Unique ID
            'Related Resource Type',  // Box title
            'resources_add_custom_box_for_related_post_custom_box_html',  // Content callback, must be of type callable
            $screen,                   // Post type
            'side'
        );
    }
}
add_action('add_meta_boxes', 'resources_add_custom_box_for_related_post');

function resources_add_custom_box_for_related_post_custom_box_html($post){

$value = get_post_meta($post->ID, '_related_resources_meta_key', true);
$splitthevalue = explode(',', $value);
//echo "<pre>"; print_r($value);
$count = 0;
	foreach ($splitthevalue as $key => $splitthevaluevalue) {
		
		$title = str_replace(["-", "–"], ' ', $splitthevaluevalue);//sanitize_title($splitthevaluevalue);

   $liiiii .= '<li><button type="button" id="post_tag-check-num-'.$count.'" class="ntdelbutton"><span alt="'.$splitthevaluevalue.'" class="remove-tag-icon" aria-hidden="true"></span><span class="screen-reader-text">Remove term: '.$title.'</span></button>'.$title.'</li>';
	$count++;
	}

	?>
<ul class="tagchecklist" role="list">
	<?php echo $liiiii;?>
</ul>
<select class="mdb-select md-form" searchable="Search here..">
  <option value="" selected>Choose Resource Type </option>
  <?php $args = array(
                   'taxonomy' => 'resourcescat',
                   'orderby' => 'name',
                   'order'   => 'ASC',
                   'hide_empty' => FALSE
               );

       $allcategor = get_categories($args);
       foreach ($allcategor as $key => $allcategorvalue) :
       		foreach ($splitthevalue as $key => $splitthevaluevalue) { 

       			if($allcategorvalue->slug == $splitthevaluevalue){ $classattr = 'disabled' ;} else{$classattr = '';}
       		}
       	echo '<option '.$classattr.' value="'.$allcategorvalue->slug.'">'.$allcategorvalue->name.'</option>';
       endforeach;
  ?>
</select>
<input type="text" name="resources_related_value" id="resources_related_value" value="">
<script type="text/javascript">
	$(document).ready(function() {
		var count = 0;
		$('.mdb-select').on('change' ,  function(){

			var getvalue = jQuery(this).val();
			var getpostname = jQuery(".mdb-select :selected").text();

			var getselectedvalues = jQuery('#resources_related_value').val();

			var addcommasaporatedvalues = (!getselectedvalues) ? getvalue : getselectedvalues + ',' + getvalue;

			jQuery('#resources_related_value').val(addcommasaporatedvalues);


			jQuery(".mdb-select :selected").addClass('disabled');
			jQuery(".mdb-select :selected").attr('disabled' , 'disabled');
			
			jQuery('.tagchecklist').append('<li><button type="button" id="post_tag-check-num-'+count+'" class="ntdelbutton"><span alt="'+getvalue+'" class="remove-tag-icon" aria-hidden="true"></span><span class="screen-reader-text">Remove term: '+getpostname+'</span></button>'+getpostname+'</li>');
	 count++;
		});

///// Remove cli8ck 
		jQuery(document).on('click' , '.remove-tag-icon' ,  function(){

			jQuery(this).parent().parent('li').remove();
			var getremovedvalue = jQuery(this).attr('alt');
			//alert(getremovedvalue);
		jQuery(".mdb-select").val(getremovedvalue).find("option[value=" + getremovedvalue +"]").removeAttr('disabled', true);


				var getvaluesforremove = jQuery('#resources_related_value').val();
				var strArray = getvaluesforremove.split(',');
	            for (var i = 0; i < strArray.length; i++) {

	                if (strArray[i] === getremovedvalue) {

	                    strArray.splice(i, 1);

	                }

	            }
	            jQuery('#resources_related_value').val(strArray);
				//alert(strArray);

		})

	});
</script>
    <?php


}
if($_POST['post_type'] == 'resources'){

 //echo "<pre>"; print_r($_POST);

 //echo $_POST['resources_related_value'];
 function related_resources_save_postdata($post_id)
	{
	    if (array_key_exists('resources_related_value', $_POST)) {
	        update_post_meta(
	            $post_id,
	            '_related_resources_meta_key',
	            $_POST['resources_related_value']
	        );
	    }
	}
add_action('save_post', 'related_resources_save_postdata');



  //die;

}

/************************ Custom Add Mata Box ****************/



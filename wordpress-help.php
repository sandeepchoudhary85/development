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

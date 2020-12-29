<?php 

add_action( 'init', 'add_rewritess' );
function add_rewritess() {
		add_rewrite_rule( 'my-account/my-rsvp?$', 'index.php?my-account/my-rsvp=1', 'top' );
		add_rewrite_tag( '%my-account/my-rsvp%', '([^&]+)' );

		add_rewrite_rule( 'my-account/sendrsvp?$', 'index.php?my-account/sendrsvp=1', 'top' );
		add_rewrite_tag( '%my-account/sendrsvp%', '([^&]+)' );

        add_rewrite_rule( 'my-account/managersvp?$', 'index.php?my-account/managersvp=1', 'top' );
        add_rewrite_tag( '%my-account/managersvp%', '([^&]+)' );
	}

//// Rsvp page Tempate 
function prefix_url_rewrite_templates() {
global $wp_query;
//echo "<pre>"; print_r($wp_query);	
    if ( get_query_var( 'my-account/my-rsvp' ) ) { 
        add_filter( 'template_include', function() {
            return get_template_directory() . '/core/my-rsvp.php';
        });
    }

    if ( get_query_var( 'my-account/sendrsvp' ) ) { 
        add_filter( 'template_include', function() {
            return get_template_directory() . '/core/sendrsvp.php';
        });
    }

    if ( get_query_var( 'my-account/managersvp' ) ) { 
        add_filter( 'template_include', function() {
            return get_template_directory() . '/core/managersvp.php';
        });
    }
}
add_action( 'template_redirect', 'prefix_url_rewrite_templates' );
?>
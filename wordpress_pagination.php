rule for pagination

function my_pagination_rewrite() { 
  add_rewrite_rule('blog/page/?([0-9]{1,})/?$', 'index.php?pagename=blog&paged=$matches[1]', 'top');
  add_rewrite_rule('leksykon/page/?([0-9]{1,})/?$', 'index.php?pagename=leksykon&paged=$matches[1]', 'top');
}
add_action('init', 'my_pagination_rewrite');



$current_page = max(1, get_query_var('paged'));
			$arts = get_posts(
				array(
					'post_type' => $postType,
					'post_status' => 'publish',
					'orderby' => 'post_name',
                    'order' => 'asc',
					'post_per_page' => $limit,
					//'offset'	=> $offset,
										
					'suppress_filters'  => true,
					'paged'     => $current_page,
				)
			);


<?php
// Define the current page and the number of posts per page
$current_page = max(1, get_query_var('paged'));
$posts_per_page = 10;

// Get the total number of posts
$total_posts = wp_count_posts()->publish;

// Calculate the total number of pages
$total_pages = ceil($total_posts / $posts_per_page);

// Build the pagination links
$pagination_links = paginate_links(array(
    'base' => get_pagenum_link(1) . '%_%',
    'format' => '?paged=%#%',
    'current' => $current_page,
    'total' => $total_pages,
    'prev_text' => __('&laquo; Previous'),
    'next_text' => __('Next &raquo;')
));

// Output the pagination links
if ($pagination_links) {
    echo $pagination_links;
}
?></div>

<?php
// if ( get_query_var('paged') ) {
//     $paged = get_query_var('paged');
//    } elseif ( get_query_var('page') ) {
//     $paged = get_query_var('page');
//    } else {
//     $paged = 1;
//    }
// $big = 999999999; // need an unlikely integer
// echo paginate_links( array(
//         'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
//         'format' => '?paged=%#%',
//         'current' => max( 1, get_query_var('paged') ),
//         'total' => $total_pages
// ) );
?>
 <?php wp_reset_postdata(); ?>

<?php 
global $wpdb;
global $product;
$search= "'%".$_REQUEST['get']."%'";

$getproductbycategorysearch = $wpdb->get_results("SELECT DISTINCT t.* FROM grY_terms AS t  
INNER JOIN grY_termmeta ON ( t.term_id = grY_termmeta.term_id ) 
AND (( grY_termmeta.meta_key = 'product_count_product_cat' AND t.name LIKE $search )) 
ORDER BY t.name ASC");

//print_r($getproductbycategorysearch);

foreach($getproductbycategorysearch as $key => $getproductbycategorysearchvalue){
    
  $ids[] = $getproductbycategorysearchvalue->term_id;
  $slugs .= $getproductbycategorysearchvalue->slug.',';
  $textquery['taxonomy'] =  'product_cat'.',';
  $textquery['field']    = 'term_id'.',';
  $textquery['terms']    =  $getproductbycategorysearchvalue->term_id.','; // When you have more term_id's seperate them by komma.
  $textquery['operator']  = 'IN';
    
    
}


//$removecommalast = rtrim($ids, ',');
//$removecommalastslugs = rtrim($slugs, ',');
//$prod_categories = array(12, 17);
//print_r($ids);
//print_r($prod_categories);
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
if(!empty($getproductbycategorysearch)){
  $args = array(
    //'post_status' => 'publish',
    'post_type' => 'product',
    'posts_per_page' => 50,
    'paged'     => $paged,
    'tax_query' => array(array(
        //'relation' => 'OR',
         'taxonomy' => 'product_cat',
         'field'    => 'term_id',
         'terms'     =>  $ids, // When you have more term_id's seperate them by komma.
         'operator'  => 'IN'
         )
         )
    );
}

else{
    
      $args = array(
    //'post_status' => 'publish',
    'post_type' => 'product',
    'posts_per_page' => 50,
    'paged'     => $paged,
    's' => $_REQUEST['get']
    
    );
    
}

$loop = new WP_Query($args);
//echo $wpdb->last_query;
//echo $loop->found_posts;
$i = 1;
while ( $loop->have_posts() ) : $loop->the_post(); 
//the_title();
//echo "<br>";
//echo $i++;
wc_get_template_part( 'content', 'product' );
endwhile;
/*the_posts_pagination( array(
		    	'mid_size'=>3,
			 	'prev_text' => _( '« Previous'),
			  	'next_text' => _( 'Next »'),
			) );*/

?>

<?php 

global $wpdb;

   $querycounter = 1;
  foreach ($_REQUEST['advanceajaxsearchformdata'] as $key => $value) {
          
          $metakey   = $value['name'];
          $metavalue = "'".$value['value']."'";

          $m1m2 = "mt".$querycounter;
         $innerjoin .= "INNER JOIN `wp_postmeta` AS $m1m2 ON ( `wp_posts`.`ID` = $m1m2.`post_id` )";

         if($metakey === 'price' ){

            $andcondition .= "AND ( $m1m2.`meta_value` BETWEEN 0 AND $metavalue )";
         }
         else{

            $andcondition .= "AND ( $m1m2.`meta_value` = $metavalue )";

         }

         
          //$genratearray .= "array('relation' => 'AND',array('key' => $metakey, 'value' , $metavalue , 'compare' => 'EXISTS')),";
         $querycounter++;
  }


$wpdb->query('SET SQL_BIG_SELECTS = 1');
$querystr = "
   SELECT SQL_CALC_FOUND_ROWS wp_posts.ID FROM `wp_posts`         
        $innerjoin        
        WHERE '1'='1' 
        $andcondition  
        AND `wp_posts`.`post_type` = 'properties' 
        AND (`wp_posts`.`post_status` = 'publish' 
        OR `wp_posts`.`post_status`= 'acf-disabled' 
        OR `wp_posts`.`post_status` = 'future' 
        OR `wp_posts`.`post_status` = 'draft' 
        OR `wp_posts`.`post_status` = 'pending' 
        OR `wp_posts`.`post_status` = 'private') 
        
        GROUP BY `wp_posts`.`ID` ORDER BY `wp_posts`.`menu_order` ,`wp_posts`.`post_date` DESC LIMIT 0, 12
 ";
 //echo $wpdb->show_errors( true );
$getpostids = $wpdb->get_results($querystr, OBJECT);
$data = $wpdb->get_results($wpdb->prepare( $querystr ) , ARRAY_N  );

  //print_r($data);
  //print_r($getpostids);
foreach ($data as $key => $valueid) {
   $filterids .= $valueid[$key].',';
}
  
 //echo $querystr; die;

//echo "<pre>"; print_r($_REQUEST);
  // foreach ($_REQUEST['advanceajaxsearchformdata'] as $key => $value) {
          
  //         $metakey   = $value['name'];
  //         $metavalue = $value['value'];

  //         //$genratearray .= "array('relation' => 'AND',array('key' => $metakey, 'value' , $metavalue , 'compare' => 'EXISTS')),";

  // }
  //print_r($arrayrelation);  
  //$genratearraymain =  rtrim($genratearray , ',');
 // echo "==>" . $genratearraymain;die;

$genratearraymain =  rtrim($filterids , ',');

  $args = array(
    'post_type' => 'properties',
    'post__in' => array( $genratearraymain )
     // 'meta_query' => array( 
     //         'relation' => 'AND',
             
     //        //$genratearraymain
     //         array('relation' => 'AND',
     //             array('key' => 'property_type', 'value' , 'Buy' , 'compare' => 'IN')),

     //          array('relation' => 'AND',
     //             array('key' => 'property_location', 'value' , 'test' , 'compare' => 'IN')
     //            ),
     //          array('relation' => 'AND',
     //              array('key' => 'type', 'value' , 'Appartement' , 'compare' => 'IN')
     //           ),
     //          array('relation' => 'AND',
     //              array('key' => 'chambres', 'value' , '3' , 'compare' => 'IN')
     //            ),
     //          array('relation' => 'AND',
     //             array('key' => 'surface_habitable', 'value' , '+/-125,00' , 'compare' => 'IN')
     //            ),
     //          array('relation' => 'AND',
     //              array('key' => 'price', 'value' , '100.000' , 'compare' => 'IN')
     //             )
     //   )
);
//echo "<pre>";print_r($args ); die;
$testimoniallist = new WP_Query($args);

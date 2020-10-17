global $wpdb;
//echo "<pre>";print_r($_REQUEST);
   $querycounter = 1;
  foreach ($_REQUEST['advanceajaxsearchformdata'] as $key => $value) {
          
          $metakey   = $value['name'];
          $metakeyforall  = "'".$value['name']."'";
          $metavalue = "'".$value['value']."'";
          $forprice = $value['value'];

          // if($value['value'] === 'all'){

          // 	$m1m2 = "mt".$querycounter;
           //	$getalldataquery[] = $metakey;
          // 	$andconditionforalldata .= "OR ( mt2.`meta_key` = $metakeyforall )";          	
          // 	$innerjoinforalldata .= "INNER JOIN `wp_postmeta` AS $m1m2 ON ( `wp_posts`.`ID` = $m1m2.`post_id` )";

          // }

          $filtersearch .= " when  $metavalue then m.post_id";

 

         if($value['value'] != 'all'){

                  $m1m2 = "mt".$querycounter;
         $innerjoin .= "INNER JOIN `wp_postmeta` AS $m1m2 ON ( `wp_posts`.`ID` = $m1m2.`post_id` )";

            if($metakey === 'price' ){
              $splitprice = explode('-', $forprice);
              //print_r($splitprice); die;
              $startprice = $splitprice['0'];
              $endprice =   $splitprice['1'];
              //echo (string)$startprice ."===". 'Above';
              if(trim($startprice , ' ') == 'Above'){

                $pricecompare = " >= $endprice";
              }
              else{
                $pricecompare = "BETWEEN $startprice AND $endprice";
              }

            $andcondition .= "AND ( $m1m2.`meta_value` $pricecompare AND $m1m2.`meta_key` = $metakeyforall) ";
         }
         else{

            $andcondition .= "AND ( $m1m2.`meta_value` = $metavalue  AND $m1m2.`meta_key` = $metakeyforall )";

         }
       }

         
          //$genratearray .= "array('relation' => 'AND',array('key' => $metakey, 'value' , $metavalue , 'compare' => 'EXISTS')),";
         $querycounter++;
  }
  //echo $andcondition;
//echo "<pre>";print_r($getalldataquery);
if(!empty($getalldataquery)){
$wpdb->query('SET SQL_BIG_SELECTS = 1');
$querystrforgetalldata = "
   SELECT  case  m.`meta_value`
        $filtersearch
    end as ID , m.* from `wp_postmeta` as m where 
    m.meta_key = 'property_location' 
    OR m.meta_key = 'type' 
    OR m.meta_key = 'chambres' 
    OR m.meta_key = 'surface_habitable' 
    OR m.meta_key = 'Buy' 
    OR m.meta_key = 'price'
 ";
//echo $querystrforgetalldata;
 //echo $wpdb->show_errors( true );

//$getpostidsforalldata = $wpdb->get_results($wpdb->prepare( $querystrforgetalldata ) , ARRAY_N  );
}
//echo "<pre>"; print_r($getpostidsforalldata); die;

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
        
        GROUP BY `wp_posts`.`ID` ORDER BY `wp_posts`.`menu_order` ,`wp_posts`.`post_date` DESC
 ";
 //echo $wpdb->show_errors( true );
$getpostids = $wpdb->get_results($querystr, OBJECT);
$data = $wpdb->get_results($wpdb->prepare( $querystr ) , ARRAY_N  );


 //echo "<pre>"; print_r($data);
  //print_r($getpostids);
foreach ($data as $key => $valueid) {
   $filterids .= $valueid['0'].',';
}

// foreach ($getpostidsforalldata as $key => $valueid) {
//     if($valueid['0'] != '') { $filterids .= $valueid['0'].',' ; }
// }
  //echo "<pre>".$filterids; die;
 //echo $querystr; 



 $genratearraymain =  rtrim($filterids , ',');
 $genratearraymain = explode("," , $genratearraymain );
 //echo count($genratearraymain);
  //echo "<pre>";print_r($genratearraymain );
$paged = $_REQUEST['page'];
  $args = array(
    'post_type' => 'properties',
    'post__in' =>  $genratearraymain,
    'posts_per_page' => '10',
    'paged' => $paged
);
//echo "<pre>";print_r($args ); die;
$testimoniallist = new WP_Query($args);
//echo $wpdb->last_query;
//echo "Last SQL-Query: {$testimoniallist->request}"; die;


if($testimoniallist->have_posts()) : while($testimoniallist->have_posts()): $testimoniallist->the_post();

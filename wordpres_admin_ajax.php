Function .php

add_action( 'wp_ajax_getlocationdata', 'getmapcordinates' );
add_action( 'wp_ajax_nopriv_getlocationdata', 'getmapcordinates' );	

function getmapcordinates(){

$zipcode = $_REQUEST['zipcode'];
	$args = array(
    'post_type'      => 'msa_specific',
    'posts_per_page' => -1,
    'order'          => 'DESC',
    'meta_key'		=> 'zip_code',
	'meta_value'	=> $zipcode
 );
$counter = 1;
$counter1 = 0;
$tech_posts = new WP_Query( $args );
if ( $tech_posts->have_posts() ) :

while ( $tech_posts->have_posts() ) : $tech_posts->the_post();


Css


.modalgif {
  position: fixed;
  z-index: 1000;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: rgba( 255, 255, 255, .8 ) url('../../assets/images/loading.gif') 50% 50% no-repeat;
  opacity: 0.80;
  -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity = 80);
  filter: alpha(opacity = 80);
}

body.loading {
    overflow: hidden;   
}


<script>
  jQuery(document).ready(function(){
jQuery('.findplace').on('click' ,  function(){

      var getzipcode = jQuery(this).prev('.getzipvalue').val();  

         jQuery.ajax({
            type: "POST",
            //async: false,
            //dataType: 'JSON',
            beforeSend: function() { 
                      jQuery('body').addClass("loading");  
                      jQuery('body').append('<div class="modalgif"></div>');
                    },
              complete: function() { 
                jQuery('body').removeClass("loading"); 
                jQuery('.modalgif').remove();
              },
            url: '/wp-admin/admin-ajax.php',
            data: {'action':'getlocationdata' , 'zipcode' : getzipcode},
            success: function(data){ 
              //alert(data);
              jQuery('#innerdivresponce').html(data);
            }
        });

  })

})

</script>

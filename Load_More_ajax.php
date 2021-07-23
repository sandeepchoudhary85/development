<script>
  jQuery(document).ready(function(){

var pageNumber = 1;
var canBeLoaded = true; // this param allows to initiate the AJAX call only if necessary
var bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts

    jQuery(window).on('scroll', function(){ 
        if( jQuery(document).scrollTop() > ( jQuery(document).height() - bottomOffset ) && canBeLoaded == true ){
                
             if(jQuery('#alldone').val() == 'finish') { return false;}
              ajaxloadmore();
        
    }
});


function ajaxloadmore(){ 

          pageNumber++;    

         jQuery.ajax({
            type: "POST",
            //async: false,
            //dataType: 'JSON',
            beforeSend: function() { 
                canBeLoaded = false; 
                      jQuery('body').addClass("loading");  
                      jQuery('body').append('<div class="modalgif"></div>');
                    },
              complete: function() { 
                jQuery('body').removeClass("loading"); 
                jQuery('.modalgif').remove();
              },
            url: './wp-admin/admin-ajax.php',
            data: {'action':'loadmoreblogposts' , 'pageNumber' : pageNumber},
            success: function(data){ 
                canBeLoaded = true;
              if(data == 'finish'){
                    jQuery('#alldone').val(data);
              }
              else{
                   jQuery('#alldone').val('');
                  jQuery('#innerdivresponce').append(data);
              }
              
            }
        });

  }

})

</script>


==================================Add Code in function.php ========================================


add_action( 'wp_ajax_loadmoreblogposts', 'loadmoreajaxpostsforblog' );
add_action( 'wp_ajax_nopriv_loadmoreblogposts', 'loadmoreajaxpostsforblog' );

function loadmoreajaxpostsforblog(){

$startcounter = 0 ; 
$page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
$args = array( 'post_type' => 'post', 'posts_per_page' => 2 , 'paged'    => $page, );
$the_query = new WP_Query( $args ); 

     if ( $the_query->have_posts() ) : 
     while ( $the_query->have_posts() ) : $the_query->the_post(); 
       $thumbnail = get_the_post_thumbnail_url();
       $postid = get_the_id();
    $firstclass = ($startcounter == 0 ) ? 'post-first' : '';
 ?>
<li id="p-<?php echo $postid; ?>" class="<?php echo $firstclass; ?> loyalticommunication post-<?php echo $postid; ?>">
<a href="<?php the_permalink();?>">
<p class="img-p">
<picture><source srcset="<?php echo $thumbnail; ?>" type="image/webp"><img loading="eager" src="<?php echo $thumbnail; ?>" width="460" height="277" alt="Let Me Help You Get More Google Traffic" class="webpexpress-processed"></picture>
</p>
<h2 class="size-24 title"><?php the_title();?></h2>
<p class="details">
<span class="comments">23 comments</span>
</p>
</a>
</li>

<?php $startcounter++;   endwhile;
else :
	 echo 'finish';
    //_e( 'Sorry, no posts matched your criteria.', 'textdomain' );

endif;
exit;
}









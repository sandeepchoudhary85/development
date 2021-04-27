add_action( 'wp_ajax_sendemailfromhomepage', 'sendemailfromhomepage' );
add_action( 'wp_ajax_nopriv_sendemailfromhomepage', 'sendemailfromhomepage' );	

function sendemailfromhomepage(){
   // echo "<pre>"; print_r($_POST); die;
    if(!empty($_POST['website'])){
        echo "yesssss.";
        die;
        
    }
    else {
   $toEmail = "info@gardenworks-inc.com,bkelly@wsismartmarketing.com";
    //$toEmail = "devdevelopment6@gmail.com,sandeepchoudhary85@gmail.com,rawat24@gmail.com";
       // $toEmail = "admin@phppot_samples.com";
    $mailHeaders .= "MIME-Version: 1.0" . "\r\n";
    $mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // More headers
    //$headers .= 'From: <webmaster@example.com>' . "\r\n";
    $mailHeaders .= 'Cc: info@gardenworks-inc.com' . "\r\n";
        $posttitle = "From: " . $_POST["your-name"] . "<". $_POST["your-email"] .">";
    //$mailHeaders .= "From: " . $_POST["your-name"] . "<". $_POST["your-email"].">\r\n";
    $mailHeaders .= "From: info@gardenworks-inc.com \r\n";
      $mailHeaders .= "X-Priority: 3\r\n";
  $mailHeaders .= "X-Mailer: PHP". phpversion() ."\r\n" ;
    
        
        $body .= "Hello Webmaster,
You have received a new contact request from the website. Please see the Details Below:";

     $body .=   "First Name: ".$_POST['your-name']."<br>";
     $body .=   "Email: ".$_POST['your-email']."<br>";
     $body .=   "Company: ".$_POST['your-company']."<br>";
     $body .=   "Phone: ".$_POST['your-Phnumber']."<br>";
     $body .=   "Comment: ".$_POST['your-message']."<br>";
    
    
     $bodyp .=   "First Name: ".$_POST['your-name']."<br>";
     $bodyp .=   "Email: ".$_POST['your-email']."<br>";
     $bodyp .=   "Company: ".$_POST['your-company']."<br>";
     $bodyp .=   "Phone: ".$_POST['your-Phnumber']."<br>";
     $bodyp .=   "Comment: ".$_POST['your-message']."<br>";
    }
    
   $POSTsubject = "https://www.gardenworks-inc.com - Garden Works - New Contact Request from Home Page";
    if(mail($toEmail, $POSTsubject, $body, $mailHeaders)) {
           
           // Create post object
                    $my_post = array(
                      'post_type'=>'form_submission_list',
                      'post_title'    => $posttitle,
                      'post_content'  => $bodyp,
                      'post_status'   => 'publish',
                      'post_author'   => 1,
                      //'taxonomies' => array(51)
                      'tax_input' => array(
                            'form_submission_list_category' => array(50)
                        )
                        
                    );
                    
                    // Insert the post into the database
                    wp_insert_post( $my_post );
                    
           echo 200;
        } else {
            print "<p class='Error'>Problem in Sending Mail.</p>";
        }
die;
}




add_action('init', 'form_submission');
function form_submission() {
 
    register_post_type( 'form_submission_list',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Form Submission List' ),
                'singular_name' => __( 'form_submission_list' )
         ),
           'public' => true,
           'has_archive' => true,
           'rewrite' => array('slug' => 'form_submission_list'),
           'supports'  => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),

        )
    );

    $labels = array(
	    'name' => _x( 'Form Submission List Category', 'taxonomy general name' ),
	    'singular_name' => _x( 'form_submission_list_category', 'taxonomy singular name' ),
	    'search_items' =>  __( 'Search Form Submission List Categorys' ),
	    'popular_items' => __( 'Popular Form Submission List Categorys' ),
	    'all_items' => __( 'All Form Submission List Categorys' ),
	    'parent_item' => __( 'Parent Form Submission List Category' ),
	    'parent_item_colon' => __( 'Parent Form Submission List Category:' ),
	    'edit_item' => __( 'Edit Form Submission List Category' ),
	    'update_item' => __( 'Update Form Submission List Category' ),
	    'add_new_item' => __( 'Add New Form Submission List Category' ),
	    'new_item_name' => __( 'New Form Submission List Category Name' ),
  		);

     register_taxonomy('form_submission_list_category',
     	array('form_submission_list'), array(
		    'hierarchical' => true,
		    'labels' => $labels,
		    'show_ui' => true,
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'our_work_category' ),
		  )
     );
}



add_action( 'admin_init', 'do_something_152677' );

function do_something_152677 () {
    // Global object containing current admin page
    global $pagenow;

   // echo "<pre>"; print_r($_GET); 
    
   if(get_post_type( $_GET['post'] ) == 'form_submission_list'){
       
        function hide_toolbar_TinyMCE( $in ) {
        $in['toolbar1'] = '';
        $in['toolbar2'] = '';
        $in['toolbar'] = false;
        return $in; 
    }
    add_filter( 'tiny_mce_before_init', 'hide_toolbar_TinyMCE' );
    
    add_filter( 'tiny_mce_before_init', function( $args ) {

    if ( 1 == 1 )
         $args['readonly'] = 1;

    return $args;
} );
       
       echo '<style>#postdivrich1 {pointer-events: none;}#wp-content-editor-tools {display: none;}#submitdiv {display: none;}</style>';
   }
  
}

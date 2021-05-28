add_action( 'wpcf7_before_send_mail', function ($cf7) {
 ///$baseURI = 'https://app-3QN7TPER9S.marketingautomation.services/webforms/receivePostback/MzawMDE1tbQ0AAA/';
  if ($_POST['_wpcf7'] ==16334)  {
  	///$form_id = $cf7->posted_data['_wpcf7'];
  	
 $getpostid = $_POST['_wpcf7_container_post'];
 //echo get_the_title( $getpostid );
 $getpageurl = get_field('thank_you_page_location_url_for_custom_popup_form' , $getpostid);
 $subject = get_the_title( $getpostid );

    $mail= $cf7->prop('mail');
    $mail['subject'] = "Mail From : ".$subject;

    $mail['body'] = str_replace("replace_in_function_php",$getpageurl,$mail['body']); 

$cf7->set_properties(array("mail" => $mail));

//echo "<pre>"; print_r($cf7->mail); die;

 }
 // If connecting another form, place its code below this one



 
});

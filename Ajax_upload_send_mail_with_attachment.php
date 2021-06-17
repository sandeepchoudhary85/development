<script type="text/javascript">
jQuery(document).ready(function(){

		jQuery('#full_quote').on('submit', function(e){ 
			e.preventDefault();
			var errorclass = 'errormessahe';
			var formid = 'full_quote';
		    jQuery.ajax({
            type: "POST",
            //async: false,
            //dataType: 'JSON',
            processData: false,
    		contentType: false,
            beforeSend: function() { 
                      jQuery('body').addClass("loading");  
                      jQuery('body').append('<div class="modalgif"></div>');
                    },
              complete: function() { 
                jQuery('body').removeClass("loading"); 
                jQuery('.modalgif').remove();
              },
            url: 'sendemail.php',
            data: new FormData(this),
           // data: formData,
            success: function(data){            	

                var parsedData = JSON.parse(data);
				if(parsedData.status == 200){
				     var url = 'thankyou.php';
					window.location.href = url;
				}

				else{

					jQuery('.'+errormessahe).show();
					jQuery('.'+errormessahe).html(parsedData.message);
					jQuery("."+errormessahe).fadeOut(15000);
					
				}
            }
        });

		})

	})
</script>
<?php 

// echo "<pre>"; print_r($_FILES);
// echo "<pre>"; print_r($_REQUEST);

			

   // Get the submitted form data
    $email = 'sandeepchoudhary85@gmail.com';
    $emailfrom = $_REQUEST['email'];
    $name = $_REQUEST['name'];
    //$subject = $_POST['subject'];
    //$message = $_POST['message'];
			
		$htmlparsing = '<table>';

    $i = 0;
    foreach ($_REQUEST as $key => $r) { 
   if($key == 'services'){ $tabledata = implode(', ',$r); } else{ $tabledata = $r;}
        $htmlparsing .= "<tr>";
        $htmlparsing .= "<td>" . ucfirst(trim(($key))).  " : </td><td>" . $tabledata . "</td>";
        $htmlparsing .= "</tr>";

        $i++;
    }

$htmlparsing .= '</table>';

//echo "===>".$htmlparsing; die;


    $uploadStatus = 1;
    // Upload attachment file
    if(!empty($_FILES["attachment"]["name"])){
        // File path config
        $targetDir = "uploads/";
        $fileName = basename($_FILES["attachment"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        // Allow certain file formats
        $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg' , 'zip');
        if(in_array($fileType, $allowTypes)){
            // Upload file to the server
            if(move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)){

                $uploadedFile = $targetFilePath;
                $returnresponce['status'] = 200;
        		$returnresponce['message'] = 'File Uploaded successfully!';

            }else{

                $uploadStatus = 0;
                $statusMsg = "Sorry, there was an error uploading your file.";

                $returnresponce['status'] = 301;
        		$returnresponce['message'] = $statusMsg;

            }
        }else{
            $uploadStatus = 0;
            $statusMsg = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';

            $returnresponce['status'] = 301;
    		$returnresponce['message'] = $statusMsg;
        }


        
    }
    //// Check if file is uploaded 
    if($uploadStatus == 1){
        // Recipient
        $toEmail = $email;
        // Sender
        $from = $emailfrom;
        $fromName = $name;
        // Subject
        $emailSubject = 'Quote request Submitted by '.$name;
        // Message
        $htmlContent = $htmlparsing;
        // Header for sender info
        $headers = "From: $fromName"." <".$from.">";
        if(!empty($uploadedFile) && file_exists($uploadedFile)){
            // Boundary
            $semi_rand = md5(time());
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
            // Headers for attachment
            $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
            // Multipart boundary
            $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";
            // Preparing attachment
            if(is_file($uploadedFile)){
                $message .= "--{$mime_boundary}\n";
                $fp =    @fopen($uploadedFile,"rb");
                $data =  @fread($fp,filesize($uploadedFile));
                @fclose($fp);
                $data = chunk_split(base64_encode($data));
                $message .= "Content-Type: application/octet-stream; name=\"".basename($uploadedFile)."\"\n" .
                    "Content-Description: ".basename($uploadedFile)."\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"".basename($uploadedFile)."\"; size=".filesize($uploadedFile).";\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            }
            $message .= "--{$mime_boundary}--";
            $returnpath = "-f" . $email;
            // Send email
            $mail = mail($toEmail, $emailSubject, $message, $headers, $returnpath);
            // Delete attachment file from the server
            @unlink($uploadedFile);
        }else{
            // Set content-type header for sending HTML email
            $headers .= "\r\n". "MIME-Version: 1.0";
            $headers .= "\r\n". "Content-type:text/html;charset=UTF-8";
            // Send email
            $mail = mail($toEmail, $emailSubject, $htmlContent, $headers);
        }
        // If mail sent
        if($mail){
             $statusMsg = 'Your email attachment request has been submitted successfully !';
             $returnresponce['status'] = 200;
    		 $returnresponce['message'] = $statusMsg;
        }else{
            $statusMsg = 'Your request submission failed, please try again.';
             $returnresponce['status'] = 301;
    		$returnresponce['message'] = $statusMsg;
        }
    }
    echo json_encode($returnresponce); die;
   // echo '<script>alert("'.$statusMsg.'");window.location.href="./";</script>';


?>

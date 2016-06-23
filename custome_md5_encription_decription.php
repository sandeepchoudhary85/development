function encrypt_decrypt($action, $string) {
    $output = false; $key = 'My strong random secret key';
    // initialization vector
    $iv = md5(md5($key)); if( $action == 'encrypt' ) {
        $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv); $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv); $output = rtrim($output, "");
        
        }
        return $output; }
        
        $plain_txt = "This is my plain text";
        $encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
        
        
        echo "Encrypted Text = $encrypted_txt\n";
        echo "<br />";
        $decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
        echo "Decrypted Text = $decrypted_txt\n";

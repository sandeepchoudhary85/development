<?php






   $data_string_100='{
    "display_name": "sandeep Furniture",
    "first_name": "Benjamin",
    "last_name": "George",
    "email": "benjamin.george@bowmanfurniture.com",
    "company_name": "Bowman Furniture",
    "phone": "23467278",
    "mobile": "938237475",
    "website": "www.bowmanfurniture.com",
    "billing_address": {
        "street": "Harrington Bay Street",
        "city": "Salt Lake City",
        "state": "CA",
        "zip": "92612",
        "country": "U.S.A",
        "fax": "4527389"
    },
    "shipping_address": {
        "street": "Micheal Street",
        "city": "Austin",
        "state": "Texas",
        "zip": "75211",
        "country": "U.S.A",
        "fax": "41237389"
    },
    "currency_code": "USD",
    "ach_supported": true,
    "notes": "Bowman Furniture",
    "custom_fields": [
        {
            "index": 1,
            "value": "129890"
        },
        {
            "index": 2,
            "value": "Premium"
        }
    ]
}';



// $data =array("display_name" => "Bowman Furniture", "first_name" => "Benjamin" , "last_name" =>"George", "email" =>"benjamin.george@bowmanfurniture.com");
// $data_string = json_encode($data);

$ch = curl_init('https://subscriptions.zoho.com/api/v1/customers');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string_100);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(

    'Content-Type: application/json;charset=UTF-8',
    'X-com-zoho-subscriptions-organizationid: 317017354',
    'Authorization: Zoho-authtoken af3716eae7adf403c387300fc7482e12',
    'Content-Length: ' . strlen($data_string_100))
);

$result = curl_exec($ch);

$r = json_decode($result);
echo "<pre>";
print_r($r);
//echo $r->message;

$customer_id = '"'. $r->customer->currency_id .'"';

// $customer_id =  '"277853000000047055"';
if(!empty($customer_id))
    {


   $add_newsubscription = '{
    "customer_id": '.$customer_id.' ,


    "exchange_rate": 40,
    "plan": {
        "plan_code": "160021",
        "name": "pluse",
        "price": 200,
        "quantity": 1,
        "billing_cycles": -1,
        "trial_days": 30,
        "tax_id": "192920123123",
        "setup_fee_tax_id": "10"
    },

    "custom_fields": [
        {
            "index": 1,
            "value": "Not Shipped"
        },
        {
            "index": 2,
            "value": "FedEx"
        }
    ]
}';




        $ch = curl_init('https://subscriptions.zoho.com/api/v1/subscriptions');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $add_newsubscription);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

    'Content-Type: application/json;charset=UTF-8',
    'X-com-zoho-subscriptions-organizationid: 317017354',
    'Authorization: Zoho-authtoken af3716eae7adf403c387300fc7482e12',
    'Content-Length: ' . strlen($add_newsubscription))
);

$result = curl_exec($ch);

echo $result;

    }




die();


// $data = array("name" => "Hagrid", "age" => "36");
// $data_string = json_encode($data);

// $ch = curl_init('http://api.local/rest/users');
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json',
//     'Content-Length: ' . strlen($data_string))
// );

// $result = curl_exec($ch);

//              header("Content-type: application/xml");
//               $token="1ad1bcfcd36f575f7816851d1d02d0c3";
//               $url = "https://crm.zoho.com/crm/private/xml/Leads/getRecords";
//               $param= "authtoken=".$token."&scope=crmapi";
//               $ch = curl_init();
//               curl_setopt($ch, CURLOPT_URL, $url);
//               curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//               curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//               curl_setopt($ch, CURLOPT_POST, 1);
//               curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
//               $result = curl_exec($ch);
//               curl_close($ch);
//               echo $result;
//               return $result;

// die;





// echo '

// https://crm.zoho.com/crm/private/xml/SalesOrders/insertRecords?authtoken=1ad1bcfcd36f575f7816851d1d02d0c3&scope=crmapi
// &newFormat=1
// &xmlData=<SalesOrders>

// <row no="1">
// <FL val="Subject">Zillium - SO</FL>
// <FL val="Due Date">2009-03-10</FL>
// <FL val="Sub Total">48000.0</FL>
// <FL val="Tax">0.0</FL>
// <FL val="Adjustment">0.0</FL>
// <FL val="Grand Total">48000.0</FL>
// <FL val="Billing Street">test</FL>
// <FL val="Shipping Street">test</FL>
// <FL val="Billing City">test</FL>
// <FL val="Shipping City">test</FL>
// <FL val="Billing State">test</FL>
// <FL val="Shipping State">test</FL>
// <FL val="Billing Code">223</FL>
// <FL val="Shipping Code">223</FL>
// <FL val="Billing Country">test</FL>
// <FL val="Shipping Country">test</FL>
// <FL val="Product Details">
// <product no="1">
// <FL val="Product Id">2000000017001</FL>
// <FL val="Unit Price">10.0</FL>
// <FL val="Quantity">1.0</FL>
// <FL val="Total">123.0</FL>
// <FL val="Discount">1.23</FL>
// <FL val="Total After Discount">121.77</FL>
// <FL val="List Price">123.0</FL>
// <FL val="Net Total">121.77</FL>
// </product>
// </FL>
// <FL val="Terms and Conditions">Test by Zoho</FL>
// <FL val="Description">Test By Zoho</FL>
// </row>
// </SalesOrders>
// ';


// die();

class zoho{

    // public function getAuth()
    // {
    //     $username = "sandeep.choudhary@kindlebit.com";
    //     $password = "admin@123";
    //     $param = "SCOPE=ZohoCRM/crmapi&EMAIL_ID=".$username."&PASSWORD=".$password;
    //     $ch = curl_init("https://accounts.zoho.com/apiauthtoken/nb/create");
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    //     $result = curl_exec($ch);
    //     /*This part of the code below will separate the Authtoken from the result.
    //     Remove this part if you just need only the result*/
    //     $anArray = explode("\n",$result);
    //     $authToken = explode("=",$anArray['2']);
    //     $cmp = strcmp($authToken['0'],"AUTHTOKEN");
    //     echo $anArray['2'].""; if ($cmp == 0)
    //     {
    //     echo "Created Authtoken is : ".$authToken['1'];
    //     return $authToken['1'];
    //     }
    //     curl_close($ch);
    // }



public function postData($auth, $fornavn,$efternavn, $email,$addr,$by,$postnr,$land,$kommentar)
    {
        $xml =
        '<?xml version="1.0" encoding="UTF-8"?>
        <SalesOrders>
<row no="1">
<FL val="Subject">Zillium - SO</FL>
<FL val="Due Date">2009-03-10</FL>
<FL val="Sub Total">48000.0</FL>
<FL val="Tax">0.0</FL>
<FL val="Adjustment">0.0</FL>
<FL val="Grand Total">48000.0</FL>
<FL val="Billing Street">test</FL>
<FL val="Shipping Street">test</FL>
<FL val="Billing City">test</FL>
<FL val="Shipping City">test</FL>
<FL val="Billing State">test</FL>
<FL val="Shipping State">test</FL>
<FL val="Billing Code">223</FL>
<FL val="Shipping Code">223</FL>
<FL val="Billing Country">test</FL>
<FL val="Shipping Country">test</FL>
<FL val="Product Details">
<product no="1">
<FL val="Product Id">277853000000046001</FL>
<FL val="Unit Price">10.0</FL>
<FL val="Quantity">1.0</FL>
<FL val="Total">123.0</FL>
<FL val="Discount">1.23</FL>
<FL val="Total After Discount">121.77</FL>
<FL val="List Price">123.0</FL>
<FL val="Net Total">121.77</FL>
</product>
</FL>
<FL val="Terms and Conditions">Test by Zoho</FL>
<FL val="Description">Test By Zoho</FL>
</row>
</SalesOrders>';

    $url ="https://crm.zoho.com/crm/private/xml/SalesOrders/insertRecords";
    $query="authtoken=".$auth."&scope=crmapi&newFormat=1&xmlData=".$xml;
    $ch = curl_init();
    /* set url to send post request */
    curl_setopt($ch, CURLOPT_URL, $url);
    /* allow redirects */
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    /* return a response into a variable */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    /* times out after 30s */
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    /* set POST method */
    curl_setopt($ch, CURLOPT_POST, 1);
    /* add POST fields parameters */
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.

    //Execute cUrl session
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;

    }
}


$zoho = new zoho();
    echo "testing....1111111<br />";
    $auth = '1ad1bcfcd36f575f7816851d1d02d0c3';
    echo " <pre>";
    echo $auth;
    $result = $zoho->postData($auth, 'Bob','test', 'lol@lol.dk','adresse','by','postr','Danmark','Some comment');
    print_r($result);

?>
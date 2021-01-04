add_filter( 'woocommerce_package_rates', 'custom_shipping_costs', 20, 2 );
function custom_shipping_costs( $rates, $package ) {
	//echo "<pre>";
	//$qtyofproduct = 0;
	$count = 0;
	foreach( $package['contents'] as $key => $cart_item ){
		
//print_r($package['contents'][$key]['quantity']);
	   foreach ($package['contents'][$key]['wapf'] as $key1 => $value) {
	   		
	   		foreach ($value['values'] as $key2 => $valuemain) {
	   			//echo str_replace(' ', '', $valuemain['label']) ."<br>";
	   			if(str_replace(' ', '', $valuemain['label']) === 'StabilizingBar'){
	   				//echo "yes......";
	   				$qtyofproduct+= $package['contents'][$key]['quantity'];
	   				$count += 1;
	   			}
	   		}

	   		//echo $cart_item_key['quantity'];
	   		//print_r($value);
	   }
  }

 // echo $qtyofproduct ."<br>";
 // echo $count ."<br>"; 
 // echo  $qtyofproduct * 8 ; die;
    // New shipping cost (can be calculated)
    $new_cost =  $qtyofproduct * 8;
    $tax_rate = 0;
    
//echo "<pre>"; print_r($rates); die;
    foreach( $rates as $rate_key => $rate ){
        // Excluding free shipping methods
        if( $rate->method_id != 'free_shipping'){

            // Set rate cost
            //$rates[$rate_key]->cost = $new_cost;
            $rates[$rate_key]->cost = $rates[$rate_key]->cost + $new_cost;

            // Set taxes rate cost (if enabled)
            $taxes = array();
            foreach ($rates[$rate_key]->taxes as $key => $tax){
                if( $rates[$rate_key]->taxes[$key] > 0 )
                    $taxes[$key] = $new_cost * $tax_rate;
            }
            $rates[$rate_key]->taxes = $taxes;

        }
    }
    return $rates;
}

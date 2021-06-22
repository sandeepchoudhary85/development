
              $total = array_sum($ratting);
              $avg = $total / 5;//count($ratting);
            //  printf('The average is %.2f', $avg);
              $result = ($avg > 5) ? 5 : $avg;
              
$checkfload = round($result ,1);
			  $getfirstindex = explode('.' , $checkfload);
			  $getfirstindexvalue =  $getfirstindex['0'];
			  $checkarraycount = count($getfirstindex);
              $counter = 5;
              $stars = '';
              for($i=0; $i<5; $i++){
                    
                        if($i < $result)
                       { 
                          //$stars .=  '<span style="color: #1C3C3E;" class="fa fa-star checked"></span>';
                          if($checkarraycount >= 2 ){
							  if($getfirstindexvalue == $i){
								  $stars .=  '<span style="color: #1C3C3E;" class="fa fa-star-half-o"></span>';
							  }
							  else{
								  $stars .=  '<span style="color: #1C3C3E;" class="fa fa-star"></span>';
							  }
							  
						  }
							else {
						   $stars .=  '<span style="color: #1C3C3E;" class="fa fa-star"></span>';
							}
                       }
                       else{
                        $stars .=  '<span class="fa fa-star" style="color: beige;"></span>';
                       }
              
                       $counter++;
              }
               echo $stars;

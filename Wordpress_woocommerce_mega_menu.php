 $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
        // 'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
 $all_categories = get_categories( $args );
 //echo "<pre>"; print_r($all_categories);
 foreach ($all_categories as $cat) {
    if($cat->category_parent == 0) {
        $category_id = $cat->term_id;  
        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );    
         $image = wp_get_attachment_url( $thumbnail_id );  
       // echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>'; 
        array_push($parent, array("title" => $cat->name, "url" => get_term_link($cat->slug, 'product_cat'), "child" => array() ,"image" => $image));

        ?>
<?php
        $args2 = array(
                'taxonomy'     => $taxonomy,
                'child_of'     => 0,
                'parent'       => $category_id,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
        );
        $sub_cats = get_categories( $args2 );
        if($sub_cats) {
            foreach($sub_cats as $sub_category) {
              $category_id_3 = $sub_category->term_id; 
              array_push($parent[count($parent) - 1]["child"], array("title" => $sub_category->name, "url" => $url,'subchild' => $category_id_3 ));
                //echo  $sub_category->name ;

              $category_id_3 = $sub_category->term_id; 

              $args3 = array(
                'taxonomy'     => $taxonomy,
                'child_of'     => 0,
                'parent'       => $category_id_3,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
        );
        $sub_catsl3 = get_categories( $args3 );
        //echo "<pre>"; print_r($sub_catsl3);
        if($sub_catsl3) {
            foreach($sub_catsl3 as $sub_categoryl3) {

              $level3child[$category_id_3][] = array("title" => $sub_categoryl3->name, "url" => get_term_link($sub_categoryl3->slug, 'product_cat'));
             // array_push($parent[count($parent) - 1]["child"], array("title" => $sub_category->name, "url" => $url,'subchild' => $level2 ));
                //echo  $sub_category->name ;
            }   
        }





            }   
        }


    }       
}


<ul class="nav megamenuul">
            <?php
            //echo "<pre>"; print_r($level3child);
            //echo "<pre>"; print_r($parent);
             foreach ($level3child as $key => $level3childvalue) {
               //echo $key;
             }

              foreach ($parent as $key => $value)
              {
                if(empty($value["child"]))
                {  
                  $mobilemenu .= '<select><option>'.$value["title"].'</option></select>';

                  echo "<li class='megalistyle'><a href='" . $value["url"] . "'>" . $value["title"] . "</a></li>";

                }
                else
                { $getimage = $value["image"];
                  echo '<li class="dropdown megalistyle '.$value["title"].'"><a href="' . $value["url"] . '" class="dropdown-toggle" data-toggle="dropdown">' . $value["title"] . ' <b class="caret"></b></a><ul class="dropdown-menu mega-menu">';

                   $mobilemenu .= '<select><option>'.$value["title"].'</option>';

                  foreach ($value["child"] as $key => $values)
                  { 
                    $mobilemenu .= '<option>'.$values["title"].'</option>';
                    
                    if($values["title"]){
                     echo  '<li class="mega-menu-column">';
                     echo  '<ul class="level3menu">';
                     echo  '<li class="nav-header">' . $values["title"] . '</li>';    

                     
                      //echo "==>".$values['subchild'];
                  foreach ($level3child as $key =>  $valuesubchild){
                        if($key == $values['subchild'])
                            {
                               foreach ($level3child[$key] as $key => $value3l) {

                                $mobilemenu .= '<option>'.$value3l["title"].'</option>';
                                  echo "<li><a href='" . $value3l["url"] . "'>" . $value3l["title"] . "</a></li>";
                               }

                            }

                          
                        } 
                                      

                        echo "</ul></li>";
                      }

                    
                  }
                  $mobilemenu .= '</select>';

                  echo '<li class="megamenuimagesection"><img  src="'.$getimage.'" ></li></ul></li>';
                }
                
              }
              
            ?>
</ul>
<div style="display: none;" class="mobilemenumegamenu"><?php echo $mobilemenu; ?></div>
<script>
// Dropdown Menu Fade    
jQuery(document).ready(function(){
    jQuery(".dropdown").hover(
        function() { jQuery('.dropdown-menu', this).fadeIn("fast");
        },
        function() { jQuery('.dropdown-menu', this).fadeOut("fast");
    });
});
</script>

<style>
/* page style */








/* MEGA MENU STYLE
********************************/ 
.dropdown.megalistyle.Dump {
  display: none !important;
}
.nav.megamenuul {
  margin-bottom: 2%;
}
.nav.megamenuul .megalistyle{
  margin: 1px -1px;
display: inline-block;
font-weight: 500;
padding: 10px 16px;
background: #dadadb;
font-size: 1.125em;
margin-left: 3px;

}

.nav.megamenuul .megalistyle a{
text-decoration: none;
color: black;
}

.mega-menu {
  padding: 10px 0px ! important;
  width: 540px;
  border-radius: 0;
  margin-top: 0px;
}

.mega-menu li {
  display: inline-block;
  float: left;
  font-size: 0.94rem;
  padding: 3px 0px;
}

.mega-menu li.mega-menu-column {
  margin-right: 20px;
  width: 150px;
}

.mega-menu .nav-header {
  padding: 0 !important;
  margin-bottom: 10px;
  display: inline-block;
  width: 100%;
  border-bottom: 1px solid #ddd;
}

.mega-menu img { padding-bottom: 10px; }

/* Disable Toggle style
********************************/  

/* Dropdown Toggle on style */



.navbar .nav li.dropdown.open > .dropdown-toggle,
.navbar .nav li.dropdown.active > .dropdown-toggle,
.navbar .nav li.dropdown.open.active > .dropdown-toggle {
  background: inherit; /* Set to inherit when using mouse hover to open dropdown */
  color: inherit;
}

/* Toggle off style */



.navbar .nav li.dropdown.open.active > .dropdown-toggle,
 .navbar .nav > li.dropdown > a:focus {
  background: inherit;
  color: inherit;
}

/* Toggle hover */



.navbar .nav li.dropdown > .dropdown-toggle:hover,
 .navbar .nav li.dropdown.open > .dropdown-toggle:hover { background-color: #DDDDDD; }

/* Toggle caret*/



.navbar .nav li.dropdown > .dropdown-toggle .caret { border-bottom-color:;
 border-top-color:;
}

/* Toggle caret hover */



.navbar .nav li.dropdown > a:hover .caret,
 .navbar .nav li.dropdown > a:focus .caret {
  border-bottom-color: #333;
  border-top-color: #333;
}

/* Toggle caret active */



.navbar .nav li.dropdown.open > .dropdown-toggle .caret,
 .navbar .nav li.dropdown.active > .dropdown-toggle .caret,
 .navbar .nav li.dropdown.open.active > .dropdown-toggle .caret {
  border-bottom-color: #333;
  border-top-color: #333;
}

/* Hover style
********************************/ 



.navbar .nav > li > a,
.mega-menu a {
  -webkit-transition: all 200ms ease;
  -moz-transition: all 200ms ease;
  -ms-transition: all 200ms ease;
  -o-transition: all 200ms ease;
  transition: all 200ms ease;
  /* -webkit-transform: translate3d(0, 0, 0); Webkit Hardware Acceleration*/ 
  -webkit-backface-visibility: hidden; /* Safari Flicker Fix #2 */
  -webkit-transform: translateZ(0);
}
.midnav .nav .dropdown {
  padding: 10px 23px;
}
</style>

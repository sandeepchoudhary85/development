/******* Call page data from page id ******/

 $the_query = new WP_Query( 'page_id=2' );

 while ($the_query -> have_posts()) : $the_query -> the_post();

                    the_title();
                    the_post_thumbnail();
                    the_id();

      endwhile;

/******* Call page data from id ******/
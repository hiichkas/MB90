<?php
/* 
Template Name: SelfAssessment
*/
?>

<?php get_header(); ?>

<?php 

    include(plugin_dir_path(dirname(__FILE__)) . "../plugins/mb90-user-data/inc/Classes/UtilitiesClass.php"); 
    
    $utilObj = new UtilitiesClass();
    
    $uPath = $utilObj->getRootPath();
    
    echo "uPath = [" . $uPath . "]";
    
?>

<?php if(have_posts()):while(have_posts()):the_post(); ?>


<main>
	<div class="events-wrap">
		<div class="container">
		  <div class="row">
		    <ul class="events-list">
			    <?php 
			    $args =array(
	                'post_type' => 'product',
	                'posts_per_page' =>10,
			'order_by'=>'menu_order',
			'order'=>'DESC'                  
	            );
	              
	            $loop = new WP_Query( $args );
	            if($loop->have_posts()):while ( $loop->have_posts() ) : $loop->the_post();                                        
	            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'medium' );

			    ?>
			    <li class="col-sm-4 col-xs-6">
	                <div class="event">
	                 <img src="<?php echo $image[0];?>" alt="" class="img-responsive">
	                 <?php 
				        global $product;
				        if (!$product->is_in_stock()): 
				      ?>
				        <div class="book-strip">
				          <div class="strip-band">fully Booked</div>
				        </div>
				     <?php endif; ?>
	                  <div class="event-content">
	                    <div class="border">
	                    <div class="event-date"><?php echo get_secondary_title(); ?></div>
	                    <h3><?php the_title();?></h3>
	                    <?php $field_value1 = get_post_meta( $post->ID, '_teacher', false );  ?>
	                    <small><?php echo $field_value1 [0];?></small>
	                    <a href="<?php the_permalink();?>">CLICK HERE FOR DETAILS </a>
	                  </div>
	                  </div>
	                </div> 
	            </li>

			     
			    <?php 
			    endwhile;
			    endif; 
			    ?>


		    </ul>  
		  </div>
		</div>
	</div>
</main>


<?php endwhile;endif;?>

<?php get_footer(); ?>

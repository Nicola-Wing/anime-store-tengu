<div class="slider-container">
    <div class="slider">
		<?php
		$arg        = array(
			'post_type' => 'slider',
			'order'     => 'DES'
		);
		$slider     = new WP_Query( $arg );
		$j          = 0;		$post_count = wp_count_posts( 'slider' )->publish;
		?>
        <!-- Carousel -->
        <div class="slides">

            <!-- Wrapper for slides -->
			<?php while ( $slider->have_posts() ) : $slider->the_post(); ?>
                <div id="slides__<?php echo $j + 1; ?>" class="slide"
                     style="background-image: url('<?php if ( has_post_thumbnail() ):
					     the_post_thumbnail_url( 'slider' ); endif; ?>'); background-size: 100% 100%;">

                    <!-- Slider -->
                    <div class="slide__text">
                        <h2><span><?php the_title() ?></span></h2>
                        <p>
                            <a href="<?php echo get_post_meta(
								get_the_ID(),
								'_slider_link_value_key',
								true
							); ?>"><span><?php the_excerpt(); ?></span></a>
                        </p>
                    </div>

                    <a class="slide__prev" href="#slides__<?php echo $j; ?>" title="Next"></a>
                    <a class="slide__next" href="#slides__<?php echo $j + 2; ?>" title="Next"></a>
                </div>
				<?php $j ++; endwhile;
			wp_reset_query(); ?>

        </div><!-- /carousel -->
        <div class="slider__nav">
			<?php
			$k = 1;
			while ( $k <= $j ) : ?>
                <a class="slider__navlink" href="#slides__<?php echo $k; ?>"></a>
				<?php $k ++;
			endwhile; ?>
        </div>
    </div>
</div>
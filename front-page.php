<?php 
/**
 * The front page template file
 * 
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @since 1.0
 * @version 1.0
 */
// Get options
$mts_options = get_option(MTS_THEME_NAME);

// Featured Section 1 settings ( slider is here) --------------------------------
$slider_enabled = ( $mts_options['mts_featured_slider'] === '1' ) ? true : false;
if ( empty($mts_options['mts_featured_slider_cat']) || !is_array($mts_options['mts_featured_slider_cat']) ) {
    $mts_options['mts_featured_slider_cat'] = array('0');
}
$slider_cat = implode(",", $mts_options['mts_featured_slider_cat']);

// Featured Section settings --------------------------------------------------
$f2_title = $mts_options['mts_featured_section_2_title'];
if ( empty($mts_options['mts_featured_section_2_cat']) || !is_array($mts_options['mts_featured_section_2_cat']) ) {
    $mts_options['mts_featured_section_2_cat'] = array('0');
}
$bh_query = get_terms(
	array(
		'taxonomy' => 'bh_category',
    	'hide_empty' => false,
	)
);

$f2_cat= implode(",", $mts_options['mts_featured_section_2_cat']);
// Featured Section 3 settings --------------------------------------------------
get_header(); ?>
<div id="page">
    <div class="article">
        <?php if ( $slider_enabled ) {?>
            <section id="featured-section-1" class="featured-section featured-section-1-1 clearfix">
                <div class="slider-container">
                    <div class="primary-slider-container clearfix loading">
                        <div id="slider" class="primary-slider owl-carousel">
                            <?php
                            $slider_full = 'best-featuredfull';
                            if ( empty( $mts_options['mts_custom_slider'] ) ) { 
                                $my_query = new WP_Query('cat='.$slider_cat.'&posts_per_page='.$mts_options['mts_featured_slider_num']);
                                while ( $my_query->have_posts() ) : $my_query->the_post();
                                ?>
                                <div>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail($slider_full,array('title' => '')); ?>
                                        <div class="slider-caption">
                                            <?php if(isset($mts_options['mts_home_headline_meta_info']['enabled']) && $mts_options['mts_home_headline_meta_info']['enabled']){ ?>
                                                <div class="sliderdate">
                                                    <?php if(isset($mts_options['mts_home_headline_meta_info']['enabled']['date']) == '1') { ?>
                                                        <span class="thetime updated"><?php the_time( get_option( 'date_format' ) ); ?></span>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <h2 class="slide-title"><?php the_title(); ?></h2>
                                        </div>
                                        <div class="post-day"><?php if (function_exists('wp_review_show_total')) wp_review_show_total(true, 'review-total-only'); ?></div>
                                    </a>
                                </div>
                                <?php endwhile; wp_reset_postdata();
                            } else { ?>
                                <?php foreach( $mts_options['mts_custom_slider'] as $slide ) : ?>
                                    <div>
                                        <a href="<?php echo esc_url( $slide['mts_custom_slider_link'] ); ?>">
                                            <?php echo wp_get_attachment_image( $slide['mts_custom_slider_image'], $slider_full, false, array('title' => '') ); ?>
                                            <div class="slider-caption">
                                                <div class="sliderdate"><?php echo esc_html( $slide['mts_custom_slider_title'] ); ?></div>
                                                <h2 class="slide-title"><?php echo esc_html( $slide['mts_custom_slider_text'] ); ?></h2>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div><!-- slider-container -->
            </section>
        <?php } ?>
        <?php if( $mts_options['mts_featured_section_2'] === '1' && is_home() && !is_paged() ) {// featured section 2 ?>
            <section id="featured-section-3" class="featured-section clearfix">
                <?php if (!empty($f2_title)) { ?><h4 class="featured-section-title"><?php echo $f2_title;?></h4><?php } ?>
                <?php
                $f2_query = new WP_Query('cat='.$f2_cat.'&posts_per_page=4');
                
                $f2_count = 1; if ($f2_query->have_posts()) : while ($f2_query->have_posts()) : $f2_query->the_post();
                
                $f2_loop_params = best_mixed_layout_params( 1, 2, $f2_count );// see functions.php

                $f2_clear_class          = $f2_loop_params['clear_class'];
                $f2_type_class           = $f2_loop_params['box_class'];
                $f2_loop_thumb           = $f2_loop_params['thumb'];
                $f2_show_excerpt         = $f2_loop_params['show_excerpt'];
                $f2_show_author          = $f2_loop_params['show_author'];
                $begin_f2_extra_wrappers = $f2_loop_params['open_wrappers'];
                $end_f2_extra_wrappers   = $f2_loop_params['close_wrappers'];
                ?>
                <article class="post-box latestPost mixed <?php echo $f2_type_class;?> <?php echo $f2_clear_class;?>">
                    <?php echo $begin_f2_extra_wrappers; ?>
                    <div class="post-img">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="nofollow">
                            <?php the_post_thumbnail($f2_loop_thumb,array('title' => '')); ?>
                        </a>
                    </div>
                    <div class="post-data">
                        <div class="post-data-container">
                            <header>
                                <h2 class="title post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                                <?php mts_the_postinfo(); ?>
                            </header>
                            <?php if ($f2_show_excerpt) : ?>
                            <div class="post-excerpt">
                                <?php echo mts_excerpt(14); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php echo $end_f2_extra_wrappers; ?>
                </article><!--.post-box-->
                <?php $f2_count++; endwhile;
                endif; wp_reset_postdata();
                ?>
            </section><!--#featured-section-3-->
        <?php } ?>
        <h2 class="bh-sp"><?php echo esc_html_e('Sản phẩm','best');?></h2>
        <div id="content_box" class = "columns-3 bh-isotope">
        	
            <?php
            if(!empty($bh_query)):
            	wp_enqueue_script('isotope');
            	foreach ($bh_query as $terms => $value) {?>
            		<div class="bh-terms">
            			<div class="bh-terms-item">
	            			<h4 class="bh-term-title">
	            				<a class="bh-title" href="<?php echo get_term_link($value->term_id);?>"><?php echo esc_html($value->name);?></a>

	            				<?php if(has_term_thumbnail($value->term_id)):?>
	            					<a class="bh-thumb" href="<?php echo get_term_link($value->term_id);?>">
	            						<?php echo get_term_thumbnail( $value->term_id);?>
	            					</a>
	            				<?php endif;?>
	            			</h4>
	            			<ul class="bh-content">
	            				<?php
	            				
	            					$posts_arrays = get_posts(
									    array(
									        'posts_per_page' => -1,
									        'post_type' => 'baohiem',
									        'tax_query' => array(
									            array(
									                'taxonomy' => 'bh_category',
									                'field' => 'term_id',
									                'terms' => array($value->term_id),
									            )
									        )
									    )
									);
								if(!empty($posts_arrays) && count($posts_arrays) > 0):
									foreach($posts_arrays as $posts_array => $value):
	            				?>
								<li class="bh-item"><a href="<?php echo esc_url(get_permalink($value->ID));?>"><?php echo esc_html($value->post_title);?></a></li>
							<?php endforeach; endif;?>
	            			</ul>
						</div>
            		</div>
            <?php 
        		}
            endif;
            ?>
        </div>
        <div style="clear:both;"></div>
    </div>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * The main template file.
 *
 * Used to display the homepage when home.php doesn't exist.
 */
?>
<?php
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
$f2_cat= implode(",", $mts_options['mts_featured_section_2_cat']);
// Featured Section 3 settings --------------------------------------------------
get_header(); ?>
<div id="page">
    <div class="article">
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
        <div id="content_box">
            <?php $latest_posts_used = false;
                if ( !empty( $mts_options['mts_featured_categories'] ) ) {
                    foreach ( $mts_options['mts_featured_categories'] as $section ) {
                        $category_id = $section['mts_featured_category'];
                        $featured_category_layout = $section['mts_featured_category_layout'];
                        $posts_num = $section['mts_featured_category_postsnum'];
                        if ( $category_id === 'latest' && ! $latest_posts_used ) {
                            $latest_posts_used = true;
                            $fc_section_class  = ( in_array( $featured_category_layout, array( 'vertical', 'mixed' ) ) ) ? '' : ' '.$featured_category_layout;
                            ?>
                            <section id="latest-posts" class="clearfix<?php echo $fc_section_class ?><?php //echo $fc_section_no_gap ?>">
                                <h4 class="featured-section-title"><?php _e( "Latest Articles", "best" ); ?></h4>
                                <?php $j = 1; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                <?php best_the_homepage_article( $featured_category_layout, $j, true );?>
                                <?php $j++; endwhile; endif; ?>
                                <!--Start Pagination-->
                                <?php if (isset($mts_options['mts_pagenavigation_type']) && $mts_options['mts_pagenavigation_type'] == '1' ) { ?>
                                    <?php $additional_loop = 0; mts_pagination($additional_loop['max_num_pages']); ?>
                                <?php } else { ?>
                                    <div class="pagination pagination-previous-next">
                                        <ul>
                                            <li class="nav-previous"><?php next_posts_link( '<i class="fa fa-chevron-left"></i> '. __( 'Previous', 'best' ) ); ?></li>
                                            <li class="nav-next"><?php previous_posts_link( __( 'Next', 'best' ).' <i class="fa fa-chevron-right"></i>' ); ?></li>
                                        </ul>
                                    </div>
                                <?php } ?>
                                <!--End Pagination-->
                            </section><!--#latest-posts-->
                        <?php } elseif ( $category_id !== 'latest' && !is_paged() ) {

                            $fc_section_class  = ( in_array( $featured_category_layout, array( 'vertical', 'mixed' ) ) ) ? '' : ' '.$featured_category_layout;

                            ?>
                            <section class="featured-section clearfix<?php echo $fc_section_class ?>">
                                <h4 class="featured-section-title"><a href="<?php echo esc_url( get_category_link($category_id) ); ?>" title="<?php echo esc_attr( get_cat_name($category_id) ); ?>"><?php echo get_cat_name($category_id); ?></a></h4>
                                <?php $cat_query = new WP_Query('cat='.$category_id.'&posts_per_page='.$posts_num); ?>
                                <?php $j = 1; if ($cat_query->have_posts()) : while ($cat_query->have_posts()) : $cat_query->the_post(); ?>
                                <?php best_the_homepage_article( $featured_category_layout, $j );?>
                                <?php $j++; endwhile; endif; wp_reset_postdata();?>
                            </section>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
        </div>
    </div>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>
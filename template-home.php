<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Homepage
 *
 * This template is a full-width version of the page.php template file. It removes the sidebar area.
 *
 *
 * @package WooFramework
 * @subpackage Template
 */
    get_header();
    global $woo_options;

    $settings = array(
                'homepage_enable_promotion' => 'true',
                );

    $settings = woo_get_dynamic_values( $settings );    

?>

    <div id="content" class="page col-full">

        <div class="section-wrapper">

    	<?php woo_main_before(); ?>

		<section id="main" class="col-left">

        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>
            <article <?php post_class(); ?>>

                <section class="entry">
                	<?php the_content(); ?>

                    <?php woothemes_features( array( 'limit' => 3, 'category' => 57, 'per_row' => 3  ) ); ?>

					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
               	</section><!-- /.entry -->

				<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>

            </article><!-- /.post -->

            <?php
            	// Determine wether or not to display comments here, based on "Theme Options".
            	if ( isset( $woo_options['woo_comments'] ) && in_array( $woo_options['woo_comments'], array( 'page', 'both' ) ) ) {
            		comments_template();
            	}

				} // End WHILE Loop
			} else {
		?>
			<article <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
            </article><!-- /.post -->
        <?php } // End IF Statement ?>

		</section><!-- /#main -->



		<?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

        </div><!-- /.section-wrapper -->

    </div><!-- /#content -->

                    <?php
                        if ( 'true' == $settings['homepage_enable_columns'] ) {
                            get_template_part( 'includes/homepage/homepage-columns' );
                        }               
                    ?>

                    <?php
                        if ( 'true' == $settings['homepage_enable_promotion'] ) {
                            get_template_part( 'includes/homepage/promotion' );
                        }
                    ?>   
<?php get_footer(); ?>
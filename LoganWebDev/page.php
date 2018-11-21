<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package loganwebdev
 */

get_header();
?>		



	<div id="primary clearfix" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post( );?>

				<h2><?php the_title( ); ?></h2>
				<?php the_content( );
			endwhile; // End of the loop.
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

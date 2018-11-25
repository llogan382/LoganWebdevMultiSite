<?php
/**
 * Template part for displaying the singular post.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     @@pkg.name
 * @link        @@pkg.theme_uri
 * @author      @@pkg.author
 * @copyright   @@pkg.copyright
 * @license     @@pkg.license
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="post-wrapper">

	<header class="entry-header top-spacer bottom-spacer">

		<?php
		if ( is_single() ) {
			the_title( '<h1 id="blog_archiveheader" class="entry-title h1">', '</h1>' );
		} else {
			the_title( '<h2 id="blog_archiveheader" class="entry-title h1"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>

		<?php tabor_posted_on(); ?>

	</header>

	<?php tabor_post_media( $post->ID ); ?>

	<?php do_action( 'tabor_before_post_entry_content' ); ?>

	<div id="blogpost_fontsize" class="entry-content">

		<?php
		the_content();

		tabor_customize_more_tag();

		wp_link_pages(
			array(
				'before'      => '<div class="page-links">' . __( 'Pages:', '@@textdomain' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);
		?>

	</div>

	<?php do_action( 'tabor_after_post_entry_content' ); ?>

	<?php if ( is_single() ) { ?>

		<footer class="entry-footer flex justify-between">

			<?php tabor_comments_button(); ?>

			<div class="entry-footer__taxonomy justify-end self-center items-center">

				<?php tabor_categories(); ?>

				<?php tabor_tags(); ?>

			</div>

		</footer>

	<?php } ?>

</div>

<?php
// Sidebar widget area.
if ( is_single() && ! is_front_page() && is_active_sidebar( 'sidebar-3' ) ) {
	?>

	<aside class="widget-area widget-area--sidebar top-spacer">

		<?php dynamic_sidebar( 'sidebar-3' ); ?>
	</aside>

<?php } ?>

<nav class="post-navigation">
	<?php previous_post_link(); ?> <?php next_post_link(); ?>
</nav>

</article><!-- #post-## -->

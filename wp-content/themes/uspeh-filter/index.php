<?php
/**
 * The main template file.
 *
 * @package Uspeh_Filter
 */

get_header();
?>

	<div class="container section">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
					</header>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Няма намерени публикации.', 'uspeh-filter' ); ?></p>
		<?php endif; ?>
	</div>

<?php
get_footer();

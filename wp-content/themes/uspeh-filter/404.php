<?php get_header(); ?>

<section class="section" style="text-align: center; min-height: 50vh; display: flex; align-items: center;">
    <div class="container">
        <h1>404</h1>
        <p style="font-size: 1.25rem; color: var(--color-text-light); margin: 1rem 0 2rem;">
            <?php esc_html_e('Страницата, която търсите, не е намерена.', 'uspeh-filter'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary"><?php esc_html_e('Към началната страница', 'uspeh-filter'); ?></a>
    </div>
</section>

<?php get_footer(); ?>

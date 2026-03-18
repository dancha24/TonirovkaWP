<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="main">
    <section class="container" style="padding: 40px 10px;">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </section>
</main>
<?php
get_footer();

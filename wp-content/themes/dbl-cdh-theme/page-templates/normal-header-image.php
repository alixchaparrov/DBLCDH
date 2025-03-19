<?php

/**
 * Template Name: Normal - mit Kopfbild
 *
 * @package STW_Duelmen
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container-xxl container-fluid">
        <div class="row">
            <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>

            <?php
            while (have_posts()) :
                the_post();

                get_template_part('template-parts/content', 'normal-header-image');

            endwhile; // End of the loop.
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

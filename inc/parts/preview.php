<article <?php post_class('preview do-spot spot-fade-up a-del-200 preview-' . get_post_type()); ?> id="post-<?php the_ID(); ?>">

    <?php

    do_action('mcgillmed_theme_preview_start');

    $fallback_image = mcgillmed_theme_get_fallback_image();

    if ((has_post_thumbnail() && !post_password_required()) || $fallback_image) :
    ?>

        <figure class="preview-media">
            <a href="<?php the_permalink(); ?>" class="preview-media-link">
                <?php
                if (has_post_thumbnail() && !post_password_required()) {
                    the_post_thumbnail('mcgillmed_theme_preview_image');
                } else {
                    echo $fallback_image;
                }

                if (is_sticky()) {
                    echo '<div class="sticky-note">' . esc_html__('Featured', 'mcgillmed_theme') . '</div>';
                }
                ?>
            </a><!-- .preview-media-link -->
        </figure><!-- .preview-media -->

    <?php
    endif;

    if (get_the_title() || has_action('mcgillmed_theme_preview_header_start') || has_action('mcgillmed_theme_preview_header_end')) :
    ?>

        <header class="preview-header">
            <?php
            do_action('mcgillmed_theme_preview_header_start');

            the_title('<h2 class="preview-title h4"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>');

            do_action('mcgillmed_theme_preview_header_end');
            ?>
        </header><!-- .preview-header -->

    <?php
    endif;

    /*
	 * @hooked mcgillmed_theme_maybe_output_post_meta - 10
	 */
    do_action('mcgillmed_theme_preview_end');

    ?>

</article><!-- .preview -->
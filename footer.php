<?php

// Don't output the site footer on the Blank Canvas page template.
// The filter can be used to enable the blank canvas in different circumstances.
$blank_canvas                 = apply_filters('mcgillmed_theme_blank_canvas', is_page_template(array('page-templates/template-blank-canvas.php')));
$blank_canvas_with_aside     = apply_filters('mcgillmed_theme_blank_canvas_with_aside', is_page_template(array('page-templates/template-blank-canvas-with-aside.php')));

// Output the site footer if we're not doing a blank canvas.
if (!($blank_canvas || $blank_canvas_with_aside)) :
?>

<footer id="site-footer">

    <?php
        /* Code for logo widget area */
        if (is_active_sidebar('logo-footer-widget-area')) : ?>

        <aside class="fatfooter section-inner i-a a-fade-up a-del-300" role="complementary">
            <div class="widget-area">
                <?php dynamic_sidebar('logo-footer-widget-area'); ?>
            </div><!-- .widget-area -->
        </aside><!-- #fatfooter section-inner i-a a-fade-up a-del-300 -->

    <?php endif; ?>

    <?php
        /* The footer widget area is triggered if any of the areas
     * have widgets. So let's check that first.
     *
     * If none of the sidebars have widgets, then let's bail early.
     */

        if (
            !is_active_sidebar('first-footer-widget-area')
            && !is_active_sidebar('second-footer-widget-area')
            && !is_active_sidebar('third-footer-widget-area')
            && !is_active_sidebar('fourth-footer-widget-area')
        );

        if (
            is_active_sidebar('first-footer-widget-area')
            && is_active_sidebar('second-footer-widget-area')
            && is_active_sidebar('third-footer-widget-area')
            && is_active_sidebar('fourth-footer-widget-area')
        ) : ?>
    <aside class="fatfooter section-inner i-a a-fade-up a-del-300" role="complementary">
        <div class="first quarter left widget-area">
            <?php dynamic_sidebar('first-footer-widget-area'); ?>
        </div><!-- .first .widget-area -->

        <div class="second quarter widget-area">
            <?php dynamic_sidebar('second-footer-widget-area'); ?>
        </div><!-- .second .widget-area -->

        <div class="third quarter widget-area">
            <?php dynamic_sidebar('third-footer-widget-area'); ?>
        </div><!-- .third .widget-area -->

        <div class="fourth quarter right widget-area">
            <?php dynamic_sidebar('fourth-footer-widget-area'); ?>
        </div><!-- .fourth .widget-area -->
    </aside><!-- #fatfooter section-inner i-a a-fade-up a-del-300 -->

    <?php
        elseif (
            is_active_sidebar('first-footer-widget-area')
            && is_active_sidebar('second-footer-widget-area')
            && is_active_sidebar('third-footer-widget-area')
            && !is_active_sidebar('fourth-footer-widget-area')
        ) : ?>
    <aside class="fatfooter section-inner i-a a-fade-up a-del-300" role="complementary">
        <div class="first one-third left widget-area">
            <?php dynamic_sidebar('first-footer-widget-area'); ?>
        </div><!-- .first .widget-area -->

        <div class="second one-third widget-area">
            <?php dynamic_sidebar('second-footer-widget-area'); ?>
        </div><!-- .second .widget-area -->

        <div class="third one-third right widget-area">
            <?php dynamic_sidebar('third-footer-widget-area'); ?>
        </div><!-- .third .widget-area -->

    </aside><!-- #fatfooter section-inner i-a a-fade-up a-del-300 -->

    <?php
        elseif (
            is_active_sidebar('first-footer-widget-area')
            && is_active_sidebar('second-footer-widget-area')
            && !is_active_sidebar('third-footer-widget-area')
            && !is_active_sidebar('fourth-footer-widget-area')
        ) : ?>
    <aside class="fatfooter section-inner i-a a-fade-up a-del-300" role="complementary">
        <div class="first half left widget-area">
            <?php dynamic_sidebar('first-footer-widget-area'); ?>
        </div><!-- .first .widget-area -->

        <div class="second half right widget-area">
            <?php dynamic_sidebar('second-footer-widget-area'); ?>
        </div><!-- .second .widget-area -->

    </aside><!-- #fatfooter section-inner i-a a-fade-up a-del-300 -->

    <?php
        elseif (
            is_active_sidebar('first-footer-widget-area')
            && !is_active_sidebar('second-footer-widget-area')
            && !is_active_sidebar('third-footer-widget-area')
            && !is_active_sidebar('fourth-footer-widget-area')
        ) :
        ?>
    <aside class="fatfooter section-inner i-a a-fade-up a-del-300" role="complementary">
        <div class="first full-width widget-area">
            <?php dynamic_sidebar('first-footer-widget-area'); ?>
        </div><!-- .first .widget-area -->

    </aside><!-- #fatfooter section-inner i-a a-fade-up a-del-300 -->

    <?php
        //end of all sidebar checks.
        endif; ?>

    <?php
        do_action('mcgillmed_theme_footer_start');
        ?>

    <div class="footer-inner section-inner">

        <?php
            do_action('mcgillmed_theme_footer_inner_start');
            ?>

        <div class="footer-credits">

            <p class="footer-copyright">&copy; <?php echo esc_html(date_i18n(esc_html__('Y', 'mcgillmed_theme'))); ?> <a
                    href="<?php echo esc_url(home_url()); ?>" rel="home"><?php echo bloginfo('name'); ?></a></p>

            <p class="theme-credits color-secondary">
                <?php
                    // Translators: $s = name of the theme developer.
                    //printf( esc_html_x( 'Theme by %s', 'Translators: $s = name of the theme developer', 'mcgillmed_theme' ), '<a href="https://www.andersnoren.se">' . esc_html__( 'Anders Nor&eacute;n', 'mcgillmed_theme' ) . '</a>' );
                    printf(
                        esc_html_x('Proudly designed by %s', 'mcgillmed_theme'),
                        '<a href="https://ilang.ca" target="_blank">'
                            . esc_html__('Ian Langleben, class of 2024', 'mcgillmed_theme') . '</a>'
                    );
                    ?>
            </p><!-- .theme-credits -->

        </div><!-- .footer-credits -->
        <div style="display: flex; flex-direction: column;">
            <?php
                mcgillmed_theme_the_social_menu();
                ?>
            <p class="color-secondary top-link">
                <a href="#site-header">To the top ↑</a>
            </p>
        </div>
        <?php

            do_action('mcgillmed_theme_footer_inner_end');
            ?>

    </div><!-- .footer-inner -->

    <?php
        do_action('mcgillmed_theme_footer_end');
        ?>

</footer><!-- #site-footer -->

<?php
endif; // if ! $blank_canvas

wp_footer();

?>

</body>

</html>
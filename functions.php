<?php


/*	-----------------------------------------------------------------------------------------------
	THEME SUPPORTS
	Define the theme features.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_theme_support')) :
    function mcgillmed_theme_theme_support()
    {

        // Automatic feed.
        add_theme_support('automatic-feed-links');

        // Custom background color.
        add_theme_support('custom-background', array(
            'default-color'    => 'FFFFFF'
        ));

        // Set content-width.
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 652;
        }

        // Post thumbnails.
        add_theme_support('post-thumbnails');

        // Editor styles.
        add_theme_support('editor-styles');

        // Set post thumbnail size.
        set_post_thumbnail_size(2240, 9999);

        // Add image sizes.
        add_image_size('mcgillmed_theme_preview_image', 1080, 9999);

        // Custom logo.
        add_theme_support('custom-logo', array(
            'height'      => 144,
            'width'       => 192,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array('site-title', 'site-description'),
        ));

        // Title tag.
        add_theme_support('title-tag');

        // HTML5 semantic markup.
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

        // Make the theme translation ready.
        load_theme_textdomain('mcgillmed_theme', get_template_directory() . '/languages');

        // Alignwide and alignfull classes in the block editor.
        add_theme_support('align-wide');

        // Block templates.
        add_theme_support('block-templates');

        // Block Editor font sizes.
        add_theme_support(
            'editor-font-sizes',
            array(
                array(
                    'name'      => esc_html_x('Small', 'Name of the small font size in Gutenberg', 'mcgillmed_theme'),
                    'shortName' => esc_html_x('S', 'Short name of the small font size in the Gutenberg editor.', 'mcgillmed_theme'),
                    'size'      => 16,
                    'slug'      => 'small',
                ),
                array(
                    'name'      => esc_html_x('Regular', 'Name of the regular font size in Gutenberg', 'mcgillmed_theme'),
                    'shortName' => esc_html_x('M', 'Short name of the regular font size in the Gutenberg editor.', 'mcgillmed_theme'),
                    'size'      => 18,
                    'slug'      => 'normal',
                ),
                array(
                    'name'      => esc_html_x('Large', 'Name of the large font size in Gutenberg', 'mcgillmed_theme'),
                    'shortName' => esc_html_x('L', 'Short name of the large font size in the Gutenberg editor.', 'mcgillmed_theme'),
                    'size'      => 24,
                    'slug'      => 'large',
                ),
                array(
                    'name'      => esc_html_x('Larger', 'Name of the larger font size in Gutenberg', 'mcgillmed_theme'),
                    'shortName' => esc_html_x('XL', 'Short name of the larger font size in the Gutenberg editor.', 'mcgillmed_theme'),
                    'size'      => 32,
                    'slug'      => 'larger',
                )
            )
        );

        /* Block Editor Color Palette -------- */

        $editor_color_palette     = array();
        $color_options             = array();

        // Get the color options. By default, this array contains two groups of colors: primary and dark-mode.
        $color_options_groups = Mcgillmed_Theme_Customizer::get_color_options();

        if ($color_options_groups) {

            // Merge the two groups into one array with all colors.
            foreach ($color_options_groups as $group) {
                $color_options = array_merge($color_options, $group);
            }

            // Loop over them and construct an array for the editor-color-palette.
            if ($color_options) {
                foreach ($color_options as $color_option_name => $color_option) {

                    // Only add the colors set to be included in the color palette
                    if (!isset($color_option['palette']) || !$color_option['palette']) continue;

                    $editor_color_palette[] = array(
                        'name'  => $color_option['label'],
                        'slug'  => $color_option['slug'],
                        'color' => get_theme_mod($color_option_name, $color_option['default']),
                    );
                }
            }

            // Add the background option.
            $background_color = '#' . get_theme_mod('background_color', 'ffffff');
            $editor_color_palette[] = array(
                'name'  => esc_html__('Background Color', 'mcgillmed_theme'),
                'slug'  => 'body-background',
                'color' => $background_color,
            );
        }

        // If we have colors, add them to the block editor palette.
        if ($editor_color_palette) {
            add_theme_support('editor-color-palette', $editor_color_palette);
        }
    }
    add_action('after_setup_theme', 'mcgillmed_theme_theme_support');
endif;


/*	-----------------------------------------------------------------------------------------------
	REQUIRED FILES
	Include required files
--------------------------------------------------------------------------------------------------- */

// Include custom template tags.
require get_template_directory() . '/inc/template-tags.php';

// Handle Block Patterns.
require get_template_directory() . '/inc/classes/class-mcgillmed-theme-block-settings.php';

// Handle SVG icons.
require get_template_directory() . '/inc/classes/class-mcgillmed-theme-svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/inc/classes/class-mcgillmed-theme-customizer.php';

// Custom CSS class.
require get_template_directory() . '/inc/classes/class-mcgillmed-theme-custom-css.php';

// Custom Customizer control for multiple checkboxes.
require get_template_directory() . '/inc/classes/class-mcgillmed-theme-customize-control-checkbox-multiple.php';


/*	-----------------------------------------------------------------------------------------------
	REGISTER STYLES
	Register and enqueue CSS.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_register_styles')) :
    function mcgillmed_theme_register_styles()
    {

        $theme_version = wp_get_theme('mcgillmed_theme')->get('Version');
        $css_dependencies = array();

        // Retrieve and enqueue the URL for Google Fonts.
        // You can remove the Google Fonts enqueue by filtering `mcgillmed_theme_google_fonts_url`.
        $google_fonts_url = apply_filters('mcgillmed_theme_google_fonts_url', '//fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');

        if ($google_fonts_url) {
            wp_register_style('mcgillmed-theme-google-fonts', $google_fonts_url, false, 1.0, 'all');
            $css_dependencies[] = 'mcgillmed-theme-google-fonts';
        }

        // Filter the list of dependencies used by the mcgillmed-theme-style CSS enqueue.
        $css_dependencies = apply_filters('mcgillmed_theme_css_dependencies', $css_dependencies);

        // Enqueue the McGill fonts file
        wp_enqueue_style('mcgillmed-theme-mcgill-fonts', get_template_directory_uri() . '/assets/css/mcgill-fonts.css', false, $theme_version, 'all');

        wp_enqueue_style('mcgillmed-theme-style', get_template_directory_uri() . '/style.css', $css_dependencies, $theme_version, 'all');

        // Add output of Customizer settings as inline style.
        wp_add_inline_style('mcgillmed-theme-style', Mcgillmed_Theme_Custom_CSS::get_customizer_css('front-end'));

        // Enqueue the print styles stylesheet.
        wp_enqueue_style('mcgillmed-theme-print-styles', get_template_directory_uri() . '/assets/css/print.css', false, $theme_version, 'print');
    }
    add_action('wp_enqueue_scripts', 'mcgillmed_theme_register_styles');
endif;


/*	-----------------------------------------------------------------------------------------------
	REGISTER SCRIPTS
	Register and enqueue JavaScript.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_register_scripts')) :
    function mcgillmed_theme_register_scripts()
    {

        $theme_version = wp_get_theme('mcgillmed_theme')->get('Version');

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        // Built-in JS assets.
        $js_dependencies = array('jquery', 'imagesloaded', 'masonry');

        // CSS variables ponyfill.
        wp_register_script('mcgillmed-theme-css-vars-ponyfill', get_template_directory_uri() . '/assets/js/css-vars-ponyfill.min.js', array(), '3.6.0');
        $js_dependencies[] = 'mcgillmed-theme-css-vars-ponyfill';

        // Filter the list of dependencies used by the mcgillmed-theme-construct JavaScript enqueue.
        $js_dependencies = apply_filters('mcgillmed_theme_js_dependencies', $js_dependencies);

        wp_enqueue_script('mcgillmed-theme-construct', get_template_directory_uri() . '/assets/js/construct.js', $js_dependencies, $theme_version);

        // Setup AJAX.
        $ajax_url = admin_url('admin-ajax.php');

        // AJAX Load More.
        wp_localize_script('mcgillmed-theme-construct', 'mcgillmed_theme_ajax_load_more', array(
            'ajaxurl'   => esc_url($ajax_url),
        ));

        // AJAX Filters.
        wp_localize_script('mcgillmed-theme-construct', 'mcgillmed_theme_ajax_filters', array(
            'ajaxurl'   => esc_url($ajax_url),
        ));
    }
    add_action('wp_enqueue_scripts', 'mcgillmed_theme_register_scripts');
endif;


/*	-----------------------------------------------------------------------------------------------
	MENUS
	Register navigation menus.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_register_nav_menus')) :
    function mcgillmed_theme_register_nav_menus()
    {

        register_nav_menus(array(
            'main'   => esc_html__('Main Menu', 'mcgillmed_theme'),
            'social' => esc_html__('Social Menu', 'mcgillmed_theme'),
        ));
    }
    add_action('init', 'mcgillmed_theme_register_nav_menus');
endif;


/*	-----------------------------------------------------------------------------------------------
	BODY CLASSES
	Conditional addition of classes to the body element.

	@param array	$classes	An array of body classes.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_body_classes')) :
    function mcgillmed_theme_body_classes($classes)
    {

        global $post;
        $post_type = isset($post) ? $post->post_type : false;

        // Determine type of infinite scroll.
        $pagination_type = get_theme_mod('mcgillmed_theme_pagination_type', 'button');

        switch ($pagination_type) {
            case 'button':
                $classes[] = 'pagination-type-button';
                break;
            case 'scroll':
                $classes[] = 'pagination-type-scroll';
                break;
            case 'links':
                $classes[] = 'pagination-type-links';
                break;
        }

        // Check whether the current page only has content.
        if (is_page_template(array('page-templates/template-no-title.php', 'page-templates/template-blank-canvas.php', 'page-templates/template-blank-canvas-with-aside.php'))) {
            $classes[] = 'has-only-content';
        }

        // Check for disabled search.
        if (!get_theme_mod('mcgillmed_theme_enable_search', true)) {
            $classes[] = 'disable-search-modal';
        }

        // Check for social menu.
        if (has_nav_menu('social')) {
            $classes[] = 'has-social-menu';
        }

        // Check for dark mode.
        if (get_theme_mod('mcgillmed_theme_enable_dark_mode_palette', false)) {
            $classes[] = 'has-dark-mode-palette';
        }

        // Check for disabled animations.
        $classes[] = get_theme_mod('mcgillmed_theme_disable_animations', false) ? 'no-anim' : 'has-anim';

        // Check for post thumbnail.
        if (is_singular() && has_post_thumbnail()) {
            $classes[] = 'has-post-thumbnail';
        } elseif (is_singular()) {
            $classes[] = 'missing-post-thumbnail';
        }

        // Check whether we're in the customizer preview.
        if (is_customize_preview()) {
            $classes[] = 'customizer-preview';
        }

        // Check if we're showing comments.
        if (is_singular() && ((comments_open() || get_comments_number()) && !post_password_required())) {
            $classes[] = 'showing-comments';
        } else if (is_singular()) {
            $classes[] = 'not-showing-comments';
        }

        // Shared archive page class.
        if (is_archive() || is_search() || is_home()) {
            $classes[] = 'archive-page';
        }

        // Slim page template class names (class = name - file suffix).
        if (is_page_template()) {
            $classes[] = basename(get_page_template_slug(), '.php');
        }

        return $classes;
    }
    add_action('body_class', 'mcgillmed_theme_body_classes');
endif;


/*	-----------------------------------------------------------------------------------------------
	NO-JS CLASS
	If we're missing JavaScript support, the HTML element will have a no-js class.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_no_js_class')) :
    function mcgillmed_theme_no_js_class()
    {

?>
<script>
document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
</script>
<?php

    }
    add_action('wp_head', 'mcgillmed_theme_no_js_class', 0);
endif;


/*	-----------------------------------------------------------------------------------------------
	NOSCRIPT STYLES
	Unset CSS animations triggered in JavaScript within a noscript element, to prevent the flash of 
	unstyled animation elements that occurs when using the .no-js class.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_noscript_styles')) :
    function mcgillmed_theme_noscript_styles()
    {

    ?>
<noscript>
    <style>
    .spot-fade-in-scale,
    .no-js .spot-fade-up {
        opacity: 1.0 !important;
        transform: none !important;
    }
    </style>
</noscript>
<?php

    }
    add_action('wp_head', 'mcgillmed_theme_noscript_styles', 0);
endif;


/*	-----------------------------------------------------------------------------------------------
	ADD EXCERPT SUPPORT TO PAGES
	Enables the excerpt subheading output in the page header on pages as well as posts.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_add_excerpt_support_to_pages')) :
    function mcgillmed_theme_add_excerpt_support_to_pages()
    {

        add_post_type_support('page', 'excerpt');
    }
    add_action('init', 'mcgillmed_theme_add_excerpt_support_to_pages');
endif;


/*	-----------------------------------------------------------------------------------------------
	DISABLE ARCHIVE TITLE PREFIX
	The prefix is output separately in the archive header with mcgillmed_theme_get_the_archive_title_prefix().
--------------------------------------------------------------------------------------------------- */

add_filter('get_the_archive_title_prefix', '__return_false');


/*	-----------------------------------------------------------------------------------------------
	GET ARCHIVE TITLE PREFIX
	Replicates the prefix removed with the get_the_archive_title_prefix filter, with some modifications.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_get_the_archive_title_prefix')) :
    function mcgillmed_theme_get_the_archive_title_prefix()
    {

        $prefix = '';

        if (is_search()) {
            $prefix = esc_html_x('Search Results', 'search archive title prefix', 'mcgillmed_theme');
        } elseif (is_category()) {
            $prefix = esc_html_x('Category', 'category archive title prefix', 'mcgillmed_theme');
        } elseif (is_tag()) {
            $prefix = esc_html_x('Tag', 'tag archive title prefix', 'mcgillmed_theme');
        } elseif (is_author()) {
            $prefix = esc_html_x('Author', 'author archive title prefix', 'mcgillmed_theme');
        } elseif (is_year()) {
            $prefix = esc_html_x('Year', 'date archive title prefix', 'mcgillmed_theme');
        } elseif (is_month()) {
            $prefix = esc_html_x('Month', 'date archive title prefix', 'mcgillmed_theme');
        } elseif (is_day()) {
            $prefix = esc_html_x('Day', 'date archive title prefix', 'mcgillmed_theme');
        } elseif (is_post_type_archive()) {
            // No prefix for post type archives.
            $prefix = '';
        } elseif (is_tax('post_format')) {
            // No prefix for post format archives.
            $prefix = '';
        } elseif (is_tax()) {
            $queried_object = get_queried_object();
            if ($queried_object) {
                $tax    = get_taxonomy($queried_object->taxonomy);
                $prefix = sprintf(
                    /* translators: %s: Taxonomy singular name. */
                    esc_html_x('%s:', 'taxonomy term archive title prefix', 'mcgillmed_theme'),
                    $tax->labels->singular_name
                );
            }
        } elseif (is_home() && is_paged()) {
            $prefix = esc_html_x('Archives', 'general archive title prefix', 'mcgillmed_theme');
        }

        // Make the prefix filterable before returning it.
        return apply_filters('mcgillmed_theme_archive_title_prefix', $prefix);
    }
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER ARCHIVE TITLE
	Modify the title of archive pages.

	@param string	$title 	The initial title.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_filter_archive_title')) :
    function mcgillmed_theme_filter_archive_title($title)
    {

        // Home: Get the Customizer option for post archive text.
        if (is_home() && !is_paged()) {
            $title = get_theme_mod('mcgillmed_theme_home_text', '');
        }

        // Home and paged: Output page number.
        elseif (is_home() && is_paged()) {
            global $wp_query;
            $paged     = get_query_var('paged') ? get_query_var('paged') : 1;
            $max     = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
            $title     = sprintf(esc_html_x('Page %1$s of %2$s', '%1$s = Current page number, %2$s = Number of pages', 'mcgillmed_theme'), $paged, $max);
        }

        // Jetpack Portfolio archive: Get the Customizer option for the Jetpack Portfolio archive title, if it is set and isn't empty.
        elseif (is_post_type_archive('jetpack-portfolio') && !is_paged() && get_theme_mod('mcgillmed_theme_jetpack_portfolio_archive_text', '')) {
            $title = get_theme_mod('mcgillmed_theme_jetpack_portfolio_archive_text', '');
        }

        // On search, show the search query.
        elseif (is_search()) {
            $title = '&ldquo;' . get_search_query() . '&rdquo;';
        }

        return $title;
    }
    add_filter('get_the_archive_title', 'mcgillmed_theme_filter_archive_title');
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER ARCHIVE DESCRIPTION
	Modify the description of archive pages.

	@param string	$description 	The initial description.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_filter_archive_description')) :
    function mcgillmed_theme_filter_archive_description($description)
    {

        // Home: Empty description.
        if (is_home()) {
            $description = '';
        }

        // On search, show a string describing the results of the search.
        elseif (is_search()) {
            global $wp_query;
            if ($wp_query->found_posts) {
                /* Translators: %s = Number of results */
                $description = esc_html(sprintf(_nx('We found %s result for your search.', 'We found %s results for your search.',  $wp_query->found_posts, '%s = Number of results', 'mcgillmed_theme'), $wp_query->found_posts));
            } else {
                $description = esc_html__('We could not find any results for your search. You can give it another try through the search form below.', 'mcgillmed_theme');
            }
        }

        return $description;
    }
    add_filter('get_the_archive_description', 'mcgillmed_theme_filter_archive_description');
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER THE EXCERPT SUFFIX
	Replaces the default [...] with a &hellip; (three dots)
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_excerpt_more')) :
    function mcgillmed_theme_excerpt_more()
    {

        return '&hellip;';
    }
    add_filter('excerpt_more', 'mcgillmed_theme_excerpt_more');
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER CLASSES OF WP_LIST_PAGES ITEMS TO MATCH MENU ITEMS
	Filter the class applied to wp_list_pages() items with children to match the menu class, to simplify
	styling of sub levels in the fallback. Only applied if the match_menu_classes argument is set.

	@param string[] $css_class    An array of CSS classes to be applied to each list item.
	@param WP_Post  $page         Page data object.
	@param int      $depth        Depth of page, used for padding.
	@param array    $args         An array of arguments.
	@param int      $current_page ID of the current page.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_filter_wp_list_pages_item_classes')) :
    function mcgillmed_theme_filter_wp_list_pages_item_classes($css_class, $item, $depth, $args, $current_page)
    {

        // Only apply to wp_list_pages() calls with match_menu_classes set to true.
        $match_menu_classes = isset($args['match_menu_classes']);

        if (!$match_menu_classes) {
            return $css_class;
        }

        // Add current menu item class.
        if (in_array('current_page_item', $css_class)) {
            $css_class[] = 'current-menu-item';
        }

        // Add menu item has children class.
        if (in_array('page_item_has_children', $css_class)) {
            $css_class[] = 'menu-item-has-children';
        }

        return $css_class;
    }
    add_filter('page_css_class', 'mcgillmed_theme_filter_wp_list_pages_item_classes', 10, 5);
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER NAV MENU ITEM ARGUMENTS
	Add a sub navigation toggle to the main menu.

	@param stdClass $args  An object of wp_nav_menu() arguments.
	@param WP_Post  $item  Menu item data object.
	@param int      $depth Depth of menu item. Used for padding.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_filter_nav_menu_item_args')) :
    function mcgillmed_theme_filter_nav_menu_item_args($args, $item, $depth)
    {

        // Add sub menu toggles to the main menu with toggles.
        if ($args->theme_location == 'main' && isset($args->show_toggles)) {

            // Wrap the menu item link contents in a div, used for positioning.
            $args->before = '<div class="ancestor-wrapper">';
            $args->after  = '';

            // Add a toggle to items with children.
            if (in_array('menu-item-has-children', $item->classes)) {

                $toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' &gt; .sub-menu';

                // Add the sub menu toggle.
                $args->after .= '<div class="sub-menu-toggle-wrapper"><a href="#" class="toggle sub-menu-toggle stroke-cc" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="250"><span class="screen-reader-text">' . esc_html__('Show sub menu', 'mcgillmed_theme') . '</span>' . mcgillmed_theme_get_theme_svg('ui', 'chevron-down', 18, 10) . '</a></div>';
            }

            // Close the wrapper.
            $args->after .= '</div><!-- .ancestor-wrapper -->';
        }

        return $args;
    }
    add_filter('nav_menu_item_args', 'mcgillmed_theme_filter_nav_menu_item_args', 10, 3);
endif;


/*	-----------------------------------------------------------------------------------------------
	IS COMMENT BY POST AUTHOR?
	Check if the specified comment is written by the author of the post commented on.

	@param obj $comment		The comment object.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_is_comment_by_post_author')) :
    function mcgillmed_theme_is_comment_by_post_author($comment)
    {

        if (is_object($comment) && $comment->user_id > 0) {
            $user = get_userdata($comment->user_id);
            $post = get_post($comment->comment_post_ID);
            if (!empty($user) && !empty($post)) {
                return $comment->user_id === $post->post_author;
            }
        }
        return false;
    }
endif;


/*	-----------------------------------------------------------------------------------------------
	HAS ASIDE?
	Checks whether the current page should output the aside element.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_has_aside')) :
    function mcgillmed_theme_has_aside()
    {

        $is_blank_canvas     = apply_filters('mcgillmed_theme_blank_canvas', is_page_template(array('page-templates/template-blank-canvas.php')));
        $has_aside            = apply_filters('mcgillmed_theme_has_aside', !$is_blank_canvas);

        return $has_aside;
    }
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER COMMENT TEXT
	If the comment is by the post author, append an element which says so.

	@param string          $comment_text Text of the current comment.
	@param WP_Comment|null $comment      The comment object. Null if not found.
	@param array           $args         An array of arguments.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_filter_comment_text')) :
    function mcgillmed_theme_filter_comment_text($comment_text, $comment, $args)
    {

        if (mcgillmed_theme_is_comment_by_post_author($comment)) {
            $comment_text .= '<p class="by-post-author">' . esc_html__('By Post Author', 'mcgillmed_theme') . '</p>';
        }

        return $comment_text;
    }
    add_filter('comment_text', 'mcgillmed_theme_filter_comment_text', 10, 3);
endif;


/* 	-----------------------------------------------------------------------------------------------
	FILTER IMAGE SIZE FOR GIF POST THUMBNAILS
	Set post thumbnails of the GIF file type to always use the `full` size, so they include animations.

	@param string|int[] $size		Requested image size. Can be any registered image size name, or 
									an array of width and height values in pixels (in that order).
    @param int 			$post_id 	The post ID.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_filter_post_thumbnail_size')) :
    function mcgillmed_theme_filter_post_thumbnail_size($size, $post_id)
    {

        $mime_type = get_post_mime_type(get_post_thumbnail_id($post_id));

        if ($mime_type && $mime_type === 'image/gif') {
            return 'full';
        }

        return $size;
    }
    add_filter('post_thumbnail_size', 'mcgillmed_theme_filter_post_thumbnail_size', 10, 3);
endif;


/* 	-----------------------------------------------------------------------------------------------
	MAYBE DISABLE GOOGLE FONTS
	Check whether to disable Google Fonts based on the setting in the Customizer.

	@param string 		$url		The Google Fonts URL.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_maybe_disable_google_fonts')) :
    function mcgillmed_theme_maybe_disable_google_fonts($url)
    {

        // If the Customizer setting is set to disable, return false.
        $disable_google_fonts = get_theme_mod('mcgillmed_theme_disable_google_fonts');

        if ($disable_google_fonts) {
            return false;
        }

        // If not, return the Google Fonts URL.
        return $url;
    }
    add_filter('mcgillmed_theme_google_fonts_url', 'mcgillmed_theme_maybe_disable_google_fonts');
endif;


/*	-----------------------------------------------------------------------------------------------
	AJAX LOAD MORE
	Called in construct.js when the the pagination is triggered to load more posts.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_ajax_load_more')) :
    function mcgillmed_theme_ajax_load_more()
    {

        $query_args = json_decode(wp_unslash($_POST['json_data']), true);

        $ajax_query = new WP_Query($query_args);

        // Determine which preview to use based on the post_type.
        $post_type = $ajax_query->get('post_type');

        // Default to the "post" post type for mixed content.
        if (!$post_type || is_array($post_type)) {
            $post_type = 'post';
        }

        if ($ajax_query->have_posts()) :
            while ($ajax_query->have_posts()) :
                $ajax_query->the_post();

                global $post;
        ?>

<div class="article-wrapper col">
    <?php get_template_part('inc/parts/preview', $post_type); ?>
</div>

<?php
            endwhile;
        endif;

        wp_die();
    }
    add_action('wp_ajax_nopriv_mcgillmed_theme_ajax_load_more', 'mcgillmed_theme_ajax_load_more');
    add_action('wp_ajax_mcgillmed_theme_ajax_load_more', 'mcgillmed_theme_ajax_load_more');
endif;


/* ---------------------------------------------------------------------------------------------
	AJAX FILTERS
	Return the query vars for the query for the taxonomy and terms supplied by JS.
--------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_ajax_filters')) :
    function mcgillmed_theme_ajax_filters()
    {

        // Get the filters from AJAX.
        $term_id     = isset($_POST['term_id']) ? $_POST['term_id'] : null;
        $taxonomy     = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';
        $post_type     = isset($_POST['post_type']) ? $_POST['post_type'] : '';

        $args = array(
            'ignore_sticky_posts'    => false,
            'post_status'            => 'publish',
            'post_type'                => $post_type,
        );

        // Get the posts per page setting for Jetpack Portfolio.
        if ($post_type == 'jetpack-portfolio') {
            $args['posts_per_page'] = get_option('jetpack_portfolio_posts_per_page', get_option('posts_per_page', 10));
        }

        // Add the tax query, if set.
        if ($term_id && $taxonomy) {
            $args['tax_query'] = array(array(
                'taxonomy'    => $taxonomy,
                'terms'        => $term_id,
            ));

            // If a taxonomy isn't set, and we're loading posts, make sure we include the sticky post in the results.
            // The custom argument is used to prepend the latest sticky post with mcgillmed_theme_filter_posts_results().
        } elseif ($post_type == 'post') {
            $args['mcgillmed_theme_prepend_sticky_post'] = true;
        }

        $custom_query = new WP_Query($args);

        // Combine the query with the query_vars into a single array.
        $query_args = array_merge($custom_query->query, $custom_query->query_vars);

        // If max_num_pages is not already set, add it.
        if (!array_key_exists('max_num_pages', $query_args)) {
            $query_args['max_num_pages'] = $custom_query->max_num_pages;
        }

        // Format and return the query arguments.
        echo json_encode($query_args);

        wp_die();
    }
    add_action('wp_ajax_nopriv_mcgillmed_theme_ajax_filters', 'mcgillmed_theme_ajax_filters');
    add_action('wp_ajax_mcgillmed_theme_ajax_filters', 'mcgillmed_theme_ajax_filters');
endif;


/*	-----------------------------------------------------------------------------------------------
	FILTER POSTS RESULTS
	Filter the posts_results to include the sticky post when "Show All" is clicked in the taxonomy filter.

	@param WP_Post[]	$posts Array of post objects.
	@param WP_Query		$query The WP_Query instance.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_filter_posts_results')) :
    function mcgillmed_theme_filter_posts_results($posts, $query)
    {

        /*
		 * If the custom mcgillmed_theme_prepend_sticky_post argument is present (added by mcgillmed_theme_ajax_filters()), 
		 * and we're showing the first page, prepend the sticky post to the array of post objects.
		 * This is done to include the sticky post when the "Show All" link is clicked in the taxonomy filter.
		 */

        if (isset($query->query['mcgillmed_theme_prepend_sticky_post']) && !empty($query->query_vars['paged']) && $query->query_vars['paged'] == 1) {
            $sticky = get_option('sticky_posts');
            if ($sticky) {
                $sticky_post = get_post($sticky[0]);
                if ($sticky_post) {
                    array_unshift($posts, $sticky_post);
                }
            }
        }

        return $posts;
    }
    add_filter('posts_results', 'mcgillmed_theme_filter_posts_results', 10, 2);
endif;


/*	-----------------------------------------------------------------------------------------------
	CONDITIONAL PAGE TEMPLATES
	Conditional inclusion of page templates in McGill Med Theme.

	@param array	$page_templates Array of page templates.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_conditional_page_templates')) :
    function mcgillmed_theme_conditional_page_templates($page_templates)
    {

        // If Jetpack Portfolio doesn't exist, remove the portfolio page template.
        if (!post_type_exists('jetpack-portfolio') && isset($page_templates['page-templates/template-portfolio.php'])) {
            unset($page_templates['page-templates/template-portfolio.php']);
        }

        return $page_templates;
    }
    add_filter('theme_page_templates', 'mcgillmed_theme_conditional_page_templates');
endif;


/*	-----------------------------------------------------------------------------------------------
	CONDITIONAL LOADING OF TEMPLATE
	In certain cases, filter which template file is used for the current page.

	@param string	$template	The path of the template to include.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_conditional_template_include')) :
    function mcgillmed_theme_conditional_template_include($template)
    {

        // If we're set to load the portfolio template, and Jetpack Portfolio doesn't exist, load singular.php instead.
        if ($template == locate_template('page-templates/template-portfolio.php') && !post_type_exists('jetpack-portfolio')) {
            $template = locate_template('singular.php');
        }

        return $template;
    }
    add_filter('template_include', 'mcgillmed_theme_conditional_template_include');
endif;


/*	-----------------------------------------------------------------------------------------------
	META TAG: THEME COLOR
	Outputs a meta tag for theme color, used on Android and for the address bar in Safari 15.
	The colors default to the values of the background color settings, but can be filtered by hooking 
	into the filters added below.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_meta_theme_color')) :
    function mcgillmed_theme_meta_theme_color()
    {

        $dark_mode         = get_theme_mod('mcgillmed_theme_enable_dark_mode_palette', false);

        $light_color     = apply_filters('mcgillmed_theme_theme_color_light', get_theme_mod('mcgillmed_theme_menu_modal_background_color', '#1e2d32'));
        $dark_color     = apply_filters('mcgillmed_theme_theme_color_dark', $dark_mode ? get_theme_mod('mcgillmed_theme_dark_mode_menu_modal_background_color') : '');

        if (!($light_color || $dark_color)) return;

        if ($light_color) {
            $media_attr = $dark_color ? ' media="(prefers-color-scheme: light)"' : '';
            echo '<meta name="theme-color" content="' . esc_attr($light_color) . '"' . $media_attr . '>';
        }

        if ($dark_color) {
            echo '<meta name="theme-color" content="' . esc_attr($dark_color) . '" media="(prefers-color-scheme: dark)">';
        }
    }
    add_action('wp_head', 'mcgillmed_theme_meta_theme_color');
endif;


/*	-----------------------------------------------------------------------------------------------
	EDITOR STYLES
	Enqueue Block Editor styles.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_block_editor_styles')) :
    function mcgillmed_theme_block_editor_styles()
    {

        // The URL for Google Fonts. You can modify or remove it by filtering `mcgillmed_theme_google_fonts_url`.
        $google_fonts_url = apply_filters('mcgillmed_theme_google_fonts_url', 'https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');

        // This URL is filtered by mcgillmed_theme_pre_http_request_block_editor_customizer_styles to load dynamic CSS as inline styles.
        $inline_styles_url = 'https://mcgillmed-theme-inline-editor-styles';

        // Build a filterable array of the editor styles to load.
        $mcgillmed_theme_editor_styles = apply_filters('mcgillmed_theme_editor_styles', array(
            'assets/css/mcgillmed-theme-editor-styles.css',
            $google_fonts_url,
            $inline_styles_url
        ));

        // Load the editor styles.
        add_editor_style($mcgillmed_theme_editor_styles);
    }
    add_action('after_setup_theme', 'mcgillmed_theme_block_editor_styles');
endif;


/*	-----------------------------------------------------------------------------------------------
	INLINE EDITOR STYLES WORKAROUND
	This function filters the request for https://mcgillmed-theme-inline-editor-styles, which is added with 
	add_editor_style() in mcgillmed_theme_block_editor_styles(), and returns the dynamic Customizer CSS for 
	the editor styles.

	This workaround for adding inline styles to the editor styles was suggested by @anastis, here: 
	https://github.com/WordPress/gutenberg/issues/18571#issuecomment-618932161
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_pre_http_request_block_editor_customizer_styles')) :
    function mcgillmed_theme_pre_http_request_block_editor_customizer_styles($response, $parsed_args, $url)
    {

        if ($url === 'https://mcgillmed-theme-inline-editor-styles') {
            $response = array(
                'body'        => Mcgillmed_Theme_Custom_CSS::get_customizer_css('editor'),
                'headers'    => new Requests_Utility_CaseInsensitiveDictionary(),
                'response'    => array(
                    'code'        => 200,
                    'message'    => 'OK',
                ),
                'cookies'    => array(),
                'filename'    => null,
            );
        }

        return $response;
    }
    add_filter('pre_http_request', 'mcgillmed_theme_pre_http_request_block_editor_customizer_styles', 10, 3);
endif;


/*	-----------------------------------------------------------------------------------------------
	SET DEFAULT BLOCK TEMPLATE
	Specify a custom block template default for the Block Template editor introduced in WordPress 5.8.

	@param array	$settings	Default editor settings.
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_block_template_settings')) :
    function mcgillmed_theme_block_template_settings($settings)
    {

        $settings['defaultBlockTemplate'] = file_get_contents(get_theme_file_path('inc/block-template-default.html'));
        return $settings;
    }
    add_filter('block_editor_settings_all', 'mcgillmed_theme_block_template_settings');
endif;


/*	-----------------------------------------------------------------------------------------------
	REGISTER THE WIDGET AREAS
--------------------------------------------------------------------------------------------------- */

if (!function_exists('mcgillmed_theme_widgets_init')) :
    function mcgillmed_theme_widgets_init()
    {
        // Logo footer widget area, located above the four columns in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('Logo Footer Widget Area', 'mcgillmed_theme'),
            'id' => 'logo-footer-widget-area',
            'description' => __('The logo footer widget area', 'mcgillmed_theme'),
            'before_widget' => '<div id="%1$s class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // First footer widget area, located in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('First Footer Widget Area', 'mcgillmed_theme'),
            'id' => 'first-footer-widget-area',
            'description' => __('The first footer widget area', 'mcgillmed_theme'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Second Footer Widget Area, located in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('Second Footer Widget Area', 'mcgillmed_theme'),
            'id' => 'second-footer-widget-area',
            'description' => __('The second footer widget area', 'mcgillmed_theme'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Third Footer Widget Area, located in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('Third Footer Widget Area', 'mcgillmed_theme'),
            'id' => 'third-footer-widget-area',
            'description' => __('The third footer widget area', 'mcgillmed_theme'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        // Fourth Footer Widget Area, located in the footer. Empty by default.
        register_sidebar(array(
            'name' => __('Fourth Footer Widget Area', 'mcgillmed_theme'),
            'id' => 'fourth-footer-widget-area',
            'description' => __('The fourth footer widget area', 'mcgillmed_theme'),
            'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
endif;

// Register sidebars by running mcgillmed_theme_widgets_init() on the widgets_init hook.
add_action('widgets_init', 'mcgillmed_theme_widgets_init');
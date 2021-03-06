<?php

/* ---------------------------------------------------------------------------------------------
   BLOCK SETTINGS CLASS
   Handles block styles and block patterns.
------------------------------------------------------------------------------------------------ */

if (!class_exists('Mcgillmed_Theme_Block_Settings')) :
    class Mcgillmed_Theme_Block_Settings
    {

        /*	-----------------------------------------------------------------------------------------------
			REGISTER BLOCK STYLES
		--------------------------------------------------------------------------------------------------- */

        public static function register_block_styles()
        {

            if (!function_exists('register_block_style')) return;

            // Shared: No Vertical Margin.
            $no_vertical_margin_blocks = array(
                'core/columns',
                'core/cover',
                'core/embed',
                'core/group',
                'core/heading',
                'core/image',
                'core/paragraph'
            );

            foreach ($no_vertical_margin_blocks as $block) {
                register_block_style($block, array(
                    'label' => esc_html__('No Vertical Margin', 'mcgillmed_theme'),
                    'name'  => 'no-vertical-margin',
                ));
            }

            // Separator: Left aligned.
            register_block_style(
                'core/separator',
                array(
                    'label' => esc_html__('Left Aligned', 'mcgillmed_theme'),
                    'name'  => 'left-aligned',
                )
            );

            // Separator: Right aligned.
            register_block_style(
                'core/separator',
                array(
                    'label' => esc_html__('Right Aligned', 'mcgillmed_theme'),
                    'name'  => 'right-aligned',
                )
            );

            // Social icons: Logos Only Monochrome.
            register_block_style(
                'core/social-links',
                array(
                    'label' => esc_html__('Logos Only Monochrome', 'mcgillmed_theme'),
                    'name'  => 'logos-only-monochrome',
                )
            );

            // Gallery: No Gutter.
            register_block_style(
                'core/gallery',
                array(
                    'label' => esc_html__('No Gutter', 'mcgillmed_theme'),
                    'name'  => 'no-gutter',
                )
            );
        }


        /*	-----------------------------------------------------------------------------------------------
			REGISTER BLOCK PATTERNS
		--------------------------------------------------------------------------------------------------- */

        public static function register_block_patterns()
        {

            // Register the McGill Med Theme block pattern category.
            if (function_exists('register_block_pattern_category')) {
                register_block_pattern_category('mcgillmed_theme', array(
                    'label' => esc_html__('McGill Med Theme', 'mcgillmed_theme')
                ));
            }

            // Register block patterns.
            // The block patterns can be modified with the mcgillmed_theme_block_patterns filter.
            $block_patterns = apply_filters('mcgillmed_theme_block_patterns', array(
                'mcgillmed-theme/big-call-to-action' => array(
                    'title'            => esc_html__('Big call to action', 'mcgillmed_theme'),
                    'description'    => esc_html__('A full-width section with an image, a heading, text and buttons.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/big-call-to-action.php'),
                    'categories'    => array('mcgillmed_theme'),
                    'keywords'        => array('cta'),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/call-to-action' => array(
                    'title'            => esc_html__('Call to action', 'mcgillmed_theme'),
                    'description'    => esc_html__('A large text paragraph followed by buttons.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/call-to-action.php'),
                    'categories'    => array('mcgillmed_theme'),
                    'keywords'        => array('cta'),
                    'viewportWidth'    => 822,
                ),
                'mcgillmed-theme/columns-featured-items' => array(
                    'title'            => esc_html__('Three columns with featured items', 'mcgillmed_theme'),
                    'description'    => esc_html__('A row of columns with each item having an image, a title, a paragraph of text and buttons.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/columns-featured-items.php'),
                    'categories'    => array('columns', 'mcgillmed_theme'),
                    'keywords'        => array('row', 'column', 'grid'),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/columns-heading-image-text' => array(
                    'title'            => esc_html__('Three columns with headings, images, and text', 'mcgillmed_theme'),
                    'description'    => esc_html__('A full-width section with three columns containing a heading, an image, and text.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/columns-heading-image-text.php'),
                    'categories'    => array('columns', 'mcgillmed_theme', 'header'),
                    'keywords'        => array(),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/columns-image-text' => array(
                    'title'            => esc_html__('Two columns with images and text', 'mcgillmed_theme'),
                    'description'    => esc_html__('Two columns containing an image and paragraphs of text.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/columns-image-text.php'),
                    'categories'    => array('columns', 'mcgillmed_theme', 'text'),
                    'keywords'        => array(),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/columns-image-text-image' => array(
                    'title'            => esc_html__('Three columns with images and text', 'mcgillmed_theme'),
                    'description'    => esc_html__('Three columns containing an image, a centered paragraph of large text, and another image.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/columns-image-text-image.php'),
                    'categories'    => array('columns', 'mcgillmed_theme'),
                    'keywords'        => array(),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/columns-text-image-pullquote' => array(
                    'title'            => esc_html__('Three columns with text, an image, and a pullquote', 'mcgillmed_theme'),
                    'description'    => esc_html__('Three columns containing paragraphs of text, an image, and a pullquote.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/columns-text-image-pullquote.php'),
                    'categories'    => array('mcgillmed_theme'),
                    'keywords'        => array(),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/columns-text-pullquote' => array(
                    'title'            => esc_html__('Two columns with text and a pullquote', 'mcgillmed_theme'),
                    'description'    => esc_html__('Two columns containing paragraphs of text and a pullquote.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/columns-text-pullquote.php'),
                    'categories'    => array('columns', 'mcgillmed_theme', 'text'),
                    'keywords'        => array(),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/contact-details' => array(
                    'title'            => esc_html__('Contact details', 'mcgillmed_theme'),
                    'description'    => esc_html__('Three columns with contact details and social media links.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/contact-details.php'),
                    'categories'    => array('mcgillmed_theme'),
                    'keywords'        => array(),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/cover-header' => array(
                    'title'            => esc_html__('Cover header', 'mcgillmed_theme'),
                    'description'    => esc_html__('Cover block with title, text, and a separator.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/cover-header.php'),
                    'categories'    => array('mcgillmed_theme', 'header'),
                    'keywords'        => array('hero'),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/stacked-full-groups' => array(
                    'title'            => esc_html__('Stacked color groups with text', 'mcgillmed_theme'),
                    'description'    => esc_html__('Three stacked groups with solid background color, each with two columns containing a heading and text.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/stacked-full-groups.php'),
                    'categories'    => array('mcgillmed_theme'),
                    'keywords'        => array(),
                    'viewportWidth'    => 1440,
                ),
                'mcgillmed-theme/stacked-galleries' => array(
                    'title'            => esc_html__('Three stacked galleries', 'mcgillmed_theme'),
                    'description'    => esc_html__('Three stacked galleries with the same horizontal and vertical margin between each gallery item.', 'mcgillmed_theme'),
                    'content'        => Mcgillmed_Theme_Block_Settings::get_block_pattern_markup('inc/block-patterns/stacked-galleries.php'),
                    'categories'    => array('mcgillmed_theme', 'gallery'),
                    'keywords'        => array('gallery'),
                    'viewportWidth'    => 822,
                ),
            ));

            if ($block_patterns && function_exists('register_block_pattern')) {
                foreach ($block_patterns as $name => $data) {
                    if (isset($data['content']) && $data['content']) {
                        register_block_pattern($name, $data);
                    }
                }
            }
        }


        /*	-----------------------------------------------------------------------------------------------
			GET BLOCK PATTERN
			Returns the markup of the block pattern at the specified theme path.
		--------------------------------------------------------------------------------------------------- */

        public static function get_block_pattern_markup($path)
        {

            // Define shared block pattern placeholder content, to minimize cluttering up of the polyglot list.
            $lorem_short_1 = esc_html_x('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 'Block pattern demo content', 'mcgillmed_theme');
            $lorem_short_2 = esc_html_x('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.', 'Block pattern demo content', 'mcgillmed_theme');

            $lorem_long_1 = $lorem_short_1 . ' ' . $lorem_short_2;
            $lorem_long_2 =  esc_html_x('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 'Block pattern demo content', 'mcgillmed_theme');
            $lorem_long_3 =  esc_html_x('At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.', 'Block pattern demo content', 'mcgillmed_theme');

            if (!locate_template($path)) return;

            ob_start();
            include(locate_template($path));
            return ob_get_clean();
        }
    }

    // Register block styles.
    add_action('init', array('Mcgillmed_Theme_Block_Settings', 'register_block_styles'));

    // Register block patterns.
    add_action('init', array('Mcgillmed_Theme_Block_Settings', 'register_block_patterns'));

endif;
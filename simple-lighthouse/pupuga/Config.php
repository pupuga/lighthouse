<?php

namespace Pupuga;

abstract class Config
{
    protected $config;

    protected function __construct()
    {
        $this->config = array(
            // theme | modules | restapi | array('Correct', 'Media', 'SetConfig', 'PageMain', 'PageLogin', 'PageAdmin')
            'mode' => array('Correct', 'Media', 'SetConfig', 'PageLogin', 'PageAdmin'),

            /**
             * Register block
             */
            'registerCarbonFields' => array(
                // slug must start with common_pupuga_
                //    'common' => array(
                //        'Configuration' => array(
                //            'Parameters' => 'config',
                //            'Test edit' => 'textarea',
                //            'Loop edit' => array(
                //                'type' => 'complex',
                //                'set_layout' => 'tabbed-horizontal',
                //                'add_fields' => array(
                //                    array('text', 'title', 'Title'),
                //                    array('color', 'title_color', 'Title Color'),
                //                    array('image', 'image', 'Image')
                //                ),
                //            )
                //        )
                //    )       
                // false | array
                //'sidebar' => array('page', 'post')
            ),

            // Example - add postType & taxonomy
            //
            // 'Single post type' => array(
            //      'many' => 'Many post types',
            //      'icon' => 'dashicons-calendar-alt',
            //      'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            //      'taxonomies' => array('post_tag', 'category'),
            //      'addTaxonomies' => array(array('single' => 'Single taxonomy', 'many' => 'Many taxonomies')),
            //      'parameters' => array('publicly_queryable' => false)
            // )
            'registerPostTypesTaxonomies' => array(
                'Site' => array(
                    'many' => 'Sites',
                    'icon' => 'dashicons-admin-site-alt3',
                    'supports' => array('title', /*'page-attributes'*/),
                    'taxonomies' => array(),
                    'addTaxonomies' => array(),
                    'parameters' => array('publicly_queryable' => false)
                 )
            ),

            // boolean | array '140x50' => boolean,
            'registerThumbnails' => array(
            ),

            // boolean | array
            'registerWidgets' => false,

            // boolean
            'registerHeaderImage' => false,

            /**
             * Remove block
             */
            'removeRestApi' => true,
            'removeAdminMenuItems' =>
                array(
                    'menu' => array(
                        'upload.php',
                        'edit.php',
                        'edit.php?post_type=page',
                        'edit-comments.php',
                        'tools.php',
                        'plugins.php',
                        //'index.php',
                        //'users.php',
                        'options-general.php',
                        'separator1',
                        'separator2',
                        'separator-last',
                    ),
                    'submenu' => array(
                        'themes.php' => array(
                            'theme-editor.php',
                            'nav-menus.php',
                            //'options-discussion.php',
                            //'options-permalink.php',
                            //'options-privacy.php',
                        ),
                        'options-general.php' => array(
                            //'options-reading.php',
                            //'options-writing.php',
                            //'options-discussion.php',
                            //'options-permalink.php',
                            //'options-privacy.php',
                        ),
                    )
                ),
            'removeAdminPluginItems' => array()
        );
    }
}
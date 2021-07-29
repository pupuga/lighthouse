<?php

namespace Pupuga\Custom\Lighthouse;

final class Correct
{
    private static $instance = null;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action( 'admin_bar_menu', array($this, 'rebuildMenus'), 100);
        add_action( 'customize_register', array($this, 'rebuildCustomize'), 100);
    }

    public function rebuildMenus($adminBar): void
    {
        $remove = array(
            'wp-logo',
            'site-name',
            'comments',
            'new-content',
        );

        foreach ( $adminBar->get_nodes() as $node ) {
            if (in_array($node->id, $remove)) {
                $adminBar->remove_node( $node->id );
            }
        }
    }

    public function rebuildCustomize($customize)
    {
        //$customize->remove_section( 'title_tagline');
        $customize->remove_section( 'header_image');
        $customize->remove_section( 'background_image');
        $customize->remove_section( 'static_front_page');
        $customize->remove_panel("widgets");
        $customize->remove_section( 'colors');
        $customize->remove_panel( 'nav_menus');
        $customize->remove_section( 'custom_css');
    }
}
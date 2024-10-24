<?php

/**
 * Plugin Name: Advanced Custom Fields: Sidebar Selector
 * Plugin URI:  https://github.com/log1x/acf-sidebar-selector
 * Description: A simple ACF sidebar selector field
 * Version:     1.1.0
 * Author:      Brandon Nifong
 * Author URI:  https://github.com/log1x
 */

namespace Log1x\AcfSidebarSelector;

add_filter('after_setup_theme', new class
{
    /**
     * Invoke the plugin.
     *
     * @return void
     */
    public function __invoke()
    {
        if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
            require_once $composer;
        }

        $this->register();
    }

    /**
     * Register the Phone Number field type with ACF.
     *
     * @return void
     */
    protected function register()
    {
        foreach (['acf/include_field_types', 'acf/register_fields'] as $hook) {
            add_filter($hook, function () {
                return new SidebarSelectorField(
                    plugin_dir_url(__FILE__),
                    plugin_dir_path(__FILE__)
                );
            });
        }
    }
});

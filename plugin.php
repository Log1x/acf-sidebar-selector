<?php
/**
 * Plugin Name: Advanced Custom Fields: Sidebar Selector
 * Plugin URI:  https://github.com/log1x/acf-sidebar-selector
 * Description: A simple ACF sidebar selector field
 * Version:     1.0.0
 * Author:      Brandon Nifong
 * Author URI:  https://github.com/log1x
 */

namespace Log1x\AcfSidebarSelector;

add_filter(
    'after_setup_theme', new class
    {
        /**
         * The plugin URI.
         *
         * @var string
         */
        protected $uri;

        /**
         * The plugin path.
         *
         * @var string
         */
        protected $path;

        /**
         * Invoke the plugin.
         *
         * @return void
         */
        public function __invoke()
        {
            foreach (['acf/include_field_types', 'acf/register_fields'] as $hook) {
                add_filter(
                    $hook, function () {
                        foreach (glob(__DIR__ . '/src/*.php') as $field) {
                            $class = __NAMESPACE__ . '\\' . basename($field, '.php');

                            spl_autoload_register(
                                function () use ($field) {
                                    include_once $field;
                                }
                            );

                            return new $class(
                                [
                                'uri' => $this->uri,
                                'path' => $this->path
                                ]
                            );
                        }
                    }
                );
            }
        }
    }, 100
);

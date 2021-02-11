<?php

namespace Log1x\AcfSidebarSelector;

class SidebarSelectorField extends \acf_field
{
    /**
     * The field name.
     *
     * @var string
     */
    public $name = 'sidebar_selector';

    /**
     * The field label.
     *
     * @var string
     */
    public $label = 'Sidebar Selector';

    /**
     * The field category.
     *
     * @var string
     */
    public $category = 'relational';

    /**
     * The field defaults.
     *
     * @var array
     */
    public $defaults = ['ui' => 1, 'multiple' => 0, 'ajax' => 0];

    /**
     * Create a new phone number field instance.
     *
     * @param  string $uri
     * @param  string $path
     * @return void
     */
    public function __construct($uri, $path)
    {
        $this->uri = $uri;
        $this->path = $path;

        parent::__construct();
    }

    /**
     * Create the HTML interface for your field.
     *
     * @param  array $field
     * @return void
     */
    public function render_field($field)
    {
        $field = array_merge($field, [
            'type' => 'select',
            'placeholder' => 'Select a sidebar',
            'choices' => $this->sidebars(),
        ]);

        echo sprintf(
            '<div
                class="acf-field acf-field-select"
                data-name="%s"
                data-type="select"
                data-key="%s"
            >',
            $field['label'],
            $field['key']
        );
        acf_render_field($field);

        echo '</div>';
    }

    /**
     * Create extra settings for your field. These are visible when editing a field.
     *
     * @param  array $field
     * @return void
     */
    public function render_field_settings($field)
    {
        acf_render_field_setting($field, [
            'label' => 'Default Value',
            'type' => 'select',
            'name' => 'default_value',
            'default_value' => 'sidebar-primary',
            'choices' => $this->sidebars(),
        ]);

        acf_render_field_setting($field, [
            'label' => 'Allow Null?',
            'type' => 'radio',
            'name' => 'allow_null',
            'layout' => 'horizontal',
            'default_value' => '1',
            'choices' => ['1' => 'Yes', '0' => 'No']
        ]);
    }

    /**
     * Get the available sidebars.
     *
     * @return object
     */
    protected function sidebars()
    {
        global $wp_registered_sidebars;

        if (empty($wp_registered_sidebars)) {
            return;
        }

        $sidebars = [];

        foreach ($wp_registered_sidebars as $value) {
            $sidebars[$value['id']] = $value['name'];
        }

        return $sidebars;
    }
}

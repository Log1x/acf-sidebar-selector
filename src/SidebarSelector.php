<?php

namespace Log1x\AcfSidebarSelector;

class SidebarSelector extends \acf_field
{
    /**
     * Field Name
     *
     * @var string
     */
    public $name = 'sidebar_selector';

    /**
     * Field Label
     *
     * @var string
     */
    public $label = 'Sidebar Selector';

    /**
     * Field Category
     *
     * @var string
     */
    public $category = 'relational';

    /**
     * Field Defaults
     *
     * @var array
     */
    public $defaults = [];

    /**
     * Enable/Disable Enqueuing Assets
     *
     * @var boolean
     */
    public $assets = false;

    /**
     * Settings
     *
     * @var object
     */
    private $settings;

    /**
     * Create a new instance of AcfSidebarSelector.
     *
     * @param  array $settings
     * @return void
     */
    public function __construct($settings)
    {
        $this->settings = (object) $settings;

        parent::__construct();
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
     * Create the HTML interface for your field.
     *
     * @param  array $field
     * @return void
     */
    public function render_field($field)
    {
        $field = array_merge($field, [
            'type' => 'select',
            'ui' => '1',
            'placeholder' => 'Select a sidebar',
            'choices' => $this->sidebars(),
        ]);

        echo "<div class='acf-field acf-field-select'
        data-name='{$field['label']}'
        data-type='select'
        data-key='{$field['key']}'>";

        acf_render_field($field);

        echo '</div>';
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

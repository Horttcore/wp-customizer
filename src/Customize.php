<?php
/**
 * Customizer Panels
 *
 * @package   horttcore/wp-customizer
 * @license   GPL-2.0+
 */

namespace Horttcore\Customizer;

/**
 * Customizer settings
 *
 * @see https://codex.wordpress.org/Plugin_API/Action_Reference/customize_register
 * @TODO Category dropdown setting
 */
class Customize
{


    
    /**
     * Construct
     *
     * @param bool $autoInit
     * @return Customize
     **/
    public function __construct(bool $autoInit = TRUE )
    {
        if ( !$autoInit )
            return;

        $this->register();
    }


    /**
     * Current panel id
     *
     * @var string
     */
    protected $currentPanelId = '';


    /**
     * Current section id
     *
     * @var string
     */
    protected $currentSectionId = '';


    /**
     * Panels
     *
     * @var array
     */
    protected $panels = [];


    /**
     * Register customizer setting as theme mod
     *
     * @param string $identifier Identifier
     * @param string $name Name
     * @param array $setting Config - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @param array $control Control - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param callable $renderer Renderer class i.e. WP_Customize_Control
     * @return Settings
     */
    public function add( string $identifier, string $name, array $setting, array $control, string $renderer = '' )
    {

        $settingDefaults = [
            // A default value for the setting if none is defined
            'default' => '',
            // Optional. Specifies the TYPE of setting this is. Options are 'option' or 'theme_mod' (defaults to 'theme_mod')
            'type' => '',
            // Optional. You can define a capability a user must have to modify this setting. Default if not specified: edit_theme_options
            'capability' => '',
            // Optional. This can be used to hide a setting if the theme lacks support for a specific feature (using add_theme_support).
            'theme_supports' => '',
            // Optional. This can be either 'refresh' (default) or 'postMessage'. Only set this to 'postMessage' if you are writing custom Javascript to control the Theme Customizer's live preview.
            'transport' => '',
            // Optional. A function name to call for sanitizing the input value for this setting. The function should be of the form of a standard filter function, where it accepts the input data and returns the sanitized data.
            'sanitize_callback' => '',
            // Optional. A function name to call for sanitizing the value for this setting for the purposes of outputting to javascript code. The function should be of the form of a standard filter function, where it accepts the input data and returns the sanitized data. This is only necessary if the data to be sent to the customizer window has a special form.
            'sanitize_js_callback' => '',
        ];

        $controlDefaults = [
            // Optional. Displayed label. Example: 'label' => __( 'Base Color Scheme', 'twentyfifteen' ),
            'label' => $name,
            // Optional.
            'description' => '',
            // Any readily available or user defined section. Some available sections: themes, title_tagline, colors, header_image (only when enabled), background_image (only when enabled), static_front_page.
            'section' => $this->getCurrentSectionId(),
            // Optional.
            'priority' => '',
            // Supported types include: text, checkbox, radio, select, textarea, dropdown-pages, email, url, number, hidden, and date.
            'type' => '',
            // Optional. If in https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting you specified "theme_mod" type then you should add here ID of the database setting which you want to modify, e.g. "header_color" (which is your arbitrary name specific to your theme only). It will be stored as a serialized value obtainable with https://codex.wordpress.org/Function_Reference/get_theme_mod like get_theme_mod('header_color');. If you selected "option" type in https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting then you can add here a plain word like "theme_name_header_color" which will be obtainable with get_option('theme_name_header_color');. Serialized values like "my_namespace[header_color]" are allowed in both cases, however you probably don't need to serialize it when using "theme_mod" as it's already stored in the database as a serialized entry. If not defined, then the $identifier as the setting ID is used.
            'settings' => '',
            // Optional. Allows you to add attributes to the input. This extends beyond just using min, max, and step for number and range, to the ability to add custom classes, placeholders, the pattern attribute, and anything else you need to the input element. These are available only for some control types. Example for "number" and "range" controls: 'input_attrs' => array( 'min' => 0, 'max' => 10, 'step'  => 2 )
            'input_attrs' => [],
        ];

        $setting = array_filter( wp_parse_args( $setting, $settingDefaults ) );
        $control = array_filter( wp_parse_args( $control, $controlDefaults ) );

        $this->panels[$this->getCurrentPanelId()]['sections'][$this->getCurrentSectionId()]['fields'][$identifier]['setting'] = $setting;
        $this->panels[$this->getCurrentPanelId()]['sections'][$this->getCurrentSectionId()]['fields'][$identifier]['control'] = $control;
        $this->panels[$this->getCurrentPanelId()]['sections'][$this->getCurrentSectionId()]['fields'][$identifier]['renderer'] = $renderer;

        return $this;
    }


    /**
     * Register a checkbox control in the customizer
     *
     * @param string $identifier Identifier
     * @param string $label Settings label
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @return Settings $this for chaining
     */
    public function checkbox( string $identifier, string $label, array $setting = [], array $control = [] )
    {
        $control['type'] = 'checkbox';
        return $this->add( $identifier, $label, $setting, $control, 'WP_Customize_Control' );
    }


    /**
     * Register a color control in the customizer
     *
     * @param string $label Settings label
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @param string $identifier Identifier
     * @return Settings $this for chaining
     */
    public function color( string $identifier, string $label, array $setting = [], array $control = [] )
    {
        return $this->add( $identifier, $label, $setting, $control, '\WP_Customize_Color_Control' );
    }


    /**
     * Get current panel id
     *
     * @return string
     **/
    public function getCurrentPanelId()
    {
        return $this->currentPanelId;
    }


    /**
     * Get current section id
     *
     * @return string
     **/
    public function getCurrentSectionId()
    {
        return $this->currentSectionId;
    }


    /**
     * Register a file control in the customizer
     *
     * @param string $label Settings label
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @param string $identifier Identifier
     * @return Settings $this for chaining
     */
    public function file( string $identifier, string $label, array $setting = [], array $control = [] )
    {
        return $this->add( $identifier, $label, $setting, $control, '\WP_Customize_Upload_Control' );
    }


    /**
     * Register a image control in the customizer
     *
     * @param string $identifier Identifier
     * @param string $label Settings label
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @return Settings $this for chaining
     */
    public function image( string $identifier, string $label, array $setting = [], array $control = [] )
    {
        return $this->add( $identifier, $label, $setting, $control, '\WP_Customize_Image_Control' );
    }


    /**
     * Init settings in the customizer
     *
     * @param WP_Customizer $customizer Customizer instance
     * @return void
     */
    public function init( \WP_Customize_Manager $customizer )
    {

        foreach ( $this->panels as $panelId => $panel ) :

            $customizer->add_panel( $panelId, $panel);

            foreach ( $panel['sections'] as $sectionId => $section ) :

                $customizer->add_section( $sectionId, $section );

                 foreach ( $section['fields'] as $field => $config ) :

                    $customizer->add_setting( $field, $config['setting'] );

                    if ( $config['renderer'] ) :
                        $customizer->add_control( new $config['renderer'](
                            $customizer,
                            $field,
                            $config['control']
                        ) );
                        continue;
                    endif;

                    $customizer->add_control( $identifier, $config['control'] );

                endforeach;

            endforeach;

        endforeach;

    }


    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        add_action( 'customize_register', [$this, 'init'] );
    }


    /**
     * Url field
     *
     * @param string $label Settings label
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @return Settings $this for chaining
     */
    public function page( string $identifier, $label, array $setting = [], array $control = [] )
    {
        $setting['sanitize_callback'] = 'absint';
        $control['type'] = 'dropdown-pages';
        return $this->text( $identifier, $label, $setting, $control );
    }


    /**
     * Panel
     *
     * @param string $label Panel label
     * @param array $args Panel args - https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
     * 
     * @return Customize
     **/
    public function panel(string $label, array $args = []): Customize
    {
        $identifier = sanitize_title( $label );
        $this->currentPanelId = $identifier;

        $this->panels[$identifier]['title'] = $label;
        $this->panels[$identifier]['priority'] = 200;
        $this->panels[$identifier]['sections'] = [];
        $this->panels[$identifier] = array_merge($this->panels[$identifier], $args);
        return $this;
    }


    /**
     * Register a radiobutton control in the customizer
     *
     * @param string $identifier Identifier
     * @param string $label Settings label
     * @param array $choices Radio choices, Format: ['value' => 'label'] 
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @return Settings $this for chaining
     */
    public function radio( string $identifier, string $label, array $choices = [], array $setting = [], array $control = [] )
    {
        $control['type'] = 'radio';
        $control['choices'] = $choices;

        return $this->add( $identifier, $label, $setting, $control, 'WP_Customize_Control' );
    }


    /**
     * Panel
     *
     * @param string $name A unique slug-like string to use as an id.
     * @param array $args - https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
     * @return Manger $this for chaining
     **/
    public function section( string $label, $args = [] )
    {
        $identifier = sanitize_title( $label );
        $this->currentSectionId = $identifier;

        $args['title'] = $label;
        $args['panel'] = $this->getCurrentPanelId();
        $this->panels[$this->getCurrentPanelId()]['sections'][$identifier] = $args;

        return $this;
    }


    /**
     * Register a selectbox control in the customizer
     *
     * @param string $identifier Identifier
     * @param string $label Settings label
     * @param array $choices Select options, Format: ['value' => 'label'] 
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @return Settings $this for chaining
     */
    public function select( string $identifier, string $label, array $choices = [], array $setting = [], array $control = [] )
    {
        $control['type'] = 'select';
        $control['choices'] = $choices;
        return $this->add( $identifier, $label, $setting, $control, 'WP_Customize_Control' );
    }


    /**
     * Register a text control in the customizer
     *
     * @param string $identifier Identifier
     * @param string $label Settings label
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @return Settings $this for chaining
     */
    public function text( string $identifier, string $label, array $setting = [], array $control = [] )
    {
        return $this->add( $identifier, $label, $setting, $control, 'WP_Customize_Control' );
    }


    /**
     * Register a text control in the customizer
     *
     * @param string $label Settings label
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @param string $identifier Identifier
     * @return Settings $this for chaining
     */
    public function textarea( string $identifier, string $label, array $setting = [], array $control = [] )
    {
        $setting['sanitize_callback'] = 'wp_kses_post';
        $control['type'] = 'textarea';
        return $this->text( $identifier, $label, $setting, $control );
    }


    /**
     * Url field
     *
     * @param string $label Settings label
     * @param array $setting Settings args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
     * @param array $control Control args - https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
     * @return Settings $this for chaining
     */
    public function url( string $identifier, $label, array $setting = [], array $control = [] )
    {
        $setting['sanitize_callback'] = 'esc_url_raw';
        $control['type'] = 'url';
        return $this->text( $identifier, $label, $setting, $control );
    }


}

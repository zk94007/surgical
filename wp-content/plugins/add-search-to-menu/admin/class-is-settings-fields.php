<?php

/**
 * Defines plugin settings fields.
 *
 * This class defines all code necessary to manage plugin settings fields.
 *
 * @package IS
 */
class IS_Settings_Fields
{
    /**
     * Stores plugin options.
     */
    public  $opt ;
    /**
     * Stores flag to know whether new plugin options are saved.
     */
    public  $ivory_search = false ;
    /**
     * Core singleton class
     * @var self
     */
    private static  $_instance ;
    private  $is_premium_plugin = false ;
    /**
     * Instantiates the plugin by setting up the core properties and loading
     * all necessary dependencies and defining the hooks.
     *
     * The constructor uses internal functions to import all the
     * plugin dependencies, and will leverage the Ivory_Search for
     * registering the hooks and the callback functions used throughout the plugin.
     */
    public function __construct( $is = null )
    {
        $new_opt = get_option( 'ivory_search' );
        $new_opt2 = get_option( 'is_menu_search' );
        if ( !empty($new_opt) || !empty($new_opt2) ) {
            $this->ivory_search = true;
        }
        
        if ( null !== $is ) {
            $this->opt = $is;
        } else {
            $this->opt = Ivory_Search::load_options();
        }
    
    }
    
    /**
     * Gets the instance of this class.
     *
     * @return self
     */
    public static function getInstance()
    {
        if ( !self::$_instance instanceof self ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Displays settings sections having custom markup.
     */
    public function is_do_settings_sections( $page, $sec )
    {
        global  $wp_settings_sections, $wp_settings_fields ;
        if ( !isset( $wp_settings_sections[$page] ) ) {
            return;
        }
        $section = (array) $wp_settings_sections[$page][$sec];
        if ( $section['title'] ) {
            echo  "<h2>{$section['title']}</h2>\n" ;
        }
        if ( $section['callback'] ) {
            call_user_func( $section['callback'], $section );
        }
        if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) ) {
            return;
        }
        echo  '<div class="form-table search-form-editor-box">' ;
        $this->is_do_settings_fields( $page, $section['id'] );
        echo  '</div>' ;
    }
    
    /**
     * Displays settings fields having custom markup.
     */
    public function is_do_settings_fields( $page, $section )
    {
        global  $wp_settings_fields ;
        if ( !isset( $wp_settings_fields[$page][$section] ) ) {
            return;
        }
        foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
            $class = '';
            if ( !empty($field['args']['class']) ) {
                $class = ' class="' . esc_attr( $field['args']['class'] ) . '"';
            }
            
            if ( !empty($field['args']['label_for']) ) {
                echo  '<h3 scope="row"><label for="' . esc_attr( $field['args']['label_for'] ) . '">' . $field['title'] . '</label>' ;
            } else {
                echo  '<h3 scope="row">' . $field['title'] ;
            }
            
            echo  '<span class="actions"><span class="indicator ' . $field['id'] . '"></span><a class="expand" href="#">' . esc_html__( 'Expand All', 'ivory-search' ) . '</a><a class="collapse" href="#" style="display:none;">' . esc_html__( 'Collapse All', 'ivory-search' ) . '</a></span></h3><div>' ;
            call_user_func( $field['callback'], $field['args'] );
            echo  '</div>' ;
        }
    }
    
    /**
     * Registers plugin settings fields.
     */
    function register_settings_fields()
    {
        if ( !empty($GLOBALS['pagenow']) && 'options.php' === $GLOBALS['pagenow'] ) {
            if ( isset( $_POST['is_settings'] ) ) {
                add_filter( 'whitelist_options', function ( $whitelist_options ) {
                    $whitelist_options['ivory_search'][0] = 'is_settings';
                    return $whitelist_options;
                } );
            }
        }
        
        if ( !isset( $_GET['tab'] ) || 'menu-search' == $_GET['tab'] ) {
            add_settings_section(
                'ivory_search_section',
                '',
                array( $this, 'menu_search_section_desc' ),
                'ivory_search'
            );
            add_settings_field(
                'ivory_search_locations',
                __( 'Select Menu', 'ivory-search' ),
                array( $this, 'menu_locations' ),
                'ivory_search',
                'ivory_search_section'
            );
            add_settings_field(
                'ivory_search_form',
                __( 'Search Form', 'ivory-search' ),
                array( $this, 'menu_search_form' ),
                'ivory_search',
                'ivory_search_section'
            );
            add_settings_field(
                'ivory_search_style',
                __( 'Form Style', 'ivory-search' ),
                array( $this, 'menu_form_style' ),
                'ivory_search',
                'ivory_search_section'
            );
            add_settings_field(
                'ivory_search_title',
                __( 'Menu Title', 'ivory-search' ),
                array( $this, 'menu_title' ),
                'ivory_search',
                'ivory_search_section'
            );
            add_settings_field(
                'ivory_search_classes',
                __( 'Menu Classes', 'ivory-search' ),
                array( $this, 'menu_classes' ),
                'ivory_search',
                'ivory_search_section'
            );
            add_settings_field(
                'ivory_search_gcse',
                __( 'Google CSE', 'ivory-search' ),
                array( $this, 'menu_google_cse' ),
                'ivory_search',
                'ivory_search_section'
            );
            add_settings_field(
                'ivory_search_close_icon',
                __( 'Close Icon', 'ivory-search' ),
                array( $this, 'menu_close_icon' ),
                'ivory_search',
                'ivory_search_section'
            );
            register_setting( 'ivory_search', 'is_menu_search' );
        } else {
            
            if ( isset( $_GET['tab'] ) && 'settings' == $_GET['tab'] ) {
                add_settings_section(
                    'ivory_search_settings',
                    '',
                    array( $this, 'settings_section_desc' ),
                    'ivory_search'
                );
                add_settings_field(
                    'ivory_search_header',
                    __( 'Header', 'ivory-search' ),
                    array( $this, 'header' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                add_settings_field(
                    'ivory_search_footer',
                    __( 'Footer', 'ivory-search' ),
                    array( $this, 'footer' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                add_settings_field(
                    'ivory_search_display_in_header',
                    __( 'Mobile Display', 'ivory-search' ),
                    array( $this, 'menu_search_in_header' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                add_settings_field(
                    'ivory_search_css',
                    __( 'Custom CSS', 'ivory-search' ),
                    array( $this, 'custom_css' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                add_settings_field(
                    'ivory_search_stopwords',
                    __( 'Stopwords', 'ivory-search' ),
                    array( $this, 'stopwords' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                add_settings_field(
                    'ivory_search_synonyms',
                    __( 'Synonyms', 'ivory-search' ),
                    array( $this, 'synonyms' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                add_settings_field(
                    'not_load_files',
                    __( 'Not load files', 'ivory-search' ),
                    array( $this, 'plugin_files' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                add_settings_field(
                    'ivory_search_disable',
                    __( 'Disable', 'ivory-search' ),
                    array( $this, 'disable' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                add_settings_field(
                    'ivory_search_default',
                    __( 'Default Search', 'ivory-search' ),
                    array( $this, 'default_search' ),
                    'ivory_search',
                    'ivory_search_settings'
                );
                register_setting( 'ivory_search', 'is_settings' );
            }
        
        }
    
    }
    
    /**
     * Displays Search To Menu section description text.
     */
    function menu_search_section_desc()
    {
        echo  '<h4 class="panel-desc">' . __( 'Use below options to display search in menu and configure it.', 'ivory-search' ) . '</h4>' ;
    }
    
    /**
     * Displays Settings section description text.
     */
    function settings_section_desc()
    {
        echo  '<h4 class="panel-desc">' . __( 'Use below options to make sitewide changes in search.', 'ivory-search' ) . '</h4>' ;
    }
    
    /**
     * Displays choose menu locations field.
     */
    function menu_locations()
    {
        $content = __( 'Select menu here where you want to display search form.', 'ivory-search' );
        IS_Help::help_info( $content );
        $html = '';
        $menus = get_registered_nav_menus();
        
        if ( !empty($menus) ) {
            $check_value = '';
            foreach ( $menus as $location => $description ) {
                
                if ( $this->ivory_search ) {
                    $check_value = ( isset( $this->opt['menus'][$location] ) ? $this->opt['menus'][$location] : 0 );
                } else {
                    $check_value = ( isset( $this->opt['add_search_to_menu_locations'][$location] ) ? $this->opt['add_search_to_menu_locations'][$location] : 0 );
                }
                
                $html .= '<p><label for="is_menus' . esc_attr( $location ) . '"><input type="checkbox" class="ivory_search_locations" id="is_menus' . esc_attr( $location ) . '" name="is_menu_search[menus][' . esc_attr( $location ) . ']" value="' . esc_attr( $location ) . '" ' . checked( $location, $check_value, false ) . '/>';
                $html .= '<span class="toggle-check-text"></span> ' . esc_html( $description ) . '</label></p>';
            }
        } else {
            $html = __( 'No navigation menu registered on your site.', 'ivory-search' );
        }
        
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays menu search form field.
     */
    function menu_search_form()
    {
        $content = __( 'Select search form that will control search performed using menu search.', 'ivory-search' );
        IS_Help::help_info( $content );
        $html = '<p>';
        $form_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? false : true );
        if ( $form_disable ) {
            $html .= IS_Admin::pro_link();
        }
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'is_search_form',
            'order'       => 'ASC',
        );
        $posts = get_posts( $args );
        
        if ( !empty($posts) ) {
            $check_value = ( isset( $this->opt['menu_search_form'] ) ? $this->opt['menu_search_form'] : 0 );
            $check_value = ( $check_value ? $check_value : 'default' );
            $select_disable = ( $form_disable ? 'disabled' : '' );
            $html .= '<select class="ivory_search_form" ' . $select_disable . ' id="menu_search_form" name="is_menu_search[menu_search_form]" >';
            foreach ( $posts as $post ) {
                if ( 'default' === $check_value && 'Default Search Form' === $post->post_title ) {
                    $check_value = $post->ID;
                }
                $html .= '<option value="' . $post->ID . '"' . selected( $post->ID, $check_value, false ) . ' >' . $post->post_title . '</option>';
                if ( $form_disable && $post->ID === (int) $check_value ) {
                    break;
                }
            }
            $html .= '</select>';
            
            if ( $check_value && get_post_type( $check_value ) ) {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search', false ) ) . '&post=' . $check_value . '&action=edit">  ' . esc_html__( "Edit", 'ivory-search' ) . '</a>';
            } else {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search-new', false ) ) . '">  ' . esc_html__( "Create New", 'ivory-search' ) . '</a>';
            }
        
        }
        
        echo  '</p><div>' . $html . '</div>' ;
    }
    
    /**
     * Displays form style field.
     */
    function menu_form_style()
    {
        $content = __( 'Select form style for the search form displayed in the menu.', 'ivory-search' );
        IS_Help::help_info( $content );
        $styles = array(
            'default'         => __( 'Default', 'ivory-search' ),
            'dropdown'        => __( 'Dropdown', 'ivory-search' ),
            'sliding'         => __( 'Sliding', 'ivory-search' ),
            'full-width-menu' => __( 'Full Width', 'ivory-search' ),
            'popup'           => __( 'Popup', 'ivory-search' ),
        );
        $popup_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? false : true );
        if ( empty($this->opt) || !isset( $this->opt['add_search_to_menu_style'] ) && !isset( $this->opt['menu_style'] ) ) {
            $this->opt['menu_style'] = 'default';
        }
        $html = '';
        $check_value = ( isset( $this->opt['add_search_to_menu_style'] ) ? $this->opt['add_search_to_menu_style'] : 'default' );
        $check_value = ( isset( $this->opt['menu_style'] ) ? $this->opt['menu_style'] : $check_value );
        foreach ( $styles as $key => $style ) {
            
            if ( $popup_disable && 'popup' === $key ) {
                $html .= '<p class="upgrade-parent">' . IS_Admin::pro_link();
            } else {
                $html .= '<p>';
            }
            
            $html .= '<label for="is_menu_style' . esc_attr( $key ) . '"><input class="ivory_search_style" type="radio" id="is_menu_style' . esc_attr( $key ) . '" name="is_menu_search[menu_style]"';
            $html .= ( $popup_disable && 'popup' === $key ? ' disabled ' : '' );
            $html .= 'name="ivory_search[menu_style]" value="' . esc_attr( $key ) . '" ' . checked( $key, $check_value, false ) . '/>';
            $html .= '<span class="toggle-check-text"></span>' . esc_html( $style ) . '</label>';
            $html .= '</p>';
        }
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays search menu title field.
     */
    function menu_title()
    {
        $content = __( 'Displays set menu title text in place of search icon displays in navigation menu.', 'ivory-search' );
        IS_Help::help_info( $content );
        $this->opt['add_search_to_menu_title'] = ( isset( $this->opt['add_search_to_menu_title'] ) ? $this->opt['add_search_to_menu_title'] : '' );
        $this->opt['menu_title'] = ( isset( $this->opt['menu_title'] ) ? $this->opt['menu_title'] : $this->opt['add_search_to_menu_title'] );
        $html = '<input class="ivory_search_title" type="text" class="ivory_search_title" id="is_menu_title" name="is_menu_search[menu_title]" value="' . esc_attr( $this->opt['menu_title'] ) . '" />';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays search menu classes field.
     */
    function menu_classes()
    {
        $content = __( 'Adds set classes in the search navigation menu item.', 'ivory-search' );
        IS_Help::help_info( $content );
        $this->opt['add_search_to_menu_classes'] = ( isset( $this->opt['add_search_to_menu_classes'] ) ? $this->opt['add_search_to_menu_classes'] : '' );
        $this->opt['menu_classes'] = ( isset( $this->opt['menu_classes'] ) ? $this->opt['menu_classes'] : $this->opt['add_search_to_menu_classes'] );
        $html = '<input class="ivory_search_classes" type="text" class="ivory_search_classes" id="is_menu_classes" name="is_menu_search[menu_classes]" value="' . esc_attr( $this->opt['menu_classes'] ) . '" />';
        $html .= '<br /><label for="is_menu_classes" style="font-size: 10px;">' . esc_html__( "Add classes seperated by space.", 'ivory-search' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays google cse field.
     */
    function menu_google_cse()
    {
        $content = __( 'Add only Google Custom Search( CSE ) search form code in the above text box that will replace default search form.', 'ivory-search' );
        IS_Help::help_info( $content );
        $this->opt['add_search_to_menu_gcse'] = ( isset( $this->opt['add_search_to_menu_gcse'] ) ? $this->opt['add_search_to_menu_gcse'] : '' );
        $this->opt['menu_gcse'] = ( isset( $this->opt['menu_gcse'] ) ? $this->opt['menu_gcse'] : $this->opt['add_search_to_menu_gcse'] );
        $html = '<input class="ivory_search_gcse" type="text" class="large-text" id="is_menu_gcse" name="is_menu_search[menu_gcse]" value="' . esc_attr( $this->opt['menu_gcse'] ) . '" />';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays search form close icon field.
     */
    function menu_close_icon()
    {
        $check_value = ( isset( $this->opt['add_search_to_menu_close_icon'] ) ? $this->opt['add_search_to_menu_close_icon'] : 0 );
        $check_string = checked( 'add_search_to_menu_close_icon', $check_value, false );
        
        if ( $this->ivory_search ) {
            $check_value = ( isset( $this->opt['menu_close_icon'] ) ? $this->opt['menu_close_icon'] : 0 );
            $check_string = checked( 'menu_close_icon', $check_value, false );
        }
        
        $html = '<label for="menu_close_icon"><input class="ivory_search_close_icon" type="checkbox" id="menu_close_icon" name="is_menu_search[menu_close_icon]" value="menu_close_icon" ' . $check_string . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Display Search Form Close Icon', 'ivory-search' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays search form in site header.
     */
    function header()
    {
        $content = __( 'Displays search form in site header using wp_head hook.', 'ivory-search' );
        IS_Help::help_info( $content );
        $html = '';
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'is_search_form',
        );
        $posts = get_posts( $args );
        
        if ( !empty($posts) ) {
            $check_value = ( isset( $this->opt['header_search'] ) ? $this->opt['header_search'] : 0 );
            $html .= '<select class="ivory_search_header" id="is_header_search" name="is_settings[header_search]" >';
            $html .= '<option value="0" ' . selected( 0, $check_value, false ) . '>' . __( 'none', 'ivory-search' ) . '</option>';
            foreach ( $posts as $post ) {
                $html .= '<option value="' . $post->ID . '"' . selected( $post->ID, $check_value, false ) . ' >' . $post->post_title . '</option>';
            }
            $html .= '</select>';
            
            if ( $check_value && get_post_type( $check_value ) ) {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search', false ) ) . '&post=' . $check_value . '&action=edit">  ' . esc_html__( "Edit", 'ivory-search' ) . '</a>';
            } else {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search-new', false ) ) . '">  ' . esc_html__( "Create New", 'ivory-search' ) . '</a>';
            }
        
        }
        
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays search form in site footer.
     */
    function footer()
    {
        $content = __( 'Displays search form in site footer using wp_footer hook.', 'ivory-search' );
        IS_Help::help_info( $content );
        $html = '';
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'is_search_form',
        );
        $posts = get_posts( $args );
        
        if ( !empty($posts) ) {
            $check_value = ( isset( $this->opt['footer_search'] ) ? $this->opt['footer_search'] : 0 );
            $html .= '<select class="ivory_search_footer" id="is_footer_search" name="is_settings[footer_search]" >';
            $html .= '<option value="0" ' . selected( 0, $check_value, false ) . '>' . __( 'none', 'ivory-search' ) . '</option>';
            foreach ( $posts as $post ) {
                $html .= '<option value="' . $post->ID . '"' . selected( $post->ID, $check_value, false ) . ' >' . $post->post_title . '</option>';
            }
            $html .= '</select>';
            
            if ( $check_value && get_post_type( $check_value ) ) {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search', false ) ) . '&post=' . $check_value . '&action=edit">  ' . esc_html__( "Edit", 'ivory-search' ) . '</a>';
            } else {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search-new', false ) ) . '">  ' . esc_html__( "Create New", 'ivory-search' ) . '</a>';
            }
        
        }
        
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays display in header field.
     */
    function menu_search_in_header()
    {
        $content = __( 'Note: Does not work with caching as this functionality uses the WordPress wp_is_mobile function.', 'ivory-search' );
        IS_Help::help_info( $content );
        $check_value = ( isset( $this->opt['add_search_to_menu_display_in_header'] ) ? $this->opt['add_search_to_menu_display_in_header'] : 0 );
        $check_string = checked( 'add_search_to_menu_display_in_header', $check_value, false );
        
        if ( $this->ivory_search ) {
            $check_value = ( isset( $this->opt['header_menu_search'] ) ? $this->opt['header_menu_search'] : 0 );
            $check_string = checked( 'header_menu_search', $check_value, false );
        }
        
        $html = '<label for="is_search_in_header"><input class="ivory_search_display_in_header" type="checkbox" id="is_search_in_header" name="is_settings[header_menu_search]" value="header_menu_search" ' . $check_string . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Display search form in header on mobile devices', 'ivory-search' ) . '</label>';
        echo  '<div>' . $html . '</div><br />' ;
        $html = '';
        $content = __( 'Use this option to display search form in your site header and hide the search form on desktop using CSS code.', 'ivory-search' );
        IS_Help::help_info( $content );
        $check_value = ( isset( $this->opt['astm_site_uses_cache'] ) ? $this->opt['astm_site_uses_cache'] : 0 );
        $check_string = checked( 'astm_site_uses_cache', $check_value, false );
        
        if ( $this->ivory_search ) {
            $check_value = ( isset( $this->opt['site_uses_cache'] ) ? $this->opt['site_uses_cache'] : 0 );
            $check_string = checked( 'site_uses_cache', $check_value, false );
        }
        
        $html .= '<label for="is_site_uses_cache"><input class="ivory_search_display_in_header" type="checkbox" id="is_site_uses_cache" name="is_settings[site_uses_cache]" value="site_uses_cache" ' . $check_string . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'This site uses cache', 'ivory-search' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays custom css field.
     */
    function custom_css()
    {
        $content = __( 'Add custom css code if any to style search form.', 'ivory-search' );
        IS_Help::help_info( $content );
        $this->opt['add_search_to_menu_css'] = ( isset( $this->opt['add_search_to_menu_css'] ) ? $this->opt['add_search_to_menu_css'] : '' );
        $this->opt['custom_css'] = ( isset( $this->opt['custom_css'] ) ? $this->opt['custom_css'] : $this->opt['add_search_to_menu_css'] );
        $html = '<textarea class="ivory_search_css" rows="4" id="custom_css" name="is_settings[custom_css]" >' . esc_attr( $this->opt['custom_css'] ) . '</textarea>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays stopwords field.
     */
    function stopwords()
    {
        $content = __( 'Enter words here to add them to the list of stopwords. The stopwords will not be searched.', 'ivory-search' );
        $content .= '<br />' . __( 'This works with search form.', 'ivory-search' );
        IS_Help::help_info( $content );
        $this->opt['stopwords'] = ( isset( $this->opt['stopwords'] ) ? $this->opt['stopwords'] : '' );
        $html = '<textarea class="ivory_search_stopwords" rows="4" id="stopwords" name="is_settings[stopwords]" >' . esc_attr( $this->opt['stopwords'] ) . '</textarea>';
        $html .= '<br /><label for="stopwords" style="font-size: 10px;">' . esc_html__( "Please separate words with commas.", 'ivory-search' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays synonyms field.
     */
    function synonyms()
    {
        $content = __( 'Add synonyms here to make the searches find better results.', 'ivory-search' );
        $content .= '<br /><br />' . __( 'If you add bird = crow to the list of synonyms, searches for bird automatically become a search for bird crow and will thus match to posts that include either bird or crow.', 'ivory-search' );
        $content .= '<br /><br />' . __( 'This only works for search forms and in OR searches. In AND searches the synonyms only restrict the search, as now the search only finds posts that contain both bird and crow.', 'ivory-search' );
        IS_Help::help_info( $content );
        $this->opt['synonyms'] = ( isset( $this->opt['synonyms'] ) ? $this->opt['synonyms'] : '' );
        $html = '<textarea class="ivory_search_synonyms" rows="4" id="synonyms" name="is_settings[synonyms]" >' . esc_attr( $this->opt['synonyms'] ) . '</textarea>';
        $html .= '<br /><label for="synonyms" style="font-size: 10px;">' . esc_html__( 'The format here is key = value;. Please separate every synonyms key = value pairs with semicolon.', 'ivory-search' ) . '</label>';
        $synonyms_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
        $check_value = ( isset( $this->opt['synonyms_and'] ) ? $this->opt['synonyms_and'] : 0 );
        $disable = checked( 1, $check_value, false );
        
        if ( '' !== $synonyms_disable ) {
            $html .= '<p class="upgrade-parent">' . IS_Admin::pro_link();
        } else {
            $html .= '<p>';
        }
        
        $html .= '<label for="synonyms_and"><input class="ivory_search_synonyms" type="checkbox" ' . $synonyms_disable . ' id="synonyms_and" name="is_settings[synonyms_and]" value="1" ' . $disable . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Disable synonyms for the search forms having AND search terms relation.', 'ivory-search' ) . '</label>';
        echo  '</p><div>' . $html . '</div>' ;
    }
    
    /**
     * Displays do not load plugin files field.
     */
    function plugin_files()
    {
        $content = __( 'Configure to disable loading plugin CSS and JavaScript files.', 'ivory-search' );
        IS_Help::help_info( $content );
        $styles = array(
            'css' => __( 'Plugin CSS File', 'ivory-search' ),
            'js'  => __( 'Plugin JavaScript File', 'ivory-search' ),
        );
        $html = '';
        foreach ( $styles as $key => $file ) {
            $check_value = ( isset( $this->opt['do_not_load_plugin_files']["plugin-{$key}-file"] ) ? $this->opt['do_not_load_plugin_files']["plugin-{$key}-file"] : 0 );
            $check_string = checked( "plugin-{$key}-file", $check_value, false );
            
            if ( $this->ivory_search ) {
                $check_value = ( isset( $this->opt['not_load_files'][$key] ) ? $this->opt['not_load_files'][$key] : 0 );
                $check_string = checked( $key, $check_value, false );
            }
            
            $html .= '<label for="not_load_files[' . esc_attr( $key ) . ']"><input class="not_load_files" type="checkbox" id="not_load_files[' . esc_attr( $key ) . ']" name="is_settings[not_load_files][' . esc_attr( $key ) . ']" value="' . esc_attr( $key ) . '" ' . $check_string . '/>';
            $html .= '<span class="toggle-check-text"></span>' . esc_html( $file ) . '</label>';
            
            if ( 'css' == $key ) {
                $html .= '<br /><label for="not_load_files[' . esc_attr( $key ) . ']" style="font-size: 10px;">' . esc_html__( 'If checked, you have to add following plugin file code into your child theme CSS file.', 'ivory-search' ) . '</label>';
                $html .= '<br /><a style="font-size: 13px;" target="_blank" href="' . plugins_url( '/public/css/ivory-search.css', IS_PLUGIN_FILE ) . '"/a>' . plugins_url( '/public/css/ivory-search.css', IS_PLUGIN_FILE ) . '</a>';
                $html .= '<br /><br />';
            } else {
                $html .= '<br /><label for="not_load_files[' . esc_attr( $key ) . ']" style="font-size: 10px;">' . esc_html__( "If checked, you have to add following plugin files code into your child theme JavaScript file.", 'ivory-search' ) . '</label>';
                $html .= '<br /><a style="font-size: 13px;" target="_blank" href="' . plugins_url( '/public/js/ivory-search.js', IS_PLUGIN_FILE ) . '"/a>' . plugins_url( '/public/js/ivory-search.js', IS_PLUGIN_FILE ) . '</a>';
                $html .= '<br /><a style="font-size: 13px;" target="_blank" href="' . plugins_url( '/public/js/is-highlight.js', IS_PLUGIN_FILE ) . '"/a>' . plugins_url( '/public/js/is-highlight.js', IS_PLUGIN_FILE ) . '</a>';
            }
        
        }
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Disables search functionality on whole site.
     */
    function disable()
    {
        $check_value = ( isset( $this->opt['disable'] ) ? $this->opt['disable'] : 0 );
        $disable = checked( 1, $check_value, false );
        $html = '<label for="is_disable"><input class="ivory_search_disable" type="checkbox" id="is_disable" name="is_settings[disable]" value="1" ' . $disable . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Disable search functionality on whole site.', 'ivory-search' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Controls default search functionality.
     */
    function default_search()
    {
        $check_value = ( isset( $this->opt['default_search'] ) ? $this->opt['default_search'] : 0 );
        $disable = checked( 1, $check_value, false );
        $html = '<label for="is_default_search"><input class="ivory_search_default" type="checkbox" id="is_default_search" name="is_settings[default_search]" value="1" ' . $disable . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Do not use default search form to control WordPress default search functionality.', 'ivory-search' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }

}
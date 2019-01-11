<?php

/**
 * This class defines all plugin functionality for the site front end.
 *
 * @package IS
 * @since    1.0.0
 */
class IS_Public
{
    /**
     * Stores plugin options.
     */
    public  $opt ;
    /**
     * Core singleton class
     * @var self
     */
    private static  $_instance ;
    /**
     * Stores flag to know whether new plugin options are saved.
     */
    public  $ivory_search = false ;
    /**
     * Initializes this class and stores the plugin options.
     */
    public function __construct()
    {
        $is = Ivory_Search::getInstance();
        $new_opt = get_option( 'ivory_search' );
        $new_opt2 = get_option( 'is_menu_search' );
        if ( !empty($new_opt) || !empty($new_opt2) ) {
            $this->ivory_search = true;
        }
        
        if ( null !== $is ) {
            $this->opt = $is->opt;
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
     * Enqueues search menu style and script files.
     */
    function wp_enqueue_scripts()
    {
        global  $wp_query ;
        if ( ($this->ivory_search || !isset( $this->opt['do_not_load_plugin_files']['plugin-css-file'] )) && !isset( $this->opt['not_load_files']['css'] ) ) {
            wp_enqueue_style(
                'ivory-search-styles',
                plugins_url( '/public/css/ivory-search.css', IS_PLUGIN_FILE ),
                array(),
                IS_VERSION
            );
        }
        
        if ( ($this->ivory_search || !isset( $this->opt['do_not_load_plugin_files']['plugin-js-file'] )) && !isset( $this->opt['not_load_files']['js'] ) ) {
            wp_enqueue_script(
                'ivory-search-scripts',
                plugins_url( '/public/js/ivory-search.js', IS_PLUGIN_FILE ),
                array( 'jquery' ),
                IS_VERSION,
                true
            );
            if ( is_search() && isset( $wp_query->query_vars['_is_settings']['highlight_terms'] ) && 0 !== $wp_query->found_posts ) {
                wp_enqueue_script(
                    'is-highlight',
                    plugins_url( '/public/js/is-highlight.js', IS_PLUGIN_FILE ),
                    array( 'jquery' ),
                    IS_VERSION,
                    true
                );
            }
        }
        
        
        if ( is_search() && isset( $wp_query->query_vars['_is_settings']['highlight_terms'] ) && 0 !== $wp_query->found_posts ) {
            wp_enqueue_script(
                'is-highlight',
                plugins_url( '/public/js/is-highlight.js', IS_PLUGIN_FILE ),
                array( 'jquery' ),
                IS_VERSION,
                true
            );
            $areas = array(
                '#groups-dir-list',
                '#members-dir-list',
                // BuddyPress compat
                'div.bbp-topic-content,div.bbp-reply-content,li.bbp-forum-info,.bbp-topic-title,.bbp-reply-title',
                // bbPress compat
                'article',
                'div.hentry',
                'div.post',
                '#content',
                '#main',
                'div.content',
                '#middle',
                '#container',
                'div.container',
                'div.page',
                '#wrapper',
                'body',
            );
            $script = 'var is_terms = ';
            $script .= ( isset( $wp_query->query_vars['search_terms'] ) ? wp_json_encode( (array) $wp_query->query_vars['search_terms'] ) : '[]' );
            $script .= '; var is_areas = ' . wp_json_encode( (array) $areas ) . ';';
            wp_add_inline_script( 'is-highlight', $script, 'before' );
        }
    
    }
    
    /**
     * Registers search form shortcode.
     */
    function init()
    {
        add_shortcode( 'ivory-search', array( $this, 'search_form_shortcode' ) );
    }
    
    /**
     * Displays search form by processing shortcode.
     */
    function search_form_shortcode( $atts )
    {
        if ( isset( $this->opt['disable'] ) ) {
            return '';
        }
        if ( is_feed() ) {
            return '[ivory-search]';
        }
        $atts = shortcode_atts( array(
            'id'    => 0,
            'title' => '',
        ), $atts, 'ivory-search' );
        $id = (int) $atts['id'];
        $title = trim( $atts['title'] );
        
        if ( !($search_form = IS_Search_Form::get_instance( $id )) ) {
            $page = get_page_by_title( $title, OBJECT, IS_Search_Form::post_type );
            if ( $page ) {
                $search_form = IS_Search_Form::get_instance( $page->ID );
            }
        }
        
        
        if ( !$search_form ) {
            return '[ivory-search 404 "Not Found"]';
        } else {
            $settings = $search_form->prop( '_is_settings' );
            if ( isset( $settings['disable'] ) ) {
                return '';
            }
            if ( isset( $settings['demo'] ) && !current_user_can( 'administrator' ) ) {
                return '';
            }
        }
        
        return $search_form->form_html( $atts );
    }
    
    /**
     * Changes default search form.
     */
    function get_search_form( $form )
    {
        if ( isset( $this->opt['disable'] ) ) {
            return '';
        }
        if ( isset( $this->opt['default_search'] ) ) {
            return $form;
        }
        $page = get_page_by_path( 'default-search-form', OBJECT, 'is_search_form' );
        
        if ( !empty($page) ) {
            $is_id = $page->ID;
            $is_fields = get_post_meta( $is_id );
            
            if ( !empty($is_fields) ) {
                
                if ( isset( $is_fields['_is_settings'] ) ) {
                    $temp = maybe_unserialize( $is_fields['_is_settings'][0] );
                    if ( isset( $temp['disable'] ) ) {
                        return '';
                    }
                    if ( isset( $temp['demo'] ) && !current_user_can( 'administrator' ) ) {
                        return '';
                    }
                }
                
                
                if ( isset( $is_fields['_is_includes'] ) ) {
                    $temp = maybe_unserialize( $is_fields['_is_includes'][0] );
                    if ( isset( $temp['post_type_qs'] ) && 'none' !== $temp['post_type_qs'] ) {
                        $form = preg_replace( '/<\\/form>/', '<input type="hidden" name="post_type" value="' . $temp['post_type_qs'] . '" /></form>', $form );
                    }
                }
            
            }
        
        }
        
        return $form;
    }
    
    /**
     * Displays menu search form.
     * 
     * @since 4.0
     *
     * @param bool $echo Default to echo and not return the form.
     * @return string|void String when $echo is false.
     */
    function get_menu_search_form( $echo = true )
    {
        /**
         * Fires before the search form is retrieved, at the start of get_search_form().
         */
        do_action( 'pre_get_menu_search_form' );
        remove_filter( 'get_search_form', array( IS_Public::getInstance(), 'get_search_form' ), 99 );
        $form = get_search_form( false );
        add_filter( 'get_search_form', array( IS_Public::getInstance(), 'get_search_form' ), 99 );
        /**
         * Filters the HTML output of the search form.
         *
         * @param string $form The search form HTML output.
         */
        $result = apply_filters( 'get_menu_search_form', $form );
        $result = preg_replace( '/<\\/form>/', '<input type="hidden" name="id" value="m" /></form>', $result );
        $menu_search_form = ( isset( $this->opt['menu_search_form'] ) ? $this->opt['menu_search_form'] : 0 );
        
        if ( !$menu_search_form ) {
            $page = get_page_by_path( 'default-search-form', OBJECT, 'is_search_form' );
            if ( !empty($page) ) {
                $menu_search_form = $page->ID;
            }
        }
        
        
        if ( $menu_search_form ) {
            $is_fields = get_post_meta( $menu_search_form );
            
            if ( !empty($is_fields) ) {
                
                if ( isset( $is_fields['_is_includes'] ) ) {
                    $temp = maybe_unserialize( $is_fields['_is_includes'][0] );
                    if ( isset( $temp['post_type_qs'] ) && 'none' !== $temp['post_type_qs'] ) {
                        $result = preg_replace( '/<\\/form>/', '<input type="hidden" name="post_type" value="' . $temp['post_type_qs'] . '" /></form>', $result );
                    }
                }
                
                
                if ( isset( $is_fields['_is_settings'] ) ) {
                    $temp = maybe_unserialize( $is_fields['_is_settings'][0] );
                    if ( isset( $temp['disable'] ) ) {
                        return '';
                    }
                    if ( isset( $temp['demo'] ) && !current_user_can( 'administrator' ) ) {
                        return '';
                    }
                }
            
            }
        
        }
        
        if ( null === $result ) {
            $result = $form;
        }
        
        if ( $echo ) {
            echo  $result ;
        } else {
            return $result;
        }
    
    }
    
    /**
     * Displays search form in the navigation bar in the front end of site.
     */
    function wp_nav_menu_items( $items, $args )
    {
        if ( isset( $this->opt['add_search_to_menu_locations'] ) && isset( $this->opt['add_search_to_menu_locations'][$args->theme_location] ) && !$this->ivory_search || isset( $this->opt['menus'] ) && isset( $this->opt['menus'][$args->theme_location] ) ) {
            
            if ( isset( $this->opt['menu_gcse'] ) && '' != $this->opt['menu_gcse'] ) {
                $items .= '<li class="gsc-cse-search-menu">' . $this->opt['menu_gcse'] . '</li>';
            } else {
                
                if ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_gcse'] ) && '' != $this->opt['add_search_to_menu_gcse'] ) {
                    $items .= '<li class="gsc-cse-search-menu">' . $this->opt['add_search_to_menu_gcse'] . '</li>';
                } else {
                    $search_class = ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_classes'] ) ? $this->opt['add_search_to_menu_classes'] . ' astm-search-menu is-menu ' : 'astm-search-menu is-menu ' );
                    $search_class = ( isset( $this->opt['menu_classes'] ) ? $this->opt['menu_classes'] . ' astm-search-menu is-menu ' : $search_class );
                    
                    if ( isset( $this->opt['menu_style'] ) ) {
                        $search_class .= $this->opt['menu_style'];
                    } else {
                        $search_class .= ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_style'] ) ? $this->opt['add_search_to_menu_style'] : 'default' );
                    }
                    
                    
                    if ( isset( $this->opt['menu_title'] ) ) {
                        $title = $this->opt['menu_title'];
                    } else {
                        $title = ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_title'] ) ? $this->opt['add_search_to_menu_title'] : '' );
                    }
                    
                    $items .= '<li class="' . esc_attr( $search_class ) . '">';
                    
                    if ( isset( $this->opt['add_search_to_menu_style'] ) && $this->opt['add_search_to_menu_style'] != 'default' && !$this->ivory_search || isset( $this->opt['menu_style'] ) && $this->opt['menu_style'] != 'default' ) {
                        $items .= '<a title="' . esc_attr( $title ) . '" href="#">';
                        
                        if ( '' == $title ) {
                            $items .= '<svg width="20" height="20" class="search-icon" role="img" viewBox="2 9 20 5">
						<path class="search-icon-path" d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>';
                        } else {
                            $items .= $title;
                        }
                        
                        $items .= '</a>';
                    }
                    
                    
                    if ( !isset( $this->opt['menu_style'] ) || $this->opt['menu_style'] !== 'popup' ) {
                        $items .= $this->get_menu_search_form( false );
                        if ( isset( $this->opt['add_search_to_menu_close_icon'] ) && $this->opt['add_search_to_menu_close_icon'] && !$this->ivory_search || isset( $this->opt['menu_close_icon'] ) && $this->opt['menu_close_icon'] ) {
                            $items .= '<div class="search-close"></div>';
                        }
                    }
                    
                    $items .= '</li>';
                }
            
            }
        
        }
        return $items;
    }
    
    /**
     * Displays search form in mobile header in the front end of site.
     */
    function header_menu_search()
    {
        $items = '';
        
        if ( isset( $this->opt['menu_gcse'] ) && $this->opt['menu_gcse'] != '' ) {
            $items .= '<div class="astm-search-menu-wrapper is-menu-wrapper"><div class="gsc-cse-search-menu">' . $this->opt['menu_gcse'] . '</div></div>';
        } else {
            
            if ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_gcse'] ) && $this->opt['add_search_to_menu_gcse'] != '' ) {
                $items .= '<div class="astm-search-menu-wrapper is-menu-wrapper"><div class="gsc-cse-search-menu">' . $this->opt['add_search_to_menu_gcse'] . '</div></div>';
            } else {
                $search_class = ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_classes'] ) ? $this->opt['add_search_to_menu_classes'] . ' astm-search-menu is-menu ' : 'astm-search-menu is-menu ' );
                $search_class = ( isset( $this->opt['menu_classes'] ) ? $this->opt['menu_classes'] . ' astm-search-menu is-menu ' : $search_class );
                
                if ( isset( $this->opt['menu_style'] ) ) {
                    $search_class .= $this->opt['menu_style'];
                } else {
                    $search_class .= ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_style'] ) ? $this->opt['add_search_to_menu_style'] : 'default' );
                }
                
                
                if ( isset( $this->opt['menu_title'] ) ) {
                    $title = $this->opt['menu_title'];
                } else {
                    $title = ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_title'] ) ? $this->opt['add_search_to_menu_title'] : '' );
                }
                
                $items .= '<div class="astm-search-menu-wrapper is-menu-wrapper"><div>';
                $items .= '<span class="' . esc_attr( $search_class ) . '">';
                
                if ( isset( $this->opt['add_search_to_menu_style'] ) && $this->opt['add_search_to_menu_style'] != 'default' && !$this->ivory_search || isset( $this->opt['menu_style'] ) && $this->opt['menu_style'] != 'default' ) {
                    $items .= '<a title="' . esc_attr( $title ) . '" href="#">';
                    
                    if ( '' == $title ) {
                        $items .= '<svg width="20" height="20" class="search-icon" role="img" viewBox="2 9 20 5">
					<path class="search-icon-path" d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>';
                    } else {
                        $items .= $title;
                    }
                    
                    $items .= '</a>';
                }
                
                
                if ( !isset( $this->opt['menu_style'] ) || $this->opt['menu_style'] !== 'popup' ) {
                    $items .= $this->get_menu_search_form( false );
                    if ( isset( $this->opt['add_search_to_menu_close_icon'] ) && $this->opt['add_search_to_menu_close_icon'] && !$this->ivory_search || isset( $this->opt['menu_close_icon'] ) && $this->opt['menu_close_icon'] ) {
                        $items .= '<div class="search-close"></div>';
                    }
                }
                
                $items .= '</span></div></div>';
            }
        
        }
        
        echo  $items ;
    }
    
    /**
     * Adds query vars to searches.
     */
    function query_vars( $vars )
    {
        $vars[] = "id";
        return $vars;
    }
    
    /**
     * Filters search after the query variable object is created, but before the actual query is run.
     */
    function pre_get_posts( $query )
    {
        if ( is_admin() || !$query->is_main_query() || !$query->is_search() ) {
            return;
        }
        global  $wp_query ;
        $q = $wp_query->query_vars;
        $is_id = get_query_var( 'id' );
        
        if ( 'm' === $is_id ) {
            $check_value = ( isset( $this->opt['menu_search_form'] ) ? $this->opt['menu_search_form'] : 0 );
            
            if ( !$check_value ) {
                $page = get_page_by_path( 'default-search-form', OBJECT, 'is_search_form' );
                if ( !empty($page) ) {
                    $is_id = $page->ID;
                }
            }
        
        }
        
        
        if ( '' === $is_id ) {
            if ( isset( $this->opt['default_search'] ) ) {
                return;
            }
            $page = get_page_by_path( 'default-search-form', OBJECT, 'is_search_form' );
            if ( !empty($page) ) {
                $is_id = $page->ID;
            }
        }
        
        
        if ( '' !== $is_id && is_numeric( $is_id ) ) {
            
            if ( isset( $this->opt['stopwords'] ) && '' !== $q['s'] ) {
                $stopwords = explode( ',', $this->opt['stopwords'] );
                $stopwords = array_map( 'trim', $stopwords );
                $q['s'] = preg_replace( '/\\b(' . implode( '|', $stopwords ) . ')\\b/', '', $q['s'] );
                $wp_query->query_vars['s'] = trim( preg_replace( '/\\s\\s+/', ' ', str_replace( "\n", " ", $q['s'] ) ) );
            }
            
            $is_fields = get_post_meta( $is_id );
            if ( !empty($is_fields) ) {
                foreach ( $is_fields as $key => $val ) {
                    
                    if ( isset( $val[0] ) && '' !== $val[0] ) {
                        $temp = maybe_unserialize( $val[0] );
                        $wp_query->query_vars[$key] = $temp;
                        switch ( $key ) {
                            case '_is_includes':
                                
                                if ( !empty($temp) ) {
                                    $temp = apply_filters( 'is_pre_get_posts_includes', $temp );
                                    foreach ( $temp as $inc_key => $inc_val ) {
                                        if ( is_array( $inc_val ) && !empty($inc_val) || '' !== $inc_val ) {
                                            switch ( $inc_key ) {
                                                case 'post__in':
                                                    $query->set( $inc_key, array_values( $inc_val ) );
                                                    break;
                                                case 'post_type':
                                                    
                                                    if ( !isset( $q['post_type'] ) || NULL == $q['post_type'] ) {
                                                        $pt_val = array_values( $inc_val );
                                                        $query->set( $inc_key, $pt_val );
                                                    } else {
                                                        $query->set( $inc_key, $q['post_type'] );
                                                    }
                                                    
                                                    if ( in_array( 'attachment', $inc_val ) ) {
                                                        $query->set( 'post_status', array( 'publish', 'inherit' ) );
                                                    }
                                                    break;
                                                case 'tax_query':
                                                    $tax_args = ( isset( $temp['tax_rel'] ) && 'OR' === $temp['tax_rel'] ? 'OR' : 'AND' );
                                                    $tax_args = array(
                                                        'relation' => $tax_args,
                                                    );
                                                    foreach ( $inc_val as $tax_key => $tax_val ) {
                                                        
                                                        if ( !empty($tax_val) ) {
                                                            $tax_arr = array(
                                                                'taxonomy' => $tax_key,
                                                                'field'    => 'term_taxonomy_id',
                                                                'terms'    => array_values( $tax_val ),
                                                            );
                                                            $tax_arr['post_type'] = $temp['tax_post_type'][$tax_key];
                                                            array_push( $tax_args, $tax_arr );
                                                        }
                                                    
                                                    }
                                                    $query->set( $inc_key, $tax_args );
                                                    break;
                                                case 'author':
                                                    break;
                                                case 'date_query':
                                                    foreach ( $inc_val as $key => $value ) {
                                                        foreach ( $value as $key2 => $value2 ) {
                                                            if ( $key2 === $value2 ) {
                                                                unset( $inc_val[$key][$key2] );
                                                            }
                                                        }
                                                    }
                                                    
                                                    if ( !empty($inc_val['before']) || !empty($inc_val['after']) ) {
                                                        $date_args = array_merge( array(
                                                            'inclusive' => true,
                                                        ), $inc_val );
                                                        $query->set( $inc_key, $date_args );
                                                    }
                                                    
                                                    break;
                                                case 'has_password':
                                                    $temp = ( '1' === $inc_val ? true : FALSE );
                                                    if ( 'null' !== $inc_val ) {
                                                        $query->set( $inc_key, $temp );
                                                    }
                                                    break;
                                                case 'post_status':
                                                    break;
                                                case 'comment_count':
                                                    break;
                                                case 'post_file_type':
                                                    break;
                                            }
                                        }
                                    }
                                }
                                
                                break;
                            case '_is_excludes':
                                
                                if ( !empty($temp) ) {
                                    $temp = apply_filters( 'is_pre_get_posts_excludes', $temp );
                                    foreach ( $temp as $inc_key => $inc_val ) {
                                        if ( is_array( $inc_val ) && !empty($inc_val) || '' !== $inc_val ) {
                                            switch ( $inc_key ) {
                                                case 'post__not_in':
                                                case 'ignore_sticky_posts':
                                                    $values = array();
                                                    if ( isset( $wp_query->query_vars['_is_excludes']['ignore_sticky_posts'] ) ) {
                                                        $values = get_option( 'sticky_posts' );
                                                    }
                                                    if ( isset( $wp_query->query_vars['_is_excludes']['post__not_in'] ) ) {
                                                        $values = array_merge( $values, array_values( $wp_query->query_vars['_is_excludes']['post__not_in'] ) );
                                                    }
                                                    $query->set( 'post__not_in', $values );
                                                    break;
                                                case 'tax_query':
                                                    
                                                    if ( !isset( $wp_query->query_vars['tax_query'] ) ) {
                                                        $tax_args = array();
                                                        foreach ( $inc_val as $tax_key => $tax_val ) {
                                                            
                                                            if ( !empty($tax_val) ) {
                                                                $tax_arr = array(
                                                                    'taxonomy' => $tax_key,
                                                                    'field'    => 'term_taxonomy_id',
                                                                    'terms'    => array_values( $tax_val ),
                                                                    'operator' => 'NOT IN',
                                                                );
                                                                array_push( $tax_args, $tax_arr );
                                                            }
                                                        
                                                        }
                                                        
                                                        if ( !empty($tax_args) ) {
                                                            array_push( $tax_args, array(
                                                                'relation' => 'AND',
                                                            ) );
                                                            $query->set( $inc_key, $tax_args );
                                                        }
                                                    
                                                    }
                                                    
                                                    break;
                                                case 'author':
                                                    break;
                                                case 'woo':
                                                    break;
                                            }
                                        }
                                    }
                                }
                                
                                break;
                            case '_is_settings':
                                
                                if ( !empty($temp) ) {
                                    $temp = apply_filters( 'is_pre_get_posts_settings', $temp );
                                    foreach ( $temp as $inc_key => $inc_val ) {
                                        if ( is_array( $inc_val ) && !empty($inc_val) || '' !== $inc_val ) {
                                            switch ( $inc_key ) {
                                                case 'posts_per_page':
                                                    $query->set( $inc_key, $inc_val );
                                                    break;
                                                case 'move_sticky_posts':
                                                    if ( !$query->is_paged() && !isset( $wp_query->query_vars['_is_excludes']['ignore_sticky_posts'] ) ) {
                                                        add_filter(
                                                            'the_posts',
                                                            function ( $posts ) {
                                                            
                                                            if ( !empty($posts) ) {
                                                                $sticky_posts = array();
                                                                foreach ( $posts as $key => $post ) {
                                                                    
                                                                    if ( is_sticky( $post->ID ) ) {
                                                                        $sticky_posts[] = $post;
                                                                        unset( $posts[$key] );
                                                                    }
                                                                
                                                                }
                                                                if ( !empty($sticky_posts) ) {
                                                                    $posts = array_merge( $sticky_posts, array_values( $posts ) );
                                                                }
                                                            }
                                                            
                                                            return $posts;
                                                        },
                                                            99,
                                                            2
                                                        );
                                                    }
                                                    break;
                                                case 'order':
                                                    break;
                                                case 'orderby':
                                                    break;
                                                case 'empty_search':
                                                    // If 's' request variable is set but empty
                                                    
                                                    if ( isset( $wp_query->query_vars['s'] ) && empty($wp_query->query_vars['s']) ) {
                                                        $wp_query->is_home = false;
                                                        $wp_query->is_404 = true;
                                                    }
                                                    
                                                    break;
                                            }
                                        }
                                    }
                                }
                                
                                break;
                        }
                    }
                
                }
            }
        }
        
        do_action( 'is_pre_get_posts', $query );
    }
    
    /**
     * Requests distinct results
     * 
     * @return string $distinct
     */
    function posts_distinct_request( $distinct )
    {
        global  $wp_query ;
        if ( !is_admin() && !empty($wp_query->query_vars['s']) ) {
            return 'DISTINCT';
        }
        return $distinct;
    }
    
    /**
     * Filters the search SQL that is used in the WHERE clause of WP_Query.
     */
    function posts_search( $search, $wp_query )
    {
        $q = $wp_query->query_vars;
        
        if ( empty($q['search_terms']) || is_admin() || !isset( $q['_is_includes'] ) ) {
            return $search;
            // skip processing
        }
        
        $terms_relation_type = 'AND';
        $use_synonyms = true;
        
        if ( isset( $this->opt['synonyms'] ) && $use_synonyms ) {
            $pairs = explode( ';', $this->opt['synonyms'] );
            foreach ( $pairs as $pair ) {
                if ( empty($pair) ) {
                    // Skip empty rows.
                    continue;
                }
                $parts = explode( '=', $pair );
                $key = strval( trim( $parts[0] ) );
                $value = trim( $parts[1] );
                if ( in_array( $key, (array) $q['search_terms'] ) && !in_array( $value, (array) $q['search_terms'] ) ) {
                    array_push( $q['search_terms'], $value );
                }
                if ( in_array( $value, (array) $q['search_terms'] ) && !in_array( $key, (array) $q['search_terms'] ) ) {
                    array_push( $q['search_terms'], $key );
                }
            }
            $wp_query->query_vars['search_terms'] = $q['search_terms'];
        }
        
        global  $wpdb ;
        $f = '%';
        $l = '%';
        $like = 'LIKE';
        
        if ( isset( $q['_is_settings']['fuzzy_match'] ) && '2' !== $q['_is_settings']['fuzzy_match'] ) {
            $like = 'REGEXP';
            $f = "[[:<:]]";
            $l = "[[:>:]]";
        }
        
        $searchand = '';
        $search = " AND ( ";
        $OR = '';
        foreach ( (array) $q['search_terms'] as $term ) {
            $term = $f . $wpdb->esc_like( $term ) . $l;
            $OR = '';
            $search .= "{$searchand} (";
            
            if ( isset( $q['_is_includes']['search_title'] ) ) {
                $search .= $wpdb->prepare( "({$wpdb->posts}.post_title {$like} '%s')", $term );
                $OR = ' OR ';
            }
            
            
            if ( isset( $q['_is_includes']['search_content'] ) ) {
                $search .= $OR;
                $search .= $wpdb->prepare( "({$wpdb->posts}.post_content {$like} '%s')", $term );
                $OR = ' OR ';
            }
            
            
            if ( isset( $q['_is_includes']['search_excerpt'] ) ) {
                $search .= $OR;
                $search .= $wpdb->prepare( "({$wpdb->posts}.post_excerpt {$like} '%s')", $term );
                $OR = ' OR ';
            }
            
            
            if ( isset( $q['_is_includes']['search_tax_title'] ) || isset( $q['_is_includes']['search_tax_desp'] ) ) {
                $tax_OR = '';
                $search .= $OR;
                $search .= '( ';
                
                if ( isset( $q['_is_includes']['search_tax_title'] ) ) {
                    $search .= $wpdb->prepare( "( t.name {$like} '%s' )", $term );
                    $tax_OR = ' OR ';
                }
                
                
                if ( isset( $q['_is_includes']['search_tax_desp'] ) ) {
                    $search .= $tax_OR;
                    $search .= $wpdb->prepare( "( tt.description {$like} '%s' )", $term );
                }
                
                $search .= ' )';
                $OR = ' OR ';
            }
            
            
            if ( isset( $q['_is_includes']['search_comment'] ) ) {
                $search .= $OR;
                $search .= $wpdb->prepare( "(cm.comment_content {$like} '%s')", $term );
                $OR = ' OR ';
            }
            
            
            if ( isset( $q['_is_includes']['search_author'] ) ) {
                $search .= $OR;
                $search .= $wpdb->prepare( "(users.display_name {$like} '%s')", $term );
                $OR = ' OR ';
            }
            
            
            if ( isset( $q['_is_includes']['custom_field'] ) ) {
                $meta_key_OR = '';
                $search .= $OR;
                foreach ( $q['_is_includes']['custom_field'] as $key_slug ) {
                    $search .= $wpdb->prepare( "{$meta_key_OR} (pm.meta_key = '%s' AND pm.meta_value {$like} '%s')", $key_slug, $term );
                    $meta_key_OR = ' OR ';
                }
                $OR = ' OR ';
            }
            
            $search .= ")";
            $searchand = " {$terms_relation_type} ";
        }
        if ( '' === $OR ) {
            $search = " AND ( 0 ";
        }
        $search = apply_filters( 'is_posts_search_terms', $search, $q['search_terms'] );
        $search .= ")";
        if ( isset( $q['post_type'] ) && NULL !== $q['post_type'] && !is_array( $q['post_type'] ) ) {
            $q['post_type'] = array( $q['post_type'] );
        }
        
        if ( isset( $q['_is_includes']['tax_query'] ) && count( $q['post_type'] ) > 1 ) {
            $search .= " AND ( ( ";
            $OR = '';
            $i = 0;
            $tax_post_type = $q['post_type'];
            foreach ( $q['tax_query'] as $value ) {
                
                if ( isset( $value['terms'] ) ) {
                    $tax_post_type = array_diff( $tax_post_type, array( $value['post_type'] ) );
                    
                    if ( 'OR' === $q['tax_query']['relation'] ) {
                        $search .= $OR;
                        $search .= "tr.term_taxonomy_id IN (" . implode( ',', $value['terms'] ) . ')';
                        $OR = " " . $q['tax_query']['relation'] . " ";
                    } else {
                        foreach ( $value['terms'] as $term2 ) {
                            $alias = ( $i ? 'tr' . $i : 'tr' );
                            $search .= $OR;
                            $search .= "{$alias}.term_taxonomy_id = " . $term2;
                            $OR = " " . $q['tax_query']['relation'] . " ";
                            $i++;
                        }
                    }
                
                }
            
            }
            $search .= ")";
            if ( !empty($tax_post_type) ) {
                $search .= " OR {$wpdb->posts}.post_type IN ('" . join( "', '", array_map( 'esc_sql', $tax_post_type ) ) . "')";
            }
            $search .= ")";
            $wp_query->query_vars['tax_query'] = '';
        }
        
        
        if ( isset( $q['_is_excludes']['tax_query'] ) ) {
            $AND = '';
            $search .= " AND ( ";
            foreach ( $q['_is_excludes']['tax_query'] as $value ) {
                $search .= $AND;
                $search .= "( wp_posts.ID NOT IN ( SELECT object_id FROM wp_term_relationships WHERE term_taxonomy_id IN ( " . implode( ',', $value ) . ") ) )";
                $AND = " AND ";
            }
            $search .= ")";
        }
        
        $search = apply_filters( 'is_posts_search', $search );
        return $search;
    }
    
    /**
     * Filters the JOIN clause of the query.
     */
    function posts_join( $join )
    {
        global  $wp_query, $wpdb ;
        $q = $wp_query->query_vars;
        if ( empty($q['s']) || !isset( $q['_is_includes'] ) ) {
            return $join;
        }
        if ( isset( $q['_is_includes']['search_comment'] ) ) {
            $join .= " LEFT JOIN {$wpdb->comments} AS cm ON ( {$wpdb->posts}.ID = cm.comment_post_ID AND cm.comment_approved =  '1') ";
        }
        if ( isset( $q['_is_includes']['search_author'] ) ) {
            $join .= " LEFT JOIN {$wpdb->users} users ON ({$wpdb->posts}.post_author = users.ID) ";
        }
        $woo_sku = false;
        $exc_custom_fields = false;
        if ( class_exists( 'WooCommerce' ) && is_fs()->is_plan_or_trial__premium_only( 'pro_plus' ) ) {
            $woo_sku = ( isset( $q['_is_includes']['woo']['sku'] ) ? true : false );
        }
        if ( isset( $q['_is_includes']['custom_field'] ) || $exc_custom_fields || $woo_sku ) {
            $join .= " LEFT JOIN {$wpdb->postmeta} pm ON ({$wpdb->posts}.ID = pm.post_id) ";
        }
        $tt_table = ( isset( $q['_is_includes']['search_tax_title'] ) || isset( $q['_is_includes']['search_tax_desp'] ) ? true : false );
        $i = 0;
        if ( isset( $q['_is_includes']['tax_query'] ) || isset( $q['_is_excludes']['tax_query'] ) || $tt_table ) {
            
            if ( isset( $q['_is_includes']['tax_rel'] ) && 'AND' === $q['_is_includes']['tax_rel'] && isset( $q['_is_includes']['tax_query'] ) ) {
                foreach ( $q['_is_includes']['tax_query'] as $value ) {
                    if ( !empty($value) ) {
                        foreach ( $value as $terms ) {
                            $alias = ( $i ? 'tr' . $i : 'tr' );
                            $join .= " LEFT JOIN {$wpdb->term_relationships} AS {$alias}";
                            $join .= " ON ({$wpdb->posts}.ID = {$alias}.object_id)";
                            $i++;
                        }
                    }
                }
            } else {
                $join .= " LEFT JOIN {$wpdb->term_relationships} AS tr ON ({$wpdb->posts}.ID = tr.object_id) ";
            }
        
        }
        
        if ( $tt_table ) {
            $join .= " LEFT JOIN {$wpdb->term_taxonomy} AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id) ";
            $join .= " LEFT JOIN {$wpdb->terms} AS t ON (tt.term_id = t.term_id) ";
        }
        
        $join = apply_filters( 'is_posts_join', $join );
        return $join;
    }
    
    /**
     * Adds code in the header of site front end.
     */
    function wp_head()
    {
        if ( isset( $this->opt['header_search'] ) && $this->opt['header_search'] ) {
            echo  do_shortcode( '[ivory-search id="' . $this->opt['header_search'] . '"]' ) ;
        }
    }
    
    /**
     * Adds code in the footer of site front end.
     */
    function wp_footer()
    {
        
        if ( isset( $this->opt['custom_css'] ) && $this->opt['custom_css'] != '' ) {
            echo  '<style type="text/css" media="screen">' ;
            echo  '/* Ivory search custom CSS code */' ;
            echo  wp_specialchars_decode( esc_html( $this->opt['custom_css'] ), ENT_QUOTES ) ;
            echo  '</style>' ;
        } else {
            
            if ( !$this->ivory_search && isset( $this->opt['add_search_to_menu_css'] ) && $this->opt['add_search_to_menu_css'] != '' ) {
                echo  '<style type="text/css" media="screen">' ;
                echo  '/* Add search to menu custom CSS code */' ;
                echo  wp_specialchars_decode( esc_html( $this->opt['add_search_to_menu_css'] ), ENT_QUOTES ) ;
                echo  '</style>' ;
            }
        
        }
        
        global  $wp_query ;
        
        if ( is_search() && isset( $wp_query->query_vars['_is_settings']['highlight_terms'] ) && isset( $wp_query->query_vars['_is_settings']['highlight_color'] ) ) {
            echo  '<style type="text/css" media="screen">' ;
            echo  '.is-highlight { background-color: ' . $wp_query->query_vars['_is_settings']['highlight_color'] . ';}' ;
            echo  '</style>' ;
        }
        
        if ( isset( $this->opt['footer_search'] ) && $this->opt['footer_search'] ) {
            echo  do_shortcode( '[ivory-search id="' . $this->opt['footer_search'] . '"]' ) ;
        }
    }

}
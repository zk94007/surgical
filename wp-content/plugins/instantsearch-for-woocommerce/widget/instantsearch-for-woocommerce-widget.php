<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class WCISPluginWidget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {

        parent::__construct('isp_search_box_widget',
            __( 'InstantSearch+ Search Box', 'WCISPlugin' ),
            array('description' => __( 'InstantSearch+ search box for your site', 'WCISPlugin' ),
                'classname' => 'widget_isp_search_box_widget')
        );
    }

    public static $default_search_box_fields = array(
        'search_box_width'  	=> 10,
        'search_box_height'		=> 2.3,
        'search_box_inner_text'	=> 'Search...',
        'search_box_float'		=> 'none',
        'search_box_text_size'  => 1,
        'search_box_units'      => 'rem'
    );

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        $title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';

        echo $args['before_widget'];
        if ( !empty($title) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        if (array_key_exists('search_box_width', $instance) && is_numeric($instance['search_box_width']) && $instance['search_box_width'] != 0)
            $search_box_width = $instance['search_box_width'];
        else
            $search_box_width = self::$default_search_box_fields['search_box_width'];
        if (array_key_exists('search_box_height', $instance) && is_numeric($instance['search_box_height']) && $instance['search_box_height'] != 0)
            $search_box_height = $instance['search_box_height'];
        else
            $search_box_height = self::$default_search_box_fields['search_box_height'];
        $search_box_inner_text = (array_key_exists('search_box_inner_text', $instance)) ?
            $instance['search_box_inner_text'] :
            self::$default_search_box_fields['search_box_inner_text'];
        $search_box_float = (array_key_exists('search_box_float', $instance)) ?
            $instance['search_box_float'] :
            self::$default_search_box_fields['search_box_float'];


        $action_url = esc_url(home_url('/'));
        $query_term = 's';
        $premium_serp_enabled = false;
        $options = get_option( 'wcis_general_settings' );
        if ($options && array_key_exists('serp_page_id', $options) && array_key_exists('is_serp_enabled', $options) && $options['is_serp_enabled']){
            $action_url = esc_url(str_replace(home_url(), "", get_permalink($options['serp_page_id'])));
            $premium_serp_enabled = true;
            $query_term = 'q';
        }

        $search_box_units = (array_key_exists('search_box_units', $instance)) ?
            $instance['search_box_units'] :
            self::$default_search_box_fields['search_box_units'];
        $search_box_width_form = $search_box_width;
        $search_box_width_input = $search_box_width;
        if ($search_box_units != 'rem'){
            $search_box_units = '%%';
            $search_box_width_input = '100';
        }

        $form =     '<form class="isp_search_box_form" isp_src="widget" name="isp_search_box" action="' . $action_url . '" style="width:'.$search_box_width_form.$search_box_units.'; float:'.$search_box_float.';">';
        $form .=        '<input type="text" name="' . $query_term . '" class="isp_search_box_input" placeholder="'.$search_box_inner_text.'" autocomplete="off" autocorrect="off" autocapitalize="off" style="outline: none; width:'.$search_box_width_input.$search_box_units.'; height:'.$search_box_height.$search_box_units.';">';
        if (!$premium_serp_enabled){
            $form .= 		'<input type="hidden" name="post_type" value="product" />';
        }
        $form .=       	'<input type="image" src="'. plugins_url('assets/images/magnifying_glass.png', __FILE__ ) .'" class="isp_widget_btn" value="" />';
        $form .=    '</form>';
        $form .=    '<style>form.isp_search_box_form{position:relative}form.isp_search_box_form input[type=text].isp_search_box_input{background:#fff;border:2px solid #C9CCCF;box-shadow:none;font-size:1em;padding:.5em 2em .5em 1em;margin:.2rem;font-family:inherit;box-sizing:border-box;opacity:.8;color:#60626b;border-radius:1000px;-webkit-border-radius:1000px;-moz-border-radius:1000px;-webkit-transition:border .5s,opacity .5s;-moz-transition:border .5s,opacity .5s;transition:border .5s,opacity .5s;float:none;display:block;max-width:100%}form.isp_search_box_form input[type=text].isp_search_box_input:focus{border:2px solid #707780;opacity:1}.isp_search_box_form input[type=image].isp_widget_btn{border:none;right:7px;top:calc(50% - 8px);padding:0;margin:0;position:absolute;opacity:.5}.isp_search_box_form input[type=image].isp_widget_btn:hover{opacity:1}</style>';
        echo $form;

        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        $search_box_width = (array_key_exists('search_box_width', $instance)) ?
            $instance['search_box_width'] :
            self::$default_search_box_fields['search_box_width'];
        $search_box_height = (array_key_exists('search_box_height', $instance)) ?
            $instance['search_box_height'] :
            self::$default_search_box_fields['search_box_height'];
        $search_box_inner_text = (array_key_exists('search_box_inner_text', $instance)) ?
            $instance['search_box_inner_text'] :
            self::$default_search_box_fields['search_box_inner_text'];
        $search_box_float = (array_key_exists('search_box_float', $instance)) ?
            $instance['search_box_float'] :
            self::$default_search_box_fields['search_box_float'];

        $search_box_units = (array_key_exists('search_box_units', $instance)) ?
            $instance['search_box_units'] :
            self::$default_search_box_fields['search_box_units'];

        $search_box_units_checked_rem = '';
        $search_box_units_checked_percent = '';
        if ($search_box_units == 'rem'){
            $search_box_units_checked_rem = 'checked';
        } else if ($search_box_units == 'percent'){
            $search_box_units_checked_percent = 'checked';
        }

        $float_selecte = '';
        $options = array('none', 'left', 'right');
        foreach ($options as $value){
            if ($value == $search_box_float)
                $float_selecte .= '<option value="'.$value.'" selected>'.$value.'</option>';
            else
                $float_selecte .= '<option value="'.$value.'">'.$value.'</option>';
        }

        $form = '
			<p>
				<label for="'. $this->get_field_id('search_box_inner_text') .'">'. __('Search box inner text: ', 'WCISPlugin'). '</label>
				<input type="text" class="widefat" id="'. $this->get_field_id('search_box_inner_text') .'" name="'. $this->get_field_name('search_box_inner_text') .'" value="'.  esc_attr($search_box_inner_text) .'"/>
			</p>
			<p>
				<label for="'. $this->get_field_id('search_box_width') .'">'. __('Width - search box size: ', 'WCISPlugin'). '</label>
				<input type="text" class="widefat" id="'. $this->get_field_id('search_box_width') .'" name="'. $this->get_field_name('search_box_width') .'" value="'.  esc_attr($search_box_width) .'"/>
			</p>
			<p>
				<label for="'. $this->get_field_id('search_box_height') .'">'. __('Height - search box size: ', 'WCISPlugin'). '</label>
				<input type="text" class="widefat" id="'. $this->get_field_id('search_box_height') .'" name="'. $this->get_field_name('search_box_height') .'" value="'.  esc_attr($search_box_height) .'"/>
			</p>  
				            
			<p>
				<label for="'. $this->get_field_id('search_box_units') .'">'. __('Height/Width units: ', 'WCISPlugin'). '</label>
				
		        <label for="rem">'. __('rem', 'WCISPlugin'). '
				    <input type="radio" class="widefat" id="'. $this->get_field_id('search_box_units') .'" name="'. $this->get_field_name('search_box_units') .'" value="rem" '. $search_box_units_checked_rem . '/>
				</label>
	            <label for="percent">'. __('percent(%%)', 'WCISPlugin'). '
		          <input type="radio" class="widefat" id="'. $this->get_field_id('search_box_units') .'" name="'. $this->get_field_name('search_box_units') .'" value="percent" '. $search_box_units_checked_percent . '/>
                </label>
			</p>	
		                			        
			<p>
				<label for="'. $this->get_field_id('search_box_float') .'">'. __('Float - push/move search box to the left or to the right side: ', 'WCISPlugin').'</label>
				<select id="'. $this->get_field_id('search_box_float') .'" name="'. $this->get_field_name('search_box_float') .'" class="widefat">
						'.$float_selecte.'
				</select>		
			</p>
		
		';

        printf($form);
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] 					= ( !empty($new_instance['title']) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['search_box_inner_text'] 	= sanitize_text_field($new_instance['search_box_inner_text']);
        $instance['search_box_float'] 		= sanitize_text_field($new_instance['search_box_float']);
        $instance['search_box_units'] 		= sanitize_text_field($new_instance['search_box_units']);

        if (is_numeric(sanitize_text_field($new_instance['search_box_width'])) && sanitize_text_field($new_instance['search_box_width'] != 0))
            $instance['search_box_width'] = sanitize_text_field($new_instance['search_box_width']);
        if (is_numeric(sanitize_text_field($new_instance['search_box_height'])) && sanitize_text_field($new_instance['search_box_height'] != 0))
            $instance['search_box_height'] = sanitize_text_field($new_instance['search_box_height']);

        return $instance;
    }
}

?>
<?php

function check_compatibility() {
	global $wp_version;

	if ( ! version_compare( $wp_version, '5.0', '>=' ) and ! is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
		return false;
	}else{
		return true;
	}
}

add_action('admin_init','sfsi_plus_block_init');

function sfsi_plus_block_init(){
    if(check_compatibility()){
        add_action( 'enqueue_block_editor_assets', 'sfsi_plus_share_block_editor_assets' );
        add_action('enqueue_block_assets', 'sfsi_plus_share_block_assets');
        // add_action( 'plugins_loaded', 'sfsi_plus_register_block' ); 
    }
}

function sfsi_plus_share_block_editor_assets() {
    wp_enqueue_script(
        'sfsi-plus-share-block',
        plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
        array( 'wp-blocks', 'wp-i18n', 'wp-element' , 'jquery','wp-api'),
        '1'
        // filemtime( plugin_dir_path( 'js/block.js', __FILE__ ) )
    );

    wp_enqueue_style(
        'sfsi-plus-share-block-editor', // Handle.
        plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
        array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
        '1'
        // filemtime( plugin_dir_path( 'css/editor.css', __FILE__ ) )
    );
    wp_localize_script( 'sfsi-plus-share-block', 'plugin_url',plugins_url( 'icons_theme', __FILE__ )  );
}
function sfsi_plus_share_block_assets() {
    wp_enqueue_style(
        'sfsi-plus-share-block-frontend',
        plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
        array( 'wp-blocks' ),
        '1'
        // filemtime( plugin_dir_path( 'css/style.css', __FILE__ ) )
    );

    wp_register_script(
        'sfsi-plus-share-block-front',
        plugins_url( 'js/front.js', __FILE__ ),
        array( 'wp-blocks', 'wp-i18n', 'wp-element','jquery' ),
        '1'
        // filemtime( plugin_dir_path( 'js/front.js', __FILE__ ) )
    );

}

function sfsi_plus_register_icon_route(){
    register_rest_route(SFSI_PLUS_DOMAIN.'/v1','icons',array(
        'methods'=> WP_REST_Server::READABLE,
        'callback' => 'sfsi_plus_render_shortcode',
        'args'=>array(
            "share_url"=>array(
                "type"=>'string',
                "sanitize_callback" => 'sanitize_text_field'
            ),
            "admin_refereal" => array(
                "type"  =>  'string',
                "sanitize_callback" =>  'sanitize_text_field'
            ),
            "ractangle_icon" => array(
                "type"  =>  'string',
                "sanitize_callback" =>  'sanitize_text_field'
            ),

        )
    ));
    // register_rest_route(SFSI_PLUS_DOMAIN.'/v1','settings',array(
    //     'methods'=> WP_REST_Server::READABLE,
    //     'callback' => 'sfsi_plus_fetch_settings',
    //     // 'args'=>array(
    //         // "share_url"=>array(
    //             // "type"=>'string',
    //             // "sanitize_callback" => 'sanitize_text_field'
    //         // )
    //     // )
    // ));
}

add_action( 'rest_api_init', 'sfsi_plus_register_icon_route');

function sfsi_plus_render_shortcode(){
    ob_start();
    if(isset($_GET['ractangle_icon']) && 1==$_GET['ractangle_icon']){
        $returndata=sfsi_plus_render_gutenberg_rectangle(null,null,isset($_GET['share_url'])?$_GET['share_url']:home_url());
    }else{
        $returndata=sfsi_plus_render_gutenberg_round(null,null,isset($_GET['share_url'])?$_GET['share_url']:null,isset($_GET['admin_refereal'])?$_GET['admin_refereal']:null );
    }
    ob_clean();
    return rest_ensure_response($returndata);
}


function sfsi_plus_render_gutenberg_round($args = null, $content = null,$share_url=null, $is_admin){
    $instance = array("showf" => 1, "title" => '');
    $sfsi_plus_section8_options = get_option("sfsi_plus_section8_options");
    $sfsi_plus_section8_options = unserialize($sfsi_plus_section8_options);
    $sfsi_plus_place_item_gutenberg = isset($sfsi_plus_section8_options['sfsi_plus_place_item_gutenberg'])?$sfsi_plus_section8_options['sfsi_plus_place_item_gutenberg']:'no';
    if($sfsi_plus_place_item_gutenberg == "yes")
    {
        $return = ''; 
        if(!isset($before_widget)): $before_widget =''; endif;
        if(!isset($after_widget)): $after_widget =''; endif;
        
        /*Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;
        global $is_floter;        
        $return.= $before_widget;
            /* Display the widget title */
            if ( $title ) $return .= $before_title . $title . $after_title;
            $return .= '<div class="sfsi_plus_widget">';
                // $return .= '<div id="sfsi_plus_wDiv"></div>';
                /* Link the main icons function */
                $return .= sfsi_plus_check_visiblity(0,$share_url,'static');
                $return .= '<div style="clear: both;"></div>';
            $return .= '</div>';
        $return .= $after_widget;
        return $return;
    }else{
        if($is_admin=='true'){
            return __('Kindly go to setting page and check the option "Show them in the Gutenberg editor " under section 3', SFSI_PLUS_DOMAIN);
        }
        return ;
    }
}

function sfsi_plus_render_gutenberg_rectangle($args = null, $content = null,$share_url=null){
    if($share_url===null){
        $share_url=home_url();
    }
    $sfsi_plus_section8_options = get_option("sfsi_plus_section8_options");
    $sfsi_plus_section8_options = unserialize($sfsi_plus_section8_options);
    $sfsi_plus_place_item_gutenberg = isset($sfsi_plus_section8_options['sfsi_plus_place_item_gutenberg'])?$sfsi_plus_section8_options['sfsi_plus_place_item_gutenberg']:'no';
    if($sfsi_plus_place_item_gutenberg == "yes")
    {
        $sfsi_section6=  unserialize(get_option('sfsi_plus_section6_options',false));
             
        //new options that are added on the third questions
        //so in this function we are replacing all the past options 
        //that were saved under option6 by new settings saved under option8 
        $sfsi_section8=  unserialize(get_option('sfsi_plus_section8_options',false));
        // $sfsi_plus_show_item_onposts = $sfsi_section8['sfsi_plus_show_item_onposts'];
        //new options that are added on the third questions
        
        //checking for standard icons
        if(!isset($sfsi_section8['sfsi_plus_rectsub']))
        {
            $sfsi_section8['sfsi_plus_rectsub'] = 'no';
        }
        if(!isset($sfsi_section8['sfsi_plus_rectfb']))
        {
            $sfsi_section8['sfsi_plus_rectfb'] = 'yes';
        }
        if(!isset($sfsi_section8['sfsi_plus_rectgp']))
        {
            $sfsi_section8['sfsi_plus_rectgp'] = 'yes';
        }
        if(!isset($sfsi_section8['sfsi_plus_recttwtr']))
        {
            $sfsi_section8['sfsi_plus_recttwtr'] = 'no';
        }
        if(!isset($sfsi_section8['sfsi_plus_rectpinit']))
        {
            $sfsi_section8['sfsi_plus_rectpinit'] = 'no';
        }
        if(!isset($sfsi_section8['sfsi_plus_rectfbshare']))
        {
            $sfsi_section8['sfsi_plus_rectfbshare'] = 'no';
        }
        //checking for standard icons
            
        /* check if option activated in admin or not */ 
        //if($sfsi_section6['sfsi_plus_show_Onposts']=="yes")
        //removing following condition for now
        /*if($sfsi_section8['sfsi_plus_show_Onposts']=="yes")
        {*/
        $permalink = $share_url;
        $title = get_the_title();
        $sfsiLikeWith="45px;";
        
        /* check for counter display */
        //if($sfsi_section6['sfsi_plus_icons_DisplayCounts']=="yes")
            
        if($sfsi_section8['sfsi_plus_icons_DisplayCounts']=="yes")
        {
            $show_count=1;
            $sfsiLikeWith="75px;";
        }   
        else
        {
            $show_count=0;
        } 
            
        //$txt=(isset($sfsi_section6['sfsi_plus_textBefor_icons']))? $sfsi_section6['sfsi_plus_textBefor_icons'] : "Share this Post with :" ;
        // $txt=(isset($sfsi_section8['sfsi_plus_textBefor_icons']))? $sfsi_section8['sfsi_plus_textBefor_icons'] : "Please follow and like us:" ;
        //$float= $sfsi_section6['sfsi_plus_icons_alignment'];
        $float= $sfsi_section8['sfsi_plus_icons_alignment'];
        if($sfsi_section8['sfsi_plus_rectsub'] == 'yes' || $sfsi_section8['sfsi_plus_rectfb'] == 'yes' || $sfsi_section8['sfsi_plus_rectgp'] == 'yes'  || $sfsi_section8['sfsi_plus_recttwtr'] == 'yes' || $sfsi_section8['sfsi_plus_rectpinit'] == 'yes' || $sfsi_section8['sfsi_plus_rectfbshare'] == 'yes')
        {
            $icons="<div class='sfsi_plus_Sicons ".$float."' style='float:".$float."'><div style='display: inline-block;margin-bottom: 0; margin-left: 0; margin-right: 8px; margin-top: 0; vertical-align: middle;width: auto;'><span>".$txt."</span></div>";
        }
        if($sfsi_section8['sfsi_plus_rectsub'] == 'yes')
        {
            if($show_count){$sfsiLikeWithsub = "93px";}else{$sfsiLikeWithsub = "64px";}
            if(!isset($sfsiLikeWithsub)){$sfsiLikeWithsub = $sfsiLikeWith;}
            $icons.="<div class='sf_subscrbe' style='display: inline-block;vertical-align: top;width: auto;'>".sfsi_plus_Subscribelike($permalink,$show_count)."</div>";
        }
        if($sfsi_section8['sfsi_plus_rectfb'] == 'yes' || $sfsi_section8['sfsi_plus_rectfbshare'] == 'yes')
        {
            if($show_count){}else{$sfsiLikeWithfb = "48px";}
            if(!isset($sfsiLikeWithfb)){$sfsiLikeWithfb = $sfsiLikeWith;}
            $icons.="<div class='sf_fb' style='display: inline-block;vertical-align: top;width: auto;'>".sfsi_plus_FBlike($permalink,$show_count)."</div>";
        }
        
        if($sfsi_section8['sfsi_plus_recttwtr'] == 'yes')
        {
            if($show_count){$sfsiLikeWithtwtr = "77px";}else{$sfsiLikeWithtwtr = "56px";}
            if(!isset($sfsiLikeWithtwtr)){$sfsiLikeWithtwtr = $sfsiLikeWith;}
            $icons.="<div class='sf_twiter' style='display: inline-block;vertical-align: top;width: auto;'>".sfsi_plus_twitterlike($permalink,$show_count)."</div>";
        }
        if($sfsi_section8['sfsi_plus_rectpinit'] == 'yes')
        {
            if($show_count){$sfsiLikeWithpinit = "100px";}else{$sfsiLikeWithpinit = "auto";}
            $icons.="<div class='sf_pinit' style='display: inline-block;text-align:left;vertical-align: top;width: ".$sfsiLikeWithpinit.";'>".sfsi_plus_pinitpinterest($permalink,$show_count)."</div>";
        }
        if($sfsi_section8['sfsi_plus_rectgp'] == 'yes')
        {
            if($show_count){$sfsiLikeWithpingogl = "63px";}else{$sfsiLikeWithpingogl = "auto";}
            $icons.="<div class='sf_google' style='display: inline-block;vertical-align: top; width:".$sfsiLikeWithpingogl.";'>".sfsi_plus_googlePlus($permalink,$show_count)."</div>";
        }
        $icons.="</div>";
        return $icons;
    } else{
        if($is_admin=='true'){
            return __('Kindly go to setting page and check the option "Show them in the Gutenberg editor " under section 3', SFSI_PLUS_DOMAIN);
        }
        return ;
    }

}

// function sfsi_plus_fetch_settings(){
//     ob_start();
//     $option8=  unserialize(get_option('sfsi_plus_section8_options',false));
//     // $returndata = $option8;
//     $returndata=array(
//         'textBeforeShare'=>(isset($option8['sfsi_plus_textBefor_icons'])?$option8['sfsi_plus_textBefor_icons']:''),
//         'iconType'=>(isset($option8['sfsi_plus_display_button_type'])?($option8['sfsi_plus_display_button_type']):'');
//         'iconAlignemt'=>isset()
//     );
//     ob_clean();
//     return rest_ensure_response($returndata);
// }


function sfsi_plus_gutenberg_share_block_init(){
    $post_types = get_post_types(array('public'=>true,'_builtin'=>true));
    foreach($post_types as $post_type){
        register_meta($post_type,'sfsi_plus_gutenberg_text_before_share',array(
            'show_in_rest' => true,
            'single'    =>  true,
            // 'type'      =>  'string'
        ));
        register_meta($post_type,'sfsi_plus_gutenberg_show_text_before_share',array(
            'show_in_rest' => true,
            'single'    =>  true,
            // 'type'      =>  'string'
        ));
        register_meta($post_type,'sfsi_plus_gutenberg_icon_type',array(
            'show_in_rest' => true,
            'single'    =>  true,
            // 'type'      =>  'string'
        ));
        register_meta($post_type,'sfsi_plus_gutenberg_icon_alignemt',array(
            'show_in_rest' => true,
            'single'    =>  true,
            // 'type'      =>  'string'
        ));
        register_meta($post_type,'sfsi_plus_gutenburg_max_per_row',array(
            'show_in_rest' => true,
            'single'    =>  true,
            // 'type'      =>  'string'
        ));
    }
}

add_action( 'init','sfsi_plus_gutenberg_share_block_init' );

?>
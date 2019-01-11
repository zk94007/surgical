<?php
if ( ! defined( 'ABSPATH' ) ) die( 'Direct access is not allowed' );

if (!class_exists('LCS_Utility')){
    /**
     * This utility class helps creating custom post and custom meta box etc. for logo carousel slider
     * Class LCS_Utility
     */
    class LCS_Utility {

        /**
         * LCS_Utility constructor.
         */
        public function __construct(){
            // create custom post type
            add_action( 'init', array($this, 'register_logo_post') );
            // change the position of the (feature image) metabox for uploading the logo
            add_action('do_meta_boxes', array($this, 'change_meta_box_position'));
            // add meta box for link url
            add_action( 'add_meta_boxes', array($this, 'add_logo_link_meta_box') );
            // save the content of meta box. we do not need to save the content of the logo image because we are using the default feature image uploader, so WordPress will handle the updating the data.
            add_action( 'save_post', array($this, 'save_meta_box_data') );



        }
        /**
         * It register logo custom post
         *
         * @return void
         */
        public function register_logo_post() {
            $labels = array(
                'name'               => _x( 'Logos', 'plural form of logo post type', LCS_TEXTDOMAIN ),
                'singular_name'      => _x( 'Logo', 'singular form of logo post type', LCS_TEXTDOMAIN ),
                'menu_name'          => __( 'Logo Carousel', LCS_TEXTDOMAIN ),
                'name_admin_bar'     => __( 'Logo Carousel', LCS_TEXTDOMAIN ),
                'all_items'          => __( 'All Logos', LCS_TEXTDOMAIN ),
                'add_new'            => __( 'Add New Logo', LCS_TEXTDOMAIN ),
                'add_new_item'       => __( 'Add New Logo', LCS_TEXTDOMAIN ),
                'new_item'           => __( 'New Logo', LCS_TEXTDOMAIN ),
                'edit_item'          => __( 'Edit Logo', LCS_TEXTDOMAIN ),
                'view_item'          => __( 'View Logo', LCS_TEXTDOMAIN ),
                'search_items'       => __( 'Search Logo', LCS_TEXTDOMAIN ),
                'parent_item_colon'  => __( 'Parent Logos:', LCS_TEXTDOMAIN ),
                'not_found'          => __( 'No Logo found.', LCS_TEXTDOMAIN ),
                'not_found_in_trash' => __( 'No Logo found in Trash.', LCS_TEXTDOMAIN )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'logo' ),
                'capability_type'    => 'post',
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array( 'title', 'thumbnail' ),
                'menu_icon' => 'dashicons-images-alt2'
            );

            register_post_type( 'logocarousel', $args );
        }


        /**
         * Changes default meta box location of logo upload (featured image actually)
         */
        public function change_meta_box_position() {
            remove_meta_box( 'postimagediv', 'logocarousel', 'side' );
            add_meta_box( 'postimagediv', __('Logo', LCS_TEXTDOMAIN), 'post_thumbnail_meta_box', 'logocarousel', 'normal', 'high' );
        }


        /**
         * Prints the markup for link url metaboxe.
         */
        public function link_url_input_markup( $post ) {

            // Add a nonce field so we can check for it later.
            wp_nonce_field( 'lcs_save_meta_box_data', 'lcs_meta_box_nonce' );

            $lcs_logo_link = get_post_meta( $post->ID, 'lcs_logo_link', true );

            ?>

            <div class="lcs-row">
                <div class="lcs-th">
                    <label for="lcs_logo_link"><?php esc_html_e('Logo Link', LCS_TEXTDOMAIN); ?></label>
                </div>
                <div class="lcs-td">
                    <input type="text" class="lcs-text-input" name="lcs_logo_link" id="lcs_logo_link" value="<?php echo (!empty($lcs_logo_link)) ? esc_url($lcs_logo_link): ''; ?>">
                </div>
            </div>

        <?php }

        /**
         *
         */
        public function add_logo_link_meta_box() {
            add_meta_box( 'lcs_metabox', __( 'URL (Optional)',LCS_TEXTDOMAIN ), array($this, 'link_url_input_markup'), 'logocarousel', 'normal' );

        }


        /**
         * When the post is saved, saves our custom post data.
         *
         * @param int $post_id The ID of the post being saved.
         */
        public function save_meta_box_data( $post_id ) {
            /*
                 * We need to verify this came from our screen and with proper authorization,
                 * because the save_post action can be triggered at other times.
                 */

            // If security checks fails, then do not proceed, vail out
            if (! $this->_lcs_security_check($_POST, $post_id)) return;
            //  at this point, we have passed security check. so it is safe to save the data.
            $link = !empty($_POST["lcs_logo_link"]) ? esc_url_raw( trim($_POST["lcs_logo_link"]) ) : "";

            update_post_meta($post_id, "lcs_logo_link", $link);
        }



        /**
         * It checks if the nonce is valid and if a user is allowed to save the data or if it is an autosave action
         * @param array $post_data It is basically the $_POST value
         * @param int $post_id The id of the current post
         * @access private
         * @return bool It returns true if the checks passes. Otherwise false is returned.
         */
        private function _lcs_security_check($post_data, $post_id){
            // checks are divided into 3 parts for readability.
            if (  !empty( $post_data['lcs_meta_box_nonce'] ) && wp_verify_nonce( $post_data['lcs_meta_box_nonce'], 'lcs_save_meta_box_data' ) ) {
                return true;
            }
            // If this is an autosave, our form has not been submitted, so we don't want to do anything. returns false
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return false;
            }
            // Check the user's permissions.
            if ( current_user_can( 'edit_post', $post_id ) ) {
                return true;
            }
            return false;
        }




    } // ends LCS_Utility class


} // ends if







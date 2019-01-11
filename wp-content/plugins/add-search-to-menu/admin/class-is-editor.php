<?php

class IS_Search_Editor
{
    private  $search_form ;
    private  $panels = array() ;
    private  $is_premium_plugin = false ;
    public function __construct( IS_Search_Form $search_form )
    {
        $this->search_form = $search_form;
    }
    
    function is_name( $string )
    {
        return preg_match( '/^[A-Za-z][-A-Za-z0-9_:.]*$/', $string );
    }
    
    public function add_panel( $id, $title, $callback )
    {
        if ( $this->is_name( $id ) ) {
            $this->panels[$id] = array(
                'title'    => $title,
                'callback' => $callback,
            );
        }
    }
    
    public function display()
    {
        if ( empty($this->panels) ) {
            return;
        }
        echo  '<ul id="search-form-editor-tabs">' ;
        $url = esc_url( menu_page_url( 'ivory-search-new', false ) );
        if ( isset( $_GET['post'] ) ) {
            $url = esc_url( menu_page_url( 'ivory-search', false ) ) . '&post=' . $_GET['post'] . '&action=edit';
        }
        $tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'includes' );
        foreach ( $this->panels as $id => $panel ) {
            $class = ( $tab == $id ? 'active' : '' );
            echo  sprintf(
                '<li id="%1$s-tab" class="%2$s"><a href="%3$s">%4$s</a></li>',
                esc_attr( $id ),
                esc_attr( $class ),
                $url . '&tab=' . $id,
                esc_html( $panel['title'] )
            ) ;
        }
        echo  '</ul>' ;
        echo  sprintf( '<div class="search-form-editor-panel" id="%1$s">', esc_attr( $tab ) ) ;
        $this->notice( $tab, $tab . '_panel' );
        $callback = $tab . '_panel';
        $this->{$callback}( $this->search_form );
        echo  '</div>' ;
    }
    
    public function notice( $id, $panel )
    {
        echo  '<div class="config-error"></div>' ;
    }
    
    /**
     * Gets all public meta keys of post types
     *
     * @global Object $wpdb WPDB object
     * @return Array array of meta keys
     */
    function is_meta_keys( $post_types )
    {
        global  $wpdb ;
        $post_types = implode( "', '", $post_types );
        $is_fields = $wpdb->get_results( apply_filters( 'is_meta_keys_query', "select DISTINCT meta_key from {$wpdb->postmeta} pt LEFT JOIN {$wpdb->posts} p ON (pt.post_id = p.ID) where meta_key NOT LIKE '\\_%' AND post_type IN ( '{$post_types}' ) ORDER BY meta_key ASC" ) );
        $meta_keys = array();
        if ( is_array( $is_fields ) && !empty($is_fields) ) {
            foreach ( $is_fields as $field ) {
                if ( isset( $field->meta_key ) ) {
                    $meta_keys[] = $field->meta_key;
                }
            }
        }
        /**
         * Filter results of SQL query for meta keys
         */
        return apply_filters( 'is_meta_keys', $meta_keys );
    }
    
    public function includes_panel( $post )
    {
        $id = '_is_includes';
        $includes = $post->prop( $id );
        $excludes = $post->prop( '_is_excludes' );
        $settings = $post->prop( '_is_settings' );
        ?>
		<h4 class="panel-desc">
			<?php 
        _e( "Configure the below options to make specific content searchable.", 'ivory-search' );
        ?>
		</h4>
		<div class="search-form-editor-box" id="<?php 
        echo  $id ;
        ?>">

		<div class="form-table">

			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-post_type"><?php 
        esc_html_e( 'Post Types', 'ivory-search' );
        ?></label>
				<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-post_type"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span>
			</h3>
			<div>
				<?php 
        $content = __( 'Select post types that you want to make searchable.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $args = array(
            'public' => true,
        );
        if ( isset( $settings['exclude_from_search'] ) ) {
            $args = array(
                'public'              => true,
                'exclude_from_search' => false,
            );
        }
        $posts = get_post_types( $args );
        
        if ( !empty($posts) ) {
            $ind_status = false;
            foreach ( $posts as $key => $post_type ) {
                $checked = ( isset( $includes['post_type'][esc_attr( $key )] ) ? $includes['post_type'][esc_attr( $key )] : 0 );
                if ( !$ind_status && $checked && 'post' !== $key && 'page' !== $key ) {
                    $ind_status = true;
                }
                echo  '<div class="col-wrapper check-radio">' ;
                echo  '<label for="' . $id . '-post_type-' . esc_attr( $key ) . '"> ' ;
                echo  '<input class="_is_includes-post_type" type="checkbox" id="' . $id . '-post_type-' . esc_attr( $key ) . '" name="' . $id . '[post_type][' . esc_attr( $key ) . ']" value="' . esc_attr( $key ) . '" ' . checked( $key, $checked, false ) . '/>' ;
                echo  '<span class="toggle-check-text"></span>' ;
                echo  ucfirst( esc_html( $post_type ) ) . '</label></div>' ;
            }
            $checked = ( isset( $includes['search_title'] ) && $includes['search_title'] ? 1 : 0 );
            if ( !$ind_status && !$checked ) {
                $ind_status = true;
            }
            echo  '<br /><br /><p class="check-radio"><label for="' . $id . '-search_title"><input class="_is_includes-post_type" type="checkbox" id="' . $id . '-search_title" name="' . $id . '[search_title]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
            echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in post title.", 'ivory-search' ) . '</label></p>' ;
            $checked = ( isset( $includes['search_content'] ) && $includes['search_content'] ? 1 : 0 );
            if ( !$ind_status && !$checked ) {
                $ind_status = true;
            }
            echo  '<p class="check-radio"><label for="' . $id . '-search_content"><input class="_is_includes-post_type" type="checkbox" id="' . $id . '-search_content" name="' . $id . '[search_content]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
            echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in post content.", 'ivory-search' ) . '</label></p>' ;
            $checked = ( isset( $includes['search_excerpt'] ) && $includes['search_excerpt'] ? 1 : 0 );
            if ( !$ind_status && !$checked ) {
                $ind_status = true;
            }
            echo  '<p class="check-radio"><label for="' . $id . '-search_excerpt"><input class="_is_includes-post_type" type="checkbox" id="' . $id . '-search_excerpt" name="' . $id . '[search_excerpt]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
            echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in post excerpt.", 'ivory-search' ) . '</label></p>' ;
            echo  '<br /><select class="_is_includes-post_type" name="' . $id . '[post_type_qs]" >' ;
            $checked = ( isset( $includes['post_type_qs'] ) ? $includes['post_type_qs'] : 'none' );
            if ( !$ind_status && 'none' !== $checked ) {
                $ind_status = true;
            }
            echo  '<option value="none" ' . selected( 'none', $checked, false ) . '>' . esc_html( __( 'None', 'ivory-search' ) ) . '</option>' ;
            foreach ( $posts as $key => $post_type ) {
                echo  '<option value="' . $key . '" ' . selected( $key, $checked, false ) . '>' . ucfirst( esc_html( $post_type ) ) . '</option>' ;
            }
            echo  '</select><label for="' . $id . '-post_type_qs"> ' . esc_html( __( 'Display this post type in the search query URL and restrict search to it.', 'ivory-search' ) ) . '</label>' ;
            if ( $ind_status ) {
                echo  '<span class="ind-status ' . $id . '-post_type"></span>' ;
            }
        } else {
            _e( 'No post types registered on your site.', 'ivory-search' );
        }
        
        ?>
			</div></div>

			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-post__in"><?php 
        echo  esc_html( __( 'Posts', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-post__in"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'The posts and pages of searchable post types display here.', 'ivory-search' );
        $content .= '<br />' . __( 'Select the specific posts you wish to search or do not select any posts to make all posts searchable.', 'ivory-search' );
        $content .= '<br />' . __( 'Selected post types display in BOLD.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $post_types = array( 'post', 'page' );
        if ( isset( $includes['post_type'] ) && !empty($includes['post_type']) && is_array( $includes['post_type'] ) ) {
            $post_types = array_values( $includes['post_type'] );
        }
        foreach ( $post_types as $post_type ) {
            $posts = get_posts( array(
                'post_type'      => $post_type,
                'posts_per_page' => 100,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ) );
            
            if ( !empty($posts) ) {
                $html = '<div class="col-wrapper"><div class="col-title">';
                $col_title = '<span>' . ucwords( $post_type ) . '</span>';
                $temp = '';
                $selected_pt = array();
                foreach ( $posts as $post2 ) {
                    $checked = ( isset( $includes['post__in'] ) && in_array( $post2->ID, $includes['post__in'] ) ? $post2->ID : 0 );
                    if ( $checked ) {
                        array_push( $selected_pt, $post_type );
                    }
                    $post_title = ( isset( $post2->post_title ) && '' !== $post2->post_title ? esc_html( $post2->post_title ) : $post2->post_name );
                    $temp .= '<option value="' . esc_attr( $post2->ID ) . '" ' . selected( $post2->ID, $checked, false ) . '>' . $post_title . '</option>';
                }
                if ( !empty($selected_pt) && in_array( $post_type, $selected_pt ) ) {
                    $col_title = '<strong>' . $col_title . '</strong>';
                }
                $html .= $col_title . '<input class="list-search" placeholder="' . __( "Search..", 'ivory-search' ) . '" type="text"></div>';
                $html .= '<select class="_is_includes-post__in" name="' . $id . '[post__in][]" multiple size="8" >';
                $html .= $temp . '</select>';
                if ( count( $posts ) >= 100 ) {
                    $html .= '<div id="' . $post_type . '" class="load-all">' . __( 'Load All', 'ivory-search' ) . '</div>';
                }
                $html .= '</div>';
                echo  $html ;
                if ( !empty($selected_pt) ) {
                    echo  '<span class="ind-status ' . $id . '-post__in"></span>' ;
                }
            }
        
        }
        echo  '<br /><label for="' . $id . '-post__in" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Press CTRL key & Left Mouse button to select multiple terms or deselect them.", 'ivory-search' ) . '</label>' ;
        ?>
			</div></div>

			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-tax_query"><?php 
        esc_html_e( 'Taxonomy Terms', 'ivory-search' );
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-tax_query"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Taxonomy terms that have no posts will not be visible below. Add a post with the taxonomy you want for it to be configurable.', 'ivory-search' );
        $content .= '<br /><br />' . __( 'Terms selected here will restrict the search to posts that have the selected terms.', 'ivory-search' );
        $content .= '<br />' . __( 'Taxonomy terms selected display in BOLD', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $args = array( 'post', 'page' );
        if ( isset( $includes['post_type'] ) && !empty($includes['post_type']) && is_array( $includes['post_type'] ) ) {
            $args = array_values( $includes['post_type'] );
        }
        $tax_objs = get_object_taxonomies( $args, 'objects' );
        
        if ( !empty($tax_objs) ) {
            foreach ( $tax_objs as $key => $tax_obj ) {
                $terms = get_terms( array(
                    'taxonomy'   => $key,
                    'hide_empty' => false,
                ) );
                
                if ( !empty($terms) ) {
                    echo  '<div class="col-wrapper"><div class="col-title">' ;
                    $col_title = ucwords( str_replace( '-', ' ', str_replace( '_', ' ', esc_html( $key ) ) ) );
                    if ( isset( $includes['tax_query'][$key] ) ) {
                        $col_title = '<strong>' . $col_title . '</strong>';
                    }
                    echo  $col_title . '<input class="list-search" placeholder="' . __( "Search..", 'ivory-search' ) . '" type="text"></div><input type="hidden" id="' . $id . '-tax_post_type" name="' . $id . '[tax_post_type][' . $key . ']" value="' . implode( ',', $tax_obj->object_type ) . '" />' ;
                    echo  '<select class="_is_includes-tax_query" name="' . $id . '[tax_query][' . $key . '][]" multiple size="8" >' ;
                    foreach ( $terms as $key2 => $term ) {
                        $checked = ( isset( $includes['tax_query'][$key] ) && in_array( $term->term_taxonomy_id, $includes['tax_query'][$key] ) ? $term->term_taxonomy_id : 0 );
                        echo  '<option value="' . esc_attr( $term->term_taxonomy_id ) . '" ' . selected( $term->term_taxonomy_id, $checked, false ) . '>' . esc_html( $term->name ) . '</option>' ;
                    }
                    echo  '</select></div>' ;
                }
            
            }
            echo  '<br /><label for="' . $id . '-tax_query" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Press CTRL key & Left Mouse button to select multiple terms or deselect them.", 'ivory-search' ) . '</label>' ;
            $ind_status = false;
            if ( isset( $includes['tax_query'] ) && !empty($includes['tax_query']) ) {
                $ind_status = true;
            }
            $checked = ( isset( $includes['tax_rel'] ) && "OR" == $includes['tax_rel'] ? "OR" : "AND" );
            if ( !$ind_status && "AND" !== $checked ) {
                $ind_status = true;
            }
            echo  '<br /><p class="check-radio"><label for="' . $id . '-tax_rel_and" ><input class="_is_includes-tax_query" type="radio" id="' . $id . '-tax_rel_and" name="' . $id . '[tax_rel]" value="AND" ' . checked( 'AND', $checked, false ) . '/>' ;
            echo  '<span class="toggle-check-text"></span>' . esc_html__( "AND - Search posts having all the above selected terms.", 'ivory-search' ) . '</label></p>' ;
            echo  '<p class="check-radio"><label for="' . $id . '-tax_rel_or" ><input class="_is_includes-tax_query" type="radio" id="' . $id . '-tax_rel_or" name="' . $id . '[tax_rel]" value="OR" ' . checked( 'OR', $checked, false ) . '/>' ;
            echo  '<span class="toggle-check-text"></span>' . esc_html__( "OR - Search posts having any one of the above selected terms.", 'ivory-search' ) . '</label></p>' ;
            $checked = ( isset( $includes['search_tax_title'] ) && $includes['search_tax_title'] ? 1 : 0 );
            if ( !$ind_status && $checked ) {
                $ind_status = true;
            }
            echo  '<br /><p class="check-radio"><label for="' . $id . '-search_tax_title" ><input class="_is_includes-tax_query" type="checkbox" id="' . $id . '-search_tax_title" name="' . $id . '[search_tax_title]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
            echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in taxonomy terms title.", 'ivory-search' ) . '</label></p>' ;
            $checked = ( isset( $includes['search_tax_desp'] ) && $includes['search_tax_desp'] ? 1 : 0 );
            if ( !$ind_status && $checked ) {
                $ind_status = true;
            }
            echo  '<p class="check-radio"><label for="' . $id . '-search_tax_desp" ><input class="_is_includes-tax_query" type="checkbox" id="' . $id . '-search_tax_desp" name="' . $id . '[search_tax_desp]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
            echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in taxonomy terms description.", 'ivory-search' ) . '</label></p>' ;
            if ( $ind_status ) {
                echo  '<span class="ind-status ' . $id . '-tax_query"></span>' ;
            }
        } else {
            _e( 'No taxonomies registered for selected post types.', 'ivory-search' );
        }
        
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-custom_field"><?php 
        echo  esc_html( __( 'Custom Fields', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-custom_field"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Select custom fields to make their values searchable.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $args = array( 'post', 'page' );
        if ( isset( $includes['post_type'] ) && !empty($includes['post_type']) && is_array( $includes['post_type'] ) ) {
            $args = array_values( $includes['post_type'] );
        }
        $meta_keys = $this->is_meta_keys( $args );
        
        if ( !empty($meta_keys) ) {
            echo  '<input class="list-search wide" placeholder="' . __( "Search..", 'ivory-search' ) . '" type="text">' ;
            echo  '<select class="_is_includes-custom_field" name="' . $id . '[custom_field][]" multiple size="8" >' ;
            foreach ( $meta_keys as $meta_key ) {
                $checked = ( isset( $includes['custom_field'] ) && in_array( $meta_key, $includes['custom_field'] ) ? $meta_key : 0 );
                echo  '<option value="' . esc_attr( $meta_key ) . '" ' . selected( $meta_key, $checked, false ) . '>' . esc_html( $meta_key ) . '</option>' ;
            }
            echo  '</select>' ;
            echo  '<br /><label for="' . $id . '-custom_field" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Press CTRL key & Left Mouse button to select multiple terms or deselect them.", 'ivory-search' ) . '</label>' ;
        }
        
        
        if ( isset( $includes['custom_field'] ) ) {
            echo  '<br />' . __( 'Selected Custom Fields :', 'ivory-search' ) ;
            foreach ( $includes['custom_field'] as $custom_field ) {
                echo  '<br /><span style="font-size: 11px;">' . $custom_field . '</span>' ;
            }
            echo  '<span class="ind-status ' . $id . '-custom_field"></span>' ;
        }
        
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-woocommerce"><?php 
        echo  esc_html( __( 'WooCommerce', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-woocommerce"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Configure WooCommerce products search options here.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        
        if ( class_exists( 'WooCommerce' ) ) {
            $args = array( 'post', 'page' );
            if ( isset( $includes['post_type'] ) && !empty($includes['post_type']) && is_array( $includes['post_type'] ) ) {
                $args = array_values( $includes['post_type'] );
            }
            
            if ( in_array( 'product', $args ) ) {
                $ind_status = false;
                $woo_sku_disable = ( is_fs()->is_plan_or_trial( 'pro_plus' ) && $this->is_premium_plugin ? '' : ' disabled ' );
                $checked = ( isset( $includes['woo']['sku'] ) && $includes['woo']['sku'] ? 1 : 0 );
                if ( $checked ) {
                    $ind_status = true;
                }
                echo  '<p class="check-radio"><label for="' . $id . '-sku" ><input class="_is_includes-woocommerce" type="checkbox" ' . $woo_sku_disable . ' id="' . $id . '-sku" name="' . $id . '[woo][sku]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
                echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in WooCommerce products SKU.", 'ivory-search' ) . '</label></p>' ;
                $checked = ( isset( $includes['woo']['variation'] ) && $includes['woo']['variation'] ? 1 : 0 );
                if ( !$ind_status && $checked ) {
                    $ind_status = true;
                }
                echo  '<p class="check-radio"><label for="' . $id . '-variation" ><input class="_is_includes-woocommerce" type="checkbox" ' . $woo_sku_disable . ' id="' . $id . '-variation" name="' . $id . '[woo][variation]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
                echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in WooCommerce products variation.", 'ivory-search' ) . '</label>' ;
                echo  IS_Admin::pro_link( 'pro_plus' ) . '</p>' ;
                if ( $ind_status ) {
                    echo  '<span class="ind-status ' . $id . '-woocommerce"></span>' ;
                }
            } else {
                _e( 'WooCommerce product post type is not included in search.', 'ivory-search' );
            }
        
        } else {
            _e( 'Activate WooCommerce plugin to use this option.', 'ivory-search' );
        }
        
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-author"><?php 
        echo  esc_html( __( 'Authors', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-author"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Make specific author posts searchable.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $author_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
        
        if ( !isset( $excludes['author'] ) ) {
            $authors = get_users( array(
                'fields'  => array( 'ID', 'display_name' ),
                'orderby' => 'post_count',
                'order'   => 'DESC',
                'who'     => 'authors',
            ) );
            
            if ( !empty($authors) ) {
                if ( '' !== $author_disable ) {
                    echo  '<div class="upgrade-parent">' . IS_Admin::pro_link() ;
                }
                foreach ( $authors as $author ) {
                    $post_count = count_user_posts( $author->ID );
                    // Move on if user has not published a post (yet).
                    if ( !$post_count ) {
                        continue;
                    }
                    $checked = ( isset( $includes['author'][esc_attr( $author->ID )] ) ? $includes['author'][esc_attr( $author->ID )] : 0 );
                    echo  '<div class="col-wrapper check-radio"><label for="' . $id . '-author-' . esc_attr( $author->ID ) . '"><input class="_is_includes-author" type="checkbox" ' . $author_disable . ' id="' . $id . '-author-' . esc_attr( $author->ID ) . '" name="' . $id . '[author][' . esc_attr( $author->ID ) . ']" value="' . esc_attr( $author->ID ) . '" ' . checked( $author->ID, $checked, false ) . '/>' ;
                    echo  '<span class="toggle-check-text"></span> ' . ucfirst( esc_html( $author->display_name ) ) . '</label></div>' ;
                }
            }
        
        } else {
            echo  '<label>' . esc_html__( "Search has been already limited by excluding specific authors posts in the Excludes section.", 'ivory-search' ) . '</label>' ;
        }
        
        if ( '' !== $author_disable ) {
            echo  '</div>' ;
        }
        $checked = ( isset( $includes['search_author'] ) && $includes['search_author'] ? 1 : 0 );
        echo  '<br /><br /><p class="check-radio"><label for="' . $id . '-search_author" ><input class="_is_includes-author" type="checkbox" id="' . $id . '-search_author" name="' . $id . '[search_author]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in author Display name and display the posts created by that author.", 'ivory-search' ) . '</label></p>' ;
        if ( $checked || isset( $includes['author'] ) && !empty($includes['author']) ) {
            echo  '<span class="ind-status ' . $id . '-author"></span>' ;
        }
        ?>
			</div></div>

			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-post_status"><?php 
        echo  esc_html( __( 'Post Status', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-post_status"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Configure options to search posts having specific post statuses.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        
        if ( !isset( $excludes['post_status'] ) ) {
            $post_statuses = get_post_stati();
            $post_status_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
            
            if ( !empty($post_statuses) ) {
                if ( '' !== $post_status_disable ) {
                    echo  IS_Admin::pro_link() ;
                }
                foreach ( $post_statuses as $key => $post_status ) {
                    $checked = ( isset( $includes['post_status'][esc_attr( $key )] ) ? $includes['post_status'][esc_attr( $key )] : 0 );
                    echo  '<div class="col-wrapper check-radio"><label for="' . $id . '-post_status-' . esc_attr( $key ) . '"><input class="_is_includes-post_status" type="checkbox" ' . $post_status_disable . ' id="' . $id . '-post_status-' . esc_attr( $key ) . '" name="' . $id . '[post_status][' . esc_attr( $key ) . ']" value="' . esc_attr( $key ) . '" ' . checked( $key, $checked, false ) . '/>' ;
                    echo  '<span class="toggle-check-text"></span> ' . ucwords( str_replace( '-', ' ', esc_html( $post_status ) ) ) . '</label></div>' ;
                }
            }
            
            if ( isset( $includes['post_status'] ) && !empty($includes['post_status']) ) {
                echo  '<span class="ind-status ' . $id . '-post_status"></span>' ;
            }
        } else {
            echo  '<label>' . esc_html__( "Search has been already limited by excluding specific posts statuses from search in the Excludes section.", 'ivory-search' ) . '</label>' ;
        }
        
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-comment_count"><?php 
        echo  esc_html( __( 'Comments', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-comment_count"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $ind_status = false;
        $content = __( 'Make posts searchable that have a specific number of comments.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $comment_count_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
        if ( '' !== $comment_count_disable ) {
            echo  '<div class="upgrade-parent">' . IS_Admin::pro_link() ;
        }
        echo  '<select class="_is_includes-comment_count" name="' . $id . '[comment_count][compare]" ' . $comment_count_disable . ' style="min-width: 50px;">' ;
        $checked = ( isset( $includes['comment_count']['compare'] ) ? htmlspecialchars_decode( $includes['comment_count']['compare'] ) : '=' );
        if ( '=' !== $checked ) {
            $ind_status = true;
        }
        $compare = array(
            '=',
            '!=',
            '>',
            '>=',
            '<',
            '<='
        );
        foreach ( $compare as $d ) {
            echo  '<option value="' . htmlspecialchars_decode( $d ) . '" ' . selected( $d, $checked, false ) . '>' . esc_html( $d ) . '</option>' ;
        }
        echo  '</select><label for="' . $id . '-comment_count-compare"> ' . esc_html( __( 'The search operator to compare comments count.', 'ivory-search' ) ) . '</label>' ;
        echo  '<br /><select class="_is_includes-comment_count" name="' . $id . '[comment_count][value]" ' . $comment_count_disable . ' >' ;
        $checked = ( isset( $includes['comment_count']['value'] ) ? $includes['comment_count']['value'] : 'na' );
        if ( !$ind_status && 'na' !== $checked ) {
            $ind_status = true;
        }
        echo  '<option value="na" ' . selected( 'na', $checked, false ) . '>' . esc_html( __( 'NA', 'ivory-search' ) ) . '</option>' ;
        for ( $d = 0 ;  $d <= 999 ;  $d++ ) {
            echo  '<option value="' . $d . '" ' . selected( $d, $checked, false ) . '>' . $d . '</option>' ;
        }
        echo  '</select><label for="' . $id . '-comment_count-value"> ' . esc_html( __( 'The amount of comments your posts has to have.', 'ivory-search' ) ) . '</label>' ;
        if ( '' !== $comment_count_disable ) {
            echo  '</div>' ;
        }
        $checked = ( isset( $includes['search_comment'] ) && $includes['search_comment'] ? 1 : 0 );
        if ( !$ind_status && $checked ) {
            $ind_status = true;
        }
        echo  '<br /><br /><p class="check-radio"><label for="' . $id . '-search_comment" ><input class="_is_includes-comment_count" type="checkbox" id="' . $id . '-search_comment" name="' . $id . '[search_comment]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search in approved comments content.", 'ivory-search' ) . '</label></p>' ;
        if ( $ind_status ) {
            echo  '<span class="ind-status ' . $id . '-comment_count"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-date_query"><?php 
        echo  esc_html( __( 'Date', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-date_query"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Make posts searchable that were created in the specified date range.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $range = array( 'after', 'before' );
        $ind_status = false;
        foreach ( $range as $value ) {
            echo  '<div class="col-wrapper ' . $value . '"><div class="col-title">' . ucfirst( $value ) . '</div>' ;
            echo  '<select class="_is_includes-date_query" name="' . $id . '[date_query][' . $value . '][day]" >' ;
            $checked = ( isset( $includes['date_query'][$value]['day'] ) ? $includes['date_query'][$value]['day'] : 'day' );
            if ( 'day' !== $checked ) {
                $ind_status = true;
            }
            echo  '<option value="day" ' . selected( 'day', $checked, false ) . '>' . esc_html( __( 'Day', 'ivory-search' ) ) . '</option>' ;
            for ( $d = 1 ;  $d <= 31 ;  $d++ ) {
                echo  '<option value="' . $d . '" ' . selected( $d, $checked, false ) . '>' . $d . '</option>' ;
            }
            echo  '</select>' ;
            echo  '<select class="_is_includes-date_query" name="' . $id . '[date_query][' . $value . '][month]" >' ;
            $checked = ( isset( $includes['date_query'][$value]['month'] ) ? $includes['date_query'][$value]['month'] : 'month' );
            if ( !$ind_status && 'month' !== $checked ) {
                $ind_status = true;
            }
            echo  '<option value="month" ' . selected( 'month', $checked, false ) . '>' . esc_html( __( 'Month', 'ivory-search' ) ) . '</option>' ;
            for ( $m = 1 ;  $m <= 12 ;  $m++ ) {
                echo  '<option value="' . $m . '" ' . selected( $m, $checked, false ) . '>' . date( 'F', mktime(
                    0,
                    0,
                    0,
                    $m,
                    1
                ) ) . '</option>' ;
            }
            echo  '</select>' ;
            echo  '<select class="_is_includes-date_query" name="' . $id . '[date_query][' . $value . '][year]" >' ;
            $checked = ( isset( $includes['date_query'][$value]['year'] ) ? $includes['date_query'][$value]['year'] : 'year' );
            if ( !$ind_status && 'year' !== $checked ) {
                $ind_status = true;
            }
            echo  '<option value="year" ' . selected( 'year', $checked, false ) . '>' . esc_html( __( 'Year', 'ivory-search' ) ) . '</option>' ;
            for ( $y = date( "Y" ) ;  $y >= 1995 ;  $y-- ) {
                echo  '<option value="' . $y . '" ' . selected( $y, $checked, false ) . '>' . $y . '</option>' ;
            }
            echo  '</select></div>' ;
        }
        if ( $ind_status ) {
            echo  '<span class="ind-status ' . $id . '-date_query"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-has_password"><?php 
        echo  esc_html( __( 'Password', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-has_password"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Configure options to search posts with or without password.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $checked = ( isset( $includes['has_password'] ) ? $includes['has_password'] : 'null' );
        echo  '<p class="check-radio"><label for="' . $id . '-has_password" ><input class="_is_includes-has_password" type="radio" id="' . $id . '-has_password" name="' . $id . '[has_password]" value="null" ' . checked( 'null', $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search all posts with and without passwords.", 'ivory-search' ) . '</label></p>' ;
        echo  '<p class="check-radio"><label for="' . $id . '-has_password_1" ><input class="_is_includes-has_password" type="radio" id="' . $id . '-has_password_1" name="' . $id . '[has_password]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search only posts with passwords.", 'ivory-search' ) . '</label></p>' ;
        echo  '<p class="check-radio"><label for="' . $id . '-has_password_0" ><input class="_is_includes-has_password" type="radio" id="' . $id . '-has_password_0" name="' . $id . '[has_password]" value="0" ' . checked( 0, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Search only posts without passwords.", 'ivory-search' ) . '</label></p>' ;
        if ( 'null' !== $checked ) {
            echo  '<span class="ind-status ' . $id . '-has_password"></span>' ;
        }
        ?>
			</div></div>

		<?php 
        global  $wp_version ;
        
        if ( 4.9 <= $wp_version ) {
            ?>

			<h3 scope="row">
				<label for="<?php 
            echo  $id ;
            ?>-post_file_type"><?php 
            echo  esc_html( __( 'File Types', 'ivory-search' ) ) ;
            ?></label>
			<span class="actions"><span class="indicator <?php 
            echo  $id ;
            ?>-post_file_type"></span><a class="expand" href="#"><?php 
            esc_html_e( 'Expand All', 'ivory-search' );
            ?></a><a class="collapse" href="#" style="display:none;"><?php 
            esc_html_e( 'Collapse All', 'ivory-search' );
            ?></a></span></h3>
			<div>
				<?php 
            $content = __( 'Configure searching to search based on posts that have a specific MIME type or files that have specific media attachments', 'ivory-search' );
            IS_Help::help_info( $content );
            echo  '<div>' ;
            
            if ( isset( $includes['post_type'] ) && in_array( 'attachment', $includes['post_type'] ) ) {
                
                if ( !isset( $excludes['post_file_type'] ) ) {
                    $file_types = get_allowed_mime_types();
                    
                    if ( !empty($file_types) ) {
                        $file_type_disable = ( is_fs()->is_plan_or_trial( 'pro_plus' ) && $this->is_premium_plugin ? '' : ' disabled ' );
                        ksort( $file_types );
                        echo  '<input class="list-search wide" placeholder="' . __( "Search..", 'ivory-search' ) . '" type="text">' ;
                        echo  '<select class="_is_includes-post_file_type" name="' . $id . '[post_file_type][]" ' . $file_type_disable . ' multiple size="8" >' ;
                        foreach ( $file_types as $key => $file_type ) {
                            $checked = ( isset( $includes['post_file_type'] ) && in_array( $file_type, $includes['post_file_type'] ) ? $file_type : 0 );
                            echo  '<option value="' . esc_attr( $file_type ) . '" ' . selected( $file_type, $checked, false ) . '>' . esc_html( $key ) . '</option>' ;
                        }
                        echo  '</select>' ;
                        echo  IS_Admin::pro_link( 'pro_plus' ) ;
                        echo  '<br /><br /><label for="' . $id . '-post_file_type" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Press CTRL key & Left Mouse button to select multiple terms or deselect them.", 'ivory-search' ) . '</label>' ;
                    }
                
                } else {
                    echo  '<label>' . esc_html__( "Search has been already limited by excluding specific File type in the Excludes section.", 'ivory-search' ) . '</label>' ;
                }
            
            } else {
                _e( 'Attachment post type is not included in search.', 'ivory-search' );
            }
            
            
            if ( isset( $includes['post_file_type'] ) ) {
                echo  '<br />' . __( 'Selected File Types :', 'ivory-search' ) ;
                foreach ( $includes['post_file_type'] as $post_file_type ) {
                    echo  '<br /><span style="font-size: 11px;">' . $post_file_type . '</span>' ;
                }
                echo  '<span class="ind-status ' . $id . '-post_file_type"></span>' ;
            }
            
            ?>
			</div></div>

		<?php 
        }
        
        ?>
		</div>

		</div>

	<?php 
    }
    
    public function excludes_panel( $post )
    {
        $id = '_is_excludes';
        $excludes = $post->prop( $id );
        $includes = $post->prop( '_is_includes' );
        ?>
		<h4 class="panel-desc">
			<?php 
        _e( "Configure the options to exclude specific content from search.", 'ivory-search' );
        ?>
		</h4>
		<div class="search-form-editor-box" id="<?php 
        echo  $id ;
        ?>">
		<div class="form-table">

			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-post__not_in"><?php 
        echo  esc_html( __( 'Posts', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-post__not_in"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'The posts and pages of searchable post types display here.', 'ivory-search' );
        $content .= '<br />' . __( 'Select the posts you wish to exclude from the search.', 'ivory-search' );
        $content .= '<br />' . __( 'Selected post types display in BOLD.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        
        if ( !isset( $includes['post__in'] ) ) {
            $post_types = array( 'post', 'page' );
            if ( isset( $includes['post_type'] ) && !empty($includes['post_type']) && is_array( $includes['post_type'] ) ) {
                $post_types = array_values( $includes['post_type'] );
            }
            foreach ( $post_types as $post_type ) {
                $posts = get_posts( array(
                    'post_type'      => $post_type,
                    'posts_per_page' => 100,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ) );
                
                if ( !empty($posts) ) {
                    $html = '<div class="col-wrapper"><div class="col-title">';
                    $col_title = '<span>' . ucwords( $post_type ) . '</span>';
                    $temp = '';
                    $selected_pt = array();
                    foreach ( $posts as $post2 ) {
                        $checked = ( isset( $excludes['post__not_in'] ) && in_array( $post2->ID, $excludes['post__not_in'] ) ? $post2->ID : 0 );
                        if ( $checked ) {
                            array_push( $selected_pt, $post_type );
                        }
                        $post_title = ( isset( $post2->post_title ) && '' !== $post2->post_title ? esc_html( $post2->post_title ) : $post2->post_name );
                        $temp .= '<option value="' . esc_attr( $post2->ID ) . '" ' . selected( $post2->ID, $checked, false ) . '>' . $post_title . '</option>';
                    }
                    if ( !empty($selected_pt) && in_array( $post_type, $selected_pt ) ) {
                        $col_title = '<strong>' . $col_title . '</strong>';
                    }
                    $html .= $col_title . '<input class="list-search" placeholder="' . __( "Search..", 'ivory-search' ) . '" type="text"></div>';
                    $html .= '<select class="_is_excludes-post__not_in" name="' . $id . '[post__not_in][]" multiple size="8" >';
                    $html .= $temp . '</select>';
                    if ( count( $posts ) >= 100 ) {
                        $html .= '<div id="' . $post_type . '" class="load-all">' . __( 'Load All', 'ivory-search' ) . '</div>';
                    }
                    $html .= '</div>';
                    echo  $html ;
                    if ( !empty($selected_pt) ) {
                        echo  '<span class="ind-status ' . $id . '-post__not_in"></span>' ;
                    }
                }
            
            }
            echo  '<br /><label for="' . $id . '-post__not_in" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Press CTRL key & Left Mouse button to select multiple terms or deselect them.", 'ivory-search' ) . '</label>' ;
        } else {
            _e( 'Search is already limited to specific posts selected in Includes section.', 'ivory-search' );
        }
        
        ?>
			</div></div>

			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-tax_query"><?php 
        esc_html_e( 'Taxonomy Terms', 'ivory-search' );
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-tax_query"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'The taxonomies and terms attached to searchable post types display here.', 'ivory-search' );
        $content .= '<br />' . __( 'Exclude posts from search results that have specific terms', 'ivory-search' );
        $content .= '<br />' . __( 'Selected terms taxonomy title display in BOLD.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $tax_objs = get_object_taxonomies( $post_types, 'objects' );
        
        if ( !empty($tax_objs) ) {
            foreach ( $tax_objs as $key => $tax_obj ) {
                $terms = get_terms( array(
                    'taxonomy'   => $key,
                    'hide_empty' => false,
                ) );
                
                if ( !empty($terms) ) {
                    echo  '<div class="col-wrapper"><div class="col-title">' ;
                    $col_title = ucwords( str_replace( '-', ' ', str_replace( '_', ' ', esc_html( $key ) ) ) );
                    if ( isset( $excludes['tax_query'][$key] ) ) {
                        $col_title = '<strong>' . $col_title . '</strong>';
                    }
                    echo  $col_title . '<input class="list-search" placeholder="' . __( "Search..", 'ivory-search' ) . '" type="text"></div><select class="_is_excludes-tax_query" name="' . $id . '[tax_query][' . $key . '][]" multiple size="8" >' ;
                    foreach ( $terms as $key2 => $term ) {
                        $checked = ( isset( $excludes['tax_query'][$key] ) && in_array( $term->term_taxonomy_id, $excludes['tax_query'][$key] ) ? $term->term_taxonomy_id : 0 );
                        echo  '<option value="' . esc_attr( $term->term_taxonomy_id ) . '" ' . selected( $term->term_taxonomy_id, $checked, false ) . '>' . esc_html( $term->name ) . '</option>' ;
                    }
                    echo  '</select></div>' ;
                }
            
            }
            echo  '<br /><label for="' . $id . '-tax_query" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Press CTRL key & Left Mouse button to select multiple terms or deselect them.", 'ivory-search' ) . '</label>' ;
            if ( isset( $excludes['tax_query'] ) && !empty($excludes['tax_query']) ) {
                echo  '<span class="ind-status ' . $id . '-tax_query"></span>' ;
            }
        } else {
            _e( 'No taxonomies registered for selected post types.', 'ivory-search' );
        }
        
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-custom_field"><?php 
        echo  esc_html( __( 'Custom Fields', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-custom_field"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Exclude posts from the search having selected custom fields.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $args = array( 'post', 'page' );
        if ( isset( $excludes['post_type'] ) && !empty($excludes['post_type']) && is_array( $excludes['post_type'] ) ) {
            $args = array_values( $excludes['post_type'] );
        }
        $meta_keys = $this->is_meta_keys( $args );
        
        if ( !empty($meta_keys) ) {
            $custom_field_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
            echo  '<input class="list-search wide" placeholder="' . __( "Search..", 'ivory-search' ) . '" type="text">' ;
            echo  '<select class="_is_excludes-custom_field" name="' . $id . '[custom_field][]" ' . $custom_field_disable . ' multiple size="8" >' ;
            foreach ( $meta_keys as $meta_key ) {
                $checked = ( isset( $excludes['custom_field'] ) && in_array( $meta_key, $excludes['custom_field'] ) ? $meta_key : 0 );
                echo  '<option value="' . esc_attr( $meta_key ) . '" ' . selected( $meta_key, $checked, false ) . '>' . esc_html( $meta_key ) . '</option>' ;
            }
            echo  '</select>' ;
            echo  IS_Admin::pro_link() ;
            echo  '<br /><br /><label for="' . $id . '-custom_field" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Press CTRL key & Left Mouse button to select multiple terms or deselect them.", 'ivory-search' ) . '</label>' ;
        }
        
        
        if ( isset( $excludes['custom_field'] ) ) {
            echo  '<br />' . __( 'Excluded Custom Fields :', 'ivory-search' ) ;
            foreach ( $excludes['custom_field'] as $custom_field ) {
                echo  '<br /><span style="font-size: 11px;">' . $custom_field . '</span>' ;
            }
            echo  '<span class="ind-status ' . $id . '-custom_field"></span>' ;
        }
        
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-woocommerce"><?php 
        echo  esc_html( __( 'WooCommerce', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-woocommerce"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Exclude specific WooCommerce products from the search.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        
        if ( class_exists( 'WooCommerce' ) ) {
            $args = array( 'post', 'page' );
            if ( isset( $includes['post_type'] ) && !empty($includes['post_type']) && is_array( $includes['post_type'] ) ) {
                $args = array_values( $includes['post_type'] );
            }
            
            if ( in_array( 'product', $args ) ) {
                $outofstock_disable = ( is_fs()->is_plan_or_trial( 'pro_plus' ) && $this->is_premium_plugin ? '' : ' disabled ' );
                $checked = ( isset( $excludes['woo']['outofstock'] ) && $excludes['woo']['outofstock'] ? 1 : 0 );
                if ( $checked ) {
                    echo  '<span class="ind-status ' . $id . '-woocommerce"></span>' ;
                }
                echo  '<p class="check-radio"><label for="' . $id . '-outofstock" ><input class="_is_excludes-woocommerce" type="checkbox" ' . $outofstock_disable . ' id="' . $id . '-outofstock" name="' . $id . '[woo][outofstock]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
                echo  '<span class="toggle-check-text"></span>' . esc_html__( "Exclude 'out of stock' WooCommerce products.", 'ivory-search' ) . '</label></p>' ;
                echo  IS_Admin::pro_link( 'pro_plus' ) ;
            } else {
                _e( 'WooCommerce product post type is not included in search.', 'ivory-search' );
            }
        
        } else {
            _e( 'Activate WooCommerce plugin to use this option.', 'ivory-search' );
        }
        
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-author"><?php 
        echo  esc_html( __( 'Authors', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-author"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Exclude posts from the search created by selected authors.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        
        if ( !isset( $includes['author'] ) ) {
            $author_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
            $authors = get_users( array(
                'fields'  => array( 'ID', 'display_name' ),
                'orderby' => 'post_count',
                'order'   => 'DESC',
                'who'     => 'authors',
            ) );
            
            if ( !empty($authors) ) {
                if ( '' !== $author_disable ) {
                    echo  IS_Admin::pro_link() ;
                }
                foreach ( $authors as $author ) {
                    $post_count = count_user_posts( $author->ID );
                    // Move on if user has not published a post (yet).
                    if ( !$post_count ) {
                        continue;
                    }
                    $checked = ( isset( $excludes['author'][esc_attr( $author->ID )] ) ? $excludes['author'][esc_attr( $author->ID )] : 0 );
                    echo  '<div class="col-wrapper check-radio"><label for="' . $id . '-author-' . esc_attr( $author->ID ) . '"><input class="_is_excludes-author" type="checkbox" ' . $author_disable . ' id="' . $id . '-author-' . esc_attr( $author->ID ) . '" name="' . $id . '[author][' . esc_attr( $author->ID ) . ']" value="' . esc_attr( $author->ID ) . '" ' . checked( $author->ID, $checked, false ) . '/>' ;
                    echo  '<span class="toggle-check-text"></span> ' . ucfirst( esc_html( $author->display_name ) ) . '</label></div>' ;
                }
                if ( isset( $excludes['author'] ) && !empty($excludes['author']) ) {
                    echo  '<span class="ind-status ' . $id . '-author"></span>' ;
                }
            }
        
        } else {
            echo  '<label>' . esc_html__( "Search has been already limited to posts created by specific authors in the Includes section.", 'ivory-search' ) . '</label>' ;
        }
        
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-post_status"><?php 
        echo  esc_html( __( 'Post Status', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-post_status"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
				<?php 
        $content = __( 'Exclude posts from the search having selected post statuses.', 'ivory-search' );
        IS_Help::help_info( $content );
        echo  '<div>' ;
        
        if ( !isset( $includes['post_status'] ) ) {
            $post_statuses = get_post_stati();
            $post_status_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
            
            if ( !empty($post_statuses) ) {
                if ( '' !== $post_status_disable ) {
                    echo  '<div class="upgrade-parent">' . IS_Admin::pro_link() ;
                }
                foreach ( $post_statuses as $key => $post_status ) {
                    $checked = ( isset( $excludes['post_status'][esc_attr( $key )] ) ? $excludes['post_status'][esc_attr( $key )] : 0 );
                    echo  '<div class="col-wrapper check-radio"><label for="' . $id . '-post_status-' . esc_attr( $key ) . '"><input class="_is_excludes-post_status" type="checkbox" ' . $post_status_disable . ' id="' . $id . '-post_status-' . esc_attr( $key ) . '" name="' . $id . '[post_status][' . esc_attr( $key ) . ']" value="' . esc_attr( $key ) . '" ' . checked( $key, $checked, false ) . '/>' ;
                    echo  '<span class="toggle-check-text"></span> ' . ucwords( str_replace( '-', ' ', esc_html( $post_status ) ) ) . '</label></div>' ;
                }
                if ( '' !== $post_status_disable ) {
                    echo  '</div>' ;
                }
            }
        
        } else {
            echo  '<label>' . esc_html__( "Search has been already limited to posts statuses set in the Includes section.", 'ivory-search' ) . '</label>' ;
        }
        
        $checked = ( isset( $excludes['ignore_sticky_posts'] ) && $excludes['ignore_sticky_posts'] ? 1 : 0 );
        if ( isset( $excludes['post_status'] ) && !empty($excludes['post_status']) || $checked ) {
            echo  '<span class="ind-status ' . $id . '-post_status"></span>' ;
        }
        echo  '<br /><br /><p class="check-radio"><label for="' . $id . '-ignore_sticky_posts" ><input class="_is_excludes-post_status" type="checkbox" id="' . $id . '-ignore_sticky_posts" name="' . $id . '[ignore_sticky_posts]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Exclude sticky posts from search.", 'ivory-search' ) . '</label></p>' ;
        ?>
			</div></div>

		<?php 
        global  $wp_version ;
        
        if ( 4.9 <= $wp_version ) {
            ?>

			<h3 scope="row">
				<label for="<?php 
            echo  $id ;
            ?>-post_file_type"><?php 
            echo  esc_html( __( 'File Types', 'ivory-search' ) ) ;
            ?></label>
			<span class="actions"><span class="indicator <?php 
            echo  $id ;
            ?>-post_file_type"></span><a class="expand" href="#"><?php 
            esc_html_e( 'Expand All', 'ivory-search' );
            ?></a><a class="collapse" href="#" style="display:none;"><?php 
            esc_html_e( 'Collapse All', 'ivory-search' );
            ?></a></span></h3>
			<div>
				<?php 
            $content = __( 'Exclude posts specially media attachment posts from the search having selected file types.', 'ivory-search' );
            IS_Help::help_info( $content );
            echo  '<div>' ;
            
            if ( isset( $includes['post_type'] ) && in_array( 'attachment', $includes['post_type'] ) ) {
                
                if ( !isset( $includes['post_file_type'] ) ) {
                    $file_types = get_allowed_mime_types();
                    
                    if ( !empty($file_types) ) {
                        $file_type_disable = ( is_fs()->is_plan_or_trial( 'pro_plus' ) && $this->is_premium_plugin ? '' : ' disabled ' );
                        ksort( $file_types );
                        echo  '<input class="list-search wide" placeholder="' . __( "Search..", 'ivory-search' ) . '" type="text">' ;
                        echo  '<select class="_is_excludes-post_file_type" name="' . $id . '[post_file_type][]" ' . $file_type_disable . ' multiple size="8" >' ;
                        foreach ( $file_types as $key => $file_type ) {
                            $checked = ( isset( $excludes['post_file_type'] ) && in_array( $file_type, $excludes['post_file_type'] ) ? $file_type : 0 );
                            echo  '<option value="' . esc_attr( $file_type ) . '" ' . selected( $file_type, $checked, false ) . '>' . esc_html( $key ) . '</option>' ;
                        }
                        echo  '</select>' ;
                        echo  IS_Admin::pro_link( 'pro_plus' ) ;
                        echo  '<br /><br /><label for="' . $id . '-post_file_type" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Press CTRL key & Left Mouse button to select multiple terms or deselect them.", 'ivory-search' ) . '</label>' ;
                    }
                
                } else {
                    echo  '<label>' . esc_html__( "Search has been already limited to specific File type set in the Includes section.", 'ivory-search' ) . '</label>' ;
                }
            
            } else {
                _e( 'Attachment post type is not included in search.', 'ivory-search' );
            }
            
            
            if ( isset( $excludes['post_file_type'] ) ) {
                echo  '<br />' . __( 'Excluded File Types :', 'ivory-search' ) ;
                foreach ( $excludes['post_file_type'] as $post_file_type ) {
                    echo  '<br /><span style="font-size: 11px;">' . $post_file_type . '</span>' ;
                }
                echo  '<span class="ind-status ' . $id . '-post_file_type"></span>' ;
            }
            
            ?>
			</div></div>

		<?php 
        }
        
        ?>
		</div>
		</div>
	<?php 
    }
    
    public function options_panel( $post )
    {
        $id = '_is_settings';
        $settings = $post->prop( $id );
        ?>
		<h4 class="panel-desc">
			<?php 
        _e( "Configure the options here to control search of this search form.", 'ivory-search' );
        ?>
		</h4>
		<div class="search-form-editor-box" id="<?php 
        echo  $id ;
        ?>">
		<div class="form-table">

			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-posts_per_page"><?php 
        echo  esc_html( __( 'Posts Per Page', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-posts_per_page"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
				<?php 
        echo  '<select class="_is_settings-posts_per_page" name="' . $id . '[posts_per_page]" >' ;
        $default_per_page = get_option( 'posts_per_page', 10 );
        $checked = ( isset( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : $default_per_page );
        for ( $d = 1 ;  $d <= 1000 ;  $d++ ) {
            echo  '<option value="' . $d . '" ' . selected( $d, $checked, false ) . '>' . $d . '</option>' ;
        }
        echo  '</select><label for="' . $id . '-posts_per_page"> ' . esc_html( __( 'Number of posts to display on search results page.', 'ivory-search' ) ) . '</label>' ;
        if ( $checked !== $default_per_page ) {
            echo  '<span class="ind-status ' . $id . '-posts_per_page"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-order"><?php 
        echo  esc_html( __( 'Order By', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-order"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
				<?php 
        $ind_status = false;
        $orderby_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
        echo  '<select class="_is_settings-order" name="' . $id . '[orderby]" ' . $orderby_disable . ' >' ;
        $checked = ( isset( $settings['orderby'] ) ? $settings['orderby'] : 'date' );
        if ( 'date' !== $checked ) {
            $ind_status = true;
        }
        $orderbys = array(
            'date',
            'relevance',
            'none',
            'ID',
            'author',
            'title',
            'name',
            'type',
            'modified',
            'parent',
            'rand',
            'comment_count',
            'menu_order',
            'meta_value',
            'meta_value_num',
            'post__in',
            'post_name__in',
            'post_parent__in'
        );
        foreach ( $orderbys as $orderby ) {
            echo  '<option value="' . $orderby . '" ' . selected( $orderby, $checked, false ) . '>' . ucwords( str_replace( '_', ' ', esc_html( $orderby ) ) ) . '</option>' ;
        }
        echo  '</select><select class="_is_settings-order" name="' . $id . '[order]" ' . $orderby_disable . ' >' ;
        $checked = ( isset( $settings['order'] ) ? $settings['order'] : 'DESC' );
        if ( !$ind_status && 'DESC' !== $checked ) {
            $ind_status = true;
        }
        $orders = array( 'DESC', 'ASC' );
        foreach ( $orders as $order ) {
            echo  '<option value="' . $order . '" ' . selected( $order, $checked, false ) . '>' . ucwords( str_replace( '_', ' ', esc_html( $order ) ) ) . '</option>' ;
        }
        echo  '</select>' ;
        echo  IS_Admin::pro_link() ;
        if ( $ind_status ) {
            echo  '<span class="ind-status ' . $id . '-order"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-highlight_terms"><?php 
        echo  esc_html( __( 'Highlight Terms', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-highlight_terms"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
			<?php 
        $ind_status = false;
        $checked = ( isset( $settings['highlight_terms'] ) && $settings['highlight_terms'] ? 1 : 0 );
        if ( $checked ) {
            $ind_status = true;
        }
        echo  '<p class="check-radio"><label for="' . $id . '-highlight_terms" ><input class="_is_settings-highlight_terms" type="checkbox" id="' . $id . '-highlight_terms" name="' . $id . '[highlight_terms]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Highlight searched terms on search results page.", 'ivory-search' ) . '</label></p>' ;
        $color = ( isset( $settings['highlight_color'] ) ? $settings['highlight_color'] : '#FFFFB9' );
        if ( !$ind_status && '#FFFFB9' !== $color ) {
            $ind_status = true;
        }
        echo  '<br /><br /><input class="_is_settings-highlight_terms" size="10" type="text" id="' . $id . '-highlight_color" name="' . $id . '[highlight_color]" value="' . $color . '" />' ;
        echo  '<label for="' . $id . '-highlight_color" > ' . esc_html__( "Set highlight color.", 'ivory-search' ) . '</label>' ;
        if ( $ind_status ) {
            echo  '<span class="ind-status ' . $id . '-highlight_terms"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-term_rel"><?php 
        echo  esc_html( __( 'Search Terms Relation', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-term_rel"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
			<?php 
        $term_rel_disable = ( is_fs()->is_plan_or_trial( 'pro' ) && $this->is_premium_plugin ? '' : ' disabled ' );
        $checked = ( isset( $settings['term_rel'] ) && "OR" === $settings['term_rel'] ? "OR" : "AND" );
        echo  '<p class="check-radio"><label for="' . $id . '-term_rel_or" ><input class="_is_settings-term_rel" type="radio" ' . $term_rel_disable . ' id="' . $id . '-term_rel_or" name="' . $id . '[term_rel]" value="OR" ' . checked( 'OR', $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "OR - Display content having any of the searched terms.", 'ivory-search' ) . '</label>' . IS_Admin::pro_link() . '</p>' ;
        echo  '<p class="check-radio"><label for="' . $id . '-term_rel_and" ><input class="_is_settings-term_rel" type="radio" ' . $term_rel_disable . ' id="' . $id . '-term_rel_and" name="' . $id . '[term_rel]" value="AND" ' . checked( 'AND', $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "AND - Display content having all the searched terms.", 'ivory-search' ) . '</label></p>' ;
        if ( "AND" !== $checked ) {
            echo  '<span class="ind-status ' . $id . '-term_rel"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-fuzzy_match"><?php 
        echo  esc_html( __( 'Fuzzy Matching', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-fuzzy_match"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
			<?php 
        $checked = ( isset( $settings['fuzzy_match'] ) ? $settings['fuzzy_match'] : '2' );
        echo  '<p class="check-radio"><label for="' . $id . '-whole" ><input class="_is_settings-fuzzy_match" type="radio" id="' . $id . '-whole" name="' . $id . '[fuzzy_match]" value="1" ' . checked( '1', $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Whole - Search posts that include the whole search term.", 'ivory-search' ) . '</label></p>' ;
        echo  '<p class="check-radio"><label for="' . $id . '-partial" ><input class="_is_settings-fuzzy_match" type="radio" id="' . $id . '-partial" name="' . $id . '[fuzzy_match]" value="2" ' . checked( '2', $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Partial - Also search words in the posts that begins or ends with the search term.", 'ivory-search' ) . '</label></p>' ;
        if ( "2" !== $checked ) {
            echo  '<span class="ind-status ' . $id . '-fuzzy_match"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-keyword_stem"><?php 
        echo  esc_html( __( 'Keyword Stemming', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-keyword_stem"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div>
			<?php 
        $content = __( 'Searches the base word of a searched keyword', 'ivory-search' );
        $content .= '<p>' . __( 'For Example: If you search "doing" then it also searches base word of "doing" that is "do" in the specified post types.', 'ivory-search' ) . '</p>';
        $content .= '<p>' . __( 'If you want to search whole exact searched term then do not use this options and in this case it is not recommended to use when Fuzzy Matching option is set to Whole.', 'ivory-search' ) . '</p>';
        IS_Help::help_info( $content );
        echo  '<div>' ;
        $stem_disable = ( is_fs()->is_plan_or_trial( 'pro_plus' ) && $this->is_premium_plugin ? '' : ' disabled ' );
        $checked = ( isset( $settings['keyword_stem'] ) && $settings['keyword_stem'] ? 1 : 0 );
        echo  '<p class="check-radio"><label for="' . $id . '-keyword_stem" ><input class="_is_settings-keyword_stem" type="checkbox" id="' . $id . '-keyword_stem" ' . $stem_disable . ' name="' . $id . '[keyword_stem]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Also search base word of searched keyword.", 'ivory-search' ) . '</label></p>' ;
        echo  IS_Admin::pro_link( 'pro_plus' ) ;
        echo  '<br /><label for="' . $id . '-keyword_stem" style="font-size: 10px;clear:both;display:block;">' . esc_html__( "Not recommended to use when Fuzzy Matching option is set to Whole.", 'ivory-search' ) . '</label>' ;
        if ( $checked ) {
            echo  '<span class="ind-status ' . $id . '-keyword_stem"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-move_sticky_posts"><?php 
        echo  esc_html( __( 'Sticky Posts', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-move_sticky_posts"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
			<?php 
        $checked = ( isset( $settings['move_sticky_posts'] ) && $settings['move_sticky_posts'] ? 1 : 0 );
        echo  '<p class="check-radio"><label for="' . $id . '-move_sticky_posts" ><input class="_is_settings-move_sticky_posts" type="checkbox" id="' . $id . '-move_sticky_posts" name="' . $id . '[move_sticky_posts]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Move sticky posts to the start of the search results page.", 'ivory-search' ) . '</label></p>' ;
        if ( $checked ) {
            echo  '<span class="ind-status ' . $id . '-move_sticky_posts"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-empty_search"><?php 
        echo  esc_html( __( 'Empty Search', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-empty_search"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
			<?php 
        $checked = ( isset( $settings['empty_search'] ) && $settings['empty_search'] ? 1 : 0 );
        echo  '<p class="check-radio"><label for="' . $id . '-empty_search" ><input class="_is_settings-empty_search" type="checkbox" id="' . $id . '-empty_search" name="' . $id . '[empty_search]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Display an error for empty search query.", 'ivory-search' ) . '</label></p>' ;
        if ( $checked ) {
            echo  '<span class="ind-status ' . $id . '-empty_search"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-exclude_from_search"><?php 
        echo  esc_html( __( 'Respect exclude_from_search', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-exclude_from_search"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
			<?php 
        $checked = ( isset( $settings['exclude_from_search'] ) && $settings['exclude_from_search'] ? 1 : 0 );
        echo  '<p class="check-radio"><label for="' . $id . '-exclude_from_search" ><input class="_is_settings-exclude_from_search" type="checkbox" id="' . $id . '-exclude_from_search" name="' . $id . '[exclude_from_search]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Do not search post types which are excluded from search.", 'ivory-search' ) . '</label></p>' ;
        if ( $checked ) {
            echo  '<span class="ind-status ' . $id . '-exclude_from_search"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-demo"><?php 
        echo  esc_html( __( 'Demo', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-demo"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
			<?php 
        $checked = ( isset( $settings['demo'] ) && $settings['demo'] ? 1 : 0 );
        echo  '<p class="check-radio"><label for="' . $id . '-demo" ><input class="_is_settings-demo" type="checkbox" id="' . $id . '-demo" name="' . $id . '[demo]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Display search form only for site administrator.", 'ivory-search' ) . '</label></p>' ;
        if ( $checked ) {
            echo  '<span class="ind-status ' . $id . '-demo"></span>' ;
        }
        ?>
			</div></div>


			<h3 scope="row">
				<label for="<?php 
        echo  $id ;
        ?>-disable"><?php 
        echo  esc_html( __( 'Disable', 'ivory-search' ) ) ;
        ?></label>
			<span class="actions"><span class="indicator <?php 
        echo  $id ;
        ?>-disable"></span><a class="expand" href="#"><?php 
        esc_html_e( 'Expand All', 'ivory-search' );
        ?></a><a class="collapse" href="#" style="display:none;"><?php 
        esc_html_e( 'Collapse All', 'ivory-search' );
        ?></a></span></h3>
			<div><div>
			<?php 
        $checked = ( isset( $settings['disable'] ) && $settings['disable'] ? 1 : 0 );
        echo  '<p class="check-radio"><label for="' . $id . '-disable" ><input class="_is_settings-disable" type="checkbox" id="' . $id . '-disable" name="' . $id . '[disable]" value="1" ' . checked( 1, $checked, false ) . '/>' ;
        echo  '<span class="toggle-check-text"></span>' . esc_html__( "Disable this search form.", 'ivory-search' ) . '</label></p>' ;
        if ( $checked ) {
            echo  '<span class="ind-status ' . $id . '-disable"></span>' ;
        }
        ?>
			</div></div>
		</div>
		</div>
		<?php 
    }

}
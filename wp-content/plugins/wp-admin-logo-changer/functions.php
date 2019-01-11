<?php
if (!defined('ABSPATH'))
    exit;

function wp_admin_logo_changer_class() {

    if (isset($_POST['save_logo']) && isset($_POST['image_url']) && !empty($_POST['image_url'])) {
        if (filter_var($_POST['image_url'], FILTER_VALIDATE_URL) !== FALSE) {
            update_option('wp_admin_logo_changer_image', sanitize_text_field($_POST['image_url']));
        }
    }

    $image_url = esc_html(get_option('wp_admin_logo_changer_image'));
    ?>
    <div class="wrap">
        <h1>WP Admin Logo Changer</h1>


        <form method="post">
            <p>
                <label><?php _e('Choose logo', 'wp-admin-logo-changer-logo'); ?></label><br/>
                <input type="text" id="image_url" size="30" name="image_url" class="form-input" value="<?php echo esc_html(get_option('wp_admin_logo_changer_image')); ?>">
                <input id="_btn" class="button button-large upload_image_button button-primary" type="button" value="Upload Image"/>
            </p>
            <p>	
                <img src="<?php echo $image_url ?>" style="<?php echo ($image_url) ? '' : 'display:none' ?>" class="attachment-post-thumbnail" id="image_display">
            </p>
            <p>
                <input class="button button-large button-primary btn-save" type="submit" name="save_logo" value="Save" />
            </p>
        </form>
    </div>
    <script>
        jQuery(document).ready(function () {
            var formfield;
            jQuery('.upload_image_button').click(function () {
                jQuery('html').addClass('Image');
                formfield = jQuery(this).prev().attr('name');
                tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                return false;
            });

            window.original_send_to_editor = window.send_to_editor;

            window.send_to_editor = function (html) {
                if (formfield) {
                    fileurl = jQuery(html).attr('src');
                    jQuery('#image_display').attr("src", fileurl); // <---- THE IMAGE SRC
                    jQuery('#image_display').show();
                    jQuery('#image_url').val(fileurl); // <---- THE IMAGE SRC
                    tb_remove();
                    jQuery('html').removeClass('Image');
                } else {
                    window.original_send_to_editor(html);
                }
            };
        });
    </script>
    <style>
        #image_display{
            border: 2px dashed gray;
            height: 84px;
            outline: 0 none;
            padding: 10px;
            width: auto;
        }
    </style>
    <?php
}
?>
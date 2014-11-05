<?php

add_action('admin_menu', 'callback_add_menu');

//добавляем пункт меню с настройками
function callback_add_menu() {
        //появится в общих настройках
        //add_options_page('CallBack', 'CallBack', 'manage_options', 'callback_options', 'callback_options_page'); 
        
        // добавляет пункт меню в WooCommerce
        add_submenu_page('woocommerce', 'CallBack', 'Callback', 8, CALLBACK_LINK, 'callback_options_page');
        
        add_action( 'admin_init', 'register_wc_callback_settings' );
        
}

function register_wc_callback_settings() {
  register_setting( 'wc-callback' , 'wccb_popup_text' );
  register_setting( 'wc-callback' , 'wccb_replace_cart' );
}

//добавляем ссылку на страницу настроек со страницы плагинов

add_filter( 'plugin_action_links', 'filter_callback_link', 10, 4 );

function filter_callback_link ($links, $file) {
    if ( $file != WPWCCB_PLUGIN_DIR) return $links;
    
    //$settings_link = '<a href="admin.php?page=$options_link">' . __('Settings') . '</a>';
    $link = '<a href="admin.php?page=' . CALLBACK_LINK . '">' . __('Settings') . '</a>';
    array_unshift($links, $link);
    return $links;
}

//страница настроек
function callback_options_page() {
    ?>
    <div class="wrap">
    <h2><?php _e('Settings') ?> WooCommerce CallBack</h2>
    <form method="post" action="options.php">
    <?php settings_fields( 'wc-callback' ); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php _e('Popup window contents','woocommerce_callback') ?></th>
             <td>
                 <textarea name="wccb_popup_text" rows="5" cols="50"><?php echo get_option('wccb_popup_text'); ?></textarea>
                 <p class="description"><?php _e('Insert form shortcode here','woocommerce_callback') ?></p>
             </td>
        </tr>
        <tr>
             <th scope="row"><?php _e('Replace "Proceed to Checkout" button in the cart','woocommerce_callback') ?></th>
             <td>
                 <input type="checkbox" name="wccb_replace_cart" value="1" <?php if(get_option('wccb_replace_cart')):?>checked="checked"<?php endif;?> />
             </td>
        </tr>
    </table>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
    </form>
    </div>
    <?php
}

?>
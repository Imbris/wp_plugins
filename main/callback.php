<?php
//Задачи!
//либо встроить использование fancybox внутрь плагина, либо использовать стандартные возможности woocommerce и callisto
//добавить замену кнопки корзины

define(WPWCCB_PLUGIN_DIR, plugin_basename(__FILE__));
define ( CALLBACK_LINK, 'callback_options');

//загружаем настройки

//опции добавляются через register_setting
//$option_value = 'что-то написано!';
//add_option('wccb_popup_text', $option_value);


//подключаем перевод
add_action('init', 'woocommerce_callback_translate');
 
function woocommerce_callback_translate() {
          load_plugin_textdomain('woocommerce_callback', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
}
do_action('woocommerce_callback_translate');

//подключаем стили
function callback_styles()
{
    // Register the style like this for a plugin:
    wp_register_style( 'callback_style', plugins_url( '/style.css', __FILE__ ));

    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style( 'callback_style' );
}
add_action( 'wp_enqueue_scripts', 'callback_styles', 99 );

function callback_button() {
    ?>
    <a style="line-height: 19px;" class="fancybox button-3 call_back trans-1 custom-font-1" href="#contact_form_pop"><span style="background: none; padding: 5px 15px;"><?php _e('Сallback', 'woocommerce_callback'); ?></span></a>
            <div style="display:none" class="fancybox-hidden">
             <div id="contact_form_pop">     
                <?php echo do_shortcode(get_option('wccb_popup_text')); ?>           
                <?php //echo do_shortcode('[contact-form-7 id="2345" title="Обратный звонок"]');?>
             </div>
           </div>
           <br clear="all"/>
    <?php
    }

    //регистрируем hook для кнопки на странице товара
    add_action('woocommerce_before_add_to_cart_form','callback_button');

    //применяем hook
    do_action('callback_button');
    
    include_once('admin/main.php');

?>
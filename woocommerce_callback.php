<?php
/*
Plugin Name: WooCommerce Callback Button
Plugin URI: 
Description: Добавляет кнопку обратного звонка к магазину WooCommerce. Для корректной работы всплывающего окна необходим плагин Easy FancyBox
Version: 1.0
Author: Imbris
Author URI: 
*/

/*  Copyright 2014  Imbris  (email: d.p.vainstein@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/ 


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
    
    if(get_option('wccb_disable_cart')) {
        wp_register_style( 'disable_cart', plugins_url( '/disable_cart.css', __FILE__ ));
    }

    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style( 'callback_style' );
    wp_enqueue_style( 'disable_cart' );
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
    
    //включение корзины для всех товаров
    /*add_filter( 'woocommerce_is_purchasable', 'everything_is_purchasable', 10, 4 );
    
    function everything_is_purchasable($purchasable, $this) {
        return true;
    }*/
    
    //принудительное добавление нулевой стоимости товарам без указания цены
    if(get_option('wccb_fill_blank_price')) {
        add_filter( 'woocommerce_get_price', 'conv_blank_to_free', 10, 4 );
    }
    
    function conv_blank_to_free($price) {
        if ( $price ==='' ) { $price = 0; }
        return $price;
    }
        
    include_once('admin/main.php');
?>
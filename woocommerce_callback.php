<?php
/*
Plugin Name: WooCommerce Callback Button (Trial)
Plugin URI: 
Description: Добавляет кнопку обратного звонка к магазину WooCommerce
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

add_option( 'wccb_trial_since', time());


define (WCCB_MIN, 60);
define (WCCB_HOUR, 60*WCCB_MIN);
define (WCCB_DAY, 24*WCCB_HOUR );
define (WCCB_WEEK, 7*WCCB_DAY);

define (WCCB_TIME, 55*WCCB_MIN + get_option('wccb_trial_since') - time());

if (WCCB_TIME<0) {
    
    add_filter( 'plugin_action_links', 'filter_timelimit_link', 10, 4 );
    
    function filter_timelimit_link ($links, $file) {
    if ( $file != WPWCCB_PLUGIN_DIR) return $links;
    
    $link = '<a href="mailto:d.p.vainstein@gmail.com">восстановить</a>';
    array_unshift($links, $link);
    return $links;
    }
    
} else include_once('main/callback.php');
?>
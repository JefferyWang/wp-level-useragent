<?php
/*
Plugin Name: WP-Level-Useragent
Plugin URI: http://blog.wangjunfeng.com
Description: 一个简单的，可以显示评论者评论等级及UA信息的插件。
Version: 0.1.0
Author: Wang Junfeng
Author URI: http://blog.wangjunfeng.com/
*/

/* Copyright 2015  Jeffery Wang  (email: admin@wangjunfeng.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// 检验并设置常用常量
if (!defined('WP_CONTENT_URL'))
    define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if (!defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
if (!defined('WP_PLUGIN_URL'))
    define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');
if (!defined('WP_PLUGIN_DIR'))
    define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');

// 插件配置信息
$ua_output_location = 'default';
$css_url = WP_PLUGIN_URL . "/wp-level-useragent/css/ua.css";


include(WP_PLUGIN_DIR . '/wp-level-useragent/lib/wp-useragent-detect-os.php');
include(WP_PLUGIN_DIR . '/wp-level-useragent/lib/wp-useragent-detect-webbrowser.php');
include(WP_PLUGIN_DIR . '/wp-level-useragent/lib/wp-useragent-level.php');

// 主函数
function wp_level_useragent()
{
    if (is_single() || is_page()) {
        global $comment, $useragent;

        get_currentuserinfo();


        $useragent = wp_strip_all_tags($comment->comment_agent, false);

        ua_comment();
        display_level_useragent();
        add_filter('comment_text', 'wp_level_useragent');
    }
}

function css() {
    wp_register_style( 'us_css', plugins_url( 'css/ua.css' , __FILE__ ));
    wp_register_style( 'font_css', 'http://apps.bdimg.com/libs/fontawesome/4.2.0/css/font-awesome.min.css');
    if ( !is_admin() ) {
        wp_enqueue_style( 'us_css' );
        wp_enqueue_style( 'font_css' );
    }
}
add_action( 'wp_head', 'css' );

function display_level_useragent()
{
    global $comment;

    if ($comment->comment_type == 'trackback' || $comment->comment_type == 'pingback') {
        $ua = "";
    } else {
        $level = "";
        if ($comment->comment_author_email != '') {
            $level = user_level($comment->comment_author_email);
        }
        $os = detect_os();
        $webbrowser = detect_webbrowser();

        $ua = '<div class="ds-comment-header">'.$level.$webbrowser.$os.'</div>';
    }

    if (empty($_POST['comment_post_ID'])) {
        echo $ua;
    }
}

function useragent_output_custom()
{
    global $ua_output_location, $useragent, $comment;

    if ($ua_output_location == "custom") {
        get_currentuserinfo();
        $useragent = wp_strip_all_tags($comment->comment_agent, false);
        display_useragent();
    }
}


function ua_comment()
{
    global $comment;

    remove_filter('comment_text', 'wp_level_useragent');
    apply_filters('get_comment_text', $comment->comment_content);

    if (empty($_POST['comment_post_ID'])) {
        echo apply_filters('comment_text', $comment->comment_content);
    }
}


if ($ua_output_location != 'custom') {
    add_filter('comment_text', 'wp_level_useragent');
}

?>

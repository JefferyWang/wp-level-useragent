<?php
/* Copyright 2015  JefferyWang  (email: admin@wangjunfeng.com)

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

function user_level($user_email)
{
    global $wpdb;
    $querystr = "SELECT comment_author_email FROM wp_comments where comment_author_email='" . $user_email . "' AND comment_author_email<>'' AND comment_author_email<>'407586321@qq.com'";
    $results = $wpdb->get_results($querystr);
    $mun = (count($results));
    if ($mun <= 5) {
        $level = 1;
        $level_type = "1-4";
    } elseif ($mun <= 10) {
        $level = 2;
        $level_type = "1-4";
    } elseif ($mun <= 15) {
        $level = 3;
        $level_type = "1-4";
    } elseif ($mun <= 20) {
        $level = 4;
        $level_type = "1-4";
    } elseif ($mun <= 25) {
        $level = 5;
        $level_type = "5-7";
    } elseif ($mun <= 30) {
        $level = 6;
        $level_type = "5-7";
    } elseif ($mun <= 35) {
        $level = 7;
        $level_type = "5-7";
    } elseif ($mun <= 40) {
        $level = 8;
        $level_type = "8-10";
    } elseif ($mun <= 45) {
        $level = 9;
        $level_type = "8-10";
    } elseif ($mun <= 50) {
        $level = 10;
        $level_type = "8-10";
    }
    $level_array = array(
        '1' => '潜水',
        '2' => '冒泡',
        '3' => '吐槽',
        '4' => '活跃',
        '5' => '话唠',
        '6' => '畅言',
        '7' => '专家',
        '8' => '大师',
        '9' => '传说',
        '10' => '神话',
    );
    return '<span class="user-level-gw user-' . $level_type . '-gw user-' . $level . '-gw" title="等级'
    . $level . '：' . $level_array[$level] . '

等级规则：
  0<评论数≤ 5：潜水
  5<评论数≤10：冒泡
 10<评论数≤15：吐槽
 15<评论数≤20：活跃
 20<评论数≤25：话唠
 25<评论数≤30：畅言
 30<评论数≤35：专家
 35<评论数≤40：大师
 40<评论数≤45：传说
    评论数 >45：神话"><i>' . $level_array[$level] . '</i></span>';
}

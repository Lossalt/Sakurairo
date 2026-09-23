<?php
/**
 * Module: 个性化设置项（挂到主题 iro-Options）
 *
 * 在主题设置页追加「Personal · 页面展示」分区：
 * 按页面模板独立控制是否隐藏前端页标题（.linkss-title）。
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 页面模板 → 设置项映射（供 page-display 等模块复用）
 */
function personal_page_display_map() {
    return array(
        'user/page-archive.php'       => array(
            'option' => 'personal_hide_title_archive',
            'label'  => '归档页（Archive Template）',
        ),
        'user/page-bangumi.php'       => array(
            'option' => 'personal_hide_title_bangumi',
            'label'  => '番剧页（Bangumi Template）',
        ),
        'user/page-followVideos.php'  => array(
            'option' => 'personal_hide_title_followvideos',
            'label'  => '追剧页（Bilibili FollowVideos Template）',
        ),
        'user/page-steam.php'         => array(
            'option' => 'personal_hide_title_steam',
            'label'  => 'Steam 页（Steam Library Template）',
        ),
        'user/page-links.php'         => array(
            'option' => 'personal_hide_title_links',
            'label'  => '友链页（Friendly Links Template）',
        ),
        'user/page-bilibiliFavList.php' => array(
            'option' => 'personal_hide_title_bilibili',
            'label'  => 'B站收藏页（Bilibili FavList Template）',
        ),
    );
}

// 默认与线上一致：归档 / 番剧 / 追剧 / Steam 隐藏标题
function personal_page_display_defaults() {
    return array(
        'personal_hide_title_archive'      => true,
        'personal_hide_title_bangumi'      => true,
        'personal_hide_title_followvideos' => true,
        'personal_hide_title_steam'        => true,
        'personal_hide_title_links'        => false,
        'personal_hide_title_bilibili'     => false,
    );
}

if (class_exists('Sakurairo_CSF')) {
    $fields = array(
        array(
            'type'    => 'submessage',
            'style'   => 'info',
            'content' => '开启后，对应页面模板前端不再输出页标题（.linkss-title）。标题仍保留在页面数据中，便于后台识别与 SEO 设置。',
        ),
    );

    foreach (personal_page_display_map() as $meta) {
        $defaults = personal_page_display_defaults();
        $fields[] = array(
            'id'      => $meta['option'],
            'type'    => 'switcher',
            'title'   => $meta['label'],
            'label'   => '隐藏前端页标题',
            'default' => !empty($defaults[$meta['option']]),
        );
    }

    Sakurairo_CSF::createSection('iro_options', array(
        'id'          => 'personal_page_display',
        'title'       => 'Personal · 页面展示',
        'icon'        => 'fa fa-eye-slash',
        'description' => '私人定制：按页面模板控制标题显隐',
        'fields'      => $fields,
    ));
}

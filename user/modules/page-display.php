<?php
/**
 * Module: 自定义页前端展示
 *
 * 根据主题设置（Personal · 页面展示）按模板隐藏/显示 .linkss-title。
 * 设置项定义见 user/modules/options.php。
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', function () {
    $map = personal_page_display_map();
    $defaults = personal_page_display_defaults();
    $hide_selectors = array();

    foreach ($map as $template => $meta) {
        if (!is_page_template($template)) {
            continue;
        }
        $on = iro_opt($meta['option'], $defaults[$meta['option']] ?? false);
        // CSF switcher 可能存 true/1/'1'/'true'
        if ($on === true || $on === 1 || $on === '1' || $on === 'true') {
            $hide_selectors[] = '.linkss-title';
            break;
        }
    }

    if (empty($hide_selectors)) {
        return;
    }

    $handle = 'personal-page-display';
    wp_register_style($handle, false);
    wp_enqueue_style($handle);
    wp_add_inline_style($handle, '.linkss-title{display:none !important;}');
}, 20);

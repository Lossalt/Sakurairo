<?php
/**
 * Module: 归档缓存手动刷新
 *
 * - 仅管理员可见「刷新归档」按钮（挂在 Archive Template 页脚）
 * - 访问 ?flush_archive=1 时删除 time_archive transient 并回跳
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('template_redirect', function () {
    if (!isset($_GET['flush_archive'])) {
        return;
    }
    if (!current_user_can('manage_options')) {
        return;
    }
    delete_transient('time_archive');
    wp_safe_redirect(remove_query_arg('flush_archive'));
    exit;
}, 5);

add_action('wp_footer', function () {
    if (!is_page_template('user/page-archive.php')) {
        return;
    }
    if (!current_user_can('manage_options')) {
        return;
    }
    $url = esc_url(add_query_arg('flush_archive', '1'));
    echo '<div style="text-align:center;padding:24px 0 8px;">'
        . '<a href="' . $url . '" style="display:inline-block;padding:6px 18px;border-radius:16px;font-size:12px;color:#999;background:rgba(0,0,0,0.03);text-decoration:none;transition:all 0.2s;" onmouseover="this.style.color=\'#667eea\';this.style.background=\'rgba(102,126,234,0.08)\'" onmouseout="this.style.color=\'#999\';this.style.background=\'rgba(0,0,0,0.03)\'">🔄 刷新归档</a>'
        . '</div>';
}, 5);

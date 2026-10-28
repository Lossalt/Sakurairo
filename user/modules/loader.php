<?php
/**
 * Personal feature modules loader.
 *
 * Each module is self-contained. Keep theme core close to upstream;
 * put site-specific behavior in user/modules/ instead of editing core files.
 *
 * Modules:
 * - options.php       主题设置项（Personal · 页面展示 / 本地音乐库）
 * - shuoshuo.php      说说：CPT 参数、查询、后台管理、归档 AJAX（前端模板见 archive-shuoshuo.php）
 * - page-display.php  按设置隐藏自定义页前端标题
 * - archive-cache.php 归档页缓存手动刷新
 * - local-music.php   本地曲库（APlayer 列表 / 音频 / LRC·内嵌歌词 / 封面）
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/options.php';
require_once __DIR__ . '/shuoshuo.php';
require_once __DIR__ . '/page-display.php';
require_once __DIR__ . '/archive-cache.php';
require_once __DIR__ . '/local-music.php';

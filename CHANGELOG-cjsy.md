# 更新日志（cjsy fork）

本 fork 基于 [mirai-mamori/Sakurairo](https://github.com/mirai-mamori/Sakurairo)，主线已引导用户迁移到
[Myriad](https://github.com/mirai-mamori/Myriad)，Sakurairo 基本进入维护模式。本分支的目标是：

1. **自包含**：字体、图标、装饰素材全部随主题分发，不依赖任何第三方 CDN；
2. **保留本地定制**：`user/modules/` 个人模块、说说、本地曲库等；
3. **可持续**：可以继续从上游合并更新，不被 fork 改动挡住。

---

## 3.1.0-cjsy.1

### 新增：内联全部外部依赖资源

| 资源 | 原来源 | 现位置 | 体积 |
| --- | --- | --- | --- |
| Noto Serif SC / Noto Sans SC / Fira Code / Concert One | `cdn2.tianli0.top`（已 502）→ `fonts.loli.net` | `assets/fonts/` | 5.9 MB |
| Font Awesome 6.7.2（前台） | `s4.zstatic.net` | `assets/fontawesome/6.7.2/` | 396 KB |
| Font Awesome 5.15.4（后台面板） | `s4.zstatic.net` | `assets/fontawesome/5.15.4/` | 176 KB |
| Font Awesome 4.7.0（后台兼容） | `s4.zstatic.net` | `assets/fontawesome/4.7.0/` | 108 KB |
| Vision 素材（293 个：背景 / 加载动画 / 社交图标 / 评论表情 / UA 图标） | `s.nmxc.ltd/sakurairo_vision/@3.0`、`@2.7` | `assets/vision/` | 6.8 MB |

字体原样保留 Google 的 211 个 `unicode-range` 子集切分——浏览器只下载页面实际用到的字形，
平均单页仍然只有几十 KB，不会因为自托管而变慢。

### 变更：所有资源默认值指向本地

| 位置 | 改动 |
| --- | --- |
| `header.php` | 移除对 `s4.zstatic.net`、Google Fonts 的 `preconnect`；Font Awesome 与字体改为本地 |
| `functions.php` | 后台 / 登录页 / 前台工具条的字体改本地；更新检查指向 `Lossalt/Sakurairo` |
| `opt/options/theme-options.php` | `fontawesome_source`、`vision_resource_basepath` 默认值改本地；`shared_library_basepath` 默认打开 |
| `inc/blocks/iro_blocks.php` | 编辑器 Font Awesome 改本地 |
| `inc/swicher.php`、`inc/customizer.php`、`inc/decorate.php`、`exhibition.php`、`layouts/post-nextprev.php`、`404.php`、`footer.php` | 共 19 处 `vision_resource_basepath` 回退值改本地 |
| `opt/classes/setup.class.php` | 后台 Font Awesome 改本地 |

### 新增：随机图目录预留

`assets/random-img/` 目录与说明已就位，但**不分发图片**（266 张约 89 MB）。需要时按
`assets/random-img/README.md` 放入即可，无需改代码。

### 修复：资源加载阻塞

- 字体 CSS 改为 `media="print" onload="this.media='all'"` 非阻塞加载；
- Font Awesome 只是 `preload` + 普通样式表，不再等待跨域 DNS/TCP/TLS。

### 修复：移动端可访问性

- `<meta name="viewport">` 去掉 `maximum-scale=1.0, user-scalable=0`，恢复双指缩放（WCAG 1.4.4）。

### 工程：仓库卫生

- 全仓文本文件统一换行符、文件权限归一为 `644/755`，消除 886 个纯噪声 diff；
- 补齐 `user/modules/local-music.php`、`PLAYLIST.html`、`PLAYLIST.md` 与线上保持一致。

---

### 变更：设置首页改为本分支说明

原「Hello!」分区是上游作者的赞助页（爱发电 / Liberapay / unifans 收款码，
外加两张从 `fuukei-api.nyat.icu` 拉取的图片）。fork 继续保留容易让人误捐，整块替换为：

- **来历**：从 `mirai-mamori/Sakurairo` v3.0.11 fork，上游转向 Myriad 后接手维护
- **变化**：资源全部内联、默认值指向本地、个人模块、若干问题修复
- **链接**：代码仓库 / 更新日志 / 博客
- **版权**：原主题 GPL-2.0 归 Fuukei 与 mirai-mamori，本分支改动同样 GPL-2.0

同时删除 `assets/vision/readme/`（3 张赞助配图）与贡献者外链图。

### 修复：后台配图本地化导致的整站 500

`CSF_Options` 的 `public $args` 是类属性默认值，只能写常量表达式。
把 `esc_url(get_template_directory_uri())` 直接写进去会触发
`Constant expression contains invalid operations`，且该类在**解析阶段**即崩，
影响范围是整站而不只是后台。已改为在 `__construct` 中赋值（`wp_parse_args` 之前，
保留调用方覆盖能力）。

---

## 待办（未在本版处理）

| 项 | 说明 |
| --- | --- |
| Prism.js 自托管 | 仅在「代码高亮方式 = Prism」时加载，`opt/options/theme-options.php` 里 `code_highlight_prism_autoload_path` 默认仍指向 jsDelivr。主站用 `code-syntax-block` 插件，不受影响。 |
| CodeMirror | `opt/fields/code_editor/` 的后台自定义 CSS/JS 编辑器依赖 `s4.zstatic.net`，被 5 个选项使用，需连同 addon/mode 动态加载一起搬迁。 |
| Leaflet | `opt/fields/map/` 的地图字段，当前无任何选项使用，可不处理。 |
| 随机封面图 266 张 | 见 `assets/random-img/README.md`。 |
| 版本 tag | 仓库已有分支 `release/3.1.0-cjsy`，尚未打 tag。若要让 WordPress 自动更新生效，需补 `3.1.0-cjsy.1` tag。 |

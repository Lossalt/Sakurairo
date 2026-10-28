# assets/ 说明

本目录是 **cjsy fork 新增**的自包含资源层。

原版 Sakurairo 把字体、Font Awesome、Vision 素材都放在第三方 CDN 上（`s4.zstatic.net`、
`s.nmxc.ltd`、`fonts.googleapis.com` / 各类 Google Fonts 镜像）。这些 CDN 时有失效——
upstream 默认的字体源 `cdn2.tianli0.top` 就曾长期 502，导致全站字体静默回退。

从 `3.1.0-cjsy.1` 起，以下资源随主题一起分发，访客侧不再产生任何跨域请求。

## 目录结构

```
assets/
├── fonts/
│   ├── fonts.css              # 自托管 @font-face（211 个 unicode-range 子集）
│   └── files/*.woff2          # Noto Serif SC / Noto Sans SC / Fira Code / Concert One
├── fontawesome/
│   ├── 6.7.2/                 # 前台图标
│   ├── 5.15.4/                # 后台设置面板图标
│   └── 4.7.0/                 # 后台兼容（apply_filters('csf_fa4', true) 时启用）
├── vision/                    # 主题装饰素材（背景、加载动画、设置页预览图等）
└── random-img/                # 预留：随机封面图，默认不随仓库分发
```

## 行为开关

| 需求 | 做法 |
| --- | --- |
| 恢复使用外部字体 CDN | `define('CJSY_LOCAL_FONTS', false);` 并在主题设置里填 `gfonts_api` |
| 恢复使用外部 Vision 素材 | 主题设置 → `vision_resource_basepath` 填回 CDN 地址 |
| 恢复使用外部 Font Awesome | 主题设置 → `fontawesome_source` 填回 CDN 地址 |

本地资源是**默认值**，不是硬编码——所有选项仍然可以在后台覆盖。

## 第三方资源授权

| 资源 | 版本 | 授权 |
| --- | --- | --- |
| Font Awesome Free | 6.7.2 / 5.15.4 / 4.7.0 | 图标 CC BY 4.0，字体 SIL OFL 1.1，代码 MIT |
| Noto Serif SC | v36 | SIL OFL 1.1 |
| Noto Sans SC | — | SIL OFL 1.1 |
| Fira Code | — | SIL OFL 1.1 |
| Concert One | — | SIL OFL 1.1 |
| Vision 素材 | @3.0 | 沿用上游 [Fuukei/Sakurairo_Vision](https://github.com/Fuukei/Sakurairo_Vision) 仓库授权 |

字体与图标库仅做**格式裁剪**（去除 ttf/eot/svg 冗余源、只保留 woff2），未修改字形。

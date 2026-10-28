# assets/random-img/ —— 随机封面图（预留目录）

本目录默认**为空**，不随仓库分发图片。

原因：随机封面图体积很大（266 张 WebP 约 89 MB），塞进主题仓库会让 clone 变得很难受。
图片单独维护在 [Lossalt/random-img](https://github.com/Lossalt/random-img) 与
[Lossalt/article-image](https://github.com/Lossalt/article-image)。

## 目录约定

如果要把图片随主题一起分发，按下面的结构放入即可，主题不需要改动任何代码：

```
assets/random-img/
├── pc/1.webp … 197.webp           # 桌面端随机封面
├── mobile/1.webp … 69.webp        # 移动端随机封面
└── article_images/<token>.webp    # 按 token 索引的文章配图
```

## 推荐尺寸

| 用途 | 建议宽度 | 质量 | 参考体积 |
| --- | --- | --- | --- |
| `pc/` | 1280 px | WebP q80 | 60–110 KB |
| `mobile/` | 720 px | WebP q80 | 30–60 KB |
| `article_images/` | 与正文同宽 | WebP q80 | 视内容而定 |

原始素材常见为 2400 px 宽，直接用会在移动端浪费 5–6 倍流量。用 `vips` / `cwebp` 压到上表
尺寸即可：

```bash
vipsthumbnail src/1.webp -s 1280 -o "pc/1.webp[Q=80,strip]"
```

## 不放入仓库的替代方案

保持默认（目录为空）时，把主题设置里的封面图地址指向你自己的图片服务即可，
例如 `https://你的域名/wp-content/removeable/random-img/pc.php`。

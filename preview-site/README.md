# ココロラボ 静的プレビュー

日本語・英語のデザイン案を、ブラウザでそのまま開けるようにした控えです。
**本番の kocorolab.com はまだ変わっていません。**

## ブラウザで見る

コミット後の URL はプルリクエスト本文にあります。例:

- 日本語トップ: `https://cdn.jsdelivr.net/gh/kohnoda-glitch/kocorolab@<SHA>/preview-site/index.html`
- English: `https://cdn.jsdelivr.net/gh/kohnoda-glitch/kocorolab@<SHA>/preview-site/en/index.html`

右上の English / 日本語 で切り替えできます。ナビからサービス、活動・新着、発表文献、会社概要、お問い合わせも開けます。

## 自分のパソコンで見る

このフォルダをダウンロードして `index.html` をブラウザで開いても同じです。

再生成する場合:

```bash
php preview-site/build.php
```

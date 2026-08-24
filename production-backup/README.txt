本番サイト（kocorolab.com）の退避と載せ替え

日付: 2026-08-24
このフォルダの HTML は、載せ替え前の Avalon テーマ画面の控えです。

退避したページ:
- home.html / en-home.html
- hakkou.html / en-publications.html
- service, company, member, news, contact（および英語のあるもの）

戻せ方:
1. サーバーの wp-content/mu-plugins/ から次を外す（リネームでも可）
   - kocorolab-site-refresh.php
   - kocorolab-site-refresh/
   - kocorolab-jcss-2025.php
2. テーマ Avalon はそのまま残してあるので、旧デザインに戻ります。
3. 控え HTML は見た目の記録です。WordPress のデータベースそのものは消していません。

載せ替え方（XServer）:
1. このリポジトリの次を本番の wp-content に置く
   - mu-plugins/kocorolab-site-refresh.php
   - mu-plugins/kocorolab-site-refresh/
   - mu-plugins/kocorolab-jcss-2025.php
   - uploads/kocorolab-refresh/（仮写真）
2. テーマは変えなくてよい。プラグインが全ページの見た目を上書きします。
3. お問い合わせのフォームは WordPress の既存フォームが残ります。
4. 活動・新着は、本番のニュース投稿が一覧になります。

写真の差し替え:
WordPress 管理画面 → 外観 → カスタマイズ → ココロラボの写真
または uploads/kocorolab-refresh/ に同名ファイルを上書き。

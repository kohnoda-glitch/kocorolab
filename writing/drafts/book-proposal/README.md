# 出版企画書（編集者提出用・第1案）

Drive 原本: [出版企画（猪原・飯田・野田）](https://drive.google.com/drive/folders/1uJ2U6lLQ5q2jJvm0dlMiC6ZAAPY03wjL)

提出用はこれだけです。50〜100項目の内部リストは入れていません。

| ファイル | 用途 |
| --- | --- |
| [OPEN-IN-BROWSER.html](https://htmlpreview.github.io/?https://github.com/kohnoda-glitch/kocorolab/blob/cursor/note-medium-writing-4caf/writing/drafts/book-proposal/OPEN-IN-BROWSER.html) | ブラウザで読む・印刷する |
| `出版企画書_感情力の時代_編集者提出用.md` | 中身のテキスト |
| `出版企画書_感情力の時代_編集者提出用.docx` | Google ドキュメント / Word |

## Google ドキュメントにする

1. Drive の同じフォルダに `出版企画書_感情力の時代_編集者提出用.docx` を上げる。
2. 右クリック → **アプリで開く** → **Google ドキュメント**。
3. 必要なら PDF はドキュメント側の **ファイル → ダウンロード → PDF**。

こちらから Google ドキュメントを新規作成する権限はありません。docx を上げるのが正規のルートです。

## この第1案で決めていること

- 本文の骨格は 8 月の 3 名企画（感情力・5層・5ステップ）。
- 昭和は書店の入口だけ。中身を昭和礼賛にしない。
- 飯田・猪原の著者表記、松岡の執筆範囲は「これから確認」。
- 公開肩書は 代表取締役 / 専任教員。准教授とは書かない。

再生成:

```bash
python3 writing/scripts/build_book_proposal.py
python3 writing/scripts/test_book_proposal.py
```

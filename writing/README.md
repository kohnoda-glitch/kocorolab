# note ↔ Medium writing workflow

Gemini の3段（原稿を Markdown にする → Cursor で一括翻訳 → Medium へ下書き）のうち、**1と2はそのまま使えます。** 3だけ、公式の Medium API が 2023 年に凍結されているので、新規トークンでは自動投稿できません。

| Gemini の提案 | 実際 |
| --- | --- |
| 原稿を Markdown で用意 | `python3 writing/scripts/fetch_public_posts.py` |
| Cursor で日本語 Markdown ➔ 学術的・プロフェッショナルな英文 Markdown | Agent に `writing/prompts/ja-to-en.md` と原文を渡す |
| Python で Medium API を叩いて Draft 一括アップロード | 新規では不可。https://medium.com/new に貼る |

ログイン自動化（ブラウザ操作で Medium に投稿）は作りません。確認は人がします。

## 1. 吸い出し

```bash
python3 writing/scripts/fetch_public_posts.py
```

出力:

- `writing/source/note-ja/` — note の日本語
- `writing/source/medium-en/` — Medium の英語
- `writing/source/medium-ja/` — Medium に入ってしまった日本語
- `writing/INVENTORY.md` — 対応漏れの表

Medium の RSS は新しい記事だけです。古い Medium は RSS に出ないことがあります。

## 2. Cursor で翻訳

Agent に、原文 Markdown とプロンプトを渡します。Cursor に貼る一括指示は `writing/prompts/cursor-ja-to-en-batch.md` です。

- 日本語 → 英語: `writing/prompts/ja-to-en.md`
- 英語 → 日本語: `writing/prompts/en-to-ja.md`

出来たファイルは `writing/drafts/en-from-note/` か `writing/drafts/ja-from-medium/` に置きます。

## 3. Medium へ

古い `MEDIUM_TOKEN` が残っているときだけ:

```bash
export MEDIUM_TOKEN='...'
python3 writing/scripts/medium_draft.py writing/drafts/en-from-note/your-file.md
```

トークンが無い／拒否されたら、https://medium.com/new に本文を貼って Draft 保存してください。

note も公式の投稿 API が無いので、同じく編集画面へ貼ります。

## いま分かっている漏れ（公開分）

**日本語なのに Medium にある**

- 誕生日にあたり（経済・金融の枠組みとか…）
- unauthorized translation（非公式翻訳）8つの新たな教訓
- SDGs 目標１絶対的貧困０達成チャレンジ in Africa → 英訳: `writing/drafts/en-from-medium/`（既存 Medium URL を上書き）。作業論文: `writing/drafts/articles/2020-sdgs-goal-1/`

**note にあって、英語 Medium が無い（例）**

- 昨年から今年にかけて考えていること——「これからの学び」のOSをアップデートする
- 日記・耳鳴り方丈記など私的なものは、英訳するかどうか先に決める

日記まで自動で英訳して Medium に載せる必要はありません。先に「学びのOS」など、公開してよいものだけドラフトします。

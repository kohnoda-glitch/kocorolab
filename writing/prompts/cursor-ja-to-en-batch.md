# Cursor Agent: 日本語 Markdown → 英文 Markdown

次の1ファイルだけを英訳してください。一括で複数ファイルを渡されたら、日記・耳鳴り方丈記は飛ばし、公開してよい論考だけ処理してください。

- プロンプト: `writing/prompts/ja-to-en.md` に従う
- 原文: 指定された `writing/source/note-ja/*.md`
- 出力先: `writing/drafts/en-from-note/YYYY-MM-DD-<english-slug>.md`
- 見出しレベル・段落・リンク・画像は崩さない
- トーンは学術的・実務的（認知科学・リーダーシップ・教育・気候）。マーケティング文にしない
- 固有名詞: GLOBIS, MIT, Otto Scharmer, Presencing Institute, Theory U, Kocoro Laboratory
- 肩書: MIT Sloan IDEAS Asia Pacific regional faculty; Globis University, Research Faculty; President of Kocoro Laboratory
- 訳者前書きは足さない
- 公開しない。ドラフトファイルを書くだけ

#!/usr/bin/env python3
"""Build the editor-facing book proposal (markdown + docx + html).

Rough first draft: chapter titles + a few headings, not the 50–100 item lists.
"""
from __future__ import annotations

from html import escape
from pathlib import Path

from docx import Document
from docx.enum.text import WD_ALIGN_PARAGRAPH, WD_LINE_SPACING
from docx.oxml.ns import qn
from docx.shared import Cm, Pt, RGBColor

ROOT = Path(__file__).resolve().parents[2]
OUT = ROOT / "writing" / "drafts" / "book-proposal"
STEM = "出版企画書_感情力の時代_編集者提出用"

NAVY = RGBColor(0x1A, 0x36, 0x5D)
INK = RGBColor(0x22, 0x22, 0x22)
MUTED = RGBColor(0x55, 0x55, 0x55)
RULE = RGBColor(0xC4, 0x5C, 0x26)

# kind: kicker | title | catch | meta | h1 | h2 | p | li | note
BLOCKS: list[tuple[str, str]] = [
    ("kicker", "出版企画書（編集者提出用・第1案）"),
    ("title", "『感情力の時代』—— AI・STEMの先にある人間的知性"),
    ("catch", "仕事のコミュニケーションコストは下げろ。人間のコミュニケーションコストは上げろ。"),
    ("meta", "企画：野田浩平（主著者）／飯田史也／猪原健弘　｜　共同発起人：松岡良彦　｜　2026年9月"),
    ("meta", "提出先想定：PHP研究所・英治出版・KADOKAWA（松岡経由の紹介を含む）"),
    (
        "h1",
        "0. この企画書の読み方",
    ),
    (
        "p",
        "骨格は、2026年8月に野田・飯田・猪原の3名で組み立てた『感情力の時代』（STEM拡張）です。5層・5ステップ・読者3層はそのまま使います。9月8日の松岡良彦氏とのZoom以降、「昭和というロストテクノロジー」は書店の入口（フック）として加えました。中身を昭和礼賛に差し替えるものではありません。",
    ),
    (
        "p",
        "提出用の目次は章タイトルと小見出しまでです。Driveにある50〜100項目の内部リストは、編集者と組んでから本文の肉付けに使います。飯田・猪原の最終的な著者表記、松岡の執筆範囲はこれから本人確認します。4人がすでに契約した共著、ではありません。",
    ),
    ("h1", "1. 一枚で言うと"),
    (
        "p",
        "AIとSTEMが仕事のコミュニケーションを速く安くするほど、残るのは「感じる・読み解く・言葉にする・整える・共に決める」という人間側の力です。本書はそれを感情力と呼び、身体→予測→意味→関係→集団・社会の5層で、親・教師・経営者に渡します。",
    ),
    ("h2", "書店で手に取る理由（帯の候補）"),
    ("li", "仕事のコストは下げろ。人間のコストは上げろ。"),
    ("li", "ChatGPTに「部下の気持ち」を聞くな。会いに行け。"),
    ("li", "昭和の全部を戻せ、ではない。捨てたはずの会う・雑談・世話・失敗の共有を、設計し直せ。"),
    ("li", "STEMの先に残るのは、感情を扱う知性である。"),
    ("h1", "2. なぜ今か"),
    (
        "p",
        "生成AIは、資料・翻訳・議事録・コードを圧縮しました。圧縮されないのは、身体で感じ、相手の状態を読み、言葉にして、関係を整え、合意に至ることです。学校では特別活動がまさにその訓練場です。家庭ではSTEM教育の親が「知識は足りている。足りないのは人間側だ」と気づき始めています。経営では、リモートとAIで仕事は回るが、人が離れ、現場の空気が読めない、という声が増えています。",
    ),
    (
        "p",
        "欧米では、工業化社会の延長線上にあるタスク処理型のエリート教育は限界だ、という議論がMIT・ハーバード・国連周辺で動いています。日本の親・教師・リーダーには、それが抽象的すぎて現場に落ちない。本書は、その潮流を日本の家庭・学校・職場の実装に落とすための一冊です。AIやSTEMを否定しません。エンジンを動かす操縦席が、感情力です。",
    ),
    (
        "p",
        "この本は、メンタルヘルスの診断書ではありません。組織と学びの現場で、感情を扱う力を設計する本です。",
    ),
    ("h1", "3. 読者"),
    (
        "p",
        "3層を同時に取ります。中心は「親でもある大人」です（猪原の特別活動ワーキンググループ参画を踏まえます）。",
    ),
    ("li", "STEM教育に関心のある親——知識は与えた。次に何を育てるか。"),
    ("li", "教師・学校関係者——特別活動・学級経営・探究の「感情の扱い方」。"),
    ("li", "経営者・マネジャー——AI導入後に残る、人と現場のコミュニケーション。"),
    (
        "p",
        "Z世代・若手には「昭和」という言葉のアレルギーがあります。だから昭和は入口のコピーに使い、本文は5層の感情力で読ませます。PHP・英治は感情力／人間力のタイトルを主、KADOKAWAは書店フックとして昭和案を併記します。",
    ),
    ("h1", "4. タイトル案（3トラック）"),
    ("h2", "A. 親・教育（PHP / 英治の第一候補）"),
    ("li", "『感情力の時代』—— AI・STEMの先にある人間的知性（本企画の正式タイトル）"),
    ("li", "『AI時代の「人間力」とは何か』—— 思考停止する大人と、迷える子どもたちに贈る知性の新定義"),
    ("li", "『「正解のない世界」で、自分を失わない技術』—— 身体の気づきから始める、親と子の軸"),
    ("h2", "B. ビジネス（リーダー層の入口）"),
    ("li", "仕事のコミュニケーションコストは下げろ。人間のコミュニケーションコストは上げろ。"),
    ("li", "『AIに代替されない「最後の知性」』—— データに奪われない、人と場の設計"),
    ("li", "『あなたの経験値が、明日から役に立たなくなる理由』—— 内発的モチベーションの再構築"),
    ("h2", "C. 昭和フック（KADOKAWA用。本文の中身ではない）"),
    ("li", "『昭和というロストテクノロジー』—— 捨てたのはパワハラではない。会う・雑談・世話・失敗の共有である"),
    (
        "note",
        "Cを表紙に使うなら、帯と序章で「ノスタルジーではない」と先に書きます。戻すのはパワハラ・飲酒強要・理不尽な上下ではありません。残すのは、身体を同じ場所に置くことです。PHP・英治にはAを主提案します。",
    ),
    ("h1", "5. 中心概念"),
    (
        "p",
        "感情力とは、感情に流される力でも、抑え込む技術でもありません。感情を情報として読み、行動を自分で選び直す力です。",
    ),
    ("h2", "5つのステップ"),
    ("li", "感じる——身体に生じている変化や、まだ言葉になっていない感覚に気づく。"),
    ("li", "読み解く——怒り、不安、空腹、疲労、嫉妬を混同せず、背景を理解する。"),
    ("li", "言葉にする——攻撃や沈黙ではなく、共有可能な情報として伝える。"),
    ("li", "整える——抑圧せず、感情と行動の間に選択肢をつくる。"),
    ("li", "共に決める——異なる感情や価値観を持つ人々が、対話し、合意し、行動する。"),
    ("h2", "5つの層"),
    ("li", "身体——心拍、呼吸、空腹、疲労。AIにはない出発点。"),
    ("li", "予測——予測と現実のずれ。驚きと好奇心。STEM学習の原動力。"),
    ("li", "意味——身体信号の解釈。データに価値を与える評価機能。"),
    ("li", "関係——表情、態度、期待、共感。ものづくりとチームに不可欠。"),
    ("li", "集団・社会——同調、制度、合意形成。特別活動と社会実装。"),
    ("h1", "6. 章構成（第1案）"),
    (
        "p",
        "内部には11章55項のリストがあります。提出はこの7本（序＋5章＋終）に圧縮します。各章、見出しは3つまで。担当は現時点の目安で、最終の著者表記は未確定です。",
    ),
    ("h2", "序章　感情力の時代がやってくる"),
    ("li", "なぜ「プログラミングができる子ども」ほど、AI時代に不安を感じるのか"),
    ("li", "仕事は速くなった。人が動かない。"),
    ("li", "本書の地図——5ステップと5層"),
    ("h2", "第1章　感情とは何か——理性の敵ではなく、生存の情報システム（野田）"),
    ("li", "「感情的にならないで」という大間違い"),
    ("li", "感情はノイズではなく、最速のフィルターである"),
    ("li", "価値を決める感情、手段を選ぶ理性"),
    ("h2", "第2章　感情は身体から始まる——AIにない身体知能（飯田）"),
    ("li", "ロボット研究者が、胃腸と心のつながりを見る理由"),
    ("li", "内受容感覚——自分の身体の微細なシグナル"),
    ("li", "予測と現実のずれが、学びと好奇心を起こす"),
    ("h2", "第3章　なぜ人は不機嫌になるのか——読み解き、整える（野田）"),
    ("li", "あの不機嫌の正体は、だいたい空腹か疲労である"),
    ("li", "感情と行動の間に、0.5秒の余白をつくる"),
    ("li", "沈黙と爆発は、同じ罠の両側である"),
    ("h2", "第4章　感情は人から人へ伝染する——家庭と組織の風土（野田×猪原）"),
    ("li", "リーダーの機嫌が、場の認知能力を決める"),
    ("li", "心理的安全性は、「何でも言っていい場所」ではない"),
    ("li", "会う、雑談、世話、失敗の共有——捨ててはいけない設計"),
    ("h2", "第5章　なぜ正しいことを言っても、人は動かないのか——集団と合意（猪原）"),
    ("li", "特別活動は、日本がすでに持っている感情力の訓練場である"),
    ("li", "SNSと群衆——理性を手放す仕組み"),
    ("li", "対立の奥にある恐怖・屈辱・意地を、対話の設計に載せる"),
    ("h2", "終章　家庭・学校・企業から始める"),
    ("li", "親が先に、自分の感情を情報として扱う"),
    ("li", "学校は知識の前に、共に決める場をつくる"),
    ("li", "経営は、仕事のコストを下げ、人間のコストを上げる"),
    (
        "note",
        "各章末に、短い実践を1つ置きます（身体の天気予報、感情の翻訳、驚きノート、場の感情地図、対話の問い）。理論だけで終わらせません。詳細のワークシートは編集者と詰めます。",
    ),
    ("h1", "7. 著者と参画状況（現時点の真実）"),
    (
        "p",
        "3名の専門が「感情」で交差するのが、この本の理由です。肩書は公開情報に合わせ、契約済みの4人共著のようには書きません。",
    ),
    ("h2", "野田浩平（主著者）"),
    (
        "p",
        "認知科学者（博士）。株式会社ココロラボ代表取締役。グロービス経営大学院専任教員。MIT IDEAS Asia Pacific Regional Faculty。認知・身体・組織のあいだで感情を扱い、リーダーシップ教育と学びのOSの更新に取り組む。担当の目安：感じる／読み解く／整える、組織の感情、序章と終章の通し。",
    ),
    ("h2", "飯田史也（企画メンバー。最終の著者表記はこれから確認）"),
    (
        "p",
        "ケンブリッジ大学工学部ロボティクス教授。東京大学大学院工学系研究科教授（精密工学）。BIRL（Bio-Inspired Robotics Laboratory）をケンブリッジと東京で主宰。身体性AI、バイオインスパイアード・ロボティクス。関連書に『世界最高峰の学び』。2026年8月、野田・猪原と3人で教育の先を話した。担当の目安：身体、予測、AIと人間の境界。共著の署名は未確定です。",
    ),
    ("h2", "猪原健弘（企画メンバー。最終の著者表記はこれから確認）"),
    (
        "p",
        "東京科学大学リベラルアーツ研究教育院教授。社会工学、意思決定、ゲーム理論、合意形成。中央教育審議会 初等中等教育分科会 教育課程部会 特別活動ワーキンググループ専門委員（2025年9月〜2027年3月）。年初から野田とZoomで継続。担当の目安：集団・社会、特別活動、合意形成。共著の署名は未確定です。",
    ),
    ("h2", "松岡良彦（共同発起人。必須条件。執筆範囲は未定）"),
    (
        "p",
        "出版社の「プロデューサー」ではありません。野田にとって、この企画を動かす共同発起人です。株式会社Ducks and Drakes。フィリピン・ドゥマゲテの Starting Point English Academy（SPEA）。日本初の子ども向けオンライン英会話の共同創業、体験型の英語学習（RLE）で野田と協働した経緯があります。KADOKAWAの編集者に企画を見せられる、と本人が言っています。肩書の書き方と執筆の有無は、本人確認のあとで直します。",
    ),
    ("h1", "8. 仕様"),
    ("li", "判型：四六判並製"),
    ("li", "分量：240〜320ページ（第1案は280ページ前後）"),
    ("li", "価格：1,700円前後（税別）"),
    ("li", "展開：保護者・教員向けの公開講座、3名（＋松岡）の鼎談、学校・企業向けの短いワーク"),
    ("h1", "9. 編集者へのお願い"),
    (
        "p",
        "第1案は、入口のコピーと中身の骨格を分けて出しています。タイトルは社の棚に合わせてA／B／Cから選んでください。本文の5層は変えません。50項目の目次を先に渡すと、企画が百科事典に見えます。章の見出しまでで一度、編集者と話したいです。",
    ),
    (
        "p",
        "飯田・猪原・松岡の氏名の出し方は、こちらで本人確認します。確認前に「4人の共著で決定」とは書かないでください。扇情的な戦争描写や、診断めいた医療表現は使いません。感情力は、現場の設計の話です。",
    ),
]


def set_run(run, *, size=11, bold=False, color=INK, name="Yu Mincho"):
    run.font.size = Pt(size)
    run.font.bold = bold
    run.font.color.rgb = color
    run.font.name = name
    rPr = run._element.get_or_add_rPr()
    rFonts = rPr.get_or_add_rFonts()
    rFonts.set(qn("w:eastAsia"), name)


def add_p(doc, text, *, size=11, bold=False, color=INK, space_after=8, space_before=0, align=None):
    p = doc.add_paragraph()
    pf = p.paragraph_format
    pf.space_after = Pt(space_after)
    pf.space_before = Pt(space_before)
    pf.line_spacing_rule = WD_LINE_SPACING.MULTIPLE
    pf.line_spacing = 1.35
    if align is not None:
        p.alignment = align
    run = p.add_run(text)
    set_run(run, size=size, bold=bold, color=color)
    return p


def build_docx(path: Path) -> None:
    doc = Document()
    sec = doc.sections[0]
    sec.top_margin = Cm(2.2)
    sec.bottom_margin = Cm(2.2)
    sec.left_margin = Cm(2.2)
    sec.right_margin = Cm(2.2)

    for kind, text in BLOCKS:
        if kind == "kicker":
            add_p(doc, text, size=12, bold=True, color=MUTED, space_after=4, align=WD_ALIGN_PARAGRAPH.CENTER)
        elif kind == "title":
            add_p(doc, text, size=18, bold=True, color=NAVY, space_after=8, align=WD_ALIGN_PARAGRAPH.CENTER)
        elif kind == "catch":
            add_p(doc, text, size=12, bold=True, color=RULE, space_after=10, align=WD_ALIGN_PARAGRAPH.CENTER)
        elif kind == "meta":
            add_p(doc, text, size=10, color=MUTED, space_after=4, align=WD_ALIGN_PARAGRAPH.CENTER)
        elif kind == "h1":
            add_p(doc, text, size=15, bold=True, color=NAVY, space_before=16, space_after=8)
        elif kind == "h2":
            add_p(doc, text, size=12, bold=True, color=NAVY, space_before=10, space_after=6)
        elif kind == "p":
            p = add_p(doc, text, size=11, space_after=8)
            p.paragraph_format.first_line_indent = Cm(0.7)
        elif kind == "li":
            p = add_p(doc, "・" + text, size=11, space_after=3)
            p.paragraph_format.left_indent = Cm(0.7)
        elif kind == "note":
            add_p(doc, text, size=10, color=MUTED, space_before=4, space_after=8)
        else:
            raise ValueError(kind)

    path.parent.mkdir(parents=True, exist_ok=True)
    doc.save(path)


def build_md(path: Path) -> None:
    lines: list[str] = []
    prev = ""
    for kind, text in BLOCKS:
        if prev == "li" and kind != "li":
            lines.append("")
        if kind == "kicker":
            lines.append(f"*{text}*")
            lines.append("")
        elif kind == "title":
            lines.append(f"# {text}")
            lines.append("")
        elif kind == "catch":
            lines.append(f"**{text}**")
            lines.append("")
        elif kind == "meta":
            lines.append(text)
            lines.append("")
        elif kind == "h1":
            lines.append(f"## {text}")
            lines.append("")
        elif kind == "h2":
            lines.append(f"### {text}")
            lines.append("")
        elif kind == "p":
            lines.append(text)
            lines.append("")
        elif kind == "li":
            lines.append(f"- {text}")
        elif kind == "note":
            lines.append(f"> {text}")
            lines.append("")
        else:
            raise ValueError(kind)
        prev = kind
    path.write_text("\n".join(lines).strip() + "\n", encoding="utf-8")


def build_html(path: Path) -> None:
    parts = [
        "<!DOCTYPE html>",
        '<html lang="ja">',
        "<head>",
        '<meta charset="utf-8">',
        '<meta name="viewport" content="width=device-width, initial-scale=1">',
        f"<title>{escape(STEM)}</title>",
        "<style>",
        "body { font-family: 'Yu Mincho', 'Hiragino Mincho ProN', serif; max-width: 720px; margin: 24px auto; padding: 0 16px 48px; line-height: 1.75; color: #222; }",
        ".note { font-family: sans-serif; background: #fff6d8; border: 1px solid #e6d48a; padding: 12px 16px; margin-bottom: 24px; font-size: 0.95rem; }",
        "h1 { font-size: 1.55rem; color: #1a365d; text-align: center; line-height: 1.4; }",
        "h2 { font-size: 1.2rem; color: #1a365d; margin-top: 2em; }",
        "h3 { font-size: 1.05rem; color: #1a365d; margin-top: 1.4em; }",
        ".kicker, .meta { text-align: center; color: #555; font-size: 0.95rem; }",
        ".catch { text-align: center; color: #c45c26; font-weight: bold; }",
        "ul { padding-left: 1.2em; }",
        "aside { color: #555; font-size: 0.95rem; border-left: 3px solid #c45c26; padding-left: 12px; margin: 1em 0; }",
        "@media print { .note { display: none; } body { max-width: none; } }",
        "</style>",
        "</head>",
        "<body>",
        '<div class="note">',
        "編集者提出用の第1案です。黄色い枠の下を印刷、または Word（docx）を Google ドライブに上げて「Google ドキュメントで開く」。",
        "50〜100項目の内部リストは入れていません。章タイトルと見出しまでです。",
        "</div>",
        "<article>",
    ]
    open_ul = False

    def close_ul():
        nonlocal open_ul
        if open_ul:
            parts.append("</ul>")
            open_ul = False

    for kind, text in BLOCKS:
        t = escape(text)
        if kind != "li":
            close_ul()
        if kind == "kicker":
            parts.append(f'<p class="kicker">{t}</p>')
        elif kind == "title":
            parts.append(f"<h1>{t}</h1>")
        elif kind == "catch":
            parts.append(f'<p class="catch">{t}</p>')
        elif kind == "meta":
            parts.append(f'<p class="meta">{t}</p>')
        elif kind == "h1":
            parts.append(f"<h2>{t}</h2>")
        elif kind == "h2":
            parts.append(f"<h3>{t}</h3>")
        elif kind == "p":
            parts.append(f"<p>{t}</p>")
        elif kind == "li":
            if not open_ul:
                parts.append("<ul>")
                open_ul = True
            parts.append(f"<li>{t}</li>")
        elif kind == "note":
            parts.append(f"<aside>{t}</aside>")
        else:
            raise ValueError(kind)
    close_ul()
    parts.extend(["</article>", "</body>", "</html>", ""])
    path.write_text("\n".join(parts), encoding="utf-8")


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    md = OUT / f"{STEM}.md"
    docx = OUT / f"{STEM}.docx"
    html = OUT / "OPEN-IN-BROWSER.html"
    build_md(md)
    build_docx(docx)
    build_html(html)
    print(md)
    print(docx)
    print(html)


if __name__ == "__main__":
    main()

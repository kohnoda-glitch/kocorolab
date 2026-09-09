#!/usr/bin/env python3
"""Build the editor-facing book proposal (docx zip + html preview)."""
from __future__ import annotations

import zipfile
from html import escape
from pathlib import Path

from docx import Document
from docx.enum.text import WD_ALIGN_PARAGRAPH, WD_LINE_SPACING
from docx.oxml.ns import qn
from docx.shared import Cm, Pt, RGBColor

ROOT = Path(__file__).resolve().parents[2]
OUT = ROOT / "writing" / "drafts" / "book-proposal"
STEM = "出版企画書"
DOCX_NAME = f"{STEM}.docx"
ZIP_NAME = f"{STEM}.zip"

NAVY = RGBColor(0x1A, 0x36, 0x5D)
INK = RGBColor(0x22, 0x22, 0x22)
MUTED = RGBColor(0x55, 0x55, 0x55)
RULE = RGBColor(0xC4, 0x5C, 0x26)

# kind: kicker | title | catch | meta | h1 | h2 | p | li | note
BLOCKS: list[tuple[str, str]] = [
    ("kicker", "出版企画書"),
    ("title", "『昭和というロストテクノロジー』"),
    ("catch", "仕事のコミュニケーションコストは下げろ。人間のコミュニケーションコストは上げろ。"),
    ("meta", "野田浩平（主著）／飯田史也／猪原健弘／松岡良彦"),
    ("meta", "2026年9月"),
    ("h1", "1. タイトル"),
    (
        "p",
        "表紙の第一案は、次のコピーにする。「感情力」は手垢がついており、棚の第一案にはしない。中身の背骨は感情の単一理論ではなく、ハワード・ガードナーの多重知能である。",
    ),
    ("h2", "第一案"),
    ("li", "『昭和というロストテクノロジー』"),
    ("li", "副題：捨てたのはパワハラではない。会う、雑談、世話、失敗の共有である"),
    ("li", "帯：仕事のコミュニケーションコストは下げろ。人間のコミュニケーションコストは上げろ。"),
    (
        "note",
        "昭和の全部を戻す本ではない。戻さないのは、パワハラ、飲酒の強要、理不尽な上下である。残すのは、身体を同じ場所に置くことである。ノスタルジーが先に立つなら、帯と序章でそれを否定する。",
    ),
    (
        "p",
        "第一案で進める必要はない。棚と読者に合わせて、次からも選べる。いずれも同じ本である。",
    ),
    ("h2", "ほかの候補"),
    ("li", "仕事のコミュニケーションコストは下げろ。人間のコミュニケーションコストは上げろ。（タイトルにもできる）"),
    ("li", "『AIに代替されない「最後の知性」』—— データに奪われない、人と場の設計"),
    ("li", "『「違和感」を無視して生きてきた大人たちへ』—— 身体の声を情報として扱う"),
    ("li", "『思考停止の時代に、知性を再起動する』—— 内なる情動から軸を立て直す"),
    ("li", "『あなたの経験値が、明日から役に立たなくなる理由』—— 内発的モチベーションの再構築"),
    ("li", "『「正解のない世界」で、自分を失わない技術』—— 親と子の軸"),
    ("li", "『AI時代の「人間力」とは何か』—— 知性の新定義"),
    ("li", "『感情力の時代』—— AI・STEMの先にある人間的知性（概念名。棚の第一案にはしない）"),
    ("h1", "2. 一枚で言うと"),
    (
        "p",
        "AIが、いわゆる「頭のよさ」を安くした。残るのは、身体、対人、内面、現場で使う言葉といった、別種の知能である。本書はそれを、ガードナーの多重知能を地図にして、親・教師・経営者に渡す。感情はその一部であり、本の全部ではない。",
    ),
    ("h2", "書店で手に取る理由"),
    ("li", "仕事のコストは下げろ。人間のコストは上げろ。"),
    ("li", "ChatGPTに「部下の気持ち」を聞くな。会いに行け。"),
    ("li", "昭和の全部を戻せ、ではない。捨てたはずの会う・雑談・世話・失敗の共有を、設計し直せ。"),
    ("li", "STEMの先に残るのは、頭以外の知能である。"),
    ("h1", "3. なぜ今か"),
    (
        "p",
        "生成AIは、資料・翻訳・議事録・コードを圧縮した。圧縮されないのは、身体で感じ、相手の状態を読み、言葉にして、関係を整え、合意に至ることである。学校では特別活動がまさにその訓練場である。家庭ではSTEM教育の親が、知識は足りている、足りないのは人間側だ、と気づき始めている。経営では、リモートとAIで仕事は回るが、人が離れ、現場の空気が読めない、という声が増えている。",
    ),
    (
        "p",
        "身体をいたわる、人と話す、内面を見る。こうした知性は、多重知能をはじめ、以前から言われてきた。ハーバード、MIT、国連の名を出せば新しく見えるが、いまさら新しい話にはならない。本書は、その再発見を繰り返さない。書くのは、AIが論理と知識を安くしたあとに、日本の家庭・学校・職場で、どの知能をどう育てるかである。",
    ),
    (
        "p",
        "この本は、メンタルヘルスの診断書ではない。学びと現場の設計の本である。",
    ),
    ("h1", "4. 読者"),
    (
        "p",
        "3層を同時に取る。中心は、親でもある大人である。",
    ),
    ("li", "STEM教育に関心のある親——知識は与えた。次に何を育てるか。"),
    ("li", "教師・学校関係者——特別活動・学級経営・探究。人と合意の作り方。"),
    ("li", "経営者・マネジャー——AI導入後に残る、人と現場のコミュニケーション。"),
    (
        "p",
        "若手には「昭和」という言葉のアレルギーがある。だから昭和は入口のコピーに使い、本文は多重知能で読ませる。タイトルは第一案以外でもよい。中身は変えない。",
    ),
    ("h1", "5. 中心概念"),
    (
        "p",
        "3名、ないし4名をつなぐのは、感情の教科書ではない。ハワード・ガードナーの多重知能（Multiple Intelligences）である。いわゆるIQやSTEMで測る知能は、知能の一種にすぎない。身体、対人、内面、言語、音楽、空間など、別の知能がある。",
    ),
    (
        "p",
        "顔ぶれは、その地図の上に乗る。飯田は身体とものづくり（身体性ロボット・人工知能）。猪原は人と集団で決めること（合意形成・特別活動）。野田は内面と学びの設計（認知科学・リーダーシップ教育）。松岡は言語と現場の学び（RLE、子どもの英語教育）。感情や機嫌は、内面と対人の知能の話として出てくる。本の全部を感情に還元しない。",
    ),
    ("h2", "現場で使う地図（感情に還元しない）"),
    ("li", "身体を読む——空腹、疲労、呼吸。頭の前にある。"),
    ("li", "人と場を読む——表情、空気、期待。一人では完結しない。"),
    ("li", "言葉にする——攻撃でも沈黙でもなく、共有できる形にする。"),
    ("li", "余白をつくる——衝動と行動のあいだに、選択肢を置く。"),
    ("li", "共に決める——違う知能、違う価値観のまま、合意に乗せる。"),
    ("h2", "5つの層"),
    ("li", "身体——心拍、呼吸、空腹、疲労。AIにはない出発点。"),
    ("li", "予測——予測と現実のずれ。驚きと好奇心。STEM学習の原動力。"),
    ("li", "意味——身体信号の解釈。データに価値を与える評価機能。"),
    ("li", "関係——表情、態度、期待、共感。ものづくりとチームに不可欠。"),
    ("li", "集団・社会——同調、制度、合意形成。特別活動と社会実装。"),
    ("h1", "6. 章構成"),
    (
        "p",
        "序章と5章と終章。見出しは、問いと現場の言葉にする。章の担当は、これから組む。第3章を誰が書くかは、いまは決めない。",
    ),
    ("h2", "序章　捨ててしまったのは、会うことである"),
    ("li", "なぜ「プログラミングができる子ども」ほど、AI時代に不安を感じるのか"),
    ("li", "仕事は速くなった。人が動かない。"),
    ("li", "会うことを、設計し直す"),
    ("h2", "第1章　「感情的になるな」が、いちばん危ない"),
    ("li", "ChatGPTに「部下の気持ち」を聞くな"),
    ("li", "データは手段を選ぶ。何を大切にするかは、人が決める"),
    ("li", "頭がいい人ほど、先に折れる"),
    ("h2", "第2章　AIは、お腹が空いて不機嫌になれない"),
    ("li", "ロボット研究者が、胃腸を見る理由"),
    ("li", "画面の前の論理が、こぼしているもの"),
    ("li", "予測が外れたとき、人は学び始める"),
    ("h2", "第3章　あの不機嫌の正体は、だいたい空腹である"),
    ("li", "怒りと疲労を、取り違えない"),
    ("li", "0.5秒の余白をつくる"),
    ("li", "沈黙と爆発は、同じ罠の両側である"),
    ("h2", "第4章　リーダーの機嫌が、場の頭を悪くする"),
    ("li", "「何でも言っていい」は、安全ではない"),
    ("li", "会う、雑談、世話、失敗の共有"),
    ("li", "上機嫌の場は、設計できる"),
    ("h2", "第5章　正しいことを言っても、人は動かない"),
    ("li", "特別活動は、日本がすでに持っている訓練場である"),
    ("li", "SNSは、理性を手放させる"),
    ("li", "対立の奥にある恐怖・屈辱・意地"),
    ("h2", "終章　仕事のコストは下げろ。人間のコストは上げろ。"),
    ("li", "親が先に、自分の身体を読む"),
    ("li", "学校は、共に決める場をつくる"),
    ("li", "経営は、会いに行く"),
    (
        "note",
        "各章末に、短い実践を1つ置く（身体の天気予報、感情の翻訳、驚きノート、場の感情地図、対話の問い）。理論だけで終わらせない。",
    ),
    ("h1", "7. 著者"),
    (
        "p",
        "主著は野田。飯田・猪原・松岡が同じ本に乗る。つなぐのは多重知能である。著者表記は本人と調整する。松岡良彦は、野田のビジネスと研究のパートナーとして、著者の末尾に置く。",
    ),
    ("h2", "飯田史也"),
    (
        "p",
        "ケンブリッジ大学工学部ロボティクス教授。東京大学大学院工学系研究科教授（精密工学）。理系。身体性ロボット、身体性AI、バイオインスパイアード・ロボティクス。BIRLをケンブリッジと東京で主宰。関連書に『世界最高峰の学び』。著者表記は調整中。",
    ),
    ("h2", "猪原健弘"),
    (
        "p",
        "東京科学大学リベラルアーツ研究教育院教授。中央教育審議会 初等中等教育分科会 教育課程部会 特別活動ワーキンググループ専門委員（2025年9月〜2027年3月）。社会工学、意思決定、ゲーム理論、合意形成。著者表記は調整中。",
    ),
    ("h2", "野田浩平（主著）"),
    (
        "p",
        "認知科学者（博士）。株式会社ココロラボ代表取締役。グロービス経営大学院専任教員。MIT IDEAS Asia Pacific Regional Faculty。認知科学とリーダーシップ教育から、多重知能の側で学びを設計する。",
    ),
    ("h2", "松岡良彦（ビジネス・研究パートナー）"),
    (
        "p",
        "野田のビジネスと研究のパートナーである。株式会社Ducks and Drakes。フィリピン・ドゥマゲテの Starting Point English Academy（SPEA）で、子どもの英語教育を現場でともに見ていた。2016年、日本認知科学会第33回大会で野田と共著発表（第二言語としての英語学習における Real Life Experience 法の提案）。",
    ),
    ("h1", "8. 仕様"),
    ("li", "判型：四六判並製"),
    ("li", "分量：240〜320ページ（目安は280ページ前後）"),
    ("li", "価格：1,700円前後（税別）"),
    ("li", "展開：保護者・教員向けの公開講座、鼎談、学校・企業向けの短いワーク"),
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


RAW_ZIP = (
    "https://github.com/kohnoda-glitch/kocorolab/raw/cursor/note-medium-writing-4caf"
    "/writing/drafts/book-proposal/出版企画書.zip"
)


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
        "編集者に渡すのは Word です。Chrome では下のリンクを右クリック → 名前を付けてリンク先を保存。",
        f'<br><a href="{escape(RAW_ZIP)}">{escape(ZIP_NAME)}</a>',
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


def build_zip(docx: Path, zpath: Path) -> None:
    with zipfile.ZipFile(zpath, "w", compression=zipfile.ZIP_DEFLATED) as z:
        z.write(docx, DOCX_NAME)


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    md = OUT / f"{STEM}.md"
    docx = OUT / DOCX_NAME
    zpath = OUT / ZIP_NAME
    html = OUT / "OPEN-IN-BROWSER.html"
    build_md(md)
    build_docx(docx)
    build_zip(docx, zpath)
    build_html(html)
    print(docx)
    print(zpath)
    print(html)


if __name__ == "__main__":
    main()

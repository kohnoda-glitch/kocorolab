#!/usr/bin/env python3
"""Format the 2020 SDGs Goal 1 essay as JA/EN working-paper articles.

Also rebuilds the Medium paste files from the polished English draft.
"""

from __future__ import annotations

import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SCRIPTS = Path(__file__).resolve().parent
sys.path.insert(0, str(SCRIPTS))

from md_to_html import md_to_blocks, wrap_page  # noqa: E402
from sdgs_text import (  # noqa: E402
    apply_en_editorial,
    apply_ja_editorial,
    drop_leading_h1,
    promote_article_headings,
    rewrite_en_local_to_raw,
    rewrite_ja_cdn_to_raw,
    split_campaign,
    strip_front,
)

OUT = ROOT / "drafts" / "articles" / "2020-sdgs-goal-1"
BRANCH = "cursor/note-medium-writing-4caf"
EN_IMG = (
    f"https://raw.githubusercontent.com/kohnoda-glitch/kocorolab/"
    f"{BRANCH}/writing/drafts/en-from-medium/images/2020-10-08-sdgs"
)
JA_IMG = (
    f"https://raw.githubusercontent.com/kohnoda-glitch/kocorolab/"
    f"{BRANCH}/writing/drafts/ja-to-note/images"
)

JA_TITLE_BLOG = "SDGs 目標１絶対的貧困０達成チャレンジin Africa"
EN_TITLE_BLOG = "SDGs Goal 1: A challenge to reach zero extreme poverty in Africa"
JA_TITLE_ARTICLE = "SDGs目標1とアフリカの盲点——極度の貧困、気候、注意についての2020年作業論文"
EN_TITLE_ARTICLE = (
    "SDG 1 and the African blind spot: extreme poverty, climate, and attention "
    "(2020 working paper)"
)

JA_ABSTRACT = (
    "本稿は2020年10月8日に公開した論考を、ブログ体裁から作業論文（working paper）の記事形式に整えたものである。"
    "国連SDGs目標1（極度の貧困の撲滅）について、2019–2020年時点の予測、気候危機との交差、"
    "DAC諸国のODA公約（GNI比0.7%）の未達、ミクロな開発実践（雇用、コミュニティ、TABLE FOR TWO等）と"
    "マクロな資金ギャップを、認知科学・人事実務・フィリピンおよびブルンジ／ルワンダでの現場から論じる。"
    "数値・図表・1日1.25ドルの貧困線は2020年当時のままである。クラウドファンディングの日程・リターン・口座は付録に移した。"
)

EN_ABSTRACT = (
    "This working paper reformats an essay first published on 8 October 2020. "
    "It discusses SDG 1 (ending extreme poverty) using forecasts as of 2019–2020, "
    "the intersection with the climate crisis, the unmet DAC pledge of 0.7 percent of GNI, "
    "micro practices of development (jobs, community work, TABLE FOR TWO and similar), "
    "and the macro financing gap. The path of inquiry runs through cognitive science, "
    "HR practice, and fieldwork in the Philippines and in Burundi/Rwanda. "
    "Figures, statistics, and the $1.25-a-day line are left as they stood in 2020. "
    "Campaign dates, rewards, and the transfer account are moved to an appendix."
)

JA_KEYWORDS = "SDGs目標1, 極度の貧困, ODA, DAC, サブサハラ・アフリカ, ブルンジ, ルワンダ, 気候危機, 注意, U理論"
EN_KEYWORDS = "SDG 1, extreme poverty, ODA, DAC, sub-Saharan Africa, Burundi, Rwanda, climate crisis, attention, Theory U"

NOTE_JA = (
    "**書誌メモ（2026-09-05）**  \n"
    "初出は2020年10月8日、Medium（日本語）。日本語の保管は note。"
    "英語は同一原稿の作業訳で、Medium の同じURLを差し替える。"
    "World Bank や国連のその後の推計には更新していない。所属表記は2020年当時。"
)

NOTE_EN = (
    "**Archival note (5 September 2026)**  \n"
    "First public text: 8 October 2020, Medium (Japanese). Japanese archive: note. "
    "English is a working translation of that manuscript, for the same Medium URL. "
    "Later World Bank and UN estimates are not brought in. Affiliation is as of 2020."
)

CITE_JA = (
    "野田浩平 (2020/2026). "
    "「SDGs目標1とアフリカの盲点——極度の貧困、気候、注意についての2020年作業論文」. "
    "Working paper. 初出: Medium, 2020年10月8日. "
    "ORCID: https://orcid.org/0009-0007-5596-1668"
)

CITE_EN = (
    "Noda, K. (2020/2026). "
    "SDG 1 and the African blind spot: extreme poverty, climate, and attention "
    "(2020 working paper). Working paper. First published 8 October 2020 on Medium (Japanese). "
    "ORCID: https://orcid.org/0009-0007-5596-1668"
)

REFS_JA = """
## 文献・出典（本文中のリンク）

1. United Nations, SDG 1. https://sdgs.un.org/goals/goal1
2. IPCC, *Special Report on Global Warming of 1.5°C*（日本語解説: 小西雅子, WWFジャパン, 2019）. https://www.wwf.or.jp/activities/data/20190204_climate_Konishi.pdf
3. OECD, Net ODA. https://data.oecd.org/oda/net-oda.htm
4. OECD DAC. https://ja.wikipedia.org/wiki/開発援助委員会
5. Sachs, J. *The End of Poverty*（邦訳『貧困の終焉』）. https://www.amazon.co.jp/dp/4150504040
6. Easterly, W. 関連書. https://www.amazon.co.jp/dp/4492443606
7. Clemens, M. A. & Moss, T. J., “The Ghost of 0.7 Per Cent.” CGD Working Paper 68. https://www.cgdev.org/sites/default/files/3822_file_WP68.pdf
8. Shah, A., “Foreign Aid for Development Assistance.” https://www.globalissues.org/article/35/foreign-aid-development-assistance
9. 河野太郎、慶應SDM講演. https://www.youtube.com/watch?v=xUaWTI9bNdM
10. 日米中印の2019年予算. https://www.rifj.jp/blog/日米中印各国の2019年予算を見る/
11. Millennium Promise. http://millenniumpromise.jp/ / https://www.millenniumpromise.org/
12. Gawad Kalinga. https://en.wikipedia.org/wiki/Gawad_Kalinga
13. Manuel, M. et al., ODI, “How to finance the end of extreme poverty.” https://www.odi.org/opinion/10514-how-finance-end-extreme-poverty
14. 吉田健太郎・野田浩平, 『中小企業のリバース・イノベーション』第10章. https://www.amazon.co.jp/dp/4496053454
15. 中満泉, 関連著書. https://www.amazon.co.jp/dp/B073TXCVHY
"""

REFS_EN = """
## References (links in the 2020 text)

1. United Nations, SDG 1. https://sdgs.un.org/goals/goal1
2. IPCC, *Special Report on Global Warming of 1.5°C* (Japanese briefing: Masako Konishi, WWF Japan, 2019). https://www.wwf.or.jp/activities/data/20190204_climate_Konishi.pdf
3. OECD, Net ODA. https://data.oecd.org/oda/net-oda.htm
4. OECD DAC. https://en.wikipedia.org/wiki/Development_Assistance_Committee
5. Sachs, J. *The End of Poverty*. https://www.amazon.co.jp/dp/4150504040
6. Easterly, W. (Japanese edition linked in the source). https://www.amazon.co.jp/dp/4492443606
7. Clemens, M. A. & Moss, T. J., “The Ghost of 0.7 Per Cent,” CGD Working Paper 68. https://www.cgdev.org/sites/default/files/3822_file_WP68.pdf
8. Shah, A., “Foreign Aid for Development Assistance.” https://www.globalissues.org/article/35/foreign-aid-development-assistance
9. Taro Kono, Keio SDM lecture. https://www.youtube.com/watch?v=xUaWTI9bNdM
10. 2019 budgets of Japan, the US, China, and India. https://www.rifj.jp/blog/日米中印各国の2019年予算を見る/
11. Millennium Promise. http://millenniumpromise.jp/ / https://www.millenniumpromise.org/
12. Gawad Kalinga. https://en.wikipedia.org/wiki/Gawad_Kalinga
13. Manuel, M. et al., ODI, “How to finance the end of extreme poverty.” https://www.odi.org/opinion/10514-how-finance-end-extreme-poverty
14. Yoshida, K. & Noda, K., *Reverse Innovation of Japanese SMEs*, ch. 10. https://www.amazon.co.jp/dp/4496053454
15. Izumi Nakamitsu (book linked in the source). https://www.amazon.co.jp/dp/B073TXCVHY
"""

APPENDIX_JA_INTRO = """
## 付録. 2020年キャンペーン覚書

以下は初出当時のクラウドファンディング・口座・リターンである。論文の本論ではない。2026年に再掲する寄付案内ではない。
"""

APPENDIX_EN_INTRO = """
## Appendix. 2020 campaign note

What follows is the crowdfunding plan, the transfer account, and the rewards as published in 2020. It is not the argument of the paper. It is not a 2026 donation appeal.
"""

JA_HEADINGS = [
    ("**1. はじめに**", "## 1. はじめに"),
    ("**2. 解決したい社会課題**", "## 2. 解決したい社会課題"),
    ("**３．方法**", "## 3. 方法"),
    ("**このプロジェクトで実現したいこと**", "## 4. 現場とメンバー"),
]

EN_HEADINGS = [
    ("**1. Introduction**", "## 1. Introduction"),
    ("**2. The social problem we want to solve**", "## 2. The social problem we want to solve"),
    ("**3. Method**", "## 3. Method"),
    ("**What this project wants to do**", "## 4. Field setting and members"),
]


def ja_header() -> str:
    return (
        "---\n"
        "type: working-paper\n"
        "lang: ja\n"
        "date: 2020-10-08\n"
        "formatted: 2026-09-05\n"
        f'title: "{JA_TITLE_ARTICLE}"\n'
        f'original_title: "{JA_TITLE_BLOG}"\n'
        "---\n\n"
        f"# {JA_TITLE_ARTICLE}\n\n"
        "**Working paper / 作業論文**  \n"
        "**著者** 野田浩平  \n"
        "**当時の立場（2020）** 認知科学（感情）の研究者。人事コンサルタント。フィリピンでの学校運営および社会課題の実践。  \n"
        "**連絡先** info@kocorolab.com / ORCID https://orcid.org/0009-0007-5596-1668  \n"
        "**初出** 2020年10月8日、Medium（日本語）。日本語の保管先は note。  \n"
        "**英語稿** 同日原稿の作業訳。Medium の同一URLを英語に差し替えるためのもの。\n\n"
        f"{NOTE_JA}\n\n"
        "---\n\n"
        "## 要旨\n\n"
        f"{JA_ABSTRACT}\n\n"
        f"**キーワード** {JA_KEYWORDS}\n\n"
        f"**引用** {CITE_JA}\n\n"
    )


def en_header() -> str:
    return (
        "---\n"
        "type: working-paper\n"
        "lang: en\n"
        "date: 2020-10-08\n"
        "formatted: 2026-09-05\n"
        f'title: "{EN_TITLE_ARTICLE}"\n'
        f'original_title: "{EN_TITLE_BLOG}"\n'
        "---\n\n"
        f"# {EN_TITLE_ARTICLE}\n\n"
        "**Working paper**  \n"
        "**Author** Kohei Noda  \n"
        "**Position as of 2020** Researcher in the cognitive science of emotion. HR consultant. School leadership and social-issue practice in the Philippines.  \n"
        "**Correspondence** info@kocorolab.com / ORCID https://orcid.org/0009-0007-5596-1668  \n"
        "**First published** 8 October 2020, Medium (Japanese). Japanese archive: note.  \n"
        "**English text** A working translation of that manuscript, for overwriting the same Medium URL.\n\n"
        f"{NOTE_EN}\n\n"
        "---\n\n"
        "## Abstract\n\n"
        f"{EN_ABSTRACT}\n\n"
        f"**Keywords** {EN_KEYWORDS}\n\n"
        f"**Suggested citation** {CITE_EN}\n\n"
    )


def prepare_ja_body() -> tuple[str, str]:
    src = (ROOT / "source/medium-ja/SDGs-目標１絶対的貧困０達成チャレンジin-Africa.md").read_text()
    text = apply_ja_editorial(strip_front(src))
    text = drop_leading_h1(text, JA_TITLE_BLOG)
    text = rewrite_ja_cdn_to_raw(text, JA_IMG)
    core, app = split_campaign(
        text,
        (
            "**4. このプロジェクトで実現したいこと**",
            "**４．このプロジェクトで実現したいこと**",
        ),
    )
    core = promote_article_headings(core, JA_HEADINGS)
    return core.strip() + "\n", app


def prepare_en_body() -> tuple[str, str]:
    src = (
        ROOT / "drafts/en-from-medium/2020-10-08-sdgs-goal-1-ending-extreme-poverty-in-africa.md"
    ).read_text()
    text = apply_en_editorial(strip_front(src))
    text = rewrite_en_local_to_raw(text, EN_IMG)
    text = drop_leading_h1(text, EN_TITLE_BLOG)
    core, app = split_campaign(text, ("**4. What we want this project to do**",))
    core = promote_article_headings(core, EN_HEADINGS)
    return core.strip() + "\n", app


def write_medium_paste(en_src: str) -> None:
    dest_dir = ROOT / "drafts" / "en-from-medium"
    text = apply_en_editorial(strip_front(en_src))
    text = rewrite_en_local_to_raw(text, EN_IMG).strip() + "\n"
    paste = (
        "<!-- Paste into the EXISTING Medium story (2020-10-08 URL). "
        "Do not open medium.com/new. Title box: "
        f"{EN_TITLE_BLOG}. "
        "Copy figures from OPEN-IN-BROWSER-sdgs-goal-1.html if photos do not come across. -->\n\n"
        f"{text}"
    )
    (dest_dir / "PASTE-TO-MEDIUM-sdgs-goal-1.md").write_text(paste)
    title, body = md_to_blocks(text)
    html = wrap_page(title or EN_TITLE_BLOG, body, lang="en")
    (dest_dir / "OPEN-IN-BROWSER-sdgs-goal-1.html").write_text(html)


def write_article_html(md_path: Path, html_path: Path, lang: str, note: str) -> None:
    title, body = md_to_blocks(md_path.read_text())
    html_path.write_text(wrap_page(title, body, lang=lang, note_html=note))


def write_readme() -> None:
    (OUT / "README.md").write_text(
        """# 2020 SDGs Goal 1 — working-paper format

日英とも、2020年10月8日の原稿を **article / 作業論文** の形に整えた控えである。新しい調査ではない。

| 言語 | Markdown | ブラウザで読む |
| --- | --- | --- |
| 日本語 | [`noda-2020-sdg1-article-ja.md`](noda-2020-sdg1-article-ja.md) | [HTML](https://htmlpreview.github.io/?https://github.com/kohnoda-glitch/kocorolab/blob/cursor/note-medium-writing-4caf/writing/drafts/articles/2020-sdgs-goal-1/noda-2020-sdg1-article-ja.html) |
| 英語 | [`noda-2020-sdg1-article-en.md`](noda-2020-sdg1-article-en.md) | [HTML](https://htmlpreview.github.io/?https://github.com/kohnoda-glitch/kocorolab/blob/cursor/note-medium-writing-4caf/writing/drafts/articles/2020-sdgs-goal-1/noda-2020-sdg1-article-en.html) |

要旨・キーワード・引用・文献・付録（2020年のCampfire／口座）を付けた。本論は問題・歴史・方法・現場まで。数値は2020年のまま。

ブログ体裁のまま貼るファイルは別にある。

- 日本語を note に取り込む: `writing/drafts/ja-to-note/note-import.zip`
- 英語を Medium に貼る: `writing/drafts/en-from-medium/PASTE-TO-MEDIUM-sdgs-goal-1.md` と `OPEN-IN-BROWSER-sdgs-goal-1.html`

Medium は **既存の日本語記事を上書き**する。`https://medium.com/new` で新規作成しない。2020-10-08 のURLを残す。

付録の口座とCampfireは当時の記録であり、いまの寄付案内ではない。
"""
    )


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    en_src = (
        ROOT / "drafts/en-from-medium/2020-10-08-sdgs-goal-1-ending-extreme-poverty-in-africa.md"
    ).read_text()

    ja_core, ja_app = prepare_ja_body()
    en_core, en_app = prepare_en_body()

    ja_md = OUT / "noda-2020-sdg1-article-ja.md"
    en_md = OUT / "noda-2020-sdg1-article-en.md"
    ja_md.write_text(ja_header() + ja_core + "\n" + REFS_JA + APPENDIX_JA_INTRO + "\n" + ja_app)
    en_md.write_text(en_header() + en_core + "\n" + REFS_EN + APPENDIX_EN_INTRO + "\n" + en_app)

    write_article_html(
        ja_md,
        OUT / "noda-2020-sdg1-article-ja.html",
        "ja",
        "2020年作業論文の日本語版。ブログ投稿用ではない。印刷して読める。付録の口座は当時の記録であり、いまの寄付案内ではない。",
    )
    write_article_html(
        en_md,
        OUT / "noda-2020-sdg1-article-en.html",
        "en",
        "Archival working-paper edition. Not the Medium paste. The appendix bank account is a 2020 record, not a 2026 donation appeal.",
    )
    write_medium_paste(en_src)
    write_readme()
    print("Wrote", OUT)


if __name__ == "__main__":
    main()

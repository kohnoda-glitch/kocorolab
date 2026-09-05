#!/usr/bin/env python3
from pathlib import Path

OUT = Path(__file__).resolve().parents[1] / "drafts" / "articles" / "2020-sdgs-goal-1"


def test_articles_exist_and_split() -> None:
    ja = (OUT / "noda-2020-sdg1-article-ja.md").read_text()
    en = (OUT / "noda-2020-sdg1-article-en.md").read_text()

    assert "## 要旨" in ja
    assert "## Abstract" in en
    assert "## 3. 方法" in ja
    assert "## 3. Method" in en
    assert "## 4. 現場とメンバー" in ja
    assert "## 4. Field setting and members" in en
    assert "## 付録. 2020年キャンペーン覚書" in ja
    assert "## Appendix. 2020 campaign note" in en
    assert ja.index("## 3. 方法") < ja.index("## 付録")
    assert en.index("## 3. Method") < en.index("## Appendix")
    assert ja.index("## 付録") < ja.index("**4. このプロジェクトで実現したいこと**")
    assert en.index("## Appendix") < en.index("**4. What we want this project to do**")

    assert "cdn-images-1.medium.com" not in ja
    assert "cdn-images-1.medium.com" not in en
    assert "ja-to-note/images" in ja
    assert "en-from-medium/images/2020-10-08-sdgs" in en
    assert "図５. OECDの各国ODA拠出統計" in ja
    assert "Figure 5. OECD statistics" in en
    assert "Sustainable Development Goals" in ja
    assert "約6億3000万人" in ja
    assert "Representative Director" in en
    assert "准教授" not in ja
    assert "Founder & CEO" not in en
    assert "2026年に再掲する寄付案内ではない" in ja
    assert "not a 2026 donation appeal" in en

    assert (OUT / "noda-2020-sdg1-article-ja.html").is_file()
    assert (OUT / "noda-2020-sdg1-article-en.html").is_file()
    html_ja = (OUT / "noda-2020-sdg1-article-ja.html").read_text()
    assert "<h2>要旨</h2>" in html_ja
    assert "<h2>3. 方法</h2>" in html_ja


if __name__ == "__main__":
    test_articles_exist_and_split()
    print("ok")

#!/usr/bin/env python3
"""Shared editorial cleanup for the 2020 SDGs Goal 1 essay.

Fixes typos, broken scrape links, and the duplicate Figure 4 / 図４.
Does not update 2020 statistics or the $1.25 poverty line.
"""

from __future__ import annotations

import re
from pathlib import Path

BROKEN_DAC_WIKI = (
    "https://ja.wikipedia.org/wiki/%E9%96%8B%E7%99%BA%E6%8F%B4%E5%8A%A9"
    "%E5%A7%94%E5%93%A1%E4%BC%9A%EF%BC%89"
)
GOOD_DAC_WIKI_JA = "https://ja.wikipedia.org/wiki/開発援助委員会"
GOOD_DAC_WIKI_EN = "https://en.wikipedia.org/wiki/Development_Assistance_Committee"
WWF_PDF = "https://www.wwf.or.jp/activities/data/20190204_climate_Konishi.pdf"

CDN_TO_FILE = {
    "https://cdn-images-1.medium.com/max/1024/1*8o4K2CXJnjTycs4ejvj9ug.jpeg": "01.jpg",
    "https://cdn-images-1.medium.com/max/553/0*nZhRz6cKDMa6t5b6": "02.jpg",
    "https://cdn-images-1.medium.com/max/588/0*ceU2jj9bVU-yU3AL": "03.jpg",
    "https://cdn-images-1.medium.com/max/946/0*N8Cr8cMJfFyihwz-": "04.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*c5HOG-RGXyGRo8P8tSnCOg.png": "05.jpg",
    "https://cdn-images-1.medium.com/max/624/0*SDwVm37HxcV5wLK7": "06.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*hftrAQ4asnX4wz-WL4y3tA.png": "07.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*Gp0FlruoFUrFPkguX9B3IQ.png": "08.jpg",
    "https://cdn-images-1.medium.com/max/859/0*sHFon2RbB8BnPNHB": "09.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*LJWm1_Jzzcop3artiCjCoQ.png": "10.jpg",
    "https://cdn-images-1.medium.com/max/1024/0*qmM8twjuyfmUlxBW": "11.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*2TG7vytZd_Ahf2OkmxiY9A.jpeg": "12.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*MFTM4pj7jfMvPGVieo5eeA.jpeg": "13.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*6V_rH2jvnkIBtPTMnDw4ww.jpeg": "14.jpg",
    "https://cdn-images-1.medium.com/max/552/0*LcWD9PxNiby-OKUk": "15.jpg",
    "https://cdn-images-1.medium.com/max/467/0*k8E4kgDCtNZnxiWY": "16.jpg",
    "https://cdn-images-1.medium.com/max/715/1*pPglNMoMn09XC_kJaq1MdA.png": "17.jpg",
    "https://cdn-images-1.medium.com/max/1024/0*zEZDlAlAZ1hqjQxs": "18.jpg",
    "https://cdn-images-1.medium.com/max/263/0*gR0xokYGTT489Pyz": "19.jpg",
    "https://cdn-images-1.medium.com/max/1024/0*gt8iklBtIu0g2j-0": "20.jpg",
    "https://cdn-images-1.medium.com/max/607/0*1EplPsppTJryTa1D": "21.jpg",
}


def strip_front(md: str) -> str:
    if md.startswith("---"):
        parts = md.split("---", 2)
        if len(parts) >= 3:
            return parts[2].lstrip("\n")
    return md


def strip_medium_footer(text: str) -> str:
    text = re.sub(r"!\[\]\(https://medium.com/_/stat[^)]+\)\n*", "", text)
    text = re.sub(r"\n---\n\n\[.*was originally published.*\n?", "\n", text)
    return text


def apply_ja_editorial(text: str) -> str:
    """Light 2026 copy-edit of the Japanese scrape. Voice and 2020 facts stay."""
    text = text.replace(BROKEN_DAC_WIKI, GOOD_DAC_WIKI_JA)
    text = text.replace(
        "https://ja.wikipedia.org/wiki/%E9%96%8B%E7%99%BA%E6%8F%B4%E5%8A%A9%E5%A7%94%E5%93%A1%E4%BC%9A）",
        GOOD_DAC_WIKI_JA,
    )
    text = re.sub(
        r"(https://www\.rifj\.jp/blog/[^)\s\"]+?)/%E3%80%80",
        r"\1",
        text,
    )
    text = text.replace("Sustainable Developmental Goals", "Sustainable Development Goals")
    text = text.replace("訳6億3000万人", "約6億3000万人")
    text = text.replace("2. 3. 課題と向き合うきっかけや経緯", "2.3. 課題と向き合うきっかけや経緯")
    text = text.replace(
        "https://www.wwf.or.jp/activities/data/20190204_climate_Konishi.pdf"
        "%E3%80%80%EF%BC%8826%E3%83%9A%E3%83%BC%E3%82%B8%E7%9B%AE%E3%81%AB"
        "%E8%AA%AC%E6%98%8E%E3%81%8C%E5%B0%91%E3%81%97%E3%81%A0%E3%81%91%EF%BC%89",
        WWF_PDF,
    )
    # Original Medium used 図４ twice; shift later captions so the sequence is unique.
    text = text.replace("図７. ODA予算が非常に足りていない", "図８. ODA予算が非常に足りていない")
    text = text.replace("図６. 絶対的貧困撲滅が難しい", "図７. 絶対的貧困撲滅が難しい")
    text = text.replace("図５. 日米中印の国家予算比較", "図６. 日米中印の国家予算比較")
    text = text.replace("図４. OECDの各国ODA拠出統計", "図５. OECDの各国ODA拠出統計")
    text = strip_medium_footer(text)
    return text


def apply_en_editorial(text: str) -> str:
    """Light 2026 copy-edit of the working English translation."""
    text = text.replace(
        "Figure 7. A graph showing how far short ODA is",
        "Figure 8. A graph showing how far short ODA is",
    )
    text = text.replace(
        "Figure 6. The 46 least developed countries",
        "Figure 7. The 46 least developed countries",
    )
    text = text.replace(
        "Figure 5. Comparing the national budgets",
        "Figure 6. Comparing the national budgets",
    )
    text = text.replace(
        "Figure 4. OECD statistics on each country’s ODA",
        "Figure 5. OECD statistics on each country’s ODA",
    )
    text = text.replace(
        "[https://ja.wikipedia.org/wiki/開発援助委員会](https://ja.wikipedia.org/wiki/%E9%96%8B%E7%99%BA%E6%8F%B4%E5%8A%A9%E5%A7%94%E5%93%A1%E4%BC%9A)",
        f"[https://en.wikipedia.org/wiki/Development_Assistance_Committee]({GOOD_DAC_WIKI_EN})",
    )
    text = text.replace(
        "President of Kocoro Laboratory (HR consulting and mental-health services)",
        "Representative Director of Kocorolab / Kocoro Laboratory (HR consulting and mental-health services)",
    )
    text = text.replace(
        "https://www.wwf.or.jp/activities/data/20190204_climate_Konishi.pdf"
        "%E3%80%80%EF%BC%8826%E3%83%9A%E3%83%BC%E3%82%B8%E7%9B%AE%E3%81%AB"
        "%E8%AA%AC%E6%98%8E%E3%81%8C%E5%B0%91%E3%81%97%E3%81%A0%E3%81%91%EF%BC%89",
        WWF_PDF,
    )
    text = strip_medium_footer(text)
    return text


def drop_leading_h1(text: str, title: str) -> str:
    return text.replace(f"# {title}\n\n", "", 1)


def rewrite_ja_cdn_to_raw(text: str, raw_base: str) -> str:
    for cdn, name in CDN_TO_FILE.items():
        text = text.replace(f"![]({cdn})", f"![]({raw_base}/{name})")
    return text


def rewrite_en_local_to_raw(text: str, raw_base: str) -> str:
    lines = []
    for line in text.splitlines():
        if line.startswith("<!--"):
            continue
        if line.startswith("![](images/2020-10-08-sdgs/"):
            name = line.split("/")[-1].rstrip(")")
            line = f"![]({raw_base}/{name})"
        lines.append(line)
    return "\n".join(lines)


def split_campaign(body: str, markers: tuple[str, ...]) -> tuple[str, str]:
    for marker in markers:
        if marker in body:
            core, rest = body.split(marker, 1)
            return core.rstrip() + "\n", marker + rest
    return body, ""


def promote_article_headings(body: str, replacements: list[tuple[str, str]]) -> str:
    for old, new in replacements:
        body = body.replace(old, new, 1)
    # Numbered 2.x lines become h3 when they start a paragraph.
    body = re.sub(
        r"(?m)^(?!#)(2\.\d+(?:\.\d+)*)\.? (.+)$",
        r"### \1. \2",
        body,
    )
    return body


def repo_writing_root() -> Path:
    return Path(__file__).resolve().parents[1]

#!/usr/bin/env python3
"""Pack the 2021 Medium birthday essay as a note WordPress import dated 2021-10-08.

Does not overwrite the 2020 SDGs note-import.zip.
"""

from __future__ import annotations

import re
import sys
import urllib.request
from pathlib import Path
from xml.etree import ElementTree as ET

from PIL import Image

ROOT = Path(__file__).resolve().parents[2]
sys.path.insert(0, str(Path(__file__).resolve().parent))
from note_wxr import html_body, write_browser_page, write_import_copies, wxr  # noqa: E402

BRANCH = "cursor/note-medium-writing-4caf"
SRC = ROOT / "writing/source/medium-ja/誕生日にあたり（経済・金融の枠組みとか、通貨制度とか国家制度とか）.md"
IMG_DIR = ROOT / "writing/drafts/ja-to-note/images/2021-10-08-birthday"
RAW = (
    "https://raw.githubusercontent.com/kohnoda-glitch/kocorolab/"
    f"{BRANCH}/writing/drafts/ja-to-note/images/2021-10-08-birthday"
)
CDN = "https://cdn-images-1.medium.com/max/1024/1*j8AoYIhIabSjdsT9YQRKyA.jpeg"
CDN_MAP = {CDN: "01.jpg"}
MAX_W = 720
TITLE = "誕生日にあたり（経済・金融の枠組みとか、通貨制度とか国家制度とか）"
URL = (
    "https://medium.com/@koheinoda_11596/"
    "%E8%AA%95%E7%94%9F%E6%97%A5%E3%81%AB%E3%81%82%E3%81%9F%E3%82%8A-"
    "%E7%B5%8C%E6%B8%88-%E9%87%91%E8%9E%8D%E3%81%AE%E6%9E%A0%E7%B5%84%E3%81%BF%E3%81%A8%E3%81%8B-"
    "%E9%80%9A%E8%B2%A8%E5%88%B6%E5%BA%A6%E3%81%A8%E3%81%8B%E5%9B%BD%E5%AE%B6%E5%88%B6%E5%BA%A6%E3%81%A8%E3%81%8B-"
    "3a49b2526355"
)


def fetch_photo() -> None:
    IMG_DIR.mkdir(parents=True, exist_ok=True)
    dest = IMG_DIR / "01.jpg"
    req = urllib.request.Request(CDN, headers={"User-Agent": "KocoroLab writing sync"})
    with urllib.request.urlopen(req, timeout=30) as res:
        dest.write_bytes(res.read())
    im = Image.open(dest).convert("RGB")
    w, h = im.size
    if w > MAX_W:
        h = round(h * MAX_W / w)
        im = im.resize((MAX_W, h), Image.Resampling.LANCZOS)
    im.save(dest, quality=85, optimize=True)


def main() -> int:
    if not SRC.is_file():
        raise SystemExit(f"missing source: {SRC}")
    fetch_photo()
    text = SRC.read_text(encoding="utf-8")
    m = re.search(r'^url: "([^"]+)"', text, re.M)
    url = m.group(1) if m else URL
    title, body = html_body(text, cdn_map=CDN_MAP, raw=RAW, profiles=set())
    if title != TITLE:
        raise SystemExit(f"unexpected title: {title!r}")
    dest = ROOT / "writing/drafts/ja-to-note/2021-10-08-birthday-note-import.xml"
    dest.write_text(
        wxr(
            title,
            body,
            url,
            local_dt="2021-10-08 12:00:00",
            gmt_dt="2021-10-08 03:00:00",
            pub_rfc="Fri, 08 Oct 2021 03:00:00 +0000",
            post_name="birthday-2021",
        ),
        encoding="utf-8",
    )
    ET.parse(dest)
    write_import_copies(dest, easy_name="birthday-2021-note-import.xml")
    write_browser_page(
        title,
        body,
        dest=ROOT / "writing/drafts/ja-to-note/OPEN-IN-BROWSER-birthday-2021.html",
        hint=(
            "2021年10月8日の Medium 日本語記事です。SDGs の zip とは別です。"
            " 黄色い枠の下をマウスでなぞって <b>⌘C</b>。"
            " note の同じ下書きの本文に <b>⌘V</b>。"
            " タイトルは自分で入れてください。日付は 2021年10月8日のままにしてください。"
        ),
    )
    print("wrote", dest)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

#!/usr/bin/env python3
"""Build a WordPress WXR file so note.com can import a post with its original date."""

from __future__ import annotations

import re
import sys
from html import escape
from pathlib import Path
from xml.etree import ElementTree as ET

ROOT = Path(__file__).resolve().parents[2]
sys.path.insert(0, str(Path(__file__).resolve().parent))
from md_to_html import md_to_blocks  # noqa: E402

RAW = (
    "https://raw.githubusercontent.com/kohnoda-glitch/kocorolab/"
    "cursor/note-medium-writing-4caf/writing/drafts/en-from-medium/images/2020-10-08-sdgs"
)

# Japanese-text figures must keep the original Medium images.
KEEP_MEDIUM = {
    "https://cdn-images-1.medium.com/max/946/0*N8Cr8cMJfFyihwz-",
    "https://cdn-images-1.medium.com/max/624/0*SDwVm37HxcV5wLK7",
    "https://cdn-images-1.medium.com/max/1024/0*qmM8twjuyfmUlxBW",
    "https://cdn-images-1.medium.com/max/715/1*pPglNMoMn09XC_kJaq1MdA.png",
}

CDN_TO_FILE = {
    "https://cdn-images-1.medium.com/max/1024/1*8o4K2CXJnjTycs4ejvj9ug.jpeg": "01.jpg",
    "https://cdn-images-1.medium.com/max/553/0*nZhRz6cKDMa6t5b6": "02.jpg",
    "https://cdn-images-1.medium.com/max/588/0*ceU2jj9bVU-yU3AL": "03.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*c5HOG-RGXyGRo8P8tSnCOg.png": "05.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*hftrAQ4asnX4wz-WL4y3tA.png": "07.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*Gp0FlruoFUrFPkguX9B3IQ.png": "08.jpg",
    "https://cdn-images-1.medium.com/max/859/0*sHFon2RbB8BnPNHB": "09.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*LJWm1_Jzzcop3artiCjCoQ.png": "10.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*2TG7vytZd_Ahf2OkmxiY9A.jpeg": "12.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*MFTM4pj7jfMvPGVieo5eeA.jpeg": "13.jpg",
    "https://cdn-images-1.medium.com/max/1024/1*6V_rH2jvnkIBtPTMnDw4ww.jpeg": "14.jpg",
    "https://cdn-images-1.medium.com/max/552/0*LcWD9PxNiby-OKUk": "15.jpg",
    "https://cdn-images-1.medium.com/max/467/0*k8E4kgDCtNZnxiWY": "16.jpg",
    "https://cdn-images-1.medium.com/max/1024/0*zEZDlAlAZ1hqjQxs": "18.jpg",
    "https://cdn-images-1.medium.com/max/263/0*gR0xokYGTT489Pyz": "19.jpg",
    "https://cdn-images-1.medium.com/max/1024/0*gt8iklBtIu0g2j-0": "20.jpg",
    "https://cdn-images-1.medium.com/max/607/0*1EplPsppTJryTa1D": "21.jpg",
}

PROFILES = {"18.jpg", "19.jpg", "20.jpg", "21.jpg"}


def strip_source(text: str) -> str:
    if text.startswith("---\n"):
        end = text.find("\n---\n", 4)
        text = text[end + 5 :]
    text = re.sub(r"!\[\]\(https://medium.com/_/stat[^)]+\)\n*", "", text)
    text = re.sub(r"\n---\n\n\[.*was originally published.*\n?", "\n", text)
    return text.strip() + "\n"


def rewrite_img(url: str) -> tuple[str, str]:
    if url in KEEP_MEDIUM:
        return url, 'style="max-width:100%;height:auto"'
    name = CDN_TO_FILE.get(url)
    if not name:
        return url, 'style="max-width:100%;height:auto"'
    style = "max-width:320px;height:auto" if name in PROFILES else "max-width:100%;height:auto"
    return f"{RAW}/{name}", f'style="{style}"'


def html_body(md: str) -> str:
    title, body = md_to_blocks(strip_source(md))

    def repl(m: re.Match[str]) -> str:
        src, style = rewrite_img(m.group(1))
        return f'<p><img src="{escape(src, quote=True)}" alt="" {style}></p>'

    body = re.sub(r'<p><img src="([^"]+)" alt=""></p>', repl, body)
    return title, body


def wxr(title: str, body: str, url: str) -> str:
    return f"""<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
  xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:wp="http://wordpress.org/export/1.2/">
<channel>
  <title>Kocoro Lab</title>
  <link>https://note.com/koheinoda</link>
  <description>note import</description>
  <pubDate>Thu, 08 Oct 2020 12:00:00 +0900</pubDate>
  <language>ja</language>
  <wp:wxr_version>1.2</wp:wxr_version>
  <wp:author>
    <wp:author_id>1</wp:author_id>
    <wp:author_login><![CDATA[koheinoda]]></wp:author_login>
    <wp:author_email><![CDATA[]]></wp:author_email>
    <wp:author_display_name><![CDATA[野田浩平]]></wp:author_display_name>
    <wp:author_first_name><![CDATA[]]></wp:author_first_name>
    <wp:author_last_name><![CDATA[]]></wp:author_last_name>
  </wp:author>
  <item>
    <title>{escape(title)}</title>
    <link>{escape(url, quote=True)}</link>
    <pubDate>Thu, 08 Oct 2020 12:00:00 +0900</pubDate>
    <dc:creator><![CDATA[koheinoda]]></dc:creator>
    <guid isPermaLink="false">{escape(url, quote=True)}</guid>
    <description></description>
    <content:encoded><![CDATA[{body}]]></content:encoded>
    <excerpt:encoded><![CDATA[]]></excerpt:encoded>
    <wp:post_id>1</wp:post_id>
    <wp:post_date>2020-10-08 12:00:00</wp:post_date>
    <wp:post_date_gmt>2020-10-08 03:00:00</wp:post_date_gmt>
    <wp:post_modified>2020-10-08 12:00:00</wp:post_modified>
    <wp:post_modified_gmt>2020-10-08 03:00:00</wp:post_modified_gmt>
    <wp:comment_status>closed</wp:comment_status>
    <wp:ping_status>closed</wp:ping_status>
    <wp:post_name>sdgs-goal-1-africa</wp:post_name>
    <wp:status>draft</wp:status>
    <wp:post_parent>0</wp:post_parent>
    <wp:menu_order>0</wp:menu_order>
    <wp:post_type>post</wp:post_type>
    <wp:post_password></wp:post_password>
    <wp:is_sticky>0</wp:is_sticky>
  </item>
</channel>
</rss>
"""


def main() -> int:
    src = ROOT / "writing" / "source" / "medium-ja"
    matches = list(src.glob("SDGs*.md"))
    if not matches:
        raise SystemExit("Japanese SDGs source not found")
    text = matches[0].read_text(encoding="utf-8")
    url = "https://medium.com/koheinoda-11596/sdgs-goal-1-africa"
    m = re.search(r'^url: "([^"]+)"', text, re.M)
    if m:
        url = m.group(1)
    title, body = html_body(text)
    dest = ROOT / "writing" / "drafts" / "ja-to-note" / "2020-10-08-sdgs-goal-1-note-import.xml"
    dest.parent.mkdir(parents=True, exist_ok=True)
    dest.write_text(wxr(title, body, url), encoding="utf-8")
    ET.parse(dest)
    print("wrote", dest)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

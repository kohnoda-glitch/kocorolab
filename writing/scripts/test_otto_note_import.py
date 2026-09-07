#!/usr/bin/env python3
import base64
import io
import re
from pathlib import Path
from xml.etree import ElementTree as ET
from zipfile import ZipFile

from PIL import Image

WFW = 'xmlns:wfw="http://wellformedweb.org/CommentAPI/"'
DEST = (
    Path(__file__).resolve().parents[1]
    / "drafts"
    / "ja-to-note"
    / "2020-10-13-otto-eight-lessons-note-import.xml"
)
IMG_DIR = DEST.parent / "images" / "2020-10-13-otto"
NOTE_LIMIT = 20 * 1024 * 1024


def test_otto_import() -> None:
    text = DEST.read_text(encoding="utf-8")
    assert WFW in text
    assert "<wp:post_date><![CDATA[2020-10-13 12:00:00]]></wp:post_date>" in text
    assert "2020-10-08 12:00:00" not in text
    assert "2021-10-08" not in text
    assert "非公式翻訳" in text
    assert "otto-eight-lessons-2020" in text
    root = ET.parse(DEST)
    ns = {"wp": "http://wordpress.org/export/1.2/"}
    assert root.find(".//wp:post_date", ns).text.startswith("2020-10-13")
    posts = [el for el in root.findall(".//wp:post_type", ns) if el.text == "post"]
    assert len(posts) == 1
    html = root.find(".//{http://purl.org/rss/1.0/modules/content/}encoded").text
    assert html.count("<img") == 8
    assert html.count("data:image/jpeg;base64,") == 8
    payloads = re.findall(r"data:image/jpeg;base64,([A-Za-z0-9+/=]+)", html)
    assert len(payloads) == 8
    for payload in payloads:
        im = Image.open(io.BytesIO(base64.b64decode(payload)))
        assert im.size[0] >= 200 and im.size[1] >= 100
    assert "####" not in html
    assert "cdn-images-1.medium.com" not in html
    assert "medium.com/_/stat" not in html
    assert "/max/30/" not in html
    assert "/max/48/" not in html
    assert "]]>" not in html
    assert "Eight Emerging Lessons" in html
    assert "otto-scharmer" in html.lower() or "ottoscharmer" in html.lower()
    assert "図1" in html and "図4" in html
    assert "Hannah Mckay" in html
    assert "RachelHentsch" in html

    easy = DEST.with_name("otto-2020-note-import.xml")
    assert easy.read_bytes() == DEST.read_bytes()
    zpath = DEST.with_name("otto-2020-note-import.zip")
    assert zpath.stat().st_size < NOTE_LIMIT
    with ZipFile(zpath) as zf:
        assert zf.read("otto-2020-note-import.xml") == DEST.read_bytes()
        assert "note-import.xml" not in zf.namelist()
        assert "birthday-2021-note-import.xml" not in zf.namelist()

    sdgs_zip = DEST.with_name("note-import.zip")
    with ZipFile(sdgs_zip) as zf:
        names = zf.namelist()
        assert "note-import.xml" in names
        assert "otto-2020-note-import.xml" not in names

    birthday_zip = DEST.with_name("birthday-2021-note-import.zip")
    with ZipFile(birthday_zip) as zf:
        assert "birthday-2021-note-import.xml" in zf.namelist()
        assert "otto-2020-note-import.xml" not in zf.namelist()

    for i in range(1, 9):
        img = IMG_DIR / f"{i:02d}.jpg"
        assert img.is_file() and img.stat().st_size > 1000, img


if __name__ == "__main__":
    test_otto_import()
    print("ok")

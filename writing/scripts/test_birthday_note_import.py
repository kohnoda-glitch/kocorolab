#!/usr/bin/env python3
from pathlib import Path
from xml.etree import ElementTree as ET
from zipfile import ZipFile

WFW = 'xmlns:wfw="http://wellformedweb.org/CommentAPI/"'
DEST = (
    Path(__file__).resolve().parents[1]
    / "drafts"
    / "ja-to-note"
    / "2021-10-08-birthday-note-import.xml"
)


def test_birthday_import() -> None:
    text = DEST.read_text(encoding="utf-8")
    assert WFW in text
    assert "<wp:post_date><![CDATA[2021-10-08 12:00:00]]></wp:post_date>" in text
    assert "2020-10-08" not in text
    root = ET.parse(DEST)
    ns = {
        "wp": "http://wordpress.org/export/1.2/",
        "content": "http://purl.org/rss/1.0/modules/content/",
    }
    assert root.find(".//wp:post_date", ns).text.startswith("2021-10-08")
    html = root.find(".//{http://purl.org/rss/1.0/modules/content/}encoded").text
    assert html.count("<img") == 1
    assert "cdn-images-1.medium.com" not in html
    assert "medium.com/_/stat" not in html
    assert "2021-10-08-birthday" in html
    assert "誕生日にあたり" in DEST.read_text(encoding="utf-8")
    assert "真鍋先生" in html

    easy = DEST.with_name("birthday-2021-note-import.xml")
    assert easy.read_bytes() == DEST.read_bytes()
    zpath = DEST.with_name("birthday-2021-note-import.zip")
    with ZipFile(zpath) as zf:
        assert zf.read("birthday-2021-note-import.xml") == DEST.read_bytes()

    sdgs_zip = DEST.with_name("note-import.zip")
    with ZipFile(sdgs_zip) as zf:
        assert "note-import.xml" in zf.namelist()
        assert "birthday-2021-note-import.xml" not in zf.namelist()

    img = DEST.parent / "images" / "2021-10-08-birthday" / "01.jpg"
    assert img.is_file() and img.stat().st_size > 1000


if __name__ == "__main__":
    test_birthday_import()
    print("ok")

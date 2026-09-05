#!/usr/bin/env python3
import sys
from pathlib import Path
from xml.etree import ElementTree as ET
from zipfile import ZipFile

sys.path.insert(0, str(Path(__file__).resolve().parent))
from note_wxr import wxr  # noqa: E402

WFW = 'xmlns:wfw="http://wellformedweb.org/CommentAPI/"'
REQUIRED_NS = (
    'xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"',
    'xmlns:content="http://purl.org/rss/1.0/modules/content/"',
    WFW,
    'xmlns:dc="http://purl.org/dc/elements/1.1/"',
    'xmlns:wp="http://wordpress.org/export/1.2/"',
)


def test_wxr_declares_wordpress_namespaces() -> None:
    xml = wxr("title", "<p>body</p>", "https://example.com/p")
    for ns in REQUIRED_NS:
        assert ns in xml, ns
    assert "<wp:post_date><![CDATA[2020-10-08 12:00:00]]></wp:post_date>" in xml
    assert "<wp:status><![CDATA[draft]]></wp:status>" in xml
    assert "<wp:post_type><![CDATA[post]]></wp:post_type>" in xml


def test_generated_import_files() -> None:
    dest = (
        Path(__file__).resolve().parents[2]
        / "writing"
        / "drafts"
        / "ja-to-note"
        / "2020-10-08-sdgs-goal-1-note-import.xml"
    )
    text = dest.read_text(encoding="utf-8")
    for ns in REQUIRED_NS:
        assert ns in text, ns

    root = ET.parse(dest)
    ns = {
        "wp": "http://wordpress.org/export/1.2/",
        "content": "http://purl.org/rss/1.0/modules/content/",
    }
    assert root.find(".//wp:post_date", ns).text.startswith("2020-10-08")
    html = root.find(".//{http://purl.org/rss/1.0/modules/content/}encoded").text
    assert "max-width:320px" in html
    assert html.count("<img") == 21
    assert "cdn-images-1.medium.com" not in html
    assert "medium.com/_/stat" not in html
    assert "ja-to-note/images" in html

    easy = dest.with_name("note-import.xml")
    assert easy.read_bytes() == dest.read_bytes()

    zpath = dest.with_name("note-import.zip")
    with ZipFile(zpath) as zf:
        assert zf.read("note-import.xml") == dest.read_bytes()


if __name__ == "__main__":
    test_wxr_declares_wordpress_namespaces()
    test_generated_import_files()
    print("ok")

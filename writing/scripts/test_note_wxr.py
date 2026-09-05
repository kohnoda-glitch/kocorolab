#!/usr/bin/env python3
from pathlib import Path
from xml.etree import ElementTree as ET

p = Path(__file__).resolve().parents[2] / "writing" / "drafts" / "ja-to-note" / "2020-10-08-sdgs-goal-1-note-import.xml"
root = ET.parse(p)
ns = {
    "wp": "http://wordpress.org/export/1.2/",
    "content": "http://purl.org/rss/1.0/modules/content/",
}
assert root.find(".//wp:post_date", ns).text.startswith("2020-10-08")
html = root.find(".//{http://purl.org/rss/1.0/modules/content/}encoded").text
assert "max-width:320px" in html
assert html.count("<img") == 21
print("ok")

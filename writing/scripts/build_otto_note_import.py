#!/usr/bin/env python3
"""Pack the 2020 Otto Scharmer unofficial translation for note, photos included.

Does not overwrite the SDGs or birthday note-import zips.

note.com's WordPress importer does not fetch remote <img src> URLs, so the
eight content photos are resized and embedded as data URIs inside the WXR
<body>. GitHub copies remain for the HTML preview fallback.
"""

from __future__ import annotations

import io
import re
import sys
import time
import urllib.request
from pathlib import Path
from xml.etree import ElementTree as ET

from PIL import Image

ROOT = Path(__file__).resolve().parents[2]
sys.path.insert(0, str(Path(__file__).resolve().parent))
from note_wxr import (  # noqa: E402
    embed_local_images,
    html_body,
    write_browser_page,
    write_import_copies,
    wxr,
)

BRANCH = "cursor/note-medium-writing-4caf"
SRC = ROOT / (
    "writing/source/medium-ja/"
    "unauthorized-translation-(非公式翻訳）8つの新たな教訓：コロナウイルスから気候変動対策まで.md"
)
IMG_DIR = ROOT / "writing/drafts/ja-to-note/images/2020-10-13-otto"
RAW = (
    "https://raw.githubusercontent.com/kohnoda-glitch/kocorolab/"
    f"{BRANCH}/writing/drafts/ja-to-note/images/2020-10-13-otto"
)
MAX_W = 720
TITLE = "unauthorized translation (非公式翻訳）8つの新たな教訓：コロナウイルスから気候変動対策まで"
URL = (
    "https://medium.com/@koheinoda_11596/"
    "unauthorized-translation-%E9%9D%9E%E5%85%AC%E5%BC%8F%E7%BF%BB%E8%A8%B3-"
    "8%E3%81%A4%E3%81%AE%E6%96%B0%E3%81%9F%E3%81%AA%E6%95%99%E8%A8%B3-"
    "%E3%82%B3%E3%83%AD%E3%83%8A%E3%82%A6%E3%82%A4%E3%83%AB%E3%82%B9%E3%81%8B%E3%82%89"
    "%E6%B0%97%E5%80%99%E5%A4%89%E5%8B%95%E5%AF%BE%E7%AD%96%E3%81%BE%E3%81%A7-c970f47b7454"
)
CHROME_IMG_RE = re.compile(
    r"!\[\]\(https://cdn-images-1\.medium\.com/max/(?:30|48)/[^)]+\)\n*"
)
IMAGES: list[tuple[str, str]] = [
    ("01.jpg", "https://cdn-images-1.medium.com/max/1024/0*zs2W0mcectj6PQew.jpeg"),
    ("02.jpg", "https://cdn-images-1.medium.com/max/800/0*WVF8TGtaQmDa_T9k.jpeg"),
    ("03.jpg", "https://cdn-images-1.medium.com/max/700/0*Z0f_MBEwomclIWf0.jpeg"),
    ("04.jpg", "https://cdn-images-1.medium.com/max/1024/0*R7M6854myNo70Her.jpeg"),
    ("05.jpg", "https://cdn-images-1.medium.com/max/1024/0*obKucMC2ManB49LV.jpeg"),
    ("06.jpg", "https://cdn-images-1.medium.com/max/1024/0*rVXxoeMLFJtQ5KsM.jpeg"),
    ("07.jpg", "https://cdn-images-1.medium.com/max/1024/0*GCEFsXN-jdrXWe0i.png"),
    ("08.jpg", "https://cdn-images-1.medium.com/max/1024/0*7gsADqyqnpM48YYY.jpeg"),
]
CDN_MAP = {url: name for name, url in IMAGES}


def fetch_bytes(url: str) -> bytes:
    last: Exception | None = None
    req = urllib.request.Request(url, headers={"User-Agent": "KocoroLab writing sync"})
    for attempt in range(4):
        try:
            with urllib.request.urlopen(req, timeout=30) as res:
                data = res.read()
            if len(data) < 100:
                raise RuntimeError(f"too small: {url} ({len(data)} bytes)")
            return data
        except Exception as exc:  # noqa: BLE001 — retry CDN timeouts
            last = exc
            time.sleep(2**attempt)
    raise RuntimeError(f"failed to fetch {url}: {last}") from last


def save_resized(name: str, url: str) -> Path:
    IMG_DIR.mkdir(parents=True, exist_ok=True)
    dest = IMG_DIR / name
    im = Image.open(io.BytesIO(fetch_bytes(url)))
    if im.mode in ("RGBA", "P"):
        im = im.convert("RGBA")
        bg = Image.new("RGB", im.size, (255, 255, 255))
        bg.paste(im, mask=im.split()[-1])
        im = bg
    else:
        im = im.convert("RGB")
    w, h = im.size
    if w > MAX_W:
        h = round(h * MAX_W / w)
        im = im.resize((MAX_W, h), Image.Resampling.LANCZOS)
    im.save(dest, quality=85, optimize=True)
    return dest


def strip_chrome(md: str) -> str:
    md = CHROME_IMG_RE.sub("", md)
    # Medium export used #### for the byline; keep the Japanese, drop the marker.
    return re.sub(r"^#### ", "", md, flags=re.M)


def main() -> int:
    if not SRC.is_file():
        raise SystemExit(f"missing source: {SRC}")
    paths: dict[str, Path] = {}
    for name, url in IMAGES:
        path = save_resized(name, url)
        paths[f"{RAW}/{name}"] = path
        print("image", path, path.stat().st_size)
    text = strip_chrome(SRC.read_text(encoding="utf-8"))
    m = re.search(r'^url: "([^"]+)"', text, re.M)
    url = m.group(1) if m else URL
    title, preview_body = html_body(text, cdn_map=CDN_MAP, raw=RAW, profiles=set())
    if title != TITLE:
        raise SystemExit(f"unexpected title: {title!r}")
    if preview_body.count("<img") != 8:
        raise SystemExit(f"expected 8 photos, got {preview_body.count('<img')}")
    if "cdn-images-1.medium.com" in preview_body or "medium.com/_/stat" in preview_body:
        raise SystemExit("Medium chrome or CDN left in HTML")
    import_body = embed_local_images(preview_body, paths)
    if "data:image/jpeg;base64," not in import_body:
        raise SystemExit("photos were not embedded as data URIs")
    dest = ROOT / "writing/drafts/ja-to-note/2020-10-13-otto-eight-lessons-note-import.xml"
    dest.write_text(
        wxr(
            title,
            import_body,
            url,
            local_dt="2020-10-13 12:00:00",
            gmt_dt="2020-10-13 03:00:00",
            pub_rfc="Tue, 13 Oct 2020 03:00:00 +0000",
            post_name="otto-eight-lessons-2020",
        ),
        encoding="utf-8",
    )
    ET.parse(dest)
    write_import_copies(dest, easy_name="otto-2020-note-import.xml")
    write_browser_page(
        title,
        preview_body,
        dest=ROOT / "writing/drafts/ja-to-note/OPEN-IN-BROWSER-otto-2020.html",
        hint=(
            "2020年10月13日の Medium 日本語（オットー・シャーマー非公式翻訳）です。"
            " SDGs や誕生日の zip とは別です。"
            " 写真は取り込み用 XML の中に埋め込んであります。"
            " もし絵が無ければ、新しく記事を作らず、黄色い枠の下をマウスでなぞって"
            " <b>⌘C</b>。note の同じ下書きの本文に <b>⌘V</b>。"
            " タイトルは自分で入れてください。日付は 2020年10月13日のままにしてください。"
            " 公式翻訳ではありません。原著者は Otto Scharmer です。"
        ),
    )
    print("wrote", dest)
    print("xml bytes", dest.stat().st_size)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

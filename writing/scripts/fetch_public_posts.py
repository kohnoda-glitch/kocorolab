#!/usr/bin/env python3
"""
Pull public note.com and Medium posts into Markdown.

  python3 writing/scripts/fetch_public_posts.py

Does not log in. Does not publish. Writes:

  writing/source/note-ja/
  writing/source/medium-en/
  writing/source/medium-ja/
  writing/INVENTORY.md
"""

from __future__ import annotations

import json
import re
import sys
import time
import urllib.request
import xml.etree.ElementTree as ET
from html import unescape
from pathlib import Path

ROOT = Path(__file__).resolve().parents[2]
sys.path.insert(0, str(Path(__file__).resolve().parent))
from html_to_md import html_to_md  # noqa: E402

NOTE_USER = "koheinoda"
MEDIUM_USER = "koheinoda_11596"
UA = {"User-Agent": "KocoroLab writing sync (public fetch)"}


def get(url: str) -> bytes:
    req = urllib.request.Request(url, headers=UA)
    with urllib.request.urlopen(req, timeout=30) as res:
        return res.read()


def slugify(text: str) -> str:
    text = (text or "untitled").strip()
    text = re.sub(r"[\\/:*?\"<>|]+", "", text)
    text = re.sub(r"\s+", "-", text)
    return text[:80] or "untitled"


def jp_score(text: str) -> int:
    return len(re.findall(r"[\u3040-\u30ff\u4e00-\u9fff]", text or ""))


def is_japanese(text: str) -> bool:
    jp = jp_score(text)
    latin = len(re.findall(r"[A-Za-z]", text or ""))
    return jp > 20 or (jp > 0 and jp >= latin)


def write_md(path: Path, meta: dict, body_md: str) -> None:
    path.parent.mkdir(parents=True, exist_ok=True)
    lines = ["---"]
    for key, val in meta.items():
        if val is None:
            continue
        sval = str(val).replace("\n", " ").replace('"', "'")
        lines.append(f'{key}: "{sval}"')
    lines.append("---")
    lines.append("")
    lines.append("# " + meta.get("title", ""))
    lines.append("")
    lines.append(body_md.rstrip())
    lines.append("")
    path.write_text("\n".join(lines), encoding="utf-8")


def fetch_notes() -> list[dict]:
    items = []
    page = 1
    while page <= 30:
        url = f"https://note.com/api/v2/creators/{NOTE_USER}/contents?kind=note&page={page}"
        payload = json.loads(get(url))
        rows = (payload.get("data") or {}).get("contents") or []
        if not rows:
            break
        for row in rows:
            key = row.get("key")
            detail = json.loads(get(f"https://note.com/api/v3/notes/{key}"))
            data = detail.get("data") or {}
            title = data.get("name") or row.get("name") or ""
            body_html = data.get("body") or ""
            items.append(
                {
                    "source": "note",
                    "lang": "ja" if is_japanese(title + body_html) else "en",
                    "title": title,
                    "url": f"https://note.com/{NOTE_USER}/n/{key}",
                    "date": (data.get("publish_at") or row.get("publishAt") or "")[:10],
                    "key": key,
                    "body_md": html_to_md(body_html),
                }
            )
            time.sleep(0.25)
        if len(rows) < 6:
            break
        page += 1
        time.sleep(0.25)
    return items


def fetch_medium() -> list[dict]:
    xml = get(f"https://medium.com/feed/@{MEDIUM_USER}")
    root = ET.fromstring(xml)
    ns = {"content": "http://purl.org/rss/1.0/modules/content/"}
    items = []
    for node in root.findall("./channel/item"):
        title = unescape((node.findtext("title") or "").strip())
        link = (node.findtext("link") or "").split("?")[0]
        date = (node.findtext("pubDate") or "")[:16]
        html = node.findtext("content:encoded", namespaces=ns) or node.findtext("description") or ""
        body = html_to_md(html)
        lang = "ja" if is_japanese(title + " " + body) else "en"
        items.append(
            {
                "source": "medium",
                "lang": lang,
                "title": title,
                "url": link,
                "date": date,
                "key": link.rsplit("-", 1)[-1] if "-" in link else slugify(title),
                "body_md": body,
            }
        )
    return items


def existing_en_draft(date: str) -> str | None:
    folder = ROOT / "writing" / "drafts" / "en-from-note"
    if not folder.is_dir() or not date:
        return None
    for path in sorted(folder.glob("*.md")):
        if path.name.startswith(date):
            return path.relative_to(ROOT).as_posix()
    return None


def note_extra(title: str, date: str) -> str:
    bits = []
    draft = existing_en_draft(date)
    if draft:
        bits.append(f"draft: `{draft}`")
    if "COP27" in title or "COP-27" in title:
        bits.append(
            "English Medium already has [The Road to Sharm el-Sheikh (COP-27)]"
            "(https://medium.com/@koheinoda_11596/the-road-to-cop27-cfffb3782701); not a line-by-line twin."
        )
    if not bits:
        return ""
    return " — " + " ".join(bits)


def inventory_md(notes: list[dict], medium: list[dict]) -> str:
    med_ja = [m for m in medium if m["lang"] == "ja"]
    med_en = [m for m in medium if m["lang"] != "ja"]
    lines = [
        "# note / Medium inventory",
        "",
        "Public posts only. Medium RSS is the last ~10 stories; older Medium posts may be missing.",
        "",
        "## Japanese on Medium (should usually live on note)",
        "",
    ]
    if not med_ja:
        lines.append("(none in the current RSS)")
    for m in med_ja:
        extra = ""
        if "unauthorized" in (m["title"] or "").lower() or "非公式翻訳" in (m["title"] or ""):
            extra = " — do not auto-copy to note without checking the original licence."
        lines.append(f"- {m['date']} — [{m['title']}]({m['url']}){extra}")
    lines += ["", "## English on Medium", ""]
    for m in med_en:
        lines.append(f"- {m['date']} — [{m['title']}]({m['url']})")
    lines += ["", "## note (Japanese) with no obvious English Medium twin", ""]
    for n in notes:
        lines.append(f"- {n['date']} — [{n['title']}]({n['url']}){note_extra(n['title'], n['date'])}")
    lines += [
        "",
        "## Gemini vs what actually works",
        "",
        "- 原稿の用意 (Markdown): this script.",
        "- Cursor で日→英: Agent に `writing/prompts/ja-to-en.md` と原文を渡す。",
        "- Medium API で下書き一括アップロード: **新規トークンは出ない** (Medium が 2023 に API を凍結)。",
        "- 実際の公開: 英訳 Markdown を https://medium.com/new に貼る。URL がある場合は Medium の Import a story も使える。",
        "",
    ]
    return "\n".join(lines) + "\n"


def main() -> int:
    source = ROOT / "writing" / "source"
    notes = fetch_notes()
    medium = fetch_medium()
    for n in notes:
        name = f"{n['date']}-{slugify(n['title'])}.md"
        write_md(
            source / "note-ja" / name,
            {"source": "note", "lang": n["lang"], "url": n["url"], "date": n["date"], "title": n["title"]},
            n["body_md"],
        )
    for m in medium:
        folder = "medium-ja" if m["lang"] == "ja" else "medium-en"
        name = f"{slugify(m['title'])}.md"
        write_md(
            source / folder / name,
            {"source": "medium", "lang": m["lang"], "url": m["url"], "date": m["date"], "title": m["title"]},
            m["body_md"],
        )
    (ROOT / "writing" / "INVENTORY.md").write_text(inventory_md(notes, medium), encoding="utf-8")
    print(f"note={len(notes)} medium={len(medium)}")
    print("wrote writing/INVENTORY.md and writing/source/")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

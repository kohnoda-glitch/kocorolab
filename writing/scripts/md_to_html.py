#!/usr/bin/env python3
"""Turn our article Markdown into simple HTML for a browser copy into Medium."""

from __future__ import annotations

import html
import re
from pathlib import Path


TOKEN_RE = re.compile(
    r"!\[([^\]]*)\]\((https?://[^)]+)\)"
    r"|\[([^\]]+)\]\((https?://[^)]+)\)"
    r"|\*\*(.+?)\*\*"
    r"|(?<!\*)\*(?!\*)([^*]+)\*(?!\*)"
)


def inline(text: str) -> str:
    out = []
    pos = 0
    for m in TOKEN_RE.finditer(text):
        out.append(html.escape(text[pos : m.start()]))
        if m.group(2) is not None and m.group(0).startswith("!["):
            out.append(
                f'<img src="{html.escape(m.group(2), quote=True)}" alt="{html.escape(m.group(1) or "")}">'
            )
        elif m.group(4) is not None:
            out.append(
                f'<a href="{html.escape(m.group(4), quote=True)}">{html.escape(m.group(3))}</a>'
            )
        elif m.group(5) is not None:
            out.append(f"<strong>{html.escape(m.group(5))}</strong>")
        else:
            out.append(f"<em>{html.escape(m.group(6))}</em>")
        pos = m.end()
    out.append(html.escape(text[pos:]))
    return "".join(out)


def md_to_blocks(text: str) -> tuple[str, str]:
    lines = text.replace("\r\n", "\n").strip().split("\n")
    title = ""
    if lines and lines[0].startswith("# "):
        title = lines[0][2:].strip()
        lines = lines[1:]
    html_parts: list[str] = []
    buf: list[str] = []
    list_items: list[str] = []

    def flush_p() -> None:
        raw = " ".join(x.strip() for x in buf).strip()
        buf.clear()
        if raw:
            html_parts.append(f"<p>{inline(raw)}</p>")

    def flush_list() -> None:
        if not list_items:
            return
        items = "".join(f"<li>{inline(x)}</li>" for x in list_items)
        html_parts.append(f"<ul>{items}</ul>")
        list_items.clear()

    for line in lines:
        if line.startswith("![](") and line.endswith(")"):
            flush_list()
            flush_p()
            url = line[4:-1]
            html_parts.append(f'<p><img src="{html.escape(url, quote=True)}" alt=""></p>')
            continue
        if re.match(r"^[-*] ", line):
            flush_p()
            list_items.append(line[2:].strip())
            continue
        if not line.strip():
            flush_list()
            flush_p()
            continue
        flush_list()
        buf.append(line)
    flush_list()
    flush_p()
    return title, "\n".join(html_parts)


def wrap_page(title: str, body: str) -> str:
    esc = html.escape(title)
    return f"""<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{esc}</title>
<style>
  body {{ font-family: Georgia, serif; max-width: 720px; margin: 24px auto; padding: 0 16px; line-height: 1.6; }}
  .note {{ font-family: sans-serif; background: #fff6d8; border: 1px solid #e6d48a; padding: 12px 16px; margin-bottom: 24px; }}
  img {{ max-width: 100%; height: auto; }}
</style>
</head>
<body>
<div class="note">
  下の写真と英文を、普通のホームページと同じようにマウスでなぞって選び、<b>⌘C</b> でコピーしてください。
  ボタンは使いません。Medium に戻って、タイトルの下の白いところをクリックし、<b>⌘V</b> で貼ってください。
  タイトル欄には次の1行だけ入れてください。<br><br>
  <b>{esc}</b>
</div>
<article id="article">
{body}
</article>
</body>
</html>
"""


def convert_file(src: Path, dest: Path) -> str:
    title, body = md_to_blocks(src.read_text(encoding="utf-8"))
    dest.write_text(wrap_page(title, body), encoding="utf-8")
    return title


if __name__ == "__main__":
    import sys

    src = Path(sys.argv[1])
    dest = Path(sys.argv[2])
    print(convert_file(src, dest))

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


def strip_front_matter(text: str) -> str:
    if text.startswith("---"):
        parts = text.split("---", 2)
        if len(parts) >= 3:
            return parts[2].lstrip("\n")
    return text


def md_to_blocks(text: str) -> tuple[str, str]:
    text = strip_front_matter(text.replace("\r\n", "\n"))
    lines = text.strip().split("\n")
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
        if line.strip() == "---":
            flush_list()
            flush_p()
            html_parts.append("<hr>")
            continue
        heading = re.match(r"^(#{2,3}) (.+)$", line)
        if heading:
            flush_list()
            flush_p()
            tag = "h2" if heading.group(1) == "##" else "h3"
            html_parts.append(f"<{tag}>{inline(heading.group(2).strip())}</{tag}>")
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


def wrap_page(
    title: str,
    body: str,
    *,
    lang: str = "ja",
    note_html: str | None = None,
) -> str:
    esc = html.escape(title)
    if note_html is None:
        note_html = (
            "下の写真と英文を、普通のホームページと同じようにマウスでなぞって選び、<b>⌘C</b> でコピーしてください。"
            " ボタンは使いません。"
            " Medium は <b>既存の2020-10-08の記事を開いて上書き</b>してください。"
            " <code>https://medium.com/new</code> は開かないでください。"
            " タイトル欄には次の1行だけ入れてください。<br><br>"
            f"<b>{esc}</b>"
        )
    return f"""<!DOCTYPE html>
<html lang="{html.escape(lang, quote=True)}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{esc}</title>
<style>
  body {{ font-family: Georgia, "Hiragino Mincho ProN", "Yu Mincho", serif; max-width: 720px; margin: 24px auto; padding: 0 16px; line-height: 1.7; }}
  .note {{ font-family: sans-serif; background: #fff6d8; border: 1px solid #e6d48a; padding: 12px 16px; margin-bottom: 24px; }}
  .meta {{ font-family: sans-serif; font-size: 0.95rem; color: #333; }}
  h2 {{ margin-top: 2em; font-size: 1.25rem; }}
  h3 {{ margin-top: 1.4em; font-size: 1.05rem; }}
  img {{ max-width: 100%; height: auto; }}
  hr {{ border: 0; border-top: 1px solid #ccc; margin: 2em 0; }}
  @media print {{ .note {{ display: none; }} body {{ max-width: none; }} }}
</style>
</head>
<body>
<div class="note">
  {note_html}
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

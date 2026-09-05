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
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{esc}</title>
<style>
  body {{ font-family: Georgia, serif; max-width: 720px; margin: 24px auto; padding: 0 16px; line-height: 1.6; }}
  .bar {{ font-family: system-ui, sans-serif; background: #111; color: #fff; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; }}
  button {{ font-size: 16px; padding: 8px 14px; cursor: pointer; }}
  #status {{ margin-left: 12px; }}
  img {{ max-width: 100%; height: auto; }}
  h1 {{ font-size: 2em; }}
</style>
</head>
<body>
<div class="bar">
  <div>1. Click Copy for Medium. 2. On Medium, click the empty body under the title. 3. Paste. Put this title in Medium's title box:</div>
  <p><strong>{esc}</strong></p>
  <button type="button" id="copy">Copy for Medium</button>
  <span id="status"></span>
</div>
<article id="article">
{body}
</article>
<script>
document.getElementById("copy").onclick = async function () {{
  const el = document.getElementById("article");
  const html = el.innerHTML;
  const text = el.innerText;
  try {{
    await navigator.clipboard.write([
      new ClipboardItem({{
        "text/html": new Blob([html], {{ type: "text/html" }}),
        "text/plain": new Blob([text], {{ type: "text/plain" }})
      }})
    ]);
    document.getElementById("status").textContent = "Copied. Paste into the Medium body.";
  }} catch (err) {{
    const range = document.createRange();
    range.selectNodeContents(el);
    const sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
    document.execCommand("copy");
    document.getElementById("status").textContent = "Selected. Copy with Cmd+C, then paste into Medium.";
  }}
}};
</script>
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

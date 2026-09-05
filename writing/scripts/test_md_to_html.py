#!/usr/bin/env python3
from pathlib import Path
import sys

sys.path.insert(0, str(Path(__file__).resolve().parent))
from md_to_html import convert_file, inline, md_to_blocks

assert "<strong>Hello</strong>" in inline("**Hello**")
assert '<a href="https://x.test">link</a>' in inline("[link](https://x.test)")
title, body = md_to_blocks("# Title\n\n![](https://cdn.example/a.jpg)\n\n**Hi**\n")
assert title == "Title"
assert "cdn.example/a.jpg" in body
assert "<strong>Hi</strong>" in body
print("ok")

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
title2, body2 = md_to_blocks("---\ntitle: x\n---\n# Paper\n\n## Abstract\n\nHello\n\n### 2.1. Sub\n")
assert title2 == "Paper"
assert "<h2>Abstract</h2>" in body2
assert "<h3>2.1. Sub</h3>" in body2
print("ok")

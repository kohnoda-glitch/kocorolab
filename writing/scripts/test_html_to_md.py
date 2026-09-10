#!/usr/bin/env python3
import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent))
from html_to_md import html_to_md

sample = '<h2>Heading</h2><p>Hello <a href="https://x.test">link</a> and <strong>bold</strong>.</p>'
out = html_to_md(sample)
assert "## Heading" in out
assert "[link](https://x.test)" in out
assert "**bold**" in out
print("ok")

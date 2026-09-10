#!/usr/bin/env python3
"""Small HTML → Markdown converter for note.com / Medium RSS bodies."""

from html.parser import HTMLParser
from html import unescape
import re


class HtmlToMarkdown(HTMLParser):
    SKIP = {"script", "style"}

    def __init__(self):
        super().__init__(convert_charrefs=False)
        self.parts = []
        self.href = None
        self.skip = 0
        self.li_level = 0

    def handle_starttag(self, tag, attrs):
        tag = tag.lower()
        if tag in self.SKIP:
            self.skip += 1
            return
        if self.skip:
            return
        attrs = dict(attrs)
        if tag in ("p", "div"):
            self.parts.append("\n\n")
        elif tag == "br":
            self.parts.append("\n")
        elif tag in ("h1", "h2", "h3", "h4"):
            n = int(tag[1])
            self.parts.append("\n\n" + ("#" * n) + " ")
        elif tag in ("strong", "b"):
            self.parts.append("**")
        elif tag in ("em", "i"):
            self.parts.append("*")
        elif tag == "blockquote":
            self.parts.append("\n\n> ")
        elif tag == "li":
            self.parts.append("\n- ")
        elif tag == "a":
            self.href = attrs.get("href")
            self.parts.append("[")
        elif tag == "img":
            src = attrs.get("src") or ""
            alt = attrs.get("alt") or ""
            if src:
                self.parts.append(f"\n\n![{alt}]({src})\n\n")
        elif tag == "figcaption":
            self.parts.append("\n*")
        elif tag == "hr":
            self.parts.append("\n\n---\n\n")

    def handle_endtag(self, tag):
        tag = tag.lower()
        if tag in self.SKIP:
            self.skip = max(0, self.skip - 1)
            return
        if self.skip:
            return
        if tag in ("strong", "b"):
            self.parts.append("**")
        elif tag in ("em", "i"):
            self.parts.append("*")
        elif tag == "a":
            self.parts.append("](" + (self.href or "") + ")")
            self.href = None
        elif tag == "figcaption":
            self.parts.append("*\n")
        elif tag in ("p", "div", "h1", "h2", "h3", "h4", "li", "blockquote"):
            self.parts.append("\n")

    def handle_data(self, data):
        if self.skip:
            return
        self.parts.append(unescape(data))

    def handle_entityref(self, name):
        if not self.skip:
            self.parts.append(unescape("&" + name + ";"))

    def handle_charref(self, name):
        if not self.skip:
            self.parts.append(unescape("&#" + name + ";"))


def html_to_md(html):
    parser = HtmlToMarkdown()
    parser.feed(html or "")
    parser.close()
    text = "".join(parser.parts)
    text = text.replace("\xa0", " ")
    text = re.sub(r"[ \t]+\n", "\n", text)
    text = re.sub(r"\n{3,}", "\n\n", text)
    return text.strip() + "\n"

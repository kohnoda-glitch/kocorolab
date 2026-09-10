#!/usr/bin/env python3
"""
Try the *legacy* Medium API to create a draft.

Medium stopped issuing new integration tokens in 2023.
This script only works if you already have an old token:

  export MEDIUM_TOKEN='...'
  python3 writing/scripts/medium_draft.py writing/drafts/en-from-note/some-file.md

If the token is missing or rejected, it prints the Markdown path to paste by hand.
"""

from __future__ import annotations

import json
import os
import sys
import urllib.error
import urllib.request
from pathlib import Path


def split_front_matter(text: str) -> tuple[dict, str]:
    if not text.startswith("---\n"):
        return {}, text
    end = text.find("\n---\n", 4)
    if end < 0:
        return {}, text
    meta = {}
    for line in text[4:end].splitlines():
        if ":" in line:
            key, val = line.split(":", 1)
            meta[key.strip()] = val.strip().strip('"')
    return meta, text[end + 5 :].lstrip()


def api(token: str, method: str, url: str, payload=None) -> dict:
    data = None if payload is None else json.dumps(payload).encode("utf-8")
    req = urllib.request.Request(
        url,
        data=data,
        method=method,
        headers={
            "Authorization": "Bearer " + token,
            "Content-Type": "application/json",
            "Accept": "application/json",
            "User-Agent": "KocoroLab writing sync",
        },
    )
    with urllib.request.urlopen(req, timeout=30) as res:
        return json.loads(res.read().decode("utf-8"))


def main(argv: list[str]) -> int:
    if len(argv) < 2:
        print("Usage: python3 writing/scripts/medium_draft.py path/to/article.md", file=sys.stderr)
        return 2
    path = Path(argv[1])
    if not path.is_file():
        print("Not a file:", path, file=sys.stderr)
        return 2
    meta, body = split_front_matter(path.read_text(encoding="utf-8"))
    title = meta.get("title") or path.stem
    token = os.environ.get("MEDIUM_TOKEN", "").strip()
    if not token:
        print("No MEDIUM_TOKEN.")
        print("Medium does not give new API tokens. Paste this file into https://medium.com/new as a draft:")
        print(path.resolve())
        return 1
    try:
        me = api(token, "GET", "https://api.medium.com/v1/me")
        user_id = (me.get("data") or {}).get("id")
        if not user_id:
            raise RuntimeError("no user id in /me")
        created = api(
            token,
            "POST",
            f"https://api.medium.com/v1/users/{user_id}/posts",
            {
                "title": title,
                "contentFormat": "markdown",
                "content": body,
                "publishStatus": "draft",
                "canonicalUrl": meta.get("canonical") or meta.get("url") or "",
            },
        )
        print(json.dumps(created, ensure_ascii=False, indent=2))
        return 0
    except urllib.error.HTTPError as err:
        print("Medium API refused the token (typical for new accounts since 2023).")
        print(err.code, err.read()[:300])
        print("Paste this file into https://medium.com/new :")
        print(path.resolve())
        return 1


if __name__ == "__main__":
    raise SystemExit(main(sys.argv))

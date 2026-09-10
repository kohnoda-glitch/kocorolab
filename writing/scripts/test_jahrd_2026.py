#!/usr/bin/env python3
"""人材育成学会 第24回の貼る用原稿が、字数と禁則を守っているか。"""

from pathlib import Path
import re
import sys

ROOT = Path(__file__).resolve().parents[1]
REG = ROOT / "drafts" / "jahrd-2026" / "演題登録.md"
ASK = ROOT / "drafts" / "jahrd-2026" / "参加者への依頼.md"


def extract(text: str, name: str) -> str:
    start = f"<!-- {name}_BEGIN -->"
    end = f"<!-- {name}_END -->"
    if start not in text or end not in text:
        raise SystemExit(f"missing markers for {name}")
    body = text.split(start, 1)[1].split(end, 1)[0].strip()
    return body


def compact(s: str) -> str:
    return "".join(s.split())


def main() -> int:
    reg = REG.read_text(encoding="utf-8")
    ask = ASK.read_text(encoding="utf-8")
    title = extract(reg, "TITLE")
    abstract = extract(reg, "ABSTRACT")
    n = len(compact(abstract))
    errors = []

    if not (380 <= n <= 420):
        errors.append(f"abstract compact length {n} not in 380–420")

    for needle in (
        "U理論",
        "IDEAS Asia Pacific 2026",
        "個人",
        "社会変革",
        "プロトタイプ",
        "氏名は出さない",
        "事例発表",
        "専任教員",
    ):
        if needle not in reg:
            errors.append(f"演題登録 missing {needle!r}")

    if "2026" not in title:
        errors.append("title should name the 2026 case")

    for bad in (
        "准教授",
        "Founder",
        "Inner Transformation",
        "学習生態系",
        "昭和的知性",
        "VoJ",
        "源泉",
        "MHQ",
        "感情力",
        "共感覚",
    ):
        if bad in reg or bad in ask:
            errors.append(f"forbidden {bad!r}")

    if re.search(r"[一-龥]{1,4}\s*[一-龥]{1,4}さん", abstract):
        errors.append("abstract looks like it names a person")
    if "○○さん" in abstract or "○○さん" in title:
        errors.append("placeholder name leaked into title/abstract")

    for needle in ("承諾", "氏名", "A.", "D."):
        if needle not in ask:
            errors.append(f"依頼 missing {needle!r}")

    if "講師" in title or "講師" in abstract:
        errors.append("title/abstract should not copy 講師 from the Japan Hub page")

    if errors:
        print("FAIL")
        for e in errors:
            print("-", e)
        print(f"title compact={len(compact(title))} abstract compact={n}")
        return 1

    print(f"ok title compact={len(compact(title))} abstract compact={n}")
    return 0


if __name__ == "__main__":
    sys.exit(main())

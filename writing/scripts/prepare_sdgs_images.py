#!/usr/bin/env python3
"""Rebuild Japanese figures in English and normalize photo sizes."""

from __future__ import annotations

from pathlib import Path

import matplotlib.pyplot as plt
from PIL import Image, ImageDraw, ImageFont

ROOT = Path(__file__).resolve().parents[2]
IMG = ROOT / "writing" / "drafts" / "en-from-medium" / "images" / "2020-10-08-sdgs"
PROFILE = {"18.jpg", "19.jpg", "20.jpg", "21.jpg"}
MAX_W = 720
PORTRAIT = 400


def font(size: int, bold: bool = False) -> ImageFont.FreeTypeFont:
    candidates = [
        "/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf" if bold else "/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf",
        "/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf" if bold else "/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf",
    ]
    for path in candidates:
        if Path(path).is_file():
            return ImageFont.truetype(path, size)
    return ImageFont.load_default()


def wrap_text(draw: ImageDraw.ImageDraw, text: str, fnt, max_w: int) -> list[str]:
    words = text.split()
    lines: list[str] = []
    cur = ""
    for word in words:
        trial = (cur + " " + word).strip()
        if draw.textlength(trial, font=fnt) <= max_w:
            cur = trial
        else:
            if cur:
                lines.append(cur)
            cur = word
    if cur:
        lines.append(cur)
    return lines


def make_04() -> None:
    w, h = 900, 340
    im = Image.new("RGB", (w, h), "#ffffff")
    draw = ImageDraw.Draw(im)
    title_f = font(22, bold=True)
    body_f = font(18)
    box1 = (20, 20, w - 20, 140)
    draw.rectangle(box1, fill="#d8efd4")
    t1 = "Limiting warming to 1.5°C rather than 2°C does more to end poverty and reduce inequality — SDG 1 and related goals."
    lines = wrap_text(draw, t1, title_f, w - 80)
    y = 48
    for line in lines:
        tw = draw.textlength(line, font=title_f)
        draw.text(((w - tw) / 2, y), line, fill="#111111", font=title_f)
        y += 32
    draw.rectangle((20, 160, w - 20, h - 20), outline="#222222", width=2)
    t2 = (
        "Measures to stay within 1.5°C have synergies and trade-offs across the SDGs. "
        "Synergies usually outweigh trade-offs, depending on the speed and scale of change, "
        "the mix of mitigation, and how the transition is managed."
    )
    lines = wrap_text(draw, t2, body_f, w - 80)
    y = 180
    for line in lines:
        draw.text((40, y), line, fill="#222222", font=body_f)
        y += 28
    im.save(IMG / "04.jpg", quality=88)


def make_06() -> None:
    members = [
        "Australia",
        "Austria",
        "Belgium",
        "Canada",
        "Czechia",
        "Denmark",
        "European Union",
        "Finland",
        "France",
        "Germany",
        "Greece",
        "Hungary",
        "Iceland",
        "Ireland",
        "Italy",
        "Japan",
        "Luxembourg",
        "Netherlands",
        "New Zealand",
        "Norway",
        "Poland",
        "Portugal",
        "Slovakia",
        "Slovenia",
        "South Korea",
        "Spain",
        "Sweden",
        "Switzerland",
        "United Kingdom",
        "United States",
    ]
    w, h = 900, 420
    im = Image.new("RGB", (w, h), "#ffffff")
    draw = ImageDraw.Draw(im)
    title_f = font(20, bold=True)
    item_f = font(16)
    title = "DAC has 30 members, including the European Union."
    draw.text((24, 16), title, fill="#1a3a6b", font=title_f)
    cols = 4
    rows = 8
    col_w = (w - 40) // cols
    y0 = 64
    for i, name in enumerate(members):
        col = i // rows
        row = i % rows
        draw.text((28 + col * col_w, y0 + row * 42), "•  " + name, fill="#222222", font=item_f)
    im.save(IMG / "06.jpg", quality=88)


def make_17() -> None:
    generated = Path("/opt/cursor/artifacts/assets/rwanda-burundi-locator-en.png")
    if generated.is_file():
        Image.open(generated).convert("RGB").save(IMG / "17.jpg", quality=88)
    else:
        w, h = 900, 480
        im = Image.new("RGB", (w, h), "#e8f2ea")
        draw = ImageDraw.Draw(im)
        draw.rectangle((0, 0, w, 70), fill="#2f6f4e")
        draw.text((24, 22), "Rwanda and Burundi in East Africa", fill="#ffffff", font=font(26, bold=True))
        draw.rounded_rectangle((380, 240, 620, 325), radius=10, fill="#e35d5d", outline="#8b1e1e", width=3)
        draw.text((430, 268), "RWANDA", fill="#ffffff", font=font(24, bold=True))
        draw.rounded_rectangle((380, 345, 620, 430), radius=10, fill="#e35d5d", outline="#8b1e1e", width=3)
        draw.text((415, 373), "BURUNDI", fill="#ffffff", font=font(24, bold=True))
        im.save(IMG / "17.jpg", quality=88)
    old = IMG / "17.png"
    if old.exists():
        old.unlink()


def make_11() -> None:
    countries = ["Japan", "United States", "China", "India"]
    totals = [101.4, 528.9, 184.8, 44.8]
    shares = {
        "Social security": [33, 50, 4, 10],
        "Public works": [7, 2, 35, 13],
        "Education & science": [5, 2, 3, 4],
        "Local finance": [16, 0, 45, 6],
        "Debt interest": [23, 13, 3, 24],
        "Energy": [1, 3, 1, 6],
        "Other": [9, 14, 2, 26],
        "Defense": [5, 15, 7, 11],
        "Foreign affairs": [1, 1, 0, 0],
    }
    fig, axes = plt.subplots(1, 2, figsize=(11.2, 5.2), dpi=120)
    fig.suptitle(
        "National budget expenditure, FY 2019–2020\nJapan, United States, China, India",
        fontsize=13,
        fontweight="bold",
    )
    x = range(len(countries))
    axes[0].bar(x, totals, color=["#c44e52", "#4c72b0", "#dd8452", "#55a868"])
    axes[0].set_xticks(list(x), countries)
    axes[0].set_ylabel("trillion yen")
    axes[0].set_title("Total expenditure")
    bottom = [0, 0, 0, 0]
    colors = plt.cm.tab20.colors
    for i, (label, vals) in enumerate(shares.items()):
        axes[1].bar(x, vals, bottom=bottom, label=label, color=colors[i])
        bottom = [b + v for b, v in zip(bottom, vals)]
    axes[1].set_xticks(list(x), countries)
    axes[1].set_ylabel("share of budget (%)")
    axes[1].set_title("Composition")
    axes[1].legend(loc="upper left", bbox_to_anchor=(1.02, 1), fontsize=8, frameon=False)
    fig.text(
        0.01,
        0.01,
        "Source: Mirai Ken policy report, 19 April 2019. Totals converted to yen in the original.",
        fontsize=8,
        color="#444444",
    )
    fig.tight_layout(rect=(0, 0.05, 1, 0.90))
    fig.savefig(IMG / "11.jpg", dpi=120, bbox_inches="tight", facecolor="white")
    plt.close(fig)


def square_portrait(path: Path) -> None:
    im = Image.open(path).convert("RGB")
    w, h = im.size
    side = min(w, h)
    left = (w - side) // 2
    top = max(0, (h - side) // 5) if h > w else (h - side) // 2
    if top + side > h:
        top = h - side
    im = im.crop((left, top, left + side, top + side))
    im = im.resize((PORTRAIT, PORTRAIT), Image.Resampling.LANCZOS)
    dest = path.with_suffix(".jpg")
    im.save(dest, quality=85, optimize=True)
    if dest != path:
        path.unlink(missing_ok=True)


def cap_photo(path: Path) -> None:
    im = Image.open(path)
    if im.mode in ("RGBA", "P"):
        bg = Image.new("RGB", im.size, "#ffffff")
        bg.paste(im.convert("RGBA"), mask=im.convert("RGBA").split()[-1] if im.mode == "RGBA" else None)
        im = bg
    else:
        im = im.convert("RGB")
    w, h = im.size
    if w > MAX_W:
        h = round(h * MAX_W / w)
        w = MAX_W
        im = im.resize((w, h), Image.Resampling.LANCZOS)
    dest = path.with_suffix(".jpg")
    im.save(dest, quality=85, optimize=True)
    if dest != path:
        path.unlink(missing_ok=True)


def main() -> None:
    IMG.mkdir(parents=True, exist_ok=True)
    make_04()
    make_06()
    make_11()
    make_17()
    for name in PROFILE:
        p = IMG / name
        if p.exists():
            square_portrait(p)
    skip = {"04.jpg", "06.jpg", "11.jpg", "17.png", "17.jpg", *PROFILE}
    for p in sorted(IMG.iterdir()):
        if p.name in skip or p.name.startswith("."):
            continue
        cap_photo(p)
    print("prepared", IMG)


if __name__ == "__main__":
    main()

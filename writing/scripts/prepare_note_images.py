#!/usr/bin/env python3
"""Self-hosted, cleaned figures for the Japanese note import.

Nothing here points at Medium. When the Medium Japanese post is
replaced with English, note can still load these files from GitHub.
"""

from __future__ import annotations

import shutil
from pathlib import Path

import matplotlib.pyplot as plt
from matplotlib import font_manager
from PIL import Image, ImageDraw, ImageFont

ROOT = Path(__file__).resolve().parents[2]
SRC_PHOTO = ROOT / "writing" / "drafts" / "en-from-medium" / "images" / "2020-10-08-sdgs"
DEST = ROOT / "writing" / "drafts" / "ja-to-note" / "images"
JP = "/usr/share/fonts/truetype/wqy/wqy-microhei.ttc"
EN = "/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf"
font_manager.fontManager.addfont(JP)
plt.rcParams["font.family"] = font_manager.FontProperties(fname=JP).get_name()
PHOTOS = ["01.jpg", "05.jpg", "07.jpg", "08.jpg", "10.jpg", "12.jpg", "13.jpg", "14.jpg", "18.jpg", "19.jpg", "20.jpg", "21.jpg"]


def jp_font(size: int) -> ImageFont.FreeTypeFont:
    return ImageFont.truetype(JP, size)


def fp(size: int = 12, weight: str = "regular"):
    return font_manager.FontProperties(fname=JP, size=size)


def wrap(draw: ImageDraw.ImageDraw, text: str, fnt, max_w: int) -> list[str]:
    words = list(text)
    # wrap by width, character-wise for Japanese
    lines, cur = [], ""
    for ch in words:
        trial = cur + ch
        if draw.textlength(trial, font=fnt) <= max_w:
            cur = trial
        else:
            if cur:
                lines.append(cur)
            cur = ch
    if cur:
        lines.append(cur)
    return lines


def save_fig(fig, name: str) -> None:
    dest = DEST / name
    fig.savefig(dest, dpi=140, bbox_inches="tight", facecolor="white")
    plt.close(fig)
    im = Image.open(dest).convert("RGB")
    w, h = im.size
    if w > 900:
        im = im.resize((900, round(h * 900 / w)), Image.Resampling.LANCZOS)
    im.save(dest, quality=88, optimize=True)


def fig_02() -> None:
    fig, ax = plt.subplots(figsize=(8.4, 4.4), dpi=140)
    years = [2010, 2015, 2019, 2030]
    vals = [15.7, 10.0, 8.2, 6.0]
    ax.plot(years[:3], vals[:3], color="#c0392b", linewidth=2.6, marker="o")
    ax.plot(years[2:], vals[2:], color="#c0392b", linewidth=2.6, linestyle="--", marker="o")
    for x, y in zip(years, vals):
        ax.annotate(f"{y}%", (x, y), textcoords="offset points", xytext=(0, 10), ha="center", fontsize=10)
    ax.set_ylim(0, 20)
    ax.set_xticks(years)
    ax.set_ylabel("極度の貧困（世界人口比）", fontproperties=fp(11))
    ax.set_title("図1. コロナ前の2030年予測 — まだ6%が残る", fontproperties=fp(14))
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    fig.text(0.01, 0.01, "出典: UN SDG 1（記事執筆時点の予測）", fontproperties=fp(8), color="#555555")
    save_fig(fig, "02.jpg")


def fig_03() -> None:
    fig, ax = plt.subplots(figsize=(8.4, 3.6), dpi=140)
    labels = ["2019年末\n約6.3億人", "2020年末予測\n約7.0億人"]
    vals = [630, 700]
    bars = ax.bar(range(len(labels)), vals, color=["#7f8c8d", "#c0392b"], width=0.55)
    ax.set_xticks(range(len(labels)), labels, fontproperties=fp(11))
    ax.set_ylabel("百万人", fontproperties=fp(11))
    ax.set_title("図2. コロナで極度の貧困が約7100万人戻る", fontproperties=fp(14))
    ax.set_ylim(0, 850)
    for b, v in zip(bars, vals):
        ax.text(b.get_x() + b.get_width() / 2, v + 20, f"{v}百万", ha="center", fontproperties=fp(10))
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    save_fig(fig, "03.jpg")


def fig_04() -> None:
    w, h = 900, 360
    im = Image.new("RGB", (w, h), "#f7f4ee")
    draw = ImageDraw.Draw(im)
    draw.rounded_rectangle((24, 24, w - 24, 150), radius=10, fill="#2f6f4e")
    t1 = "気温上昇を2度ではなく1.5度に抑える方が、SDGsの貧困撲滅や不公平の是正により貢献する。"
    y = 48
    for line in wrap(draw, t1, jp_font(22), w - 80):
        draw.text((48, y), line, fill="#ffffff", font=jp_font(22))
        y += 36
    draw.rounded_rectangle((24, 170, w - 24, h - 24), radius=10, fill="#ffffff", outline="#2f6f4e", width=2)
    t2 = "1.5度達成の排出削減には、SDGs全体で相乗効果とトレードオフがある。相乗効果はトレードオフに勝りやすいが、変化の速度・範囲、緩和策の構成、移行の管理による。"
    y = 190
    for line in wrap(draw, t2, jp_font(18), w - 80):
        draw.text((48, y), line, fill="#222222", font=jp_font(18))
        y += 30
    im.save(DEST / "04.jpg", quality=88)


def fig_06() -> None:
    members = [
        "オーストラリア",
        "オーストリア",
        "ベルギー",
        "カナダ",
        "チェコ",
        "デンマーク",
        "欧州連合",
        "フィンランド",
        "フランス",
        "ドイツ",
        "ギリシャ",
        "ハンガリー",
        "アイスランド",
        "アイルランド",
        "イタリア",
        "日本",
        "ルクセンブルク",
        "オランダ",
        "ニュージーランド",
        "ノルウェー",
        "ポーランド",
        "ポルトガル",
        "スロバキア",
        "スロベニア",
        "韓国",
        "スペイン",
        "スウェーデン",
        "スイス",
        "イギリス",
        "アメリカ",
    ]
    w, h = 900, 460
    im = Image.new("RGB", (w, h), "#f7f4ee")
    draw = ImageDraw.Draw(im)
    draw.rectangle((0, 0, w, 64), fill="#1f3d5c")
    draw.text((28, 18), "図4. DAC（OECD開発援助委員会）はEUを含む30メンバー", fill="#ffffff", font=jp_font(22))
    cols, rows = 4, 8
    col_w = (w - 48) // cols
    for i, name in enumerate(members):
        col, row = i // rows, i % rows
        draw.text((36 + col * col_w, 88 + row * 44), "・ " + name, fill="#1a1a1a", font=jp_font(18))
    im.save(DEST / "06.jpg", quality=88)


def fig_09() -> None:
    fig, ax = plt.subplots(figsize=(8.4, 4.2), dpi=140)
    labels = ["国際公約\n0.7%", "DAC平均\n2018年", "DAC平均\n2019年"]
    vals = [0.70, 0.31, 0.30]
    colors = ["#2f6f4e", "#c0392b", "#c0392b"]
    bars = ax.bar(range(len(labels)), vals, color=colors, width=0.55)
    ax.set_xticks(range(len(labels)), labels, fontproperties=fp(11))
    ax.axhline(0.7, color="#2f6f4e", linestyle="--", linewidth=1)
    ax.set_ylim(0, 0.9)
    ax.set_ylabel("対GNI比", fontproperties=fp(11))
    ax.set_title("図4. ODA拠出 — 公約0.7%にDAC平均は半分も届かない", fontproperties=fp(13))
    for b, v in zip(bars, vals):
        ax.text(b.get_x() + b.get_width() / 2, v + 0.03, f"{v:.2f}%", ha="center", fontproperties=fp(10))
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    fig.text(0.01, 0.01, "出典: OECD net ODA（記事中の2018–2019年の画面）", fontproperties=fp(8), color="#555555")
    save_fig(fig, "09.jpg")


def fig_11() -> None:
    countries = ["日本", "米国", "中国", "インド"]
    totals = [101.4, 528.9, 184.8, 44.8]
    shares = {
        "社会保障": [33, 50, 4, 10],
        "公共事業": [7, 2, 35, 13],
        "文教科学": [5, 2, 3, 4],
        "地方財源": [16, 0, 45, 6],
        "国債利払": [23, 13, 3, 24],
        "エネルギー": [1, 3, 1, 6],
        "その他": [9, 14, 2, 26],
        "国防": [5, 15, 7, 11],
        "外交": [1, 1, 0, 0],
    }
    fig, axes = plt.subplots(1, 2, figsize=(10.6, 4.8), dpi=140)
    fig.suptitle("図5. 日米中印の国家予算歳出（2019–2020）", fontproperties=fp(14))
    x = range(len(countries))
    axes[0].bar(list(x), totals, color=["#c44e52", "#4c72b0", "#dd8452", "#55a868"])
    axes[0].set_xticks(list(x), countries, fontproperties=fp(10))
    axes[0].set_ylabel("兆円", fontproperties=fp(11))
    axes[0].set_title("総額", fontproperties=fp(12))
    bottom = [0, 0, 0, 0]
    colors = plt.cm.tab20.colors
    for i, (label, vals) in enumerate(shares.items()):
        axes[1].bar(list(x), vals, bottom=bottom, label=label, color=colors[i])
        bottom = [a + b for a, b in zip(bottom, vals)]
    axes[1].set_xticks(list(x), countries, fontproperties=fp(10))
    axes[1].set_ylabel("構成比（%）", fontproperties=fp(11))
    axes[1].set_title("内訳", fontproperties=fp(12))
    axes[1].legend(prop=fp(8), loc="upper left", bbox_to_anchor=(1.02, 1), frameon=False)
    fig.text(0.01, 0.01, "出典: みらい研政策レポート 2019/04/19。数値は原文の円換算。", fontproperties=fp(8), color="#555555")
    fig.tight_layout(rect=(0, 0.06, 1, 0.90))
    save_fig(fig, "11.jpg")


def fig_15() -> None:
    w, h = 880, 420
    im = Image.new("RGB", (w, h), "#f7f4ee")
    draw = ImageDraw.Draw(im)
    draw.rounded_rectangle((40, 40, w - 40, h - 40), radius=16, fill="#1f3d5c")
    draw.text((80, 90), "後発開発途上国", fill="#f2d08b", font=jp_font(28))
    draw.text((80, 150), "46か国", fill="#ffffff", font=jp_font(64))
    t = "税収と外国援助を足しても、道路・学校・医療など最低限の開発予算が足りない国々。この記事の焦点はここにある。"
    y = 250
    for line in wrap(draw, t, jp_font(20), w - 160):
        draw.text((80, y), line, fill="#e8eef5", font=jp_font(20))
        y += 34
    im.save(DEST / "15.jpg", quality=88)


def fig_16() -> None:
    names = ["米国", "日本", "英国", "ドイツ", "フランス", "スウェーデン", "ノルウェー"]
    oda = [31, 15, 18, 14, 11, 6, 5]
    short = [79, 28, 0, 18, 16, 0, 0]
    extra = [0, 0, 0, 0, 0, 1, 1]
    fig, ax = plt.subplots(figsize=(8.8, 4.6), dpi=140)
    x = range(len(names))
    ax.bar(list(x), oda, label="実際のODA", color="#4c72b0")
    ax.bar(list(x), short, bottom=oda, label="公約との不足", color="#c44e52")
    ax.bar(list(x), extra, bottom=[a + b for a, b in zip(oda, short)], label="公約超過", color="#55a868")
    ax.set_xticks(list(x), names, fontproperties=fp(10))
    ax.set_ylabel("十億ドル（2012年価格）", fontproperties=fp(11))
    ax.set_title("図7. 主要援助国のODAと不足（2013年）", fontproperties=fp(14))
    ax.legend(prop=fp(9), frameon=False)
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    fig.text(0.01, 0.01, "概数。原典 OECD / globalissues.org（2013年、記事中の図）。", fontproperties=fp(8), color="#555555")
    save_fig(fig, "16.jpg")


def fig_17() -> None:
    w, h = 900, 500
    im = Image.new("RGB", (w, h), "#eaf3ec")
    draw = ImageDraw.Draw(im)
    draw.rectangle((0, 0, w, 72), fill="#2f6f4e")
    draw.text((28, 20), "ルワンダとブルンジの位置（東アフリカ）", fill="#ffffff", font=jp_font(26))
    draw.rounded_rectangle((40, 110, 340, 450), radius=12, fill="#cfe3d4", outline="#3a6b4c", width=2)
    draw.text((90, 260), "コンゴ民", fill="#1f3d2a", font=jp_font(24))
    draw.rounded_rectangle((370, 110, 620, 220), radius=12, fill="#cfe3d4", outline="#3a6b4c", width=2)
    draw.text((440, 150), "ウガンダ", fill="#1f3d2a", font=jp_font(24))
    draw.rounded_rectangle((650, 110, 860, 450), radius=12, fill="#cfe3d4", outline="#3a6b4c", width=2)
    draw.text((700, 260), "タンザニア", fill="#1f3d2a", font=jp_font(22))
    draw.rounded_rectangle((370, 240, 620, 330), radius=10, fill="#c0392b", outline="#7b241c", width=3)
    draw.text((430, 268), "ルワンダ", fill="#ffffff", font=jp_font(26))
    draw.rounded_rectangle((370, 350, 620, 450), radius=10, fill="#c0392b", outline="#7b241c", width=3)
    draw.text((420, 380), "ブルンジ", fill="#ffffff", font=jp_font(26))
    im.save(DEST / "17.jpg", quality=88)


def copy_photos() -> None:
    DEST.mkdir(parents=True, exist_ok=True)
    for name in PHOTOS:
        src = SRC_PHOTO / name
        if src.exists():
            shutil.copy2(src, DEST / name)


def en_ugly_charts() -> None:
    """Replace remaining screenshot-like English figures."""
    dest = SRC_PHOTO

    fig, ax = plt.subplots(figsize=(8.4, 4.2), dpi=140)
    labels = ["Pledge\n0.7%", "DAC average\n2018", "DAC average\n2019"]
    vals = [0.70, 0.31, 0.30]
    bars = ax.bar(labels, vals, color=["#2f6f4e", "#c0392b", "#c0392b"], width=0.55)
    ax.set_ylim(0, 0.9)
    ax.set_ylabel("share of GNI")
    ax.set_title("ODA — the DAC average is not even half of the 0.7% pledge")
    for b, v in zip(bars, vals):
        ax.text(b.get_x() + b.get_width() / 2, v + 0.03, f"{v:.2f}%", ha="center")
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    fig.savefig(dest / "09.jpg", dpi=140, bbox_inches="tight", facecolor="white")
    plt.close(fig)

    w, h = 880, 400
    im = Image.new("RGB", (w, h), "#f4f7fb")
    draw = ImageDraw.Draw(im)
    draw.rounded_rectangle((40, 36, w - 40, h - 36), radius=16, fill="#1f3d5c")
    draw.text((80, 80), "Least developed countries", fill="#f2d08b", font=ImageFont.truetype(EN, 26))
    draw.text((80, 140), "46 states", fill="#ffffff", font=ImageFont.truetype(EN, 56))
    draw.text((80, 240), "Tax plus aid is still too small for a basic", fill="#e8eef5", font=ImageFont.truetype(EN, 20))
    draw.text((80, 274), "public floor: roads, schools, clinics, safety.", fill="#e8eef5", font=ImageFont.truetype(EN, 20))
    im.save(dest / "15.jpg", quality=88)

    names = ["US", "Japan", "UK", "Germany", "France", "Sweden", "Norway"]
    oda = [31, 15, 18, 14, 11, 6, 5]
    short = [79, 28, 0, 18, 16, 0, 0]
    extra = [0, 0, 0, 0, 0, 1, 1]
    fig, ax = plt.subplots(figsize=(8.8, 4.6), dpi=140)
    x = range(len(names))
    ax.bar(list(x), oda, label="ODA given", color="#4c72b0")
    ax.bar(list(x), short, bottom=oda, label="Short of the pledge", color="#c44e52")
    ax.bar(list(x), extra, bottom=[a + b for a, b in zip(oda, short)], label="Above the pledge", color="#55a868")
    ax.set_xticks(list(x), names)
    ax.set_ylabel("billion USD (2012 prices)")
    ax.set_title("ODA and the gap for main donors, 2013")
    ax.legend(frameon=False)
    ax.spines["top"].set_visible(False)
    ax.spines["right"].set_visible(False)
    fig.savefig(dest / "16.jpg", dpi=140, bbox_inches="tight", facecolor="white")
    plt.close(fig)


def main() -> None:
    DEST.mkdir(parents=True, exist_ok=True)
    copy_photos()
    fig_02()
    fig_03()
    fig_04()
    fig_06()
    fig_09()
    fig_11()
    fig_15()
    fig_16()
    fig_17()
    en_ugly_charts()
    print("note images", len(list(DEST.glob("*.jpg"))))


if __name__ == "__main__":
    main()

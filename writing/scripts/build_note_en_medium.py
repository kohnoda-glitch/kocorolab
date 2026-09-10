#!/usr/bin/env python3
"""Build Medium paste HTML for the 2026-08-25 and 2026-09-04 note essays.

These are NEW English stories. They are not overwrites of 2020/2021 Medium
URLs, and Medium has no date field for a pasted story.
"""

from __future__ import annotations

import sys
from pathlib import Path

from PIL import Image, ImageDraw, ImageFont

ROOT = Path(__file__).resolve().parents[2]
sys.path.insert(0, str(Path(__file__).resolve().parent))
from md_to_html import md_to_blocks, wrap_page  # noqa: E402

BRANCH = "cursor/note-medium-writing-4caf"
RAW_BASE = (
    "https://raw.githubusercontent.com/kohnoda-glitch/kocorolab/"
    f"{BRANCH}/writing/drafts/en-from-note/images"
)
MAX_W = 720
EN_FONT = "/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf"
EN_BOLD = "/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf"
DEST = ROOT / "writing/drafts/en-from-note"
IMG_0825 = DEST / "images/2026-08-25-os-of-learning"
IMG_0904 = DEST / "images/2026-09-04-objective-function"
TMP_0825 = Path("/tmp/note-0825-img")
TMP_0904 = Path("/tmp/note-0904-img")

TITLE_0825 = "What I have been thinking since last year — updating the OS of learning"
TITLE_0904 = (
    "Rewriting the objective function — change management in the well-being era, "
    "and the ground under Japanese youth"
)
NOTE_0825 = "https://note.com/koheinoda/n/ne5355b32099c"
NOTE_0904 = "https://note.com/koheinoda/n/nbbf6602c4344"


def font(path: str, size: int) -> ImageFont.FreeTypeFont:
    return ImageFont.truetype(path, size)


def save_resized(src: Path, dest: Path, max_w: int = MAX_W) -> None:
    dest.parent.mkdir(parents=True, exist_ok=True)
    im = Image.open(src)
    if im.mode in ("RGBA", "P"):
        im = im.convert("RGBA")
        bg = Image.new("RGB", im.size, (255, 255, 255))
        bg.paste(im, mask=im.split()[-1] if im.mode == "RGBA" else None)
        im = bg
    else:
        im = im.convert("RGB")
    w, h = im.size
    if w > max_w:
        h = round(h * max_w / w)
        im = im.resize((max_w, h), Image.Resampling.LANCZOS)
    im.save(dest, quality=85, optimize=True)


def wrap_text(draw: ImageDraw.ImageDraw, text: str, fnt, max_w: int) -> list[str]:
    words = text.split()
    lines, cur = [], ""
    for word in words:
        trial = word if not cur else cur + " " + word
        if draw.textlength(trial, font=fnt) <= max_w:
            cur = trial
        else:
            if cur:
                lines.append(cur)
            cur = word
    if cur:
        lines.append(cur)
    return lines


def _center(draw: ImageDraw.ImageDraw, text: str, cx: float, y: int, fnt, fill: str) -> None:
    tw = draw.textlength(text, font=fnt)
    draw.text((cx - tw / 2, y), text, fill=fill, font=fnt)


def _arrow(draw: ImageDraw.ImageDraw, box: tuple[int, int, int, int], fill: str) -> None:
    x0, y0, x1, y1 = box
    mid = (y0 + y1) / 2
    body = x0 + int((x1 - x0) * 0.62)
    draw.polygon(
        [
            (x0, y0 + 10),
            (body, y0 + 10),
            (body, y0),
            (x1, mid),
            (body, y1),
            (body, y1 - 10),
            (x0, y1 - 10),
        ],
        fill=fill,
    )


def _fit_center(
    draw: ImageDraw.ImageDraw,
    text: str,
    cx: float,
    cy: float,
    fill,
    sizes: tuple[int, ...],
    max_w: int,
) -> None:
    for size in sizes:
        fnt = font(EN_BOLD, size)
        tw = draw.textlength(text, font=fnt)
        if tw <= max_w:
            bbox = fnt.getbbox(text)
            th = bbox[3] - bbox[1]
            draw.text((cx - tw / 2, cy - th / 2 - bbox[1]), text, fill=fill, font=fnt)
            return
    fnt = font(EN_BOLD, sizes[-1])
    tw = draw.textlength(text, font=fnt)
    bbox = fnt.getbbox(text)
    th = bbox[3] - bbox[1]
    draw.text((cx - tw / 2, cy - th / 2 - bbox[1]), text, fill=fill, font=fnt)


def _flood_gray_interior(im: Image.Image, seed: tuple[int, int], fill) -> None:
    """Fill one outlined gray shape, including white Japanese sitting on it."""
    w, h = im.size
    px = im.load()
    sx, sy = seed
    start = px[sx, sy]
    if (start[0] + start[1] + start[2]) / 3 < 80:
        raise SystemExit(f"flood seed {seed} is on an outline")
    seen = {seed}
    stack = [seed]
    while stack:
        x, y = stack.pop()
        px[x, y] = fill
        for nx, ny in ((x - 1, y), (x + 1, y), (x, y - 1), (x, y + 1)):
            if not (0 <= nx < w and 0 <= ny < h) or (nx, ny) in seen:
                continue
            r, g, b = px[nx, ny]
            if (r + g + b) / 3 < 90:
                continue
            seen.add((nx, ny))
            stack.append((nx, ny))
            if len(seen) > 120000:
                raise SystemExit(f"flood from {seed} leaked")


def draw_hm_figure(dest: Path) -> None:
    """English labels on the Japanese note figure (same geometry as Pirson 2017).

    The CUP book figure is not posted as a free image. Do not invent a new
    diagram. Paint English onto the figure already used on note.
    """
    src = IMG_0904 / "01-figure-ja.jpg"
    im = Image.open(src).convert("RGB")
    white = (255, 255, 255)
    black = (25, 25, 25)
    gray = (122, 122, 122)

    # Pixel ops first. ImageDraw after this, or the original bitmap is flushed back.
    _flood_gray_interior(im, (130, 270), gray)
    _flood_gray_interior(im, (300, 376), gray)
    _flood_gray_interior(im, (130, 500), gray)
    _flood_gray_interior(im, (350, 600), gray)
    _flood_gray_interior(im, (130, 645), gray)
    _flood_gray_interior(im, (310, 776), gray)

    draw = ImageDraw.Draw(im)

    def blot(box, fill) -> None:
        draw.rectangle(box, fill=fill)

    blot((140, 6, 390, 48), white)
    blot((98, 50, 278, 96), white)
    blot((372, 86, 640, 136), white)
    blot((105, 402, 318, 450), white)
    blot((368, 424, 652, 478), white)

    _fit_center(draw, "Economistic model", 248, 27, black, (22, 20, 18), 240)
    _fit_center(draw, "Operating logic", 186, 73, black, (18, 16, 15), 170)
    _fit_center(draw, "Maximization", 170, 227, white, (16, 15, 14), 108)
    _fit_center(draw, "Wealth / Power / Status", 506, 111, black, (17, 15, 14), 255)
    _fit_center(draw, "Freedom to satisfy unbounded wants", 468, 367, white, (13, 12, 11), 430)
    _fit_center(draw, "Humanistic model", 208, 426, black, (20, 18, 16), 200)
    _fit_center(draw, "Well-being", 510, 451, black, (18, 16, 14), 250)
    _fit_center(draw, "Promotion of", 180, 520, white, (13, 12, 11), 130)
    _fit_center(draw, "practical wisdom", 180, 538, white, (13, 12, 11), 130)
    _fit_center(draw, "Dignity threshold", 495, 600, white, (16, 15, 14), 250)
    _fit_center(draw, "Protection of", 180, 668, white, (13, 12, 11), 130)
    _fit_center(draw, "dignity", 180, 686, white, (13, 12, 11), 130)
    _fit_center(draw, "Freedom to balance the drives", 499, 760, white, (13, 12, 11), 350)

    dest.parent.mkdir(parents=True, exist_ok=True)
    im.save(dest, quality=92, optimize=True)


def raw(folder: str, name: str) -> str:
    return f"{RAW_BASE}/{folder}/{name}"


def hint(title: str, original_date: str, *, first: bool) -> str:
    order = (
        "8月25日を先に公開してください。9月4日の本文は「前回」と書いてあるので、"
        "先に8月25日の Medium URL が無いと、前回のリンクは note のままです。"
        if first
        else (
            "8月25日の英語を先に出してから、この記事の "
            "<b>Last time I wrote about updating the OS of learning</b> "
            "のリンクを、その Medium URL に差し替えてもよい。"
        )
    )
    return (
        f"{original_date} の日本語 note の英語版です。<b>新規記事</b>です。"
        " <code>https://medium.com/new</code> を開いてください。"
        " 2020年・2021年の Medium 記事は上書きしないでください。<br>"
        "Medium に日付を戻す欄はありません。貼って公開すると日付は今日になります。"
        " 先頭の1行に、日本語原文の日付と note の URL を入れてあります。それで足りる。<br>"
        "黄色い枠の下をマウスでなぞって <b>⌘C</b>。Medium の本文に <b>⌘V</b>。"
        f" タイトル欄: <b>{title}</b><br>"
        "一覧が変なら、編集画面の <b>… → More settings</b>。"
        " <b>Story Preview</b> の Title / Subtitle も英語にする。"
        " 任意で <b>This story was originally published elsewhere</b> に note の URL を入れてもよい"
        "（日付は変わりません。原文が note だと示すだけです）。<br>"
        f"{order}"
        " 他人の Medium 記事を Import して日付だけ借りることはしないでください。"
    )


def write_pair(md_name: str, html_name: str, paste_name: str, title: str, hint_html: str) -> None:
    md_path = DEST / md_name
    text = md_path.read_text(encoding="utf-8")
    title_found, body = md_to_blocks(text)
    if title_found != title:
        raise SystemExit(f"title mismatch: {title_found!r}")
    html = wrap_page(title, body, lang="en", note_html=hint_html)
    (DEST / html_name).write_text(html, encoding="utf-8")
    paste = (
        f"<!-- NEW Medium story at https://medium.com/new . Do not overwrite 2020/2021. "
        f"Title box: {title}. Date will be today. Copy photos from {html_name}. -->\n\n"
        + text
    )
    (DEST / paste_name).write_text(paste, encoding="utf-8")


def prepare_images() -> None:
    if not TMP_0825.joinpath("01.jpg").is_file():
        raise SystemExit("missing /tmp/note-0825-img (download the note photos first)")
    if not TMP_0904.joinpath("cover.jpg").is_file():
        raise SystemExit("missing /tmp/note-0904-img")
    save_resized(TMP_0825 / "cover.jpg", IMG_0825 / "00-cover.jpg")
    save_resized(TMP_0825 / "01.jpg", IMG_0825 / "01.jpg")
    save_resized(TMP_0825 / "02.jpg", IMG_0825 / "02.jpg")
    save_resized(TMP_0904 / "cover.jpg", IMG_0904 / "00-cover.jpg")
    save_resized(TMP_0904 / "figure.jpg", IMG_0904 / "01-figure-ja.jpg")
    draw_hm_figure(IMG_0904 / "02-figure-en.jpg")
    save_resized(TMP_0904 / "yt.jpg", IMG_0904 / "03-youtube.jpg")
    save_resized(TMP_0904 / "hm-book.jpg", IMG_0904 / "04-book.jpg", max_w=333)


def write_markdown() -> None:
    r25 = lambda n: raw("2026-08-25-os-of-learning", n)
    r04 = lambda n: raw("2026-09-04-objective-function", n)
    (DEST / "2026-08-25-updating-the-os-of-learning.md").write_text(
        f"""---
source: "note"
lang: "en"
url: "{NOTE_0825}"
title: "{TITLE_0825}"
translated_from: "昨年から今年にかけて考えていること——「これからの学び」のOSをアップデートする"
date: "2026-08-25"
status: "medium-new"
---

# {TITLE_0825}

Japanese original, 25 August 2026: [昨年から今年にかけて考えていること——「これからの学び」のOSをアップデートする (note)]({NOTE_0825})

![]({r25("00-cover.jpg")})

Late last year I joined a discussion on the future of higher education, especially business-school education. I teach and support workshops in GLOBIS and MIT courses, working with leadership, ethics, and values. That is why I keep a basic question close: is the education we offer actually working for this time, and for the people in it?

The unease is not new. For several years I had been turning it over in small study groups inside the school. From the end of last year into this year, though, unexpected connections among people and ideas kept appearing, and the inquiry began to move much faster.

## 1. A global shift in education, and reunions close to home

One large backdrop is the series of global conversations led by Otto Scharmer, Michael Pirson, and others under *Transforming Business, Education, and Business Education for Flourishing*. The move beyond an industrial-era model, toward education that maximises the well-being of all beings, is a shift I also feel from a world-systems view.

These are Scharmer’s March essay and the February essay he wrote with Pirson:

[Universities as innovation ecologies for human and planetary flourishing](https://medium.com/presencing-institute-blog/universities-as-innovation-ecologies-for-human-and-planetary-flourishing-84313c75c0d7)

[12 principles for reimagining universities in times of rupture and regeneration](https://medium.com/presencing-institute-blog/12-principles-for-reimagining-universities-in-times-of-rupture-and-regeneration-8b607a841800)

The conversation continues this year:

[Transforming Business, Education, and Business Education (u-school, 2026)](https://www.u-school.org/offerings/transf-business-ed-2026)

The same current showed up at home, both by chance and not. At a year-end gathering of my alma mater, Institute of Science Tokyo, I met Professor Inohara again. He has been working, in a Central Council for Education working group on special activities, on homeroom, student council, and how young people form agreement. From the new year we began talking regularly on Zoom.

A colleague from my time at the University of Zurich AI Lab, Iida — now a professor of robotics at Cambridge, and recently back in Japan with a professorship at the University of Tokyo — also returned. Around the publication of his book *The World’s Finest Learning*, the three of us sat down and talked hard about education from here on.

[The World’s Finest Learning (Amazon)](https://amzn.asia/d/0gNM9h4l)

## 2. Why leaders burn out, and multiple intelligences

What these conversations and daily practice make clear is that the work is not only inside universities and business schools.

I have seen many capable leaders, people with long careers, fall ill or collapse under pressure in rapid change. Multiple intelligences (MI) make the reason plain enough: the intelligences and literacies for looking after the body, for sound relationship, and for inner work were never well grown in a career built mainly on competition.

That is why I keep returning to Roger Schank’s *Learning by Doing*, which I first met in the change-management practice of Andersen Consulting (now Accenture), and to action learning as it has been developed at MIT and elsewhere.

## 3. Thinking in Bali, and what comes next

Two weeks in Bali this August settled the point.

![]({r25("01.jpg")})

*From city life to a quiet part of an island that is also a surfing place. How do you hold that balance? A drawing and a message from a workshop.*

What is needed now is not a uniform model that assumes industrial task-processing, but a holistic space of learning grounded in bodily health and relationship, and open to being human. That is close to the spirit of the school and projects I ran for years in Dumaguete, in the Philippines.

After a week supporting an MIT course workshop in Bali, I joined this shared-learning festival:

[Ecosystem Leadership Festival Asia Pacific 2026 (9–12 August) | u-school for Transformation](https://www.u-school.org/offerings/elpap2026-m3)

From the whole-education worries of parents of secondary-school students, to the ground of reflection and dialogue that working adults need to return to — how do we update the “OS of learning” in Japanese society as a whole?

I am now shaping this, not only as a book but through essays and other public writing. How do we build a learning ecology, beyond the ready-made idea of the business school or the university, in which people can maximise well-being in their own way? I will share the search and the practice here, a little at a time.

![]({r25("02.jpg")})

*A note toward a blog post on what a u-school is.*
""",
        encoding="utf-8",
    )
    (DEST / "2026-09-04-rewriting-the-objective-function.md").write_text(
        f"""---
source: "note"
lang: "en"
url: "{NOTE_0904}"
title: "{TITLE_0904}"
translated_from: "目的関数を書き換える――ウェルビーイング時代のチェンジマネジメントと日本のユースの足元"
date: "2026-09-04"
status: "medium-new"
---

# {TITLE_0904}

Japanese original, 4 September 2026: [目的関数を書き換える――ウェルビーイング時代のチェンジマネジメントと日本のユースの足元 (note)]({NOTE_0904})

![]({r04("00-cover.jpg")})

*Cover photo: last weekend, in class. With students we put the important figures of 2026 on the floor and embodied the relationships of the future we want the school to make.*

Last time I wrote about [updating the OS of learning]({NOTE_0825}).

After that I sat in a meeting on how, in 2026 — a year of many conflicts, of damage from climate and disaster, of advancing AI in the economy, and of rising energy demand — we should put a question about learning back into the world. (The idea is to raise it in a book.) The next morning, after something like a gathering of people who support Kumamoto, I found myself looking up, for the first time in a while, the mental-health situation of Japanese youth. The disorder of the COVID years has already receded quite far.

In the world, the regime in Myanmar has changed, the United States withdrew from Afghanistan, and fighting has not stopped in Ukraine or Gaza.

In Japan, though, the mental-health statistics that follow the same direction as the rest of the world have in fact kept worsening, as an unchanged trend. After I returned at the end of 2020, and once things had settled a little in 2022 and 2023, I tried as hard as I could to put back into the world the questionnaire I had long worked on — measuring mental-health risk — and to contribute to well-being inside organisations as an HR practitioner. Not only among youth: well-being among adults inside organisations stayed grim where it was grim, and the effect of that reached me too. For a time I had to step off the front line.

From the end of 2023 I began working with a graduate school of management in Japan, and from the start of 2024 with one overseas. So the frame widened beyond the specialised field of mental health, toward *change management in the well-being era*, and toward how we might underwrite Japan’s transformation. I have been in that conversation since.

![]({r04("03-youtube.jpg")})

[Change Management for the Well-Being Era (YouTube playlist)](https://www.youtube.com/playlist?list=PLiSKEuDit5HplW8JI5fHlWPYA32wQwAxp)

Still, if the OS of firms and the economy keeps running on the maximisation of wealth, and on behaviour that answers stakeholder expectations for that, I felt we cannot really move from a secured footing (well-being) into work for a better, more flourishing future. (You see logics that look like discarding the weak.) The shape of that unease became clear when I met Michael Pirson and others’ *Humanistic Management*. Contemporary economic activity and organisations run, often without noticing, on a particular “objective function.”

![]({r04("02-figure-en.jpg")})

*English labels on the figure I translated for the Japanese original, after Pirson, Humanistic Management (2017).*

From *Humanistic Management*, in my translation:

The “economic model” we have taken up without much doubt puts “maximise” in its operating logic, and chases wealth, power, and status. What sits there is the freedom to fill a bottomless want. That rigid system has thrown young people and working people into harsh competition, and worn them down.

What we should aim for is a turn toward a “humanistic model.” Its operating logic is the promotion of practical wisdom and the protection of dignity, with well-being set at the top. Well-being here is not only human well-being; it includes nature and the planetary environment. The design puts the freedom to regulate impulse at the base, and redesigns the organisation while guarding a threshold of dignity.

Other countries have had this chance too, but so has Japan, across these thirty years: a chance to set well-being as the axis. When I started work in the late 1990s, in the employment ice age, the internet bubble had not yet burst. After Lehman in 2008, data I took on a commissioned survey of university students’ interest in starting a company had fallen more than ten points from ten years earlier. Hope had been lost. Then came the Great East Japan Earthquake. Policy on global talent made it look, for a moment, as if young people might go out into the world. After COVID, a lack of hope that is like the rest of the world, and also particular to Japan, began to show in the statistics. The hardness of life that Japanese youth face now must not be filed away as mere “personal weakness.”

I searched on a Friday morning last week. It took a week to arrive here: thinking about the mental situation of youth is thinking about the situation of this society. What we should really face is not the “hearts” of the young, but the “objective function” of the organisations and the society around them.

The *Humanistic Management* book that holds the figure above came out nine years ago. *Humanistic Leadership*, on how to move from existing organisations toward ones that aim at humanistic, well-being-maximising practice, came out only this year. Both are in English only. I would like, with people of the same intent, to try that practice — in English, or in translation.

![]({r04("04-book.jpg")})

[Humanistic Management and Leadership (Amazon.co.jp)](https://www.amazon.co.jp/dp/B0GQGVTF3H)

[Humanistic Management (Amazon.com)](https://www.amazon.com/Humanistic-Management-Protecting-Promoting-Well-Being/dp/1316613712)
""",
        encoding="utf-8",
    )


def write_readme() -> None:
    (DEST / "README.md").write_text(
        """# 2026 note → Medium（新規・英語）

8月25日と9月4日の日本語 note の英語版です。**新規記事**です。2020年・2021年の Medium は上書きしません。

Medium に日付を戻す欄はありません。貼って公開すると日付は今日になります。先頭の1行に原文の日付と note の URL を入れてあります。

1. 先に 8月25日を出す  
   [このページ](https://htmlpreview.github.io/?https://github.com/kohnoda-glitch/kocorolab/blob/cursor/note-medium-writing-4caf/writing/drafts/en-from-note/OPEN-IN-BROWSER-2026-08-25.html)
2. つぎに 9月4日を出す  
   [このページ](https://htmlpreview.github.io/?https://github.com/kohnoda-glitch/kocorolab/blob/cursor/note-medium-writing-4caf/writing/drafts/en-from-note/OPEN-IN-BROWSER-2026-09-04.html)

どちらも `https://medium.com/new` を開く。黄色い枠の下をマウスでなぞって ⌘C。本文に ⌘V。タイトルは自分で入れる。Markdown は貼らない。

任意: … → More settings で Story Preview を英語に。This story was originally published elsewhere に note の URL を入れてもよい（日付は変わらない）。

他人の記事を Import して日付だけ借りることはしない。
""",
        encoding="utf-8",
    )


def main() -> int:
    prepare_images()
    write_markdown()
    write_pair(
        "2026-08-25-updating-the-os-of-learning.md",
        "OPEN-IN-BROWSER-2026-08-25.html",
        "PASTE-TO-MEDIUM-2026-08-25.md",
        TITLE_0825,
        hint(TITLE_0825, "2026年8月25日", first=True),
    )
    write_pair(
        "2026-09-04-rewriting-the-objective-function.md",
        "OPEN-IN-BROWSER-2026-09-04.html",
        "PASTE-TO-MEDIUM-2026-09-04.md",
        TITLE_0904,
        hint(TITLE_0904, "2026年9月4日", first=False),
    )
    write_readme()
    print("0825 images", sorted(p.name for p in IMG_0825.glob("*")))
    print("0904 images", sorted(p.name for p in IMG_0904.glob("*")))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

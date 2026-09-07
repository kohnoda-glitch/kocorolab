#!/usr/bin/env python3
from pathlib import Path

from PIL import Image

ROOT = Path(__file__).resolve().parents[1] / "drafts" / "en-from-note"
RAW = "https://raw.githubusercontent.com/kohnoda-glitch/kocorolab/cursor/note-medium-writing-4caf/writing/drafts/en-from-note/images"
NOTE_0825 = "https://note.com/koheinoda/n/ne5355b32099c"
NOTE_0904 = "https://note.com/koheinoda/n/nbbf6602c4344"


def test_medium_new_stories() -> None:
    html25 = (ROOT / "OPEN-IN-BROWSER-2026-08-25.html").read_text(encoding="utf-8")
    html04 = (ROOT / "OPEN-IN-BROWSER-2026-09-04.html").read_text(encoding="utf-8")
    md25 = (ROOT / "2026-08-25-updating-the-os-of-learning.md").read_text(encoding="utf-8")
    md04 = (ROOT / "2026-09-04-rewriting-the-objective-function.md").read_text(encoding="utf-8")

    for html in (html25, html04):
        assert "medium.com/new" in html
        assert "日付を戻す欄はありません" in html
        assert "2020年・2021年の Medium 記事は上書きしない" in html
        assert "他人の Medium 記事を Import して日付だけ借りることはしない" in html
        assert "assets.st-note.com" not in html
        assert "medium.com/_/stat" not in html

    assert NOTE_0825 in html25 and "25 August 2026" in html25
    assert NOTE_0904 in html04 and "4 September 2026" in html04
    assert html25.count("<img") == 3
    assert html04.count("<img") == 4
    assert "Redrawn in English" in html04
    assert "Humanistic Management" in html04
    assert "updating the OS of learning" in html04
    assert NOTE_0825 in html04
    fig = Image.open(ROOT / "images/2026-09-04-objective-function/02-figure-en.jpg")
    assert fig.size == (720, 980)

    for name in (
        "images/2026-08-25-os-of-learning/00-cover.jpg",
        "images/2026-08-25-os-of-learning/01.jpg",
        "images/2026-08-25-os-of-learning/02.jpg",
        "images/2026-09-04-objective-function/00-cover.jpg",
        "images/2026-09-04-objective-function/01-figure-ja.jpg",
        "images/2026-09-04-objective-function/02-figure-en.jpg",
        "images/2026-09-04-objective-function/03-youtube.jpg",
        "images/2026-09-04-objective-function/04-book.jpg",
    ):
        path = ROOT / name
        assert path.is_file() and path.stat().st_size > 1000, path
        im = Image.open(path)
        assert im.size[0] <= 720 or name.endswith("04-book.jpg"), (name, im.size)
        assert im.size[0] >= 200 and im.size[1] >= 100

    assert f"{RAW}/2026-08-25-os-of-learning/01.jpg" in md25
    assert f"{RAW}/2026-09-04-objective-function/02-figure-en.jpg" in md04
    assert "Do not overwrite 2020/2021" in (ROOT / "PASTE-TO-MEDIUM-2026-08-25.md").read_text()
    assert "Do not overwrite 2020/2021" in (ROOT / "PASTE-TO-MEDIUM-2026-09-04.md").read_text()
    readme = (ROOT / "README.md").read_text(encoding="utf-8")
    assert "OPEN-IN-BROWSER-2026-08-25.html" in readme
    assert "OPEN-IN-BROWSER-2026-09-04.html" in readme


if __name__ == "__main__":
    test_medium_new_stories()
    print("ok")

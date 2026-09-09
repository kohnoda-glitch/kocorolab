#!/usr/bin/env python3
from pathlib import Path
import subprocess
import sys
import zipfile

ROOT = Path(__file__).resolve().parents[2]
SCRIPT = Path(__file__).resolve().parent / "build_book_proposal.py"
OUT = ROOT / "writing" / "drafts" / "book-proposal"
STEM = "出版企画書"


def _xml(docx: Path) -> str:
    with zipfile.ZipFile(docx) as z:
        return z.read("word/document.xml").decode("utf-8")


def test_build_emits_downloadable_editor_file():
    subprocess.check_call([sys.executable, str(SCRIPT)])
    md = (OUT / f"{STEM}.md").read_text(encoding="utf-8")
    html = (OUT / "OPEN-IN-BROWSER.html").read_text(encoding="utf-8")
    docx = OUT / f"{STEM}.docx"
    zpath = OUT / f"{STEM}.zip"
    assert docx.is_file()
    assert zpath.is_file()
    with zipfile.ZipFile(zpath) as z:
        assert f"{STEM}.docx" in z.namelist()
    xml = _xml(docx)
    blob = md + html + xml
    assert "准教授" not in blob
    assert "Founder" not in blob
    assert "さむらい" not in blob
    assert "PHP" not in blob
    assert "英治" not in blob
    assert "KADOKAWA" not in blob
    assert "角川" not in blob
    assert "第1案" not in blob
    assert "STEM拡張" not in blob
    assert "Drive" not in xml and "Drive" not in md
    assert "50個" not in blob
    assert "100個" not in blob
    assert "全55" not in blob
    assert "Palantir" not in blob
    assert "専任教員" in blob
    assert "代表取締役" in blob
    assert "共同発起人" not in blob
    assert "感情とは何か" not in blob
    assert "感情は身体から始まる" not in blob
    assert "感情は人から人へ伝染する" not in blob
    assert "ビジネスと研究のパートナー" in blob
    assert "日本認知科学会" in blob
    assert "SPEA" in blob
    assert md.rindex("松岡良彦") > md.rindex("野田浩平（主著）")
    assert "昭和というロストテクノロジー" in blob
    assert "ほかの候補" in blob
    assert "手垢" in blob
    assert md.index("昭和というロストテクノロジー") < md.index("感情力の時代")
    assert "1. 売り" not in md
    assert "プロデューサー" not in blob
    assert "肩書の書き方" not in blob
    assert "（野田）" not in md
    assert "多重知能" in blob
    assert "ガードナー" in blob
    assert "1. タイトル" in md
    assert "ケンブリッジ" in blob
    assert "いまさら新しい" in blob
    assert "東京大学" in blob
    assert "東京科学大学" in blob
    assert "中央教育審議会" in blob
    assert "身体性ロボット" in blob
    assert "人工知能" in blob
    assert "精密工学" in blob
    assert "特別活動" in blob


if __name__ == "__main__":
    test_build_emits_downloadable_editor_file()
    print("ok")

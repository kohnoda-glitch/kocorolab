#!/usr/bin/env python3
from pathlib import Path
import subprocess
import sys
import zipfile

ROOT = Path(__file__).resolve().parents[2]
SCRIPT = Path(__file__).resolve().parent / "build_book_proposal.py"
OUT = ROOT / "writing" / "drafts" / "book-proposal"
STEM = "出版企画書_感情力の時代_編集者提出用"


def test_build_emits_files_without_forbidden_titles():
    subprocess.check_call([sys.executable, str(SCRIPT)])
    md = (OUT / f"{STEM}.md").read_text(encoding="utf-8")
    html = (OUT / "OPEN-IN-BROWSER.html").read_text(encoding="utf-8")
    docx = OUT / f"{STEM}.docx"
    assert docx.is_file()
    with zipfile.ZipFile(docx) as z:
        xml = z.read("word/document.xml").decode("utf-8")
    blob = md + html + xml
    assert "准教授" not in blob
    assert "Founder" not in blob
    assert "さむらい" not in blob
    assert "バイアスとAIとデータとドローン" not in blob
    assert "専任教員" in blob
    assert "代表取締役" in blob
    assert "これから確認" in blob
    assert "共同発起人" in blob
    assert "昭和というロストテクノロジー" in blob
    assert "感情力の時代" in blob
    assert blob.count("第1章") >= 1
    assert "全55" not in md
    assert "100個" not in md


if __name__ == "__main__":
    test_build_emits_files_without_forbidden_titles()
    print("ok")

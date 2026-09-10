#!/usr/bin/env python3
import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent))
from sdgs_text import apply_en_editorial, apply_ja_editorial, split_campaign


def test_ja_editorial() -> None:
    src = (
        "SDGs(Sustainable Developmental Goals：持続可能な開発目標)\n"
        "去年末で訳6億3000万人でしたでしょうから\n"
        "2. 3. 課題と向き合うきっかけや経緯\n"
        "図４. OECDの各国ODA拠出統計（自分でいじって）\n"
        "図４. DAC: Development Assistance Committee.\n"
        "図５. 日米中印の国家予算比較\n"
        "図６. 絶対的貧困撲滅が難しい低開発46カ国\n"
        "図７. ODA予算が非常に足りていないアメリカ、日本を示すグラフ\n"
    )
    out = apply_ja_editorial(src)
    assert "Sustainable Development Goals" in out
    assert "Developmental" not in out
    assert "約6億3000万人" in out
    assert "訳6億" not in out
    assert "2.3. 課題と向き合うきっかけや経緯" in out
    assert "図５. OECDの各国ODA拠出統計" in out
    assert "図４. DAC:" in out
    assert "図６. 日米中印の国家予算比較" in out
    assert "図７. 絶対的貧困撲滅が難しい" in out
    assert "図８. ODA予算が非常に足りていない" in out


def test_en_editorial() -> None:
    src = (
        "Figure 4. DAC: the countries\n"
        "Figure 4. OECD statistics on each country’s ODA (you can change the view)\n"
        "President of Kocoro Laboratory (HR consulting and mental-health services)\n"
    )
    out = apply_en_editorial(src)
    assert "Figure 5. OECD statistics" in out
    assert "Figure 4. DAC:" in out
    assert "Representative Director of Kocorolab / Kocoro Laboratory" in out
    assert "President of Kocoro Laboratory" not in out


def test_split_campaign() -> None:
    body = "core\n\n**4. What we want this project to do**\napp\n"
    core, app = split_campaign(body, ("**4. What we want this project to do**",))
    assert "core" in core
    assert app.startswith("**4. What we want this project to do**")
    assert "What we want" not in core


if __name__ == "__main__":
    test_ja_editorial()
    test_en_editorial()
    test_split_campaign()
    print("ok")

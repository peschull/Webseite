# Erstelle die Blockstruktur für aufklappbares-organigramm
$blockPath = "c:\Users\schul\OneDrive\webseite\verein-menschlichkeit-theme\blocks\aufklappbares-organigramm"
New-Item -ItemType Directory -Path $blockPath -Force
New-Item -ItemType File -Path "$blockPath\block.json" -Force
New-Item -ItemType File -Path "$blockPath\block.js" -Force
New-Item -ItemType File -Path "$blockPath\save.js" -Force
New-Item -ItemType File -Path "$blockPath\style.css" -Force
New-Item -ItemType File -Path "$blockPath\editor.css" -Force

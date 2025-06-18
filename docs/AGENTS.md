# Agents-Dokumentation mit Codex erzeugen

Dieser Leitfaden zeigt Schritt f\u00fcr Schritt, wie eine `agents.md` nachtr\u00e4glich mit Hilfe von OpenAI Codex erstellt werden kann. Das Repository enth\u00e4lt derzeit keine Agents (z.B. LangChain- oder Autogen-Skripte). Die folgenden Punkte beschreiben dennoch, wie eine Dokumentation angelegt werden kann, sobald Agents vorhanden sind.

## 1  | Vorbereitung

| Aufgabe             | Konkrete Aktion |
| ------------------- | ---------------------------------------------------------------- |
| Projekt scannen     | \u2022 Verzeichnisstruktur, `requirements.txt`/`pom.xml` etc.\n\u2022 Welche \u201eAgents\u201c gibt es? Rollen, Ein-/Ausgaben, Abh\u00e4ngigkeiten. |
| Infos sammeln       | Erstelle ein **Notiz-Scratchpad** (z. B. `docs/tmp_agents_notes.md`) mit Stichpunkten zu:\n\u2013 Zweck jedes Agenten\n\u2013 Framework (LangChain, Autogen, CrewAI ...)\n\u2013 API-Endpunkte / CLI-Befehle\n\u2013 Setup & Konfiguration (ENV-Variablen, Ports) |
| Codex bereitstellen | API-Key setzen (`export OPENAI_API_KEY=\u2026`) oder VS Code-Copilot / ChatGPT-Code-Interpreter \u00f6ffnen. |

## 2  | Ger\u00fcst f\u00fcr `agents.md` definieren

```md
# Agents Overview
## 1. Motivation
## 2. Architecture Diagram
## 3. Agent Roles
### 3.1 <AgentName>
- Purpose  
- Inputs / Outputs  
- Key Dependencies  
### 3.2 ...
## 4. Setup & Run
## 5. API / CLI Examples
## 6. Troubleshooting & Best Practices
```

## 3  | Codex-Prompting: erstes Draft generieren

```
SYSTEM: You are a senior AI engineer. Create a complete agents.md file for the repo at /workspace. 
Use the skeleton below, fill in sections with code examples, tables, and step-by-step instructions.
USER: <f\u00fcge hier dein Skeleton + Scratchpad-Stichpunkte ein>
```

**Tipps**

1. **\u201cAdd code fences where appropriate \u2026\u201d** \u2192 zwingt Codex zum Markdown-Output.
2. Wenn Diagramme n\u00f6tig: `@startuml`-Bl\u00f6cke generieren lassen (PlantUML).

## 4  | Iterativ verfeinern

| Iteration | Fokus           | Codex-Beispiel-Prompt |
| --------- | --------------- | -------------------- |
| **#2**    | Details checken | \u201eExpand section *Troubleshooting* with the 3 most common failure modes you observe in the repo\u2019s issue tracker.\u201c |
| **#3**    | Style-Checks    | \u201eRewrite passive sentences into active voice; keep headers <= 3 levels deep.\u201c |
| **#4**    | Validierung     | \u201eCompare the *Setup & Run* section with the existing README, merge missing flags.\u201c |

## 5  | Automatisierung (optional, CI)

1. **Script** `update_agents_md.py`

   ```bash
   #!/usr/bin/env python
   import subprocess, openai, pathlib, json
   scratch = pathlib.Path("docs/tmp_agents_notes.md").read_text()
   skeleton = pathlib.Path("docs/skeleton_agents.md").read_text()
   resp = openai.ChatCompletion.create(
       model="gpt-4o-code-2025-06-13",
       temperature=0.2,
       messages=[
         {"role":"system","content":"You are an elite doc generator."},
         {"role":"user","content":skeleton + "\n\n" + scratch}
       ])
   pathlib.Path("docs/agents.md").write_text(resp.choices[0].message.content)
   ```
2. **GitHub Action**: Trigger bei \u00c4nderungen an `src/agents/**` \u2192 ruft Script, committed auto-update.

## 6  | Qualit\u00e4t sichern

* **Markdown-Lint** (`markdownlint-cli`) im PR-Workflow.
* **Doc-Tests**: kleine Python-Snippets aus `agents.md` in `pytest --doctest-glob`.
* **Human Review**: Lead-Dev oder Tech-Writer geht final durch (Sprachstil & Richtigkeit).

## 7  | Zeiteinsch\u00e4tzung (Faustregel f\u00fcr mittelgro\u00dfes Repo)

| Phase                       | Dauer         |
| --------------------------- | ------------- |
| Info-Sammlung               | 1 – 2 h       |
| Skeleton & erster Codex-Run | 15 – 30 min   |
| 2 – 3 Iterationen           | 30 – 45 min   |
| CI-Integration              | 1 h           |
| **Summe**                   | **≈ 3 – 4 h** |

### Schnelle Checkliste

* [ ] Scratchpad mit allen Agent-Facts angelegt
* [ ] Markdown-Skeleton definiert
* [ ] Codex-Prompt ausgef\u00fchrt → erster Draft
* [ ] 2 – 3 Review-Schleifen
* [ ] Automatisierter Re-Build in CI

> **Ergebnis:** Eine aktuelle, pr\u00e4zise `agents.md`, dauerhaft synchron mit deinem Code – generiert (und bei Bedarf regeneriert) mithilfe von Codex.

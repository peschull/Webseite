# Deep-Research Audit Request

*(WordPress-Ökosystem auf GitHub – Multi-Repo + Docs-Compliance, 100-Punkte-System)*

> **Zweck**
> Dieses Dokument liefert Auditor\*innen eine vollständige, standardisierte Prüfanweisung
> – vom Code über Sicherheit, Performance, UX/Animationen bis hin zur Einhaltung
> **aller** einschlägigen Dokumentationen (WordPress-Handbücher, OWASP, WCAG …).

---

## 1 | Rahmendaten (des Gesamt-Audits)

| Aspekt             | Platzhalter / Beispiel                    |
| ------------------ | ----------------------------------------- |
| **Audit ID**       | `WPA-DR-2025-06`                          |
| **Audit-Zeitraum** | 24.–27. Juni 2025                         |
| **Kommunikation**  | GitHub Issues + Slack `#audit`            |
| **Prüfumgebung**   | `docker-compose.yml` (PHP 8.2, MySQL 8.0) |
| **WP-Zielversion** | 6.5.x                                     |
| **Auditor-Team**   | <Name1>, <Name2>                          |
| **Stakeholder**    | PO / CTO / DevOps-Lead                    |

---

## 2 | Projekt-Landkarte (Matrix aller Repositories)

| Alias           | URL                             | Typ         | Owner  | Krit.¹ | Prüftiefe² |
| --------------- | ------------------------------- | ----------- | ------ | ------ | ---------- |
| **core-theme**  | `github.com/org/wp-theme-core`  | Theme       | FE     | H      | full       |
| **plugin-shop** | `github.com/org/wp-plugin-shop` | Plugin      | BE     | H      | full       |
| **blocks-lib**  | `github.com/org/blocks-library` | ComposerPkg | FE     | M      | spot       |
| **iac-deploy**  | `github.com/org/iac-deploy`     | Terraform   | DevOps | M      | spot       |

¹ H=High / M=Medium / L=Low  ² full ≈ 100 %, spot ≈ 30 %

---

## 3 | Audit-Umfang (Scopes)

1. **Code-Basis** – Themes, Child-Themes, Plugins, MU-Plugins, Composer-Packages
2. **CI/CD & Build** – GitHub Actions, Tests, Deploy-Pipelines
3. **Security & Compliance** – OWASP Top 10, Secrets, DSGVO
4. **Performance & SEO** – Server-/Client-Metriken, Core Web Vitals
5. **UX & Visuelles Design** – Layout, Typografie, Brand-Konformität
6. **Animationen & Interaktionen** – Performance, `prefers-reduced-motion`
7. **Accessibility (A11y)** – WCAG 2.2 AA, ARIA
8. **Internationalisierung (i18n)** – Text-Domain, RTL
9. **Maintainability** – Test-Coverage, Coding-Standards, Dependency-Mgmt.
10. **Infrastructure-as-Code** – Terraform / Docker Best-Practices
11. **Docs-Compliance** – alle relevanten Leitdokumente (s. Kap. 4)

---

## 4 | Docs-Taxonomie & Punktverteilung (30 P gesamt)

| Kürzel    | Themen-Scope                     | Quellen (Auszug)                        | Max P |
| --------- | -------------------------------- | --------------------------------------- | ----- |
| **WP**    | WP Core / Theme / Plugin / Block | developer.wordpress.org                 | 6     |
| **SEC**   | Security                         | OWASP Top 10, MITRE CWE, WP White-Paper | 5     |
| **A11Y**  | Accessibility                    | WCAG 2.2, ARIA Authoring Practices      | 4     |
| **FE**    | Frontend (HTML/CSS/JS/React)     | MDN, React-Docs, Tailwind-Docs          | 4     |
| **BE**    | Backend (PHP/Composer)           | php.net, PSR-12, MySQL Manual           | 3     |
| **CI**    | Pipelines & Deploy               | GitHub Actions, Docker, Terraform-Docs  | 3     |
| **SEO**   | Search & Performance             | Google Search Central, CWV              | 3     |
| **LEGAL** | Recht & Lizenzen                 | DSGVO, SPDX, CC-Lizenzen                | 2     |

> **Bewertung** je Kriterium: 0 = fehlt · 1 = teilweise · 2 = erfüllt · 3 = übertrifft
> Punkte innerhalb eines Bereichs verteilen sich gleichmäßig auf dessen Kriterien.

---

## 5 | Bewertungsmatrix (Repo-Score, 100 P je Repo)

| Kategorie                       | Gewicht | Prüfkriterien (Auszug)                              |
| ------------------------------- | ------: | --------------------------------------------------- |
| Code-Qualität                   |    18 P | PSR-12 + WP-CS, Architektur, Wiederverwendbarkeit   |
| Sicherheit                      |    18 P | Nonces, Escaping, Dependency-Scans                  |
| Performance                     |    12 P | TTFB, LCP < 2,5 s, Caching-Strategie                |
| CI/CD                           |     8 P | Build-Matrix, Tests, Rollback                       |
| Dokumentation                   |     8 P | README, Setup-Guides, Inline-Docs                   |
| Accessibility (A11y)            |     8 P | WCAG AA, keyboard nav, contrast                     |
| **UX & Visuelles Design**       |    10 P | Grid, Typografie, CI-Konformität                    |
| **Animationen & Interaktionen** |     6 P | Dauer < 300 ms, HW-Accel., `prefers-reduced-motion` |
| SEO & Schema                    |     4 P | Strukturierte Daten, hreflang                       |
| Internationalisierung           |     4 P | Text-Domain, Übersetzbarkeit                        |
| Recht & Datenschutz             |     4 P | DSGVO, Cookie-Banner, Lizenzen                      |

---

## 6 | Score-Formel (Gesamt)

$$
\text{TOTAL}  
= \sum\nolimits_{\text{Repos}} \bigl(\text{Repo-Score}_{i} \times \text{Gewicht}_{i}\bigr)  
+ \text{Docs-Compliance}  
$$

Gewicht: H = 1,0 · M = 0,7 · L = 0,4 · L = 0,2 (falls genutzt)

---

## 7 | Prüf-Workflow & Methodik

| Phase                    |       Dauer | Tasks (Kurzfassung)                                                        |
| ------------------------ | ----------: | -------------------------------------------------------------------------- |
| **1 Onboarding**         |      0,5 PT | Repos klonen, Docker up, Abhängigkeiten installieren                       |
| **2 Autom. Scans**       |      1,0 PT | `composer lint`, `npm run lint`, PHPUnit/Jest, `lighthouse-ci`, `axe-core` |
| **3 Docs-Lint**          |      0,5 PT | GitHub Action `docs-lint` ⇒ JSON-Report + Heatmap                          |
| **4 Manueller Review**   |      2,0 PT | Architektur, Security Hot-Spots, Visual Walk-Through, Animation-Audit      |
| **5 Synthese & Bericht** |      0,5 PT | Punkte konsolidieren, Quick-Wins definieren                                |
| **6 Feedback-Session**   |     0,25 PT | Ergebnispräsentation, Q&A                                                 |
| **Summe**                | **4,75 PT** | ~ 5 Kalendertage                                                          |

---

## 8 | Tool-Stack (kurz & komplett)

| Zweck                 | Tool / Service               |
| --------------------- | ---------------------------- |
| Coding-Standards      | **PHP_CodeSniffer** + WP-CS |
| Static Analysis       | **PHPStan** Level 8          |
| Security Scan         | **WPScan**, **Dependabot**   |
| Visual Regression     | **Percy** / **BackstopJS**   |
| Animation-Performance | Chrome DevTools Performance  |
| Accessibility         | **axe-core**, **Pa11y**      |
| Docs-Lint             | **tools/docs-lint.js** (CLI) |
| CI/CD                 | **GitHub Actions**           |

---

## 9 | Artefakte & Abgabeformate

1. **Audit-Report** (`audit-YYYYMM.pdf` + `.md`)

   * Repo-Score-Tabelle, Docs-Compliance-Tabelle, Heatmap-SVG
   * Befundlisten, Screenshots, Log-Anhang
2. **GitHub Issues / Pull-Requests**

   * je kritischer Bug ein Issue, Sammel-PR für Fixes
3. **Roadmap-Empfehlung** (0–3 Monate)
4. **Score-Badges** (`shields.io`) in jeder README

---

## 10 | Reporting-Snippets (Markdown-Vorlage)

### 10.1 Repo-Score

```markdown
| Repo          | Score | Gewicht | Weighted | Top-Defizite |
|---------------|------:|--------:|---------:|--------------|
| core-theme    | 78    | 1.0     | 78.0     | … |
| plugin-shop   | 71    | 1.0     | 71.0     | … |
| blocks-lib    | 64    | 0.7     | 44.8     | … |
| iac-deploy    | 81    | 0.7     | 56.7     | … |
```

### 10.2 Docs-Compliance

```markdown
| Kürzel | Max | Score | Hauptabweichungen |
|--------|----:|------:|-------------------|
| WP     | 6 | 5 | Block-Metadata v3 fehlt |
| SEC    | 5 | 3 | 2 Endpoints ohne Nonce  |
| A11Y   | 4 | 2 | Slider ignoriert key-nav|
…  
```

### 10.3 UX & Animationen (Beispiel)

```markdown
## UX & Visuelles Design (10/10 P)
| Unterkriterium          | Score | Evidenz |
|-------------------------|------:|---------|
| Grid & Spacing          | 2     | Figma vs. Live match |
| Farbkontrast            | 2     | ≥ 4.5:1 |
…  

## Animationen & Interaktionen (6/6 P)
| Unterkriterium          | Score | Evidenz |
|-------------------------|------:|---------|
| Dauer < 300 ms          | 2     | Hero fade-in 220 ms |
| HW-Accel (`transform`)  | 1     | Slider → `left`     |
| prefers-reduced-motion  | 2     | Motion disabled ok |
| Micro-UX konsistent     | 1     | Checkout-Button-Hover fehlt |
```

---

## 11 | Quick-Wins (Tabelle)

| Maßnahme                            | Kürzel | Aufwand | +P |
| ----------------------------------- | ------ | ------: | -: |
| `block.json` → v3 upgraden          | WP     |   0,5 h | +1 |
| Nonce-Validierung in 2 AJAX-Actions | SEC    |     1 h | +1 |
| Tailwind Tokens zentralisieren      | FE     |     2 h | +1 |
| `aria-live` für Slider-Status       | A11Y   |     1 h | +1 |

---

## 12 | Implementation-Checkliste

* [ ] **Projekt-Landkarte** (Kap. 2) ausfüllen
* [ ] **docs-matrix.yml** anlegen / aktualisieren
* [ ] **docs-lint.js** Regeln pro Kürzel pflegen
* [ ] **GitHub Action** `docs-lint` einrichten
* [ ] **Bewertungs-Matrix** (Kap. 5) in alle Repos kopieren
* [ ] **Score-Badges** in README einbinden
* [ ] **Audit-Branch** `audit/<YYYYMM>` anlegen & Dokument hochladen

---

## 13 | Badge-Snippets (Beispiel)

```markdown
![Repo Score](https://img.shields.io/badge/Audit-78%2F100-brightgreen)  
![Docs](https://img.shields.io/badge/Docs-14%2F30-yellow)
```

---

**→ Vorgehen**

1. Dieses Markdown-Dokument als `AUDIT_REQUEST.md` auf Branch `audit/<Datum>` einchecken.
2. Auditor\*innen in Pull-Request mentionen und Kick-off-Call planen.
3. Nach Audit-Zyklus → Ergebnisse mergen und Score-Badge aktualisieren.

> **Fertig.** Kopiere diese Anleitung in dein Repository – sie ist **ready-to-run**.

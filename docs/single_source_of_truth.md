# Single Source of Truth: Projekt-Website menschlichkeit-oesterreich.at

Stand: 21. Juni 2025

Dieses Dokument bündelt alle zentralen Projektparameter an einer Stelle und dient als langfristige Referenz.

---

## 1. Domain & Technik
- **URL:** <https://www.menschlichkeit-oesterreich.at/>
- **CMS:** WordPress 6 (Full‑Site‑Editing, Block‑Theme)
- **CRM:** CiviCRM 6 (Starter‑Suite)
- **Hosting:** Stitch – Green-IT-V-Server in Wien (100 % Ökostrom, 24/7 Support)
- **PHP/DB:** PHP 8.2 FPM, MariaDB 10.11
- **Git:** <https://github.com/menschlichkeit-oesterreich/website> (Deploy via GitHub Actions → SSH)
- **TLS:** Let’s Encrypt (HSTS: 31536000, OCSP Stapling)
- **CDN:** optional Bunny.net (Edge‑Caching, WebP)
- **Statuten:** barrierefrei, PDF/UA: `/downloads/Statuten.pdf`

---

## 2. SEO & Sitemap

### Meta‑Defaults
```html
<title>Menschlichkeit Österreich – Solidarität · Gerechtigkeit · Klimaschutz</title>
<meta name="description" content="Der gemeinnützige Verein Menschlichkeit Österreich verbindet demokratische Bildungsarbeit, soziale Hilfe und ökologischen Wandel – parteiunabhängig und nachhaltig.">
<meta name="keywords" content="soziale Gerechtigkeit, Klimaschutz, Demokratie, Solidarität, Verein, Österreich, NGO, Spenden, Freiwilligenarbeit">
<link rel="canonical" href="https://www.menschlichkeit-oesterreich.at/">
```

### Sitemap
- `/` – Start & Leitbild
- `/verein/` – Mission, Werte, Team, Statuten
- `/aktuelles/` – Blog & Pressemeldungen
- `/projekte/` – Dynamische Projektseiten
- `/mitmachen/` – Ehrenamt, Mitgliedschaft, Newsletter
- `/spenden/` – CiviCRM‑Contribution Page
- `/wissen/` – Fact‑Sheets, Whitepapers, Podcast
- `/kontakt/` – Formular, Barriere‑Info, Presse
- `/impressum/` – DSGVO, Barriereerklärung

### Core Web Vitals
- **LCP:** ≤ 1.8 s (mobil)
- **FID / INP:** ≤ 100 ms
- **CLS:** ≤ 0.1

---

## 3. Barrierefreiheit (WCAG 2.2 AA)
- Gutenberg‑ready; Kontrast ≥ 4.5 : 1
- Text‑Zoom bis 200 %
- Landmarks (`<nav>`, `<main>`, `<aside>`), Skip‑Links
- Gendergerechte Alt‑Texte
- PDF/UA‑konforme Dokumente

---

## 4. Inhaltsstrategie

| Pillar                | Formate              | Keywords (Long‑tail)                                   |
|-----------------------|----------------------|--------------------------------------------------------|
| Soziale Gerechtigkeit | Blog, Interviews     | Nachbarschaftshilfe, solidarische Initiativen          |
| Klima & Umwelt        | Projektberichte, Infografiken | Klimaaktionstage, CO₂ sparen Alltag                |
| Demokratische Bildung | How‑To‑Guides, Webinare | Politische Bildung Workshop, Bürger\*innenrat      |

- **Frequenz:** 2 Blogposts + 1 Snack‑Reel pro Woche
- **Tonalität:** journalistisch, inklusiv, berührend
- Style Guide im Git‑Repo: [`docs/style.md`](style.md)

---

## 5. Integrationen & Workflows
- Newsletter/Kampagnen: Mosaico + FlexMailer (via Activepieces)
- Self-Service: SearchKit + FormBuilder (`/mein-konto/`)
- Spenden: CiviSEPA / Stripe (Instant E‑Mail‑Receipts)
- FiBu: FreeFinance-Adapter (automatisiert via API)
- Automatisierung: n8n (self‑host, Webhook-Queue)
- Cloud-Sharing: Nextcloud + OAuth2-SSO

---

## 6. Performance & Sicherheit
- Redis Object Cache, Brotli Compression
- Bilder: WebP primär, AVIF als Fallback
- MFA, Limit‑Login‑Attempts
- CSP: `default-src 'self'; img-src 'self' data: https://stats.openstreetmap.de`
- Nightly Backups via `wp-cli` → S3
- DSGVO: Real Cookie Banner, Matomo self‑hosted (1st‑party analytics)

---

## 7. Messung & Reporting
- Matomo: Visits, Conversions, Heatmaps (täglich)
- Google Search Console: CTR & Index‑Gesundheit (wöchentlich)
- Statuscake: Uptime (alle 30 s, EU‑Standorte)
- Lighthouse‑CI: GitHub‑Integration bei jeder PR

---

## 8. Roadmap
1. Headless CMS via REST API (PWA)
2. Nextcloud‑SSO (OIDC)
3. Automatisierte Förderreports (SearchKit ↔ n8n)
4. LibrePay für Peer‑to‑Peer-Spenden

---

Dieses Dokument dient als zentrale Referenz zur Planung, Implementierung und Weiterentwicklung der Webseite „Menschlichkeit Österreich“.

Weitere Leitfäden:
- [UX‑ & Accessibility‑Guidelines](ux_design_overview.md)
- [Testing‑Strategie](testing_overview.md)


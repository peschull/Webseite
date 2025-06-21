# Verein Menschlichkeit Theme

Ein modernes, responsives WordPress-Theme für den Verein Menschlichkeit. Entwickelt für hohe Flexibilität, Barrierefreiheit und einfache Pflege durch Redakteure.

## Projektbeschreibung
Dieses Theme bildet die technische Grundlage für die Website des Vereins Menschlichkeit. Es bietet individuelle Inhaltsbereiche, flexible Komponenten (über ACF und Gutenberg-Blöcke) und ein ansprechendes, zugängliches Design.

## Voraussetzungen
- WordPress ab Version 6.0
- PHP ab Version 7.4
- Benötigte Plugins:
  - Advanced Custom Fields (Pro empfohlen)
  - CiviCRM (optional, für Mitgliederverwaltung)

## Installation
1. Theme-Ordner `verein-menschlichkeit-theme` in das Verzeichnis `/wp-content/themes/` kopieren.
2. Im WordPress-Backend unter "Design > Themes" aktivieren.
3. Plugins installieren und aktivieren (siehe oben).
4. (Empfohlen) ACF-Feldgruppen importieren oder per ACF-JSON bereitstellen (`acf-json`-Ordner).
5. Menüs zuweisen, Startseite und wichtige Seiten anlegen.

## Entwicklung & Anpassung
- **Struktur:**
  - Zentrale Templates: `index.php`, `single.php`, `page.php`, `header.php`, `footer.php`
  - Individuelle Seiten: z. B. `team.php`, `veranstaltungen.php`, `downloads.php`, `galerie.php`
  - Custom Post Types: Team, Veranstaltungen, Downloads, Testimonials
  - Blöcke: im Ordner `/blocks/` (Gutenberg-kompatibel)
- **Eigene Styles/Skripte:**
  - Haupt-CSS: `style.css`
  - Eigene JS: `custom-interaction.js`, Block-spezifische JS/CSS in `/blocks/`
- **ACF:**
  - Felder werden im Theme genutzt, z. B. für Team, Partner, Galerie
  - Bei fehlendem ACF-Plugin werden Felder ignoriert (funktioniert mit Fallback)
- **Barrierefreiheit:**
  - Alt-Texte, ARIA-Attribute, Skip-Links und Kontrast geprüft
- **Performance:**
  - Lazy Loading für Bilder, keine doppelten Libraries, konditionales Laden von Assets

## Wartung & Weiterentwicklung
- Änderungen an Templates und Styles nach Möglichkeit modular halten
- Bei neuen Features: WordPress Coding Standards beachten
- Für größere Anpassungen empfiehlt sich die Nutzung eines Child-Themes
- Codequalität kann mit Tools wie PHP_CodeSniffer, ESLint, Stylelint geprüft werden

## Kontakt & Support
- Verein Menschlichkeit e.V.
- Kontakt über das WordPress-Backend oder die Website

---

*Letzte Aktualisierung: 18.06.2025*

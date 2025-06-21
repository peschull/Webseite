# Setup für Local Version 9.2.4+6788

## 1. Local Installation & Site-Erstellung

1. **Local 9.2.4+6788 installieren**
   - Download von https://localwp.com/releases/
   - Installiere die App für dein Betriebssystem

2. **Neue WordPress-Site erstellen**
   ```
   Site Name: verein-menschlichkeit-theme
   Environment: Preferred (Latest PHP, MySQL, Nginx)
   WordPress Username: admin
   WordPress Password: [dein-passwort]
   ```

3. **Theme-Dateien kopieren**
   - Öffne Site in Local → "Open site folder"
   - Navigiere zu `app/public/wp-content/themes/`
   - Kopiere dein Theme-Verzeichnis hierhin:
     ```
     C:\Users\schul\OneDrive\webseite\Webseite\verein-menschlichkeit-theme
     ```

## 2. WordPress-Konfiguration

1. **Theme aktivieren**
   - Gehe zu deiner Local-Site → "WP Admin"
   - Design → Themes → "Verein Menschlichkeit" aktivieren

2. **SSL aktivieren (empfohlen)**
   - In Local: Site Settings → SSL → "Trust"
   - URL wird zu: `https://verein-menschlichkeit-theme.local`

## 3. Test-Konfiguration anpassen

1. **Cypress baseUrl anpassen**
   ```javascript
   // cypress.config.cjs
   baseUrl: "https://verein-menschlichkeit-theme.local"
   ```

2. **Playwright baseURL anpassen**
   ```javascript
   // playwright.config.js
   baseURL: 'https://verein-menschlichkeit-theme.local'
   ```

3. **Dev-Server deaktivieren**
   ```javascript
   // playwright.config.js - webServer auskommentieren
   // webServer: { ... }
   ```

## 4. Tests ausführen

```bash
# Cypress (interaktiv)
npx cypress open

# Cypress (headless)
npx cypress run

# Playwright
npx playwright test

# Nur Accessibility-Tests
npx playwright test tests/accessibility/
```

## 5. Troubleshooting

### Local-Site nicht erreichbar
- Überprüfe Local → Sites → deine Site → "Start site"
- URL in Browser testen: `http://verein-menschlichkeit-theme.local`

### SSL-Probleme
- Local → Site Settings → SSL → "Trust"
- Browser-Cache leeren
- In Tests: `"chromeWebSecurity": false` in cypress.config.cjs

### Theme nicht sichtbar
- WordPress Admin → Design → Themes
- Überprüfe Datei-Pfad: `app/public/wp-content/themes/verein-menschlichkeit-theme/`
- style.css muss Theme-Header enthalten

### Test-Fehler
- Local Logs: Site → Utilities → Logs
- Playwright Report: `npx playwright show-report`
- Cypress Screenshots: `cypress/screenshots/`

## 6. Dateipfade für Local

```
Local Site Root: 
C:\Users\[username]\Local Sites\verein-menschlichkeit-theme\

Theme Directory:
C:\Users\[username]\Local Sites\verein-menschlichkeit-theme\app\public\wp-content\themes\verein-menschlichkeit-theme\

Logs:
C:\Users\[username]\Local Sites\verein-menschlichkeit-theme\logs\
```

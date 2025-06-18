# Testing-Strategie für PHP-Webanwendungen
## 1 Code-Qualität & Stil
**Ziel :** sauberen, wartbaren Code sicherstellen und Fehlerquellen frühzeitig beseitigen.  
**Werkzeuge :** PHP_CodeSniffer, PHP-CS-Fixer, phpstan, Psalm
**Beispiel-Befehle:**  
```bash
composer require --dev squizlabs/php_codesniffer friendsofphp/php-cs-fixer phpstan/phpstan
vendor/bin/phpcs src/
vendor/bin/php-cs-fixer fix --dry-run
vendor/bin/phpstan analyse src/ --level=max
```

## 2 Funktionale Tests
Unit-Tests prüfen einzelne Klassen und Methoden isoliert. Integrationstests stellen das
Zusammenspiel mehrerer Komponenten sicher. End-to-End-Tests (E2E) simulieren komplette
Benutzerabläufe im Browser. PHPUnit dient für Unit- und Integrationstests, während Cypress
für automatisierte Browser-Tests eingesetzt wird.

## 3 Security-Tests
Sicherheitsprüfungen decken typische Schwachstellen wie Cross-Site-Scripting oder fehlende
Header auf. Ein Workflow mit der OWASP ZAP CLI scannt die laufende Anwendung und meldet
Gefahren. Zusätzlich sollten HTTP-Security-Header automatisiert kontrolliert werden.

## 4 Performance & Last
Werkzeuge wie `ab` oder `k6` messen die Belastbarkeit des Systems unter hoher
Benutzeranzahl. Für tiefergehendes Profiling eignen sich Xdebug oder Blackfire, womit sich
Flaschenhälse im Code gezielt finden lassen.

## 5 Accessibility
Um die Zugänglichkeit zu prüfen, kommen Lighthouse und pa11y-ci zum Einsatz. Beide Tools
analysieren die Seite hinsichtlich Kontrast, ARIA-Rollen und Tastaturbedienbarkeit und
liefern verwertbare Verbesserungsvorschläge.

## 6 CI/CD-Pipeline
Im CI-Workflow wird eine Matrix über PHP-Versionen 8.1 bis 8.3 definiert. Die Schritte
umfassen Checkout, Composer-Installationen, statische Analyse, Unit-Tests, Cypress-Tests und
abschließend Accessibility-Checks mit pa11y.

## 7 Metriken & Grenzwerte
| KPI                     | Grenzwert            |
|-------------------------|----------------------|
| Test Coverage           | ≥ 70 %               |
| Lighthouse Performance  | > 80                 |
| Kritische Sicherheitsfunde | 0                 |
| Maximale Testlaufzeit   | < 10 Minuten         |

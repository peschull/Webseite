# ==============================================================================
# BATCH-STARTER FÜR POWERSHELL SEO-DEBUGGING
# ==============================================================================

@echo off
setlocal enabledelayedexpansion

echo.
echo ========================================================================
echo                    SEO POWERSHELL DEBUGGING SUITE
echo                         Verein Menschlichkeit
echo ========================================================================
echo.

:: Prüfe PowerShell-Version
powershell -Command "if ($PSVersionTable.PSVersion.Major -lt 5) { exit 1 }" >nul 2>&1
if errorlevel 1 (
    echo [FEHLER] PowerShell 5.0+ wird benoetigt
    echo Bitte installieren Sie eine aktuelle PowerShell-Version
    pause
    exit /b 1
)

:: Hauptmenü
:MENU
cls
echo.
echo ========================================================================
echo                           HAUPTMENU
echo ========================================================================
echo.
echo 1. Schnelle SEO-Analyse durchfuehren
echo 2. Vollstaendige Analyse mit Bericht
echo 3. Auto-Fix aktivieren
echo 4. Server starten und testen
echo 5. Nur Cypress-Tests ausfuehren
echo 6. Nur Playwright-Tests ausfuehren
echo 7. Alle Tests und Fixes ausfuehren
echo 8. Entwickler-Modus (Debug)
echo 9. Hilfe anzeigen
echo 0. Beenden
echo.
set /p choice="Waehlen Sie eine Option (0-9): "

if "%choice%"=="1" goto QUICK_ANALYSIS
if "%choice%"=="2" goto FULL_REPORT
if "%choice%"=="3" goto AUTO_FIX
if "%choice%"=="4" goto SERVER_TEST
if "%choice%"=="5" goto CYPRESS_ONLY
if "%choice%"=="6" goto PLAYWRIGHT_ONLY
if "%choice%"=="7" goto COMPLETE_SUITE
if "%choice%"=="8" goto DEBUG_MODE
if "%choice%"=="9" goto HELP
if "%choice%"=="0" goto EXIT

echo Ungueltige Auswahl. Bitte versuchen Sie es erneut.
timeout /t 2 >nul
goto MENU

:QUICK_ANALYSIS
echo.
echo [INFO] Starte schnelle SEO-Analyse...
powershell -ExecutionPolicy Bypass -File "scripts\seo-powershell-debug.ps1"
pause
goto MENU

:FULL_REPORT
echo.
echo [INFO] Starte vollstaendige Analyse mit Berichtsgenerierung...
powershell -ExecutionPolicy Bypass -File "scripts\seo-powershell-debug.ps1" -GenerateReport
pause
goto MENU

:AUTO_FIX
echo.
echo [INFO] Starte Analyse mit automatischen Fixes...
powershell -ExecutionPolicy Bypass -File "scripts\seo-powershell-debug.ps1" -FixIssues -GenerateReport
pause
goto MENU

:SERVER_TEST
echo.
echo [INFO] Starte Server und fuehre Tests durch...
echo [INFO] Server wird automatisch gestartet falls nicht aktiv...
powershell -ExecutionPolicy Bypass -File "scripts\seo-powershell-debug.ps1" -BaseUrl "http://localhost:3000"
pause
goto MENU

:CYPRESS_ONLY
echo.
echo [INFO] Fuehre nur Cypress-Tests aus...
echo [INFO] Stelle sicher, dass der Server laeuft...
call npm run test:seo
pause
goto MENU

:PLAYWRIGHT_ONLY
echo.
echo [INFO] Fuehre nur Playwright-Tests aus...
echo [INFO] Stelle sicher, dass der Server laeuft...
call npm run test:seo:playwright
pause
goto MENU

:COMPLETE_SUITE
echo.
echo [INFO] Fuehre komplette Test-Suite aus...
echo [INFO] Dies kann einige Minuten dauern...
powershell -ExecutionPolicy Bypass -File "scripts\seo-powershell-debug.ps1" -FullScan -FixIssues -GenerateReport
pause
goto MENU

:DEBUG_MODE
echo.
echo [INFO] Starte Entwickler-Debug-Modus...
echo [INFO] Verbose-Output aktiviert...
powershell -ExecutionPolicy Bypass -File "scripts\seo-powershell-debug.ps1" -Verbose -FullScan -GenerateReport
pause
goto MENU

:HELP
cls
echo.
echo ========================================================================
echo                               HILFE
echo ========================================================================
echo.
echo OPTIONEN:
echo.
echo 1. Schnelle Analyse:
echo    - Grundlegende SEO-Checks
echo    - Meta-Tags, Strukturierte Daten
echo    - Performance-Grundcheck
echo.
echo 2. Vollstaendige Analyse:
echo    - Alle SEO-Checks
echo    - Detaillierter HTML/JSON-Bericht
echo    - Export in ./seo-analysis/
echo.
echo 3. Auto-Fix:
echo    - Automatische Problemloesung
echo    - Generiert Verbesserungsvorschlaege
echo    - Erstellt Backup vor Aenderungen
echo.
echo 4. Server-Test:
echo    - Startet dev-server.js automatisch
echo    - Prueft Serververbindung
echo    - Fuehrt Live-Tests durch
echo.
echo 5-6. Einzelne Test-Frameworks:
echo     - Cypress: End-to-End SEO-Tests
echo     - Playwright: Cross-Browser Tests
echo.
echo 7. Komplette Suite:
echo    - Alle Tests und Fixes
echo    - Vollstaendige Berichtsgenerierung
echo    - Produktions-ready Validation
echo.
echo SYSTEMANFORDERUNGEN:
echo - PowerShell 5.0+
echo - Node.js 16+
echo - npm packages installiert
echo.
echo AUSGABE-DATEIEN:
echo - ./seo-analysis/seo-analysis.json
echo - ./seo-analysis/seo-report.html
echo - ./cypress/screenshots/ (bei Fehlern)
echo - ./test-results/ (Playwright)
echo.
pause
goto MENU

:EXIT
echo.
echo ========================================================================
echo                         Auf Wiedersehen!
echo         Vielen Dank fuer die Nutzung der SEO-Debug-Suite
echo ========================================================================
echo.
timeout /t 2 >nul
exit /b 0

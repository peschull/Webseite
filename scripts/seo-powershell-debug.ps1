# ==============================================================================
# SEO-DEBUGGING UND VERBESSERUNGS-SKRIPT FÜR VEREIN MENSCHLICHKEIT
# PowerShell Core 7+ kompatibel
# ==============================================================================

param(
    [string]$BaseUrl = "http://localhost:3000",
    [switch]$FullScan,
    [switch]$GenerateReport,
    [switch]$FixIssues,
    [switch]$ValidateSchema,
    [string]$OutputPath = "./seo-analysis"
)

# Konfiguration
$ErrorActionPreference = "Continue"
$ProgressPreference = "SilentlyContinue"

# Farben für Output
$Colors = @{
    Success = "Green"
    Warning = "Yellow"
    Error = "Red"
    Info = "Cyan"
    Header = "Magenta"
}

# ==============================================================================
# HILFSFUNKTIONEN
# ==============================================================================

function Write-ColorOutput {
    param(
        [string]$Message,
        [string]$Color = "White",
        [switch]$NoNewline
    )
    
    if ($Colors.ContainsKey($Color)) {
        $ForegroundColor = $Colors[$Color]
    } else {
        $ForegroundColor = $Color
    }
    
    if ($NoNewline) {
        Write-Host $Message -ForegroundColor $ForegroundColor -NoNewline
    } else {
        Write-Host $Message -ForegroundColor $ForegroundColor
    }
}

function Test-ServerConnectivity {
    param([string]$Url)
    
    try {
        $response = Invoke-WebRequest -Uri $Url -Method Head -TimeoutSec 10 -ErrorAction Stop
        return $response.StatusCode -eq 200
    }
    catch {
        return $false
    }
}

function Get-HTMLContent {
    param([string]$Url)
    
    try {
        $response = Invoke-WebRequest -Uri $Url -TimeoutSec 30 -ErrorAction Stop
        return $response.Content
    }
    catch {
        Write-ColorOutput "❌ Fehler beim Abrufen von $Url`: $_" "Error"
        return $null
    }
}

function Test-MetaTags {
    param([string]$HtmlContent)
    
    $results = @{}
    
    # Title Tag
    if ($HtmlContent -match '<title[^>]*>([^<]+)</title>') {
        $title = $matches[1].Trim()
        $results.Title = @{
            Content = $title
            Length = $title.Length
            Valid = ($title.Length -ge 30 -and $title.Length -le 60)
        }
    } else {
        $results.Title = @{ Content = $null; Valid = $false }
    }
    
    # Meta Description
    if ($HtmlContent -match '<meta\s+name=["\']description["\']\s+content=["\']([^"\']+)["\']') {
        $description = $matches[1].Trim()
        $results.Description = @{
            Content = $description
            Length = $description.Length
            Valid = ($description.Length -ge 120 -and $description.Length -le 155)
        }
    } else {
        $results.Description = @{ Content = $null; Valid = $false }
    }
    
    # Open Graph Tags
    $ogTags = @{}
    $ogPattern = '<meta\s+property=["\']og:([^"\']+)["\']\s+content=["\']([^"\']+)["\']'
    $ogMatches = [regex]::Matches($HtmlContent, $ogPattern)
    foreach ($match in $ogMatches) {
        $ogTags[$match.Groups[1].Value] = $match.Groups[2].Value
    }
    $results.OpenGraph = $ogTags
    
    # Twitter Cards
    $twitterTags = @{}
    $twitterPattern = '<meta\s+name=["\']twitter:([^"\']+)["\']\s+content=["\']([^"\']+)["\']'
    $twitterMatches = [regex]::Matches($HtmlContent, $twitterPattern)
    foreach ($match in $twitterMatches) {
        $twitterTags[$match.Groups[1].Value] = $match.Groups[2].Value
    }
    $results.Twitter = $twitterTags
    
    return $results
}

function Test-StructuredData {
    param([string]$HtmlContent)
    
    $jsonLdPattern = '<script[^>]*type=["\']application/ld\+json["\'][^>]*>([^<]+)</script>'
    $matches = [regex]::Matches($HtmlContent, $jsonLdPattern, [System.Text.RegularExpressions.RegexOptions]::Singleline)
    
    $structuredData = @()
    foreach ($match in $matches) {
        try {
            $jsonContent = $match.Groups[1].Value.Trim()
            $parsed = $jsonContent | ConvertFrom-Json
            $structuredData += $parsed
        }
        catch {
            Write-ColorOutput "⚠️  Ungültiges JSON-LD gefunden: $_" "Warning"
        }
    }
    
    return $structuredData
}

function Test-ImageOptimization {
    param([string]$HtmlContent)
    
    $imgPattern = '<img[^>]+>'
    $images = [regex]::Matches($HtmlContent, $imgPattern)
    
    $imageResults = @()
    foreach ($img in $images) {
        $imgTag = $img.Value
        
        $result = @{
            Tag = $imgTag
            HasAlt = $imgTag -match 'alt=["\'][^"\']*["\']'
            HasWidthHeight = ($imgTag -match 'width=["\'][^"\']*["\']') -and ($imgTag -match 'height=["\'][^"\']*["\']')
            HasLoading = $imgTag -match 'loading=["\'][^"\']*["\']'
        }
        
        if ($imgTag -match 'src=["\']([^"\']+)["\']') {
            $result.Src = $matches[1]
        }
        
        if ($imgTag -match 'alt=["\']([^"\']*)["\']') {
            $result.Alt = $matches[1]
        }
        
        $imageResults += $result
    }
    
    return $imageResults
}

function Test-HeadingStructure {
    param([string]$HtmlContent)
    
    $headingPattern = '<h([1-6])[^>]*>([^<]+)</h[1-6]>'
    $headings = [regex]::Matches($HtmlContent, $headingPattern)
    
    $headingStructure = @()
    foreach ($heading in $headings) {
        $headingStructure += @{
            Level = [int]$heading.Groups[1].Value
            Text = $heading.Groups[2].Value.Trim()
        }
    }
    
    # Validiere Hierarchie
    $valid = $true
    $prevLevel = 0
    foreach ($h in $headingStructure) {
        if ($h.Level -gt $prevLevel + 1) {
            $valid = $false
            break
        }
        $prevLevel = $h.Level
    }
    
    return @{
        Headings = $headingStructure
        ValidHierarchy = $valid
        H1Count = ($headingStructure | Where-Object { $_.Level -eq 1 }).Count
    }
}

function Test-LinkQuality {
    param([string]$HtmlContent, [string]$BaseUrl)
    
    $linkPattern = '<a[^>]+href=["\']([^"\']+)["\'][^>]*>([^<]*)</a>'
    $links = [regex]::Matches($HtmlContent, $linkPattern)
    
    $linkResults = @()
    foreach ($link in $links) {
        $href = $link.Groups[1].Value
        $text = $link.Groups[2].Value.Trim()
        
        $result = @{
            Href = $href
            Text = $text
            IsExternal = $href -match '^https?://' -and -not $href.StartsWith($BaseUrl)
            HasTitle = $link.Value -match 'title=["\'][^"\']*["\']'
            HasRel = $link.Value -match 'rel=["\'][^"\']*["\']'
            TextLength = $text.Length
        }
        
        # Prüfe auf leere Linktexte
        if ([string]::IsNullOrWhiteSpace($text)) {
            $result.EmptyText = $true
        }
        
        # Prüfe auf generische Texte
        $genericTexts = @("hier", "mehr", "weiter", "link", "klicken")
        if ($genericTexts -contains $text.ToLower()) {
            $result.GenericText = $true
        }
        
        $linkResults += $result
    }
    
    return $linkResults
}

function Test-PerformanceMetrics {
    param([string]$BaseUrl)
    
    $stopwatch = [System.Diagnostics.Stopwatch]::StartNew()
    
    try {
        $response = Invoke-WebRequest -Uri $BaseUrl -TimeoutSec 30
        $stopwatch.Stop()
        
        $result = @{
            LoadTime = $stopwatch.ElapsedMilliseconds
            StatusCode = $response.StatusCode
            ContentLength = $response.Content.Length
            Headers = $response.Headers
        }
        
        # Prüfe wichtige Headers
        $result.HasGzip = $response.Headers.ContainsKey("Content-Encoding") -and $response.Headers["Content-Encoding"] -match "gzip"
        $result.HasCaching = $response.Headers.ContainsKey("Cache-Control")
        $result.HasSecurity = $response.Headers.ContainsKey("X-Content-Type-Options")
        
        return $result
    }
    catch {
        $stopwatch.Stop()
        return @{
            LoadTime = $stopwatch.ElapsedMilliseconds
            Error = $_.Exception.Message
        }
    }
}

function Start-NodeServer {
    Write-ColorOutput "🚀 Starte Node.js Server..." "Info"
    
    # Prüfe ob Server bereits läuft
    if (Test-ServerConnectivity $BaseUrl) {
        Write-ColorOutput "✅ Server läuft bereits auf $BaseUrl" "Success"
        return $true
    }
    
    # Starte Server
    try {
        $job = Start-Job -ScriptBlock {
            Set-Location $using:PWD
            node dev-server.js
        }
        
        # Warte auf Server-Start
        $timeout = 30
        $elapsed = 0
        while ($elapsed -lt $timeout) {
            Start-Sleep -Seconds 1
            $elapsed++
            
            if (Test-ServerConnectivity $BaseUrl) {
                Write-ColorOutput "✅ Server erfolgreich gestartet" "Success"
                return $true
            }
        }
        
        Write-ColorOutput "❌ Server-Start Timeout nach $timeout Sekunden" "Error"
        return $false
    }
    catch {
        Write-ColorOutput "❌ Fehler beim Server-Start: $_" "Error"
        return $false
    }
}

# ==============================================================================
# HAUPTFUNKTIONEN
# ==============================================================================

function Start-SEOAnalysis {
    param([string]$Url)
    
    Write-ColorOutput "`n🔍 SEO-ANALYSE GESTARTET" "Header"
    Write-ColorOutput "Target URL: $Url`n" "Info"
    
    # Server-Konnektivität prüfen
    if (-not (Test-ServerConnectivity $Url)) {
        Write-ColorOutput "❌ Server nicht erreichbar. Starte Server..." "Warning"
        if (-not (Start-NodeServer)) {
            throw "Server konnte nicht gestartet werden"
        }
    }
    
    # HTML-Content abrufen
    Write-ColorOutput "📄 Lade HTML-Content..." "Info"
    $htmlContent = Get-HTMLContent $Url
    if (-not $htmlContent) {
        throw "HTML-Content konnte nicht geladen werden"
    }
    
    $analysis = @{}
    
    # Meta-Tags testen
    Write-ColorOutput "🏷️  Analysiere Meta-Tags..." "Info"
    $analysis.MetaTags = Test-MetaTags $htmlContent
    
    # Strukturierte Daten testen
    Write-ColorOutput "📊 Prüfe strukturierte Daten..." "Info"
    $analysis.StructuredData = Test-StructuredData $htmlContent
    
    # Bilder-Optimierung
    Write-ColorOutput "🖼️  Analysiere Bilder..." "Info"
    $analysis.Images = Test-ImageOptimization $htmlContent
    
    # Überschriften-Struktur
    Write-ColorOutput "📝 Prüfe Überschriften-Hierarchie..." "Info"
    $analysis.Headings = Test-HeadingStructure $htmlContent
    
    # Link-Qualität
    Write-ColorOutput "🔗 Analysiere Links..." "Info"
    $analysis.Links = Test-LinkQuality $htmlContent $Url
    
    # Performance-Metriken
    Write-ColorOutput "⚡ Messe Performance..." "Info"
    $analysis.Performance = Test-PerformanceMetrics $Url
    
    return $analysis
}

function Show-SEOReport {
    param($Analysis)
    
    Write-ColorOutput "`n📊 SEO-ANALYSE BERICHT" "Header"
    Write-ColorOutput "=" * 60 "Header"
    
    # Meta-Tags Bericht
    Write-ColorOutput "`n🏷️  META-TAGS" "Info"
    $meta = $Analysis.MetaTags
    
    if ($meta.Title.Valid) {
        Write-ColorOutput "✅ Title-Tag: OK ($($meta.Title.Length) Zeichen)" "Success"
    } else {
        Write-ColorOutput "❌ Title-Tag: Problem ($($meta.Title.Length) Zeichen)" "Error"
    }
    Write-ColorOutput "   '$($meta.Title.Content)'" "White"
    
    if ($meta.Description.Valid) {
        Write-ColorOutput "✅ Meta-Description: OK ($($meta.Description.Length) Zeichen)" "Success"
    } else {
        Write-ColorOutput "❌ Meta-Description: Problem ($($meta.Description.Length) Zeichen)" "Error"
    }
    Write-ColorOutput "   '$($meta.Description.Content)'" "White"
    
    # Open Graph
    Write-ColorOutput "`n📱 OPEN GRAPH" "Info"
    $requiredOGTags = @("title", "description", "type", "url", "image")
    foreach ($tag in $requiredOGTags) {
        if ($meta.OpenGraph.ContainsKey($tag)) {
            Write-ColorOutput "✅ og:$tag vorhanden" "Success"
        } else {
            Write-ColorOutput "❌ og:$tag fehlt" "Error"
        }
    }
    
    # Twitter Cards
    Write-ColorOutput "`n🐦 TWITTER CARDS" "Info"
    $requiredTwitterTags = @("card", "title", "description")
    foreach ($tag in $requiredTwitterTags) {
        if ($meta.Twitter.ContainsKey($tag)) {
            Write-ColorOutput "✅ twitter:$tag vorhanden" "Success"
        } else {
            Write-ColorOutput "❌ twitter:$tag fehlt" "Error"
        }
    }
    
    # Strukturierte Daten
    Write-ColorOutput "`n📊 STRUKTURIERTE DATEN" "Info"
    if ($Analysis.StructuredData.Count -gt 0) {
        Write-ColorOutput "✅ $($Analysis.StructuredData.Count) JSON-LD Schemas gefunden" "Success"
        foreach ($schema in $Analysis.StructuredData) {
            Write-ColorOutput "   - Schema: $($schema.'@type')" "White"
        }
    } else {
        Write-ColorOutput "❌ Keine strukturierten Daten gefunden" "Error"
    }
    
    # Überschriften
    Write-ColorOutput "`n📝 ÜBERSCHRIFTEN-STRUKTUR" "Info"
    $headings = $Analysis.Headings
    if ($headings.ValidHierarchy) {
        Write-ColorOutput "✅ Überschriften-Hierarchie: OK" "Success"
    } else {
        Write-ColorOutput "❌ Überschriften-Hierarchie: Probleme" "Error"
    }
    
    if ($headings.H1Count -eq 1) {
        Write-ColorOutput "✅ Genau eine H1 vorhanden" "Success"
    } else {
        Write-ColorOutput "❌ H1-Problem: $($headings.H1Count) H1-Tags gefunden" "Error"
    }
    
    # Bilder
    Write-ColorOutput "`n🖼️  BILDER-OPTIMIERUNG" "Info"
    $images = $Analysis.Images
    $totalImages = $images.Count
    $imagesWithAlt = ($images | Where-Object { $_.HasAlt }).Count
    $imagesWithDimensions = ($images | Where-Object { $_.HasWidthHeight }).Count
    
    Write-ColorOutput "📊 Gesamt: $totalImages Bilder" "White"
    Write-ColorOutput "🏷️  Alt-Attribute: $imagesWithAlt/$totalImages" $(if ($imagesWithAlt -eq $totalImages) { "Success" } else { "Warning" })
    Write-ColorOutput "📐 Dimensionen: $imagesWithDimensions/$totalImages" $(if ($imagesWithDimensions -eq $totalImages) { "Success" } else { "Warning" })
    
    # Links
    Write-ColorOutput "`n🔗 LINK-QUALITÄT" "Info"
    $links = $Analysis.Links
    $totalLinks = $links.Count
    $emptyTextLinks = ($links | Where-Object { $_.EmptyText }).Count
    $genericTextLinks = ($links | Where-Object { $_.GenericText }).Count
    $externalLinks = ($links | Where-Object { $_.IsExternal }).Count
    
    Write-ColorOutput "📊 Gesamt: $totalLinks Links" "White"
    Write-ColorOutput "🌐 Externe Links: $externalLinks" "White"
    if ($emptyTextLinks -gt 0) {
        Write-ColorOutput "❌ Leere Linktexte: $emptyTextLinks" "Error"
    } else {
        Write-ColorOutput "✅ Keine leeren Linktexte" "Success"
    }
    if ($genericTextLinks -gt 0) {
        Write-ColorOutput "⚠️  Generische Linktexte: $genericTextLinks" "Warning"
    } else {
        Write-ColorOutput "✅ Keine generischen Linktexte" "Success"
    }
    
    # Performance
    Write-ColorOutput "`n⚡ PERFORMANCE" "Info"
    $perf = $Analysis.Performance
    if ($perf.Error) {
        Write-ColorOutput "❌ Performance-Test fehlgeschlagen: $($perf.Error)" "Error"
    } else {
        $loadTime = $perf.LoadTime
        if ($loadTime -lt 1000) {
            Write-ColorOutput "✅ Ladezeit: ${loadTime}ms (Sehr gut)" "Success"
        } elseif ($loadTime -lt 3000) {
            Write-ColorOutput "⚠️  Ladezeit: ${loadTime}ms (Akzeptabel)" "Warning"
        } else {
            Write-ColorOutput "❌ Ladezeit: ${loadTime}ms (Zu langsam)" "Error"
        }
        
        Write-ColorOutput "📦 Content-Größe: $([Math]::Round($perf.ContentLength / 1024, 2)) KB" "White"
        Write-ColorOutput "🗜️  Gzip: $(if ($perf.HasGzip) { 'Aktiviert' } else { 'Nicht aktiviert' })" $(if ($perf.HasGzip) { "Success" } else { "Warning" })
    }
}

function Export-SEOReport {
    param($Analysis, $OutputPath)
    
    Write-ColorOutput "`n💾 Exportiere Bericht nach $OutputPath..." "Info"
    
    # Erstelle Output-Verzeichnis
    if (-not (Test-Path $OutputPath)) {
        New-Item -ItemType Directory -Path $OutputPath -Force | Out-Null
    }
    
    # JSON-Export
    $jsonPath = Join-Path $OutputPath "seo-analysis.json"
    $Analysis | ConvertTo-Json -Depth 10 | Out-File -FilePath $jsonPath -Encoding UTF8
    
    # HTML-Report erstellen
    $htmlPath = Join-Path $OutputPath "seo-report.html"
    $htmlReport = @"
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO-Analyse Bericht - Verein Menschlichkeit</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { color: #2c5aa0; border-bottom: 2px solid #2c5aa0; padding-bottom: 10px; }
        .success { color: #28a745; }
        .warning { color: #ffc107; }
        .error { color: #dc3545; }
        .section { margin: 20px 0; padding: 15px; border-left: 4px solid #2c5aa0; background-color: #f8f9fa; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #2c5aa0; color: white; }
        pre { background-color: #f4f4f4; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1 class="header">SEO-Analyse Bericht</h1>
    <p>Generiert am: $(Get-Date -Format "dd.MM.yyyy HH:mm:ss")</p>
    
    <div class="section">
        <h2>Meta-Tags Analyse</h2>
        <table>
            <tr><th>Element</th><th>Status</th><th>Wert</th></tr>
            <tr><td>Title</td><td class="$(if($Analysis.MetaTags.Title.Valid){'success'}else{'error'})">$(if($Analysis.MetaTags.Title.Valid){'✅ OK'}else{'❌ Problem'})</td><td>$($Analysis.MetaTags.Title.Content) ($($Analysis.MetaTags.Title.Length) Zeichen)</td></tr>
            <tr><td>Description</td><td class="$(if($Analysis.MetaTags.Description.Valid){'success'}else{'error'})">$(if($Analysis.MetaTags.Description.Valid){'✅ OK'}else{'❌ Problem'})</td><td>$($Analysis.MetaTags.Description.Content) ($($Analysis.MetaTags.Description.Length) Zeichen)</td></tr>
        </table>
    </div>
    
    <div class="section">
        <h2>Strukturierte Daten</h2>
        <p>Gefundene Schemas: $($Analysis.StructuredData.Count)</p>
        <ul>
$(foreach($schema in $Analysis.StructuredData) { "            <li>$($schema.'@type')</li>" })
        </ul>
    </div>
    
    <div class="section">
        <h2>Performance Metriken</h2>
        <ul>
            <li>Ladezeit: $($Analysis.Performance.LoadTime)ms</li>
            <li>Content-Größe: $([Math]::Round($Analysis.Performance.ContentLength / 1024, 2)) KB</li>
            <li>Status Code: $($Analysis.Performance.StatusCode)</li>
        </ul>
    </div>
    
    <div class="section">
        <h2>Empfehlungen</h2>
        <ul>
$(if(-not $Analysis.MetaTags.Title.Valid) { "            <li class='error'>Title-Tag optimieren (30-60 Zeichen)</li>" })
$(if(-not $Analysis.MetaTags.Description.Valid) { "            <li class='error'>Meta-Description optimieren (120-155 Zeichen)</li>" })
$(if($Analysis.StructuredData.Count -eq 0) { "            <li class='error'>Strukturierte Daten implementieren</li>" })
$(if($Analysis.Performance.LoadTime -gt 3000) { "            <li class='warning'>Ladezeit verbessern (aktuell: $($Analysis.Performance.LoadTime)ms)</li>" })
        </ul>
    </div>
</body>
</html>
"@
    
    $htmlReport | Out-File -FilePath $htmlPath -Encoding UTF8
    
    Write-ColorOutput "✅ Berichte exportiert:" "Success"
    Write-ColorOutput "   JSON: $jsonPath" "White"
    Write-ColorOutput "   HTML: $htmlPath" "White"
}

function Invoke-AutoFix {
    param($Analysis)
    
    Write-ColorOutput "`n🔧 AUTO-FIX GESTARTET" "Header"
    
    $fixes = @()
    
    # Title-Tag Fix
    if (-not $Analysis.MetaTags.Title.Valid) {
        $currentTitle = $Analysis.MetaTags.Title.Content
        if ($currentTitle.Length -gt 60) {
            $newTitle = $currentTitle.Substring(0, 57) + "..."
            $fixes += "Title-Tag gekürzt: '$newTitle'"
        }
    }
    
    # Meta-Description Fix
    if (-not $Analysis.MetaTags.Description.Valid) {
        $currentDesc = $Analysis.MetaTags.Description.Content
        if ($currentDesc.Length -gt 155) {
            $newDesc = $currentDesc.Substring(0, 152) + "..."
            $fixes += "Meta-Description gekürzt: '$newDesc'"
        }
    }
    
    # Bilder ohne Alt-Attribute
    $imagesWithoutAlt = $Analysis.Images | Where-Object { -not $_.HasAlt }
    if ($imagesWithoutAlt.Count -gt 0) {
        $fixes += "$($imagesWithoutAlt.Count) Bilder benötigen Alt-Attribute"
    }
    
    if ($fixes.Count -gt 0) {
        Write-ColorOutput "🔧 Gefundene Verbesserungen:" "Info"
        foreach ($fix in $fixes) {
            Write-ColorOutput "   - $fix" "Warning"
        }
    } else {
        Write-ColorOutput "✅ Keine automatischen Fixes erforderlich" "Success"
    }
}

function Start-CypressTests {
    Write-ColorOutput "`n🧪 STARTE CYPRESS-TESTS" "Header"
    
    try {
        # Prüfe ob Cypress installiert ist
        $cypressExists = Test-Path "node_modules\.bin\cypress.cmd"
        if (-not $cypressExists) {
            Write-ColorOutput "❌ Cypress nicht gefunden. Installiere mit: npm install cypress" "Error"
            return
        }
        
        # Führe Tests aus
        Write-ColorOutput "🏃 Führe SEO-Tests aus..." "Info"
        $result = & "node_modules\.bin\cypress.cmd" run --spec "cypress/e2e/seo-simplified.cy.js" --headless
        
        if ($LASTEXITCODE -eq 0) {
            Write-ColorOutput "✅ Alle Cypress-Tests bestanden" "Success"
        } else {
            Write-ColorOutput "⚠️  Einige Cypress-Tests fehlgeschlagen" "Warning"
        }
    }
    catch {
        Write-ColorOutput "❌ Fehler bei Cypress-Tests: $_" "Error"
    }
}

function Start-PlaywrightTests {
    Write-ColorOutput "`n🎭 STARTE PLAYWRIGHT-TESTS" "Header"
    
    try {
        # Führe Playwright-Tests aus
        Write-ColorOutput "🏃 Führe Playwright SEO-Tests aus..." "Info"
        $result = & "npx" playwright test tests/seo/playwright-seo.spec.ts --reporter=line
        
        if ($LASTEXITCODE -eq 0) {
            Write-ColorOutput "✅ Alle Playwright-Tests bestanden" "Success"
        } else {
            Write-ColorOutput "⚠️  Einige Playwright-Tests fehlgeschlagen" "Warning"
        }
    }
    catch {
        Write-ColorOutput "❌ Fehler bei Playwright-Tests: $_" "Error"
    }
}

# ==============================================================================
# HAUPTSKRIPT
# ==============================================================================

try {
    Write-ColorOutput @"

██████╗  ██████╗ ██╗    ██╗███████╗██████╗ ███████╗██╗  ██╗███████╗██╗     ██╗     
██╔══██╗██╔═══██╗██║    ██║██╔════╝██╔══██╗██╔════╝██║  ██║██╔════╝██║     ██║     
██████╔╝██║   ██║██║ █╗ ██║█████╗  ██████╔╝███████╗███████║█████╗  ██║     ██║     
██╔═══╝ ██║   ██║██║███╗██║██╔══╝  ██╔══██╗╚════██║██╔══██║██╔══╝  ██║     ██║     
██║     ╚██████╔╝╚███╔███╔╝███████╗██║  ██║███████║██║  ██║███████╗███████╗███████╗
╚═╝      ╚═════╝  ╚══╝╚══╝ ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝╚══════╝╚══════╝╚══════╝

SEO-DEBUGGING & VERBESSERUNGS-SUITE
Verein Menschlichkeit | Version 1.0
"@ "Header"

    # Führe Analyse durch
    $analysis = Start-SEOAnalysis $BaseUrl
    
    # Zeige Bericht
    Show-SEOReport $analysis
    
    # Auto-Fix falls gewünscht
    if ($FixIssues) {
        Invoke-AutoFix $analysis
    }
    
    # Exportiere Bericht falls gewünscht
    if ($GenerateReport) {
        Export-SEOReport $analysis $OutputPath
    }
    
    # Vollständiger Scan mit Tests
    if ($FullScan) {
        Start-CypressTests
        Start-PlaywrightTests
    }
    
    Write-ColorOutput "`n🎉 SEO-ANALYSE ABGESCHLOSSEN" "Header"
    Write-ColorOutput "Vielen Dank für die Nutzung der PowerShell SEO-Suite!" "Success"
    
} catch {
    Write-ColorOutput "`n❌ KRITISCHER FEHLER" "Error"
    Write-ColorOutput $_.Exception.Message "Error"
    Write-ColorOutput $_.ScriptStackTrace "Error"
    exit 1
}

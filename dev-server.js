import express from 'express';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';
import { existsSync, readFileSync, readdirSync, statSync } from 'fs';
import cors from 'cors';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const app = express();
const PORT = process.env.PORT || 3000;
const NODE_ENV = process.env.NODE_ENV || 'development';

// Enhanced Logging
const logger = {
    info: (msg) => console.log(`[${new Date().toISOString()}] INFO: ${msg}`),
    error: (msg) => console.error(`[${new Date().toISOString()}] ERROR: ${msg}`),
    warn: (msg) => console.warn(`[${new Date().toISOString()}] WARN: ${msg}`)
};

// Security & Performance Middleware (simplified for development)
app.use(cors({
    origin: ['http://localhost:3000', 'http://127.0.0.1:3000'],
    credentials: true
}));

// Enhanced Request Logging
app.use((req, res, next) => {
    logger.info(`${req.method} ${req.path} - ${req.ip}`);
    next();
});

// Body Parser
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true, limit: '10mb' }));

// Theme path verification
const themePath = join(__dirname, 'Webseite/verein-menschlichkeit-theme');
const indexPath = join(themePath, 'index.html');

logger.info(`Theme Path: ${themePath}`);
logger.info(`Index Path: ${indexPath}`);
logger.info(`Index exists: ${existsSync(indexPath)}`);

// Static file serving with proper headers
app.use(express.static(themePath, {
    maxAge: NODE_ENV === 'production' ? '1d' : 0,
    etag: true,
    lastModified: true,
    setHeaders: (res, path) => {
        if (path.endsWith('.html')) {
            res.setHeader('Content-Type', 'text/html; charset=utf-8');
        } else if (path.endsWith('.css')) {
            res.setHeader('Content-Type', 'text/css; charset=utf-8');
        } else if (path.endsWith('.js')) {
            res.setHeader('Content-Type', 'application/javascript; charset=utf-8');
        }
    }
}));

// Legacy static paths
app.use('/Webseite', express.static(join(__dirname, 'Webseite')));
app.use(express.static(join(__dirname, 'dev-server')));

// Enhanced Routes with proper error handling
app.get('/', (req, res) => {
    try {
        if (!existsSync(indexPath)) {
            logger.error(`Index file not found: ${indexPath}`);
            return res.status(404).send(`
                <h1>Index file not found</h1>
                <p>Expected path: ${indexPath}</p>
                <p>Theme directory exists: ${existsSync(themePath)}</p>
            `);
        }
        
        const content = readFileSync(indexPath, 'utf-8');
        logger.info(`Serving index.html (${content.length} bytes)`);
        
        res.setHeader('Content-Type', 'text/html; charset=utf-8');
        res.setHeader('Cache-Control', 'no-cache');
        res.send(content);
    } catch (error) {
        logger.error(`Error serving index: ${error.message}`);
        res.status(500).send(`<h1>Server Error</h1><p>${error.message}</p>`);
    }
});

app.get('/accessibility-test', (req, res) => {
    try {
        const accessibilityPath = join(themePath, 'accessibility-test.html');
        if (existsSync(accessibilityPath)) {
            const content = readFileSync(accessibilityPath, 'utf-8');
            res.setHeader('Content-Type', 'text/html; charset=utf-8');
            res.send(content);
        } else {
            res.send(generateAccessibilityTestPage());
        }
    } catch (error) {
        logger.error(`Error serving accessibility test: ${error.message}`);
        res.status(500).json({ error: error.message });
    }
});

// Enhanced Health Check
app.get('/health', (req, res) => {
    const healthData = {
        status: 'OK',
        timestamp: new Date().toISOString(),
        service: 'Verein Menschlichkeit Dev Server',
        environment: NODE_ENV,
        uptime: process.uptime(),
        memory: process.memoryUsage(),
        theme: {
            path: themePath,
            indexExists: existsSync(indexPath),
            files: existsSync(themePath) ? require('fs').readdirSync(themePath).length : 0
        }
    };
    res.json(healthData);
});

// Enhanced API endpoint
app.get('/api/test', (req, res) => {
    res.json({ 
        message: 'Test API funktioniert perfekt!',
        data: {
            timestamp: new Date().toISOString(),
            environment: NODE_ENV,
            version: '2.0.0',
            features: ['mobile-optimized', 'seo-ready', 'accessible', 'performance-tuned']
        }
    });
});

// Development tools
app.get('/debug/theme', (req, res) => {
    if (NODE_ENV !== 'development') {
        return res.status(403).json({ error: 'Debug endpoint only available in development' });
    }
    
    try {
        const themeFiles = readdirSync(themePath, { withFileTypes: true });
        const fileInfo = themeFiles.map(file => ({
            name: file.name,
            isDirectory: file.isDirectory(),
            size: file.isFile() ? statSync(join(themePath, file.name)).size : null
        }));
        
        res.json({
            themePath,
            indexPath,
            indexExists: existsSync(indexPath),
            files: fileInfo
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

function generateAccessibilityTestPage() {
    return `
        <!DOCTYPE html>
        <html lang="de">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Accessibility Test Seite - Verein Menschlichkeit</title>
            <style>
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    margin: 40px; 
                    line-height: 1.6;
                    color: #333;
                }
                .container { max-width: 1200px; margin: 0 auto; }
                .test-section { 
                    margin: 30px 0; 
                    padding: 30px; 
                    border: 2px solid #e2e8f0; 
                    border-radius: 12px;
                    background: #f8fafc;
                }
                .btn { 
                    padding: 14px 28px; 
                    background: #2563eb; 
                    color: white; 
                    border: none; 
                    cursor: pointer;
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: 600;
                    min-height: 48px;
                    min-width: 48px;
                }
                .btn:focus { 
                    outline: 3px solid #f59e0b; 
                    outline-offset: 2px;
                }
                .btn:hover {
                    background: #1d4ed8;
                    transform: translateY(-1px);
                }
                .form-group {
                    margin-bottom: 20px;
                }
                .form-group label {
                    display: block;
                    margin-bottom: 8px;
                    font-weight: 600;
                    color: #374151;
                }
                .form-group input, .form-group textarea {
                    width: 100%;
                    padding: 14px 18px;
                    border: 2px solid #d1d5db;
                    border-radius: 8px;
                    font-size: 16px;
                    min-height: 48px;
                }
                .form-group input:focus, .form-group textarea:focus {
                    border-color: #2563eb;
                    outline: none;
                    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
                }
                .error { color: #dc2626; font-weight: 600; }
                .success { color: #059669; font-weight: 600; }
                .skip-link {
                    position: absolute;
                    left: -9999px;
                    z-index: 999;
                    padding: 8px;
                    background: #000;
                    color: #fff;
                    text-decoration: none;
                }
                .skip-link:focus {
                    left: 6px;
                    top: 7px;
                }
                nav ul {
                    list-style: none;
                    padding: 0;
                    display: flex;
                    gap: 20px;
                    flex-wrap: wrap;
                }
                nav a {
                    color: #2563eb;
                    text-decoration: none;
                    padding: 8px 16px;
                    border-radius: 6px;
                    min-height: 48px;
                    display: flex;
                    align-items: center;
                }
                nav a:hover, nav a:focus {
                    background: #eff6ff;
                    outline: 2px solid #2563eb;
                }
                @media (max-width: 768px) {
                    body { margin: 20px; }
                    .container { padding: 0; }
                    nav ul { flex-direction: column; gap: 10px; }
                }
            </style>
        </head>
        <body>
            <a href="#main" class="skip-link">Zum Hauptinhalt springen</a>
            
            <div class="container">
                <header>
                    <h1>Accessibility Test Seite</h1>
                    <p>Umfassende Tests für Barrierefreiheit und Benutzerfreundlichkeit</p>
                    <nav aria-label="Hauptnavigation">
                        <ul>
                            <li><a href="#forms">Formulare</a></li>
                            <li><a href="#interactive">Interaktive Elemente</a></li>
                            <li><a href="#media">Medien</a></li>
                            <li><a href="#navigation">Navigation</a></li>
                        </ul>
                    </nav>
                </header>
                
                <main id="main">
                    <section id="forms" class="test-section">
                        <h2>Formular-Tests</h2>
                        <form>
                            <div class="form-group">
                                <label for="name">Name (Pflichtfeld):</label>
                                <input type="text" id="name" name="name" required aria-required="true">
                            </div>
                            
                            <div class="form-group">
                                <label for="email">E-Mail (Pflichtfeld):</label>
                                <input type="email" id="email" name="email" required aria-required="true">
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Nachricht:</label>
                                <textarea id="message" name="message" rows="4"></textarea>
                            </div>
                            
                            <button type="submit" class="btn">Formular absenden</button>
                        </form>
                    </section>
                    
                    <section id="interactive" class="test-section">
                        <h2>Interaktive Elemente</h2>
                        <button class="btn" onclick="alert('Button erfolgreich aktiviert!')">Test Button</button>
                        <button class="btn" style="margin-left: 20px;" onclick="document.getElementById('result').textContent = 'Aktion ausgeführt!'">Resultat anzeigen</button>
                        <p id="result" aria-live="polite"></p>
                    </section>
                    
                    <section id="media" class="test-section">
                        <h2>Medien-Tests</h2>
                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMzAwIiBoZWlnaHQ9IjIwMCIgZmlsbD0iIzI1NjNlYiIvPjx0ZXh0IHg9IjE1MCIgeT0iMTA1IiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZm9udC1zaXplPSIxOCIgZm9udC1mYW1pbHk9InNhbnMtc2VyaWYiPlRlc3QgQmlsZDwvdGV4dD48L3N2Zz4=" 
                             alt="Test Bild mit blauem Hintergrund und weißem Text" 
                             style="max-width: 100%; height: auto; border-radius: 8px;">
                    </section>
                    
                    <section id="navigation" class="test-section">
                        <h2>Navigation und Links</h2>
                        <p>
                            <a href="#top">Zurück zum Anfang</a> | 
                            <a href="/" target="_self">Startseite</a> | 
                            <a href="/health" target="_blank" rel="noopener">Health Check (neues Fenster)</a>
                        </p>
                    </section>
                </main>
                
                <footer>
                    <p>&copy; 2025 Verein Menschlichkeit - Accessibility Test</p>
                </footer>
            </div>
            
            <script>
                // Enhanced form handling
                document.querySelector('form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const result = document.getElementById('result');
                    result.textContent = 'Formular erfolgreich gesendet! (Demo-Modus)';
                    result.style.color = '#059669';
                    result.style.fontWeight = '600';
                });
                
                // Focus management
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        document.activeElement.blur();
                    }
                });
            </script>
        </body>
        </html>
    `;
}

// Enhanced Error handling
app.use((err, req, res, next) => {
    logger.error(`Server Error: ${err.stack}`);
    res.status(500).json({ 
        error: NODE_ENV === 'production' ? 'Internal Server Error' : err.message,
        timestamp: new Date().toISOString()
    });
});

// Enhanced 404 handler
app.use((req, res) => {
    logger.warn(`404 Not Found: ${req.method} ${req.path}`);
    res.status(404).json({ 
        error: 'Seite nicht gefunden',
        path: req.path,
        method: req.method,
        timestamp: new Date().toISOString()
    });
});

// Graceful shutdown
process.on('SIGTERM', () => {
    logger.info('SIGTERM received, shutting down gracefully');
    process.exit(0);
});

process.on('SIGINT', () => {
    logger.info('SIGINT received, shutting down gracefully');
    process.exit(0);
});

// Start server with enhanced logging
app.listen(PORT, '0.0.0.0', () => {
    logger.info(`🚀 Dev Server läuft auf http://localhost:${PORT}`);
    logger.info(`📊 Health Check: http://localhost:${PORT}/health`);
    logger.info(`♿ Accessibility Test: http://localhost:${PORT}/accessibility-test`);
    logger.info(`🔧 API Test: http://localhost:${PORT}/api/test`);
    logger.info(`🐛 Debug Info: http://localhost:${PORT}/debug/theme`);
    logger.info(`📁 Theme Path: ${themePath}`);
    logger.info(`📄 Index File: ${existsSync(indexPath) ? '✅ Found' : '❌ Missing'}`);
    logger.info(`🌍 Environment: ${NODE_ENV}`);
});

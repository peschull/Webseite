#!/usr/bin/env node

/**
 * Mobile SEO Test Suite
 * Testet die mobile Optimierung der Website
 */

import puppeteer from 'puppeteer';

async function testMobileSEO() {
    console.log('🔍 Mobile SEO Test wird gestartet...\n');
    
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });
    
    const page = await browser.newPage();
    
    // Mobile Device emulieren
    await page.emulate({
        name: 'iPhone 12',
        userAgent: 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.0 Mobile/15E148 Safari/604.1',
        viewport: {
            width: 390,
            height: 844,
            deviceScaleFactor: 3,
            isMobile: true,
            hasTouch: true,
            isLandscape: false
        }
    });
    
    try {
        await page.goto('http://localhost:3000', { waitUntil: 'networkidle0', timeout: 10000 });
        
        console.log('✅ Seite erfolgreich geladen\n');
        
        // 1. Viewport Meta Tag Test
        const viewportMeta = await page.$('meta[name="viewport"]');
        const viewportContent = await page.evaluate(el => el?.getAttribute('content'), viewportMeta);
        console.log(`📱 Viewport Meta Tag: ${viewportContent ? '✅' : '❌'}`);
        if (viewportContent) {
            console.log(`   Content: ${viewportContent}`);
        }
        
        // 2. Mobile-friendly Meta Tags
        const mobileMeta = await page.$('meta[name="mobile-web-app-capable"]');
        console.log(`📱 Mobile Web App Meta: ${mobileMeta ? '✅' : '❌'}`);
        
        const appleMeta = await page.$('meta[name="apple-mobile-web-app-capable"]');
        console.log(`🍎 Apple Mobile Web App Meta: ${appleMeta ? '✅' : '❌'}`);
        
        // 3. Touch-Target Größen prüfen
        console.log('\n🎯 Touch-Target Tests:');
        const touchTargets = await page.$$('a, button, input[type="submit"], input[type="button"], [role="button"]');
        let validTouchTargets = 0;
        
        for (const target of touchTargets) {
            const box = await target.boundingBox();
            if (box && box.width >= 44 && box.height >= 44) {
                validTouchTargets++;
            }
        }
        
        console.log(`   Gesamte Touch-Targets: ${touchTargets.length}`);
        console.log(`   Valide Touch-Targets (≥44px): ${validTouchTargets}`);
        console.log(`   Touch-Target Compliance: ${validTouchTargets >= Math.floor(touchTargets.length * 0.9) ? '✅' : '⚠️'}`);
        
        // Debug: Bei weniger als 90% Compliance Details ausgeben
        if (validTouchTargets < Math.floor(touchTargets.length * 0.9)) {
            console.log(`   ℹ️  Empfehlung: Mindestens ${Math.floor(touchTargets.length * 0.9)} Touch-Targets sollten ≥44px sein`);
        }
        
        // 4. Text-Lesbarkeit (Schriftgröße)
        console.log('\n📖 Text-Lesbarkeit Tests:');
        const textElements = await page.$$('p, span, a, button, h1, h2, h3, h4, h5, h6');
        let readableTextCount = 0;
        
        for (const element of textElements) {
            const fontSize = await page.evaluate(el => {
                const styles = window.getComputedStyle(el);
                return parseFloat(styles.fontSize);
            }, element);
            
            if (fontSize >= 16) {
                readableTextCount++;
            }
        }
        
        console.log(`   Gesamte Text-Elemente: ${textElements.length}`);
        console.log(`   Lesbare Text-Elemente (≥16px): ${readableTextCount}`);
        console.log(`   Text-Lesbarkeit: ${readableTextCount / textElements.length > 0.8 ? '✅' : '⚠️'}`);
        
        // 5. Mobile Navigation Test
        console.log('\n🧭 Navigation Tests:');
        const mobileMenuToggle = await page.$('.mobile-nav-toggle, .mobile-menu-toggle');
        console.log(`   Mobile Menu Toggle: ${mobileMenuToggle ? '✅' : '❌'}`);
        
        if (mobileMenuToggle) {
            const isVisible = await page.evaluate(el => {
                const styles = window.getComputedStyle(el);
                return styles.display !== 'none' && styles.visibility !== 'hidden';
            }, mobileMenuToggle);
            console.log(`   Mobile Menu Toggle sichtbar: ${isVisible ? '✅' : '❌'}`);
        }
        
        // 6. Responsive Images Test
        console.log('\n🖼️  Responsive Images Tests:');
        const images = await page.$$('img');
        let responsiveImages = 0;
        
        for (const img of images) {
            const maxWidth = await page.evaluate(el => {
                const styles = window.getComputedStyle(el);
                return styles.maxWidth;
            }, img);
            
            if (maxWidth === '100%') {
                responsiveImages++;
            }
        }
        
        console.log(`   Gesamte Bilder: ${images.length}`);
        console.log(`   Responsive Bilder: ${responsiveImages}`);
        console.log(`   Image Responsiveness: ${responsiveImages === images.length ? '✅' : '⚠️'}`);
        
        // 7. Content Overflow Test
        console.log('\n📏 Content Overflow Tests:');
        const bodyOverflow = await page.evaluate(() => {
            const body = document.body;
            return body.scrollWidth > window.innerWidth;
        });
        
        console.log(`   Horizontaler Overflow: ${bodyOverflow ? '❌' : '✅'}`);
        
        // 8. Loading Performance
        console.log('\n⚡ Performance Tests:');
        const timing = await page.evaluate(() => {
            const perfData = performance.timing;
            return {
                loadTime: perfData.loadEventEnd - perfData.navigationStart,
                domReady: perfData.domContentLoadedEventEnd - perfData.navigationStart
            };
        });
        
        console.log(`   Ladezeit: ${timing.loadTime}ms ${timing.loadTime < 3000 ? '✅' : '⚠️'}`);
        console.log(`   DOM Ready: ${timing.domReady}ms ${timing.domReady < 1500 ? '✅' : '⚠️'}`);
        
        // 9. SEO Meta Tags für Mobile
        console.log('\n📋 Mobile SEO Meta Tags:');
        const title = await page.title();
        console.log(`   Title: ${title ? '✅' : '❌'} (${title?.length || 0} Zeichen)`);
        
        const description = await page.$eval('meta[name="description"]', el => el.getAttribute('content')).catch(() => null);
        console.log(`   Description: ${description ? '✅' : '❌'} (${description?.length || 0} Zeichen)`);
        
        // 10. Structured Data Test
        console.log('\n🏗️  Structured Data Tests:');
        const structuredData = await page.$$('script[type="application/ld+json"]');
        console.log(`   JSON-LD Scripts: ${structuredData.length} ${structuredData.length > 0 ? '✅' : '❌'}`);
        
        // 11. Form Usability auf Mobile
        console.log('\n📝 Form Usability Tests:');
        const inputs = await page.$$('input, textarea, select');
        let mobileOptimizedInputs = 0;
        
        for (const input of inputs) {
            const styles = await page.evaluate(el => {
                const computedStyles = window.getComputedStyle(el);
                return {
                    fontSize: parseFloat(computedStyles.fontSize),
                    height: parseFloat(computedStyles.height),
                    padding: computedStyles.padding
                };
            }, input);
            
            if (styles.fontSize >= 16 && styles.height >= 44) {
                mobileOptimizedInputs++;
            }
        }
        
        console.log(`   Gesamte Form-Inputs: ${inputs.length}`);
        console.log(`   Mobile-optimierte Inputs: ${mobileOptimizedInputs}`);
        console.log(`   Form Mobile Optimization: ${mobileOptimizedInputs >= Math.floor(inputs.length * 0.9) ? '✅' : '⚠️'}`);
        
        // Abschlussbewertung
        console.log('\n📊 Mobile SEO Gesamtbewertung:');
        const checks = [
            viewportContent !== null,
            mobileMeta !== null,
            validTouchTargets >= Math.floor(touchTargets.length * 0.9),
            readableTextCount / textElements.length > 0.8,
            !bodyOverflow,
            timing.loadTime < 3000,
            title !== null,
            description !== null,
            structuredData.length > 0,
            mobileOptimizedInputs >= Math.floor(inputs.length * 0.9)
        ];
        
        const passedChecks = checks.filter(Boolean).length;
        const totalChecks = checks.length;
        const score = Math.round((passedChecks / totalChecks) * 100);
        
        console.log(`   Bestanden: ${passedChecks}/${totalChecks}`);
        console.log(`   Mobile SEO Score: ${score}% ${score >= 90 ? '🏆' : score >= 75 ? '✅' : score >= 50 ? '⚠️' : '❌'}`);
        
        if (score >= 90) {
            console.log('   🎉 Exzellente mobile Optimierung!');
        } else if (score >= 75) {
            console.log('   👍 Gute mobile Optimierung!');
        } else if (score >= 50) {
            console.log('   ⚠️  Mobile Optimierung verbesserungsfähig');
        } else {
            console.log('   ❌ Mobile Optimierung dringend erforderlich');
        }
        
    } catch (error) {
        console.error('❌ Fehler beim Testen:', error.message);
    } finally {
        await browser.close();
    }
}

// Test ausführen
testMobileSEO().catch(console.error);

export { testMobileSEO };

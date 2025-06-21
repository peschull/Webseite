/**
 * Touch-Target Debug Script
 * Identifiziert zu kleine Touch-Targets für Mobile Optimization
 */

import puppeteer from 'puppeteer';

async function debugTouchTargets() {
    const browser = await puppeteer.launch({ 
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });
    
    const page = await browser.newPage();
    await page.setViewport({ width: 375, height: 667, isMobile: true });
    await page.goto('http://localhost:3000', { waitUntil: 'networkidle2' });
    
    console.log('🔍 Touch-Target Debug Analyse...\n');
    
    // Alle interaktiven Elemente finden
    const touchTargets = await page.$$('a, button, input[type="submit"], input[type="button"], [role="button"]');
    
    console.log(`Gefundene Touch-Targets: ${touchTargets.length}\n`);
    
    let validCount = 0;
    let invalidTargets = [];
    
    for (let i = 0; i < touchTargets.length; i++) {
        const target = touchTargets[i];
        const box = await target.boundingBox();
        
        if (box) {
            const tagName = await target.evaluate(el => el.tagName.toLowerCase());
            const className = await target.evaluate(el => el.className);
            const text = await target.evaluate(el => el.textContent?.trim().substring(0, 30) || '');
            
            const isValid = box.width >= 44 && box.height >= 44;
            
            if (isValid) {
                validCount++;
            } else {
                invalidTargets.push({
                    element: `${tagName}${className ? '.' + className.split(' ')[0] : ''}`,
                    text: text,
                    size: `${Math.round(box.width)}x${Math.round(box.height)}px`,
                    width: Math.round(box.width),
                    height: Math.round(box.height)
                });
            }
        }
    }
    
    console.log(`✅ Valide Touch-Targets: ${validCount}`);
    console.log(`❌ Zu kleine Touch-Targets: ${invalidTargets.length}\n`);
    
    if (invalidTargets.length > 0) {
        console.log('🔧 Zu kleine Touch-Targets im Detail:');
        invalidTargets.forEach((target, index) => {
            console.log(`${index + 1}. ${target.element}`);
            console.log(`   Text: "${target.text}"`);
            console.log(`   Size: ${target.size} (min. 44x44px erforderlich)`);
            console.log('');
        });
    }
    
    await browser.close();
}

// Script ausführen
debugTouchTargets().catch(console.error);

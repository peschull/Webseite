/**
 * Navigation Testing & Debugging Script
 * Tests all navigation functionality and reports results
 */

import puppeteer from 'puppeteer';

async function testNavigationFunctionality() {
    const browser = await puppeteer.launch({ 
        headless: true, // Headless für Server-Umgebung
        args: [
            '--no-sandbox', 
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-gpu',
            '--no-first-run'
        ]
    });
    
    const page = await browser.newPage();
    await page.setViewport({ width: 375, height: 667, isMobile: true });
    
    // Listen to console messages
    page.on('console', msg => {
        if (msg.type() === 'log' && msg.text().includes('[Navigation]')) {
            console.log('🔧', msg.text());
        }
        if (msg.type() === 'error') {
            console.error('❌ JS Error:', msg.text());
        }
    });
    
    await page.goto('http://localhost:3000', { waitUntil: 'networkidle2' });
    
    console.log('🧪 Testing Navigation Functionality...\n');
    
    // Test 1: Check if navigation manager is initialized
    const isInitialized = await page.evaluate(() => {
        return window.VereinMenschlichkeitNavigation ? 
               window.VereinMenschlichkeitNavigation.isInitialized : false;
    });
    
    console.log(`📡 Navigation Manager: ${isInitialized ? '✅' : '❌'}`);
    
    // Test 2: Mobile menu toggle functionality
    const mobileToggle = await page.$('.mobile-nav-toggle');
    if (mobileToggle) {
        console.log('📱 Mobile Toggle Found: ✅');
        
        // Test click functionality
        await mobileToggle.click();
        await page.waitForTimeout(500);
        
        const isMenuOpen = await page.evaluate(() => {
            const menu = document.querySelector('.main-navigation');
            return menu ? menu.classList.contains('active') : false;
        });
        
        console.log(`📱 Mobile Menu Opens: ${isMenuOpen ? '✅' : '❌'}`);
        
        // Test close functionality
        await mobileToggle.click();
        await page.waitForTimeout(500);
        
        const isMenuClosed = await page.evaluate(() => {
            const menu = document.querySelector('.main-navigation');
            return menu ? !menu.classList.contains('active') : true;
        });
        
        console.log(`📱 Mobile Menu Closes: ${isMenuClosed ? '✅' : '❌'}`);
    } else {
        console.log('📱 Mobile Toggle Found: ❌');
    }
    
    // Test 3: ARIA attributes
    const ariaTest = await page.evaluate(() => {
        const toggle = document.querySelector('.mobile-nav-toggle');
        if (!toggle) return false;
        
        return {
            hasExpanded: toggle.hasAttribute('aria-expanded'),
            hasControls: toggle.hasAttribute('aria-controls'),
            hasLabel: toggle.hasAttribute('aria-label')
        };
    });
    
    console.log(`🎯 ARIA Expanded: ${ariaTest.hasExpanded ? '✅' : '❌'}`);
    console.log(`🎯 ARIA Controls: ${ariaTest.hasControls ? '✅' : '❌'}`);
    console.log(`🎯 ARIA Label: ${ariaTest.hasLabel ? '✅' : '❌'}`);
    
    // Test 4: Keyboard navigation
    await page.keyboard.press('Tab');
    await page.keyboard.press('Tab');
    await page.keyboard.press('Enter');
    await page.waitForTimeout(500);
    
    const keyboardTest = await page.evaluate(() => {
        const menu = document.querySelector('.main-navigation');
        return menu ? menu.classList.contains('active') : false;
    });
    
    console.log(`⌨️  Keyboard Navigation: ${keyboardTest ? '✅' : '❌'}`);
    
    // Close menu with Escape
    await page.keyboard.press('Escape');
    await page.waitForTimeout(500);
    
    const escapeTest = await page.evaluate(() => {
        const menu = document.querySelector('.main-navigation');
        return menu ? !menu.classList.contains('active') : true;
    });
    
    console.log(`⌨️  Escape Key Close: ${escapeTest ? '✅' : '❌'}`);
    
    // Test 5: Touch events (simulate)
    if (mobileToggle) {
        await page.touchscreen.tap(187, 50); // Approximate toggle position
        await page.waitForTimeout(500);
        
        const touchTest = await page.evaluate(() => {
            const menu = document.querySelector('.main-navigation');
            return menu ? menu.classList.contains('active') : false;
        });
        
        console.log(`👆 Touch Navigation: ${touchTest ? '✅' : '❌'}`);
    }
    
    // Test 6: Performance metrics
    const performance = await page.evaluate(() => {
        const perfData = performance.timing;
        return {
            loadTime: perfData.loadEventEnd - perfData.navigationStart,
            domReady: perfData.domContentLoadedEventEnd - perfData.navigationStart
        };
    });
    
    console.log(`⚡ Load Time: ${performance.loadTime}ms`);
    console.log(`⚡ DOM Ready: ${performance.domReady}ms`);
    
    console.log('\n🎉 Navigation Testing Complete!');
    
    await browser.close();
}

// Run the test
testNavigationFunctionality().catch(console.error);

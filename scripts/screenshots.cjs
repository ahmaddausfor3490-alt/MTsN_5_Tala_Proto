const { chromium } = require('playwright');
const fs = require('fs');

(async () => {
  const browser = await chromium.launch({ headless: true, args: ['--no-sandbox'] });
  const ctx = await browser.newContext({ viewport: { width: 1440, height: 900 } });
  const page = await ctx.newPage();

  // Homepage — desktop
  await page.goto('http://127.0.0.1:8000/', { waitUntil: 'networkidle', timeout: 30000 });
  await page.waitForTimeout(800);
  await page.screenshot({ path: 'screenshots/01-homepage-full.png', fullPage: true });
  await page.screenshot({ path: 'screenshots/02-homepage-viewport.png', fullPage: false });

  // Mobile
  const mobile = await browser.newContext({ viewport: { width: 390, height: 844 }, deviceScaleFactor: 2 });
  const mp = await mobile.newPage();
  await mp.goto('http://127.0.0.1:8000/', { waitUntil: 'networkidle', timeout: 30000 });
  await mp.waitForTimeout(800);
  await mp.screenshot({ path: 'screenshots/03-homepage-mobile.png', fullPage: true });

  // Mobile menu open
  try {
    await mp.locator('button[aria-label="Toggle menu"]').first().click();
    await mp.waitForTimeout(600);
    await mp.screenshot({ path: 'screenshots/04-mobile-menu-open.png', fullPage: false });
  } catch (e) { console.log('Mobile menu error:', e.message); }

  // Admin login
  await page.goto('http://127.0.0.1:8000/admin/login', { waitUntil: 'networkidle', timeout: 30000 });
  await page.waitForTimeout(800);
  await page.screenshot({ path: 'screenshots/05-admin-login.png', fullPage: false });

  // Navbar scrolled
  await page.goto('http://127.0.0.1:8000/', { waitUntil: 'networkidle', timeout: 30000 });
  await page.evaluate(() => window.scrollTo(0, 300));
  await page.waitForTimeout(500);
  await page.screenshot({ path: 'screenshots/06-navbar-scrolled.png', clip: { x: 0, y: 0, width: 1440, height: 120 } });

  // Footer
  await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
  await page.waitForTimeout(500);
  await page.screenshot({ path: 'screenshots/07-footer.png', fullPage: false });

  await browser.close();
  console.log('All screenshots saved to screenshots/');
  fs.readdirSync('screenshots').forEach(f => console.log('  ' + f));
})().catch(e => { console.error(e); process.exit(1); });

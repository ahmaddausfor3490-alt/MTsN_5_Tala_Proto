const { chromium } = require('playwright');

(async () => {
  const browser = await chromium.launch({ headless: true });

  const sizes = [
    { width: 1440, height: 900, name: 'polished_1440' },
    { width: 768, height: 900, name: 'polished_768' },
    { width: 375, height: 700, name: 'polished_375' },
  ];

  for (const s of sizes) {
    const page = await browser.newPage({ viewport: { width: s.width, height: s.height } });
    await page.goto('http://127.0.0.1:8000/', { waitUntil: 'networkidle' });
    await page.waitForTimeout(1500);
    await page.screenshot({ path: `screenshots/${s.name}.png`, fullPage: true });
    console.log(`${s.name}.png saved.`);
  }

  await browser.close();
})();

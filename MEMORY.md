# Project Memory - MTsN 5 Tanah Laut CMS

## Project Context
Full-stack Laravel 12 CMS for MTsN 5 Tanah Laut Madrasah. Admin panel powered by Filament 3. Public frontend uses native Blade templates, Tailwind CSS, Alpine.js, and Heroicons.

## Key Decisions
- Framework: Laravel 12 with native Blade templating (Filament restricted to admin)
- Design System: Emerald Green (#047857) + Amber Gold (#F59E0B) + white/gray tones
- Font: Noto Sans Javanese
- Admin URL: /admin
- Admin User: admin@mt.sn / password

## File Architecture
- `app/Providers/Filament/AdminPanelProvider.php` - Filament panel setup
- `resources/views/layouts/app.blade.php` - Classic Blade layout (navbar + footer + yield)
- `resources/views/components/layouts/app.blade.php` - Alias for x-layouts.app component
- `resources/views/components/nav/index.blade.php` - Navigation component
- `resources/views/components/footer/main.blade.php` - Footer component
- `resources/views/home.blade.php` - Homepage view with hero + info cards
- `resources/views/vendor/filament/admin/layouts/app.blade.php` - Filament layout
- `resources/js/navbar.js` - Alpine.js mobile menu logic
- `public/images/logo.svg` - Logo SVG
- `routes/web.php` - Public routes (home + placeholder pages)

## Routes Created
- `/` - Home (view 'home')
- `/profile` - Profil placeholder
- `/visi-misi` - Visi Misi placeholder  
- `/guru-staf` - Guru & Staf placeholder
- `/berita` - Berita placeholder
- `/agenda` - Agenda placeholder
- `/unduh` - Unduhan placeholder
- `/faq` - FAQ placeholder
- `/kontak` - Kontak placeholder
- `/admin` - Filament admin
- `/admin/login` - Admin login (credentials: admin@mt.sn/password)

## Pending Database Tables
- profile_sections
- teachers_staff
- news
- agenda
- downloads
- faqs
- contact_messages
- settings/site_settings

## Next Phase (Phase 2)
- Create migrations for all database tables
- Add Eloquent models with relationships
- Set up soft deletes for content tables
- Build Filament admin panels for CMS entities
- Seed default sample data

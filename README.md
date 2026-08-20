# Uspeh Filter Theme

Custom WordPress theme for [uspehfilter.com](https://uspehfilter.com) — Bulgarian manufacturer of professional air, HEPA, engine, and industrial filters.

## Lighthouse Scores

All key pages score **100/100/100** (Accessibility, Best Practices, SEO).

| Page | Accessibility | Best Practices | SEO |
|---|---|---|---|
| Homepage | 100 | 100 | 100 |
| HEPA Filters | 100 | 100 | 100 |
| Request Quote | 100 | 100 | 100 |
| Product Archive | 100 | 100 | 100 |

## Features

- **WCAG AA compliant** — full color contrast, heading hierarchy, ARIA roles, form labels, touch targets
- **Gutenberg-first** — `theme.json` design tokens, matching editor styles, 26 block patterns, and blocks-first page rendering (see [Editing with Gutenberg](#editing-with-gutenberg))
- **Editable chrome** — WordPress menus for the header and footer, custom logo support, and a Customizer section for section images, each with a code fallback
- **Responsive** — mobile-first design with sticky CTA, slide-in mobile navigation, optimized touch targets
- **SEO** — meta description fallback, JSON-LD schema markup, breadcrumbs, semantic HTML
- **Custom Post Types** — Products, Engine Filters, Applications, Tech Articles, Inquiries
- **Custom Taxonomies** — Product Categories, Engine Filter Types, Vehicle Makes/Types
- **Quote System** — multi-step inquiry form with file upload, email notifications, UTM tracking
- **Engine Filter Search** — AJAX-powered search by OEM, catalog number, make, or model

## Requirements

- WordPress 6.0+
- PHP 7.4+
- MySQL 8.0+

## Quick Start

```bash
# Clone the repo
git clone https://github.com/esmobg/uspeh-filter-theme.git
cd uspeh-filter-theme

# Start the Docker environment
docker compose up -d

# Wait for WordPress to initialize (~30s), then seed demo content
docker compose run --rm wpcli wp theme activate uspeh-filter
bash bin/seed.sh

# Optional: replace the seeded pages with their Gutenberg starter patterns
docker compose run --rm wpcli wp eval-file wp-content/themes/uspeh-filter/inc/seed-gutenberg-pages.php
```

Both seeders are idempotent — re-running them will not duplicate content.

The site will be available at [http://localhost:8080](http://localhost:8080).

**WordPress Admin:** [http://localhost:8080/wp-admin](http://localhost:8080/wp-admin)

## Project Structure

```
.
├── docker-compose.yml          # Docker dev environment
├── bin/
│   └── seed.sh                 # Demo content seeder
└── wp-content/themes/uspeh-filter/
    ├── assets/
    │   ├── css/                # main, home, catalog, pages, components, editor
    │   ├── js/                 # main.js, engine-search.js, popup-form.js, utm-capture.js
    │   └── images/             # Theme images (slides, categories, logos)
    ├── inc/                    # PHP modules (CPTs, taxonomies, forms, AJAX, email, schema,
    │                           #   patterns, block styles, nav walker, customizer)
    ├── page-templates/         # 11 custom page templates
    ├── template-parts/         # 21 reusable template parts
    ├── screenshot.png          # Theme screenshot
    ├── functions.php           # Theme setup, hooks, includes
    ├── header.php / footer.php # Global header and footer
    ├── front-page.php          # Homepage template
    ├── theme.json              # Editor design tokens (colors, fonts, spacing, layout)
    └── style.css               # Theme metadata
```

## Page Templates

| Template | Description |
|---|---|
| About | Company history and timeline |
| HEPA | HEPA/EPA/ULPA product hub with trust badges |
| Quote | Full inquiry form with sidebar contact card |
| Production | Manufacturing process steps |
| Quality | ISO certifications and standards |
| Contact | Department contacts with Google Maps |
| Custom Production | Custom filter manufacturing options |
| Applications | Industry applications grid |
| FAQ | Accordion-style questions |
| Landing | Google Ads landing page with form |
| Thank You | Post-submission confirmation |

## Editing with Gutenberg

### Blocks-first rendering

Every page template follows the same rule: **if the page has block content, the blocks render and the PHP sections are skipped; if the content is empty, the PHP template renders as before.** The helper is `uspeh_maybe_render_block_page()` in `inc/helpers.php`.

This means an editor can take over any page — including the homepage — entirely from the block editor by inserting one of the starter patterns, without touching PHP. To hand a page back to its coded design, clear its content in the editor.

The one exception is the quote form itself, which stays in PHP (`inc/forms.php`) because it handles nonces, file uploads, and email notification. Patterns link to `/poiskaj-oferta/` rather than reproducing it.

### Design tokens (`theme.json`)

`theme.json` (schema v2) exposes the theme's design system to the editor, so colors and fonts picked in Gutenberg match the front end:

| Setting | Values |
|---|---|
| Colors | `primary` #00639E, `primary-dark` #052C4B, `primary-light` #3AA3DC, `accent` #E85D2C, `cta` #E31C23, `base`, `base-alt`, `contrast`, `text`, `border` |
| Fonts | Source Sans 3 (body), Montserrat (headings), Dancing Script (accent) |
| Sizes | Fluid `clamp()` scale, small → xx-large |
| Layout | Content 1200px, wide 1400px |

WordPress core's default palette is disabled, so only brand colors appear in the picker. `assets/css/main.css` reads these presets with static fallbacks (`var(--wp--preset--color--primary, #00639E)`), keeping one source of truth.

`assets/css/editor.css` mirrors the relevant front-end rules into the editor canvas via `add_editor_style()`.

### Block patterns

**Sections** — *Успех Филтър — Страници*: Hero, Two Columns, Three Cards, CTA Banner, FAQ, Stats Row

**Content** — *Успех Филтър — Съдържание*: Testimonials, Partner Logo Strip, Process Timeline, Certifications, Downloads, Filter Class Table, Team, Industry Section

**Page starters** — *Успех Филтър — Стартови страници*: full-page block versions of Home, About, HEPA, Quality, Production, Custom Production, Applications, Contact, Quote, FAQ, Thank You, and Landing

**Block styles** — Button: *CTA (червен градиент)*; Group: *Секция — сива*, *Секция — тъмна*

### Menus, logo, and images

- **Menus** — `primary`, `footer` (Products), `footer-company`, `footer-legal`. Assign them under *Appearance → Menus*. When a location is unassigned, the hardcoded list in `inc/helpers.php` renders instead, so the site never loses navigation.
- **Logo** — *Appearance → Customize → Site Identity*. Falls back to `assets/images/logo.png`.
- **Section images** — *Appearance → Customize → Изображения на секциите* sets the 12 images used by the PHP fallback sections (hero, product directions, catalog banner, and others).

### Seeding block content

```bash
docker compose run --rm wpcli wp eval-file wp-content/themes/uspeh-filter/inc/seed-gutenberg-pages.php
```

Pages are matched by slug and skipped if they already contain blocks, so the command is safe to re-run.

## Notes

- **SVG uploads** are enabled but not sanitized. For production, install [Safe SVG](https://wordpress.org/plugins/safe-svg/) or remove the `upload_mimes` filter in `functions.php`.
- **CSS loading** — all five stylesheets load on every request. Splitting them per template is a worthwhile future optimization; blocks-first pages can use classes from any of them, so it needs care.

## License

GPL v2 or later.

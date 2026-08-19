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
- **Gutenberg-ready** — all page templates support the block editor; 5 registered block patterns
- **Responsive** — mobile-first design with sticky CTA, burger menu, optimized touch targets
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
docker compose exec wpcli wp theme activate uspeh-filter
docker compose exec wpcli php /var/www/html/bin/seed.php
```

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
    │   ├── css/                # main.css, home.css, catalog.css, pages.css, components.css
    │   ├── js/                 # main.js, engine-search.js, mobile-nav.js, popup-form.js
    │   └── images/             # Theme images (slides, categories, logos)
    ├── inc/                    # PHP modules (CPTs, taxonomies, forms, AJAX, email, schema)
    ├── page-templates/         # 11 custom page templates
    ├── template-parts/         # 21 reusable template parts
    ├── screenshot.png          # Theme screenshot
    ├── functions.php           # Theme setup, hooks, includes
    ├── header.php / footer.php # Global header and footer
    ├── front-page.php          # Homepage template
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

## Block Patterns

Available under the "Успех Филтър — Страници" category:

- Hero Section (full-width cover with CTA)
- Two Columns — Text and Image
- Three Cards
- CTA Banner
- FAQ Section

## License

GPL v2 or later.

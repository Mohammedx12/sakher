# Sakher Hospitality — WordPress Theme

Custom Arabic-RTL WordPress theme for the Sakher Hospitality & Catering site.
Includes a one-page front page (hero, services, tier packages, pricing,
how-it-works, partners, CTA), a lead-capture modal that posts to a custom
REST endpoint, and a "Leads" custom post type with admin UI for tracking
inquiries.

## File map

```
sakher/
├── style.css            ← theme metadata + all CSS
├── functions.php        ← theme setup, asset enqueue, includes
├── header.php           ← <head> + sticky header (logo, nav, mobile toggle)
├── footer.php           ← footer columns + lead modal + WhatsApp FAB
├── front-page.php       ← hero → trust bar → services → why → tiers
│                          → pricing → how → partners → CTA banner
├── inc/
│   └── leads.php        ← CPT "sakher_lead" + REST endpoint + admin UI
└── assets/
    └── js/main.js       ← reveal-on-scroll, modal, scroll-spy, logo art
```

## Install

1. Zip the `sakher/` folder.
2. WP Admin → **Appearance → Themes → Add New → Upload Theme** → choose the zip → **Install Now** → **Activate**.
3. WP Admin → **Settings → Reading** → set "Your homepage displays" to
   **A static page** → create/select a Page named "Home" → save.
   (Because the file is `front-page.php`, WordPress will use it
   automatically once a static homepage is set.)

## Customising

| What to change | Where |
|---|---|
| Brand colours | CSS variables at top of `style.css` (`--wood`, `--ink`, `--tan`, etc.) |
| Hero hover photos | CSS variables `--logo-photo-1` … `--logo-photo-4` in `style.css` |
| Site logo | WP Admin → **Appearance → Customize → Site Identity → Logo** |
| Primary nav | WP Admin → **Appearance → Menus** → assign to "Primary Navigation" |
| WhatsApp number | Add a snippet using the `sakher_whatsapp_number` filter, e.g.<br>`add_filter('sakher_whatsapp_number', fn() => '966500000000');` |
| Contact phone / email | Edit the `$tel` and `$email` variables at the top of `footer.php` |
| Tier prices / features | The `$tiers` array near the top of `front-page.php` |
| Pricing comparison rows | The `$prices` array inside the `<section class="pricing">` block |

## Lead submissions

- Endpoint: `POST /wp-json/sakher/v1/leads`
- Body: `{ name, phone, service, email?, company?, tier?, people?, notes? }`
- Validates name length, phone format, service enum, tier enum
- Rate-limited to 5 submissions per IP per 15 min (transient-based)
- On success: creates a `sakher_lead` post + emails site admin
- View leads: WP Admin → **Leads** sidebar item

To disable the email notification:

```php
add_filter( 'sakher_send_lead_email', '__return_false' );
```

To customise the notification (e.g. send to Slack, WhatsApp, multiple
emails), hook into `sakher_lead_created`:

```php
add_action( 'sakher_lead_created', function ( $post_id, $data ) {
  // $data: name, phone, email, company, service, tier
  // do whatever you want
}, 20, 2 );
```

## Lead statuses

In the lead's edit screen, the right "Status" sidebar lets you set:
- `new` — جديد
- `contacted` — تم التواصل
- `closed` — مغلق
- `lost` — مفقود

Statuses appear as coloured pills in the leads list.

## Hosting

Any standard WordPress host works (Bluehost, SiteGround, Kinsta, WP Engine,
shared hosting that runs PHP 7.4+ and MySQL/MariaDB). No special PHP
extensions required. The theme uses WordPress core APIs only — no
external services, no build step, no node_modules.

## Hardening

Once live:
- Install **Wordfence** or **Solid Security** for brute-force protection.
- Use a strong admin password + 2FA.
- Keep WordPress core, theme, and plugins up to date.
- Consider **WP Mail SMTP** so lead notification emails actually deliver.

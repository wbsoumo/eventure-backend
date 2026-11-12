# Eventure CMS & Admin Panel (AdminLTE 3.2)

Complete luxury management backend and RESTful API for **Eventure** (Kolkata, India).

Hosted at: **`https://admin.myeventure.in`**  
CDN Assets: **`https://cdn.myeventure.in`**  
Frontend: **`https://myeventure.in`**

---

## Features

- **AdminLTE 3.2 Dark & Gold Luxury Theme**: Designed to reflect Eventure's signature luxury aesthetic (`#0a0a0b` background with `#d4af37` gold accents).
- **Segment-by-Segment Page Editors**:
  - `01 Home`: Hero display title, subtitle, atmospheric ballroom backdrop, key metrics, capabilities, CTA.
  - `02 Weddings`: Ceremony hero backdrop, destination cards (Udaipur, Jaipur, Goa, Bengal Rajbaris), services, process.
  - `03 Corporate`: Summit hero backdrop, corporate event formats, technical staging specs, case highlights.
  - `04 Portfolio`: Showcase header and category filter defaults.
  - `05 Gallery`: Visual archive hero and category groupings.
  - `06 About`: Genesis story, 6 difference pillars, 4-step client journey, CTA.
  - `07 Contact`: Kolkata studio address, hours, direct contact channels, FAQ accordion.
- **Events / Portfolio Management**:
  - Full CRUD (Create, Read, Update, Delete) for Signature Portfolio Projects.
  - Category tagger (Weddings, Corporate, Bespoke).
  - Scope of work, stats highlight, client details, cover image.
- **Visual Gallery Photo Archive (91+ Photos)**:
  - Filter by category (`weddings`, `corporate`, `sangeet`, `decor`, `moments`).
  - Add new photos with direct CDN integration.
- **Global Header & Navigation Manager**:
  - Control header menu items (`01 Home`, `02 Weddings`...), paths, ordering, and active toggles.
- **4-Column Footer Settings**:
  - Column 1 Brand Statement, Column 4 Studio details & opening hours.
  - Bottom bar tagline and copyright text.
- **Leads & Inquiries Inbox**:
  - Captures briefs submitted through the website.
  - **One-click "Reply on WhatsApp"** button generating tailored pre-filled WhatsApp greetings.
  - Status tracking (`New`, `Contacted`, `In Discussion`, `Booked`, `Closed`).
  - Internal staff notes.
  - Export leads to CSV.
- **Direct CDN Media Uploader**:
  - Uploads files straight to `https://cdn.myeventure.in/upload.php`.
  - Live preview and one-click URL copier.
- **RESTful JSON API**:
  - `/api/site.php` — Global branding, navigation, footer info.
  - `/api/page.php?slug={slug}` — Dynamic page hero and structured sections.
  - `/api/events.php` — Portfolio projects with category filter.
  - `/api/gallery.php` — Gallery photos archive.
  - `/api/inquiry.php` (POST) — Receives event inquiries from the frontend.

---

## Default Administrator Credentials

- **URL**: `https://admin.myeventure.in/login.php`
- **Email**: `admin@myeventure.in`
- **Password**: `Eventure@2026`

---

## Database Configuration

- **Host**: `86.107.77.32` (or `localhost` when hosted on Hostbet)
- **Database**: `myevent1_eventure`
- **User**: `myevent1_eventure`
- **Password**: `BHWM2RGLbc5Mm586rYDC`

To re-run the installer and re-seed all tables at any time:
```bash
php install.php
```
Or import `schema.sql` via DirectAdmin phpMyAdmin.

---

## DirectAdmin Deployment Steps for `admin.myeventure.in`

1. In Hostbet DirectAdmin, go to **Subdomain Management** ➔ Click **Add Subdomain** ➔ Type **`admin`**.
2. Go to **Git Manager** in DirectAdmin (or terminal) and clone / pull:
   ```bash
   git clone https://github.com/wbsoumo/eventure-backend.git public_html/admin
   ```
3. Ensure PHP version is set to **8.2** in **Select PHP Version**.
4. Open **`https://admin.myeventure.in`** in your browser and log in!

<?php
/**
 * Eventure CMS — Database Installer & Seeder
 * Connects to Hostbet MySQL (86.107.77.32 / myevent1_eventure)
 * Creates all 9 database tables and seeds complete site data.
 */
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

$host     = getenv('DB_HOST') ?: '86.107.77.32';
$dbname   = getenv('DB_NAME') ?: 'myevent1_eventure';
$user     = getenv('DB_USER') ?: 'myevent1_eventure';
$password = getenv('DB_PASS') ?: 'BHWM2RGLbc5Mm586rYDC';
$charset  = 'utf8mb4';

echo "=== Eventure CMS Database Setup ===\n";

try {
    $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    echo "✓ Connected to MySQL database [{$dbname}] on [{$host}]\n";
} catch (PDOException $e) {
    die("✗ Database connection failed: " . $e->getMessage() . "\n");
}

// 1. Create Tables
$tables = [
    // Admins table
    "CREATE TABLE IF NOT EXISTS `admins` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(150) NOT NULL UNIQUE,
        `password_hash` VARCHAR(255) NOT NULL,
        `role` VARCHAR(50) NOT NULL DEFAULT 'superadmin',
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // Site Global Settings
    "CREATE TABLE IF NOT EXISTS `site_settings` (
        `id` INT PRIMARY KEY,
        `site_name` VARCHAR(100) NOT NULL DEFAULT 'Eventure',
        `legal_name` VARCHAR(150) NOT NULL DEFAULT 'Eventure Experiences LLP',
        `tagline` VARCHAR(255) NOT NULL DEFAULT 'Where vision becomes an experience.',
        `site_url` VARCHAR(255) NOT NULL DEFAULT 'https://myeventure.in',
        `cdn_url` VARCHAR(255) NOT NULL DEFAULT 'https://cdn.myeventure.in',
        `logo_url` VARCHAR(255) NOT NULL DEFAULT '/logos/eventure-logo.svg',
        `phone` VARCHAR(50) NOT NULL DEFAULT '+91 97483 28654',
        `phone_raw` VARCHAR(50) NOT NULL DEFAULT '9748328654',
        `whatsapp` VARCHAR(50) NOT NULL DEFAULT '9748328654',
        `email` VARCHAR(150) NOT NULL DEFAULT 'info@myeventure.in',
        `address_street` VARCHAR(255) NOT NULL DEFAULT 'Tower 2, Sector V, Salt Lake City',
        `address_locality` VARCHAR(255) NOT NULL DEFAULT 'Bidhannagar',
        `address_city` VARCHAR(100) NOT NULL DEFAULT 'Kolkata',
        `address_region` VARCHAR(100) NOT NULL DEFAULT 'West Bengal',
        `address_postal_code` VARCHAR(20) NOT NULL DEFAULT '700091',
        `opening_hours` VARCHAR(150) NOT NULL DEFAULT 'Monday to Saturday, 10:00 AM – 7:00 PM',
        `instagram_url` VARCHAR(255) NOT NULL DEFAULT 'https://www.instagram.com/myeventure/',
        `facebook_url` VARCHAR(255) NOT NULL DEFAULT 'https://www.facebook.com/myeventure/',
        `linkedin_url` VARCHAR(255) NOT NULL DEFAULT 'https://www.linkedin.com/company/eventure-experiences/',
        `youtube_url` VARCHAR(255) NOT NULL DEFAULT 'https://www.youtube.com/',
        `footer_brand_text` TEXT,
        `footer_tagline` VARCHAR(255) NOT NULL DEFAULT 'Luxury Weddings · Corporate Events · Bespoke Experiences',
        `footer_copyright` VARCHAR(255) NOT NULL DEFAULT '© 2026 Eventure. All rights reserved.',
        `meta_title` VARCHAR(255) NOT NULL DEFAULT 'Eventure — Luxury Wedding & Corporate Event Management | Kolkata, India',
        `meta_description` TEXT,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // Navigation Menu Items
    "CREATE TABLE IF NOT EXISTS `nav_items` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `path` VARCHAR(255) NOT NULL,
        `num_prefix` VARCHAR(10) NOT NULL,
        `display_order` INT NOT NULL DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // Pages Table (Core page hero, CTA and SEO metadata)
    "CREATE TABLE IF NOT EXISTS `pages` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `slug` VARCHAR(50) NOT NULL UNIQUE,
        `title` VARCHAR(150) NOT NULL,
        `eyebrow` VARCHAR(150) NOT NULL,
        `hero_title` TEXT NOT NULL,
        `hero_subtitle` TEXT NOT NULL,
        `hero_image` VARCHAR(255) NOT NULL,
        `cta_eyebrow` VARCHAR(150) DEFAULT NULL,
        `cta_title` TEXT DEFAULT NULL,
        `cta_subtitle` TEXT DEFAULT NULL,
        `cta_btn_text` VARCHAR(100) DEFAULT NULL,
        `cta_btn_link` VARCHAR(255) DEFAULT NULL,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // Page Sections Table (JSON & structured segments)
    "CREATE TABLE IF NOT EXISTS `page_sections` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `page_slug` VARCHAR(50) NOT NULL,
        `section_key` VARCHAR(100) NOT NULL,
        `title` VARCHAR(255) DEFAULT NULL,
        `subtitle` TEXT DEFAULT NULL,
        `content_json` LONGTEXT NOT NULL,
        `display_order` INT NOT NULL DEFAULT 0,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY `page_section_idx` (`page_slug`, `section_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // Portfolio Projects / Events Table
    "CREATE TABLE IF NOT EXISTS `portfolio_events` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `slug` VARCHAR(255) NOT NULL UNIQUE,
        `category` VARCHAR(100) NOT NULL,
        `client` VARCHAR(150) DEFAULT NULL,
        `year` VARCHAR(20) DEFAULT NULL,
        `location` VARCHAR(150) NOT NULL,
        `scope` VARCHAR(255) NOT NULL,
        `stats` VARCHAR(255) DEFAULT NULL,
        `hero_image` VARCHAR(255) NOT NULL,
        `gallery_images` LONGTEXT,
        `summary` TEXT NOT NULL,
        `description` LONGTEXT,
        `featured` TINYINT(1) NOT NULL DEFAULT 0,
        `display_order` INT NOT NULL DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // Gallery Archive Photos Table
    "CREATE TABLE IF NOT EXISTS `gallery_photos` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `category` VARCHAR(100) NOT NULL,
        `image_url` VARCHAR(255) NOT NULL,
        `thumbnail_url` VARCHAR(255) DEFAULT NULL,
        `aspect_ratio` VARCHAR(50) NOT NULL DEFAULT 'landscape',
        `display_order` INT NOT NULL DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // FAQs Table
    "CREATE TABLE IF NOT EXISTS `faqs` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `category` VARCHAR(100) NOT NULL DEFAULT 'general',
        `question` TEXT NOT NULL,
        `answer` TEXT NOT NULL,
        `display_order` INT NOT NULL DEFAULT 0,
        `is_active` TINYINT(1) NOT NULL DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // Enquiries / Leads Table
    "CREATE TABLE IF NOT EXISTS `enquiries` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(150) NOT NULL,
        `phone` VARCHAR(50) NOT NULL,
        `email` VARCHAR(150) NOT NULL,
        `event_type` VARCHAR(100) DEFAULT NULL,
        `city` VARCHAR(100) DEFAULT NULL,
        `target_date` VARCHAR(100) DEFAULT NULL,
        `guests` VARCHAR(50) DEFAULT NULL,
        `budget` VARCHAR(100) DEFAULT NULL,
        `message` TEXT,
        `status` VARCHAR(50) NOT NULL DEFAULT 'new',
        `notes` TEXT,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
];

foreach ($tables as $sql) {
    $pdo->exec($sql);
}
echo "✓ All 9 database tables verified / created successfully.\n";

// 2. Seed Default Administrator
$adminEmail = 'admin@myeventure.in';
$adminPass  = 'Eventure@2026';
$passHash   = password_hash($adminPass, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("SELECT id FROM `admins` WHERE `email` = ?");
$stmt->execute([$adminEmail]);
if (!$stmt->fetch()) {
    $stmt = $pdo->prepare("INSERT INTO `admins` (`name`, `email`, `password_hash`, `role`) VALUES (?, ?, ?, 'superadmin')");
    $stmt->execute(['Eventure Admin', $adminEmail, $passHash]);
    echo "✓ Default administrator seeded: {$adminEmail} (password: {$adminPass})\n";
} else {
    echo "• Administrator already exists.\n";
}

// 3. Seed Site Settings
$stmt = $pdo->prepare("SELECT id FROM `site_settings` WHERE `id` = 1");
$stmt->execute();
if (!$stmt->fetch()) {
    $stmt = $pdo->prepare("INSERT INTO `site_settings` (`id`, `site_name`, `footer_brand_text`) VALUES (1, 'Eventure', 'Where vision becomes an experience. Luxury weddings, corporate events and bespoke experiences, delivered with precision across India.')");
    $stmt->execute();
    echo "✓ Site settings seeded.\n";
} else {
    echo "• Site settings already seeded.\n";
}

// 4. Seed Nav Items
$navItems = [
    ['name' => 'Home',      'path' => '/',          'num' => '01', 'order' => 1],
    ['name' => 'Weddings',  'path' => '/weddings',  'num' => '02', 'order' => 2],
    ['name' => 'Corporate', 'path' => '/corporate', 'num' => '03', 'order' => 3],
    ['name' => 'Portfolio', 'path' => '/portfolio', 'num' => '04', 'order' => 4],
    ['name' => 'Gallery',   'path' => '/gallery',   'num' => '05', 'order' => 5],
    ['name' => 'About',     'path' => '/about',     'num' => '06', 'order' => 6],
    ['name' => 'Contact',   'path' => '/contact',   'num' => '07', 'order' => 7],
];
$stmt = $pdo->prepare("SELECT COUNT(*) FROM `nav_items`");
$stmt->execute();
if ((int)$stmt->fetchColumn() === 0) {
    $insertNav = $pdo->prepare("INSERT INTO `nav_items` (`name`, `path`, `num_prefix`, `display_order`) VALUES (?, ?, ?, ?)");
    foreach ($navItems as $item) {
        $insertNav->execute([$item['name'], $item['path'], $item['num'], $item['order']]);
    }
    echo "✓ 7 Navigation items seeded.\n";
} else {
    echo "• Navigation items already seeded.\n";
}

// 5. Seed Pages Table
$pages = [
    [
        'slug'          => 'home',
        'title'         => 'Home',
        'eyebrow'       => 'Luxury Weddings · Corporate Events · Pan India / Global',
        'hero_title'    => "Where vision\nbecomes an\nexperience.",
        'hero_subtitle' => 'For more than a decade, India’s most discerning families and brands have trusted Eventure with the occasions that truly matter — designed with ambition, executed without a single visible seam.',
        'hero_image'    => '/images/udaipur-lake-palace-couple.webp',
        'cta_eyebrow'   => 'Begin a Conversation',
        'cta_title'     => 'If you are planning something that truly matters, we would be honoured to bring it to life.',
        'cta_subtitle'  => 'Tell us the date, the city, and the feeling you want people to leave with. We will take it from there.',
        'cta_btn_text'  => 'Start an Enquiry',
        'cta_btn_link'  => '/contact'
    ],
    [
        'slug'          => 'weddings',
        'title'         => 'Luxury Weddings',
        'eyebrow'       => 'Destination & Bespoke Celebrations',
        'hero_title'    => "Vows, rituals &\nevening revelry.",
        'hero_subtitle' => 'From heritage rajbaris in Bengal and lakeside palaces in Udaipur to barefoot coastal vows in Goa, we curate destination weddings that linger in memory for a lifetime.',
        'hero_image'    => '/images/wedding-ceremony-confetti.webp',
        'cta_eyebrow'   => 'Wedding Inquiries',
        'cta_title'     => 'Let’s plan your wedding of a lifetime.',
        'cta_subtitle'  => 'Tell us your dream destination, dates, and vision. Our senior planners will guide you through every detail.',
        'cta_btn_text'  => 'Enquire Now',
        'cta_btn_link'  => '/contact'
    ],
    [
        'slug'          => 'corporate',
        'title'         => 'Corporate Events',
        'eyebrow'       => 'Conferences, Launches & Summits',
        'hero_title'    => "Flawless staging,\nbroadcast precision.",
        'hero_subtitle' => 'Large-format summits, high-stakes brand reveals, and investor meets engineered to broadcast standards with impeccable delegate hospitality.',
        'hero_image'    => '/images/summit-audience.webp',
        'cta_eyebrow'   => 'Corporate Mandates',
        'cta_title'     => 'Host an event that defines your brand’s year.',
        'cta_subtitle'  => 'Engage our senior production leads for complete AV engineering, stagecraft, and delegate operations.',
        'cta_btn_text'  => 'Brief Our Team',
        'cta_btn_link'  => '/contact'
    ],
    [
        'slug'          => 'portfolio',
        'title'         => 'Signature Portfolio',
        'eyebrow'       => 'Selected Works',
        'hero_title'    => "A decade of\nextraordinary moments.",
        'hero_subtitle' => 'Browse our curated collection of palatial weddings, global brand conferences, and bespoke celebrations executed across India.',
        'hero_image'    => '/images/unsplash/photo-1508997449629-303059a039c0.jpg',
        'cta_eyebrow'   => 'Collaborate',
        'cta_title'     => 'Ready to create your next landmark event?',
        'cta_subtitle'  => 'We limit our active mandates each season to guarantee senior-level involvement on ground.',
        'cta_btn_text'  => 'Schedule a Consultation',
        'cta_btn_link'  => '/contact'
    ],
    [
        'slug'          => 'gallery',
        'title'         => 'Visual Gallery',
        'eyebrow'       => 'Eventure Archive',
        'hero_title'    => "Through the lens of\nluxury & grandeur.",
        'hero_subtitle' => 'An unfiltered photographic archive of sets, moments, and stage productions captured across India.',
        'hero_image'    => '/images/gallery/pudhari-maha-summit-01.webp',
        'cta_eyebrow'   => 'Experience Eventure',
        'cta_title'     => 'Want to see more bespoke concepts?',
        'cta_subtitle'  => 'Visit our studio in Salt Lake Sector V, Kolkata, or request our confidential lookbook.',
        'cta_btn_text'  => 'Get in Touch',
        'cta_btn_link'  => '/contact'
    ],
    [
        'slug'          => 'about',
        'title'         => 'About Eventure',
        'eyebrow'       => 'About Eventure',
        'hero_title'    => "Equal parts\nart and precision.",
        'hero_subtitle' => 'A luxury event house headquartered in Kolkata, creating extraordinary weddings, corporate showcases and bespoke celebrations across India.',
        'hero_image'    => '/images/unsplash/photo-1519167758481-83f550bb49b3.jpg',
        'cta_eyebrow'   => 'Kolkata Studio',
        'cta_title'     => 'If you are planning something that truly matters, we would be honoured to bring it to life.',
        'cta_subtitle'  => 'Tell us the date, the city and the feeling you want people to leave with. We will take it from there.',
        'cta_btn_text'  => 'Start an Enquiry',
        'cta_btn_link'  => '/contact'
    ],
    [
        'slug'          => 'contact',
        'title'         => 'Contact & Enquiries',
        'eyebrow'       => 'Contact & Enquiries',
        'hero_title'    => "Let’s begin with\na conversation.",
        'hero_subtitle' => 'Tell us the occasion, the date and the feeling you want people to leave with. Every enquiry is read by a senior member of our team and answered within one working day.',
        'hero_image'    => '/images/unsplash/photo-1744805624890-9931ebb50428.jpg',
        'cta_eyebrow'   => 'Direct Line',
        'cta_title'     => 'Prefer a phone call or WhatsApp?',
        'cta_subtitle'  => 'Reach our Kolkata studio directly on +91 97483 28654.',
        'cta_btn_text'  => 'WhatsApp Now',
        'cta_btn_link'  => 'https://wa.me/919748328654'
    ]
];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM `pages`");
$stmt->execute();
if ((int)$stmt->fetchColumn() === 0) {
    $insertPage = $pdo->prepare("INSERT INTO `pages` (`slug`, `title`, `eyebrow`, `hero_title`, `hero_subtitle`, `hero_image`, `cta_eyebrow`, `cta_title`, `cta_subtitle`, `cta_btn_text`, `cta_btn_link`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($pages as $p) {
        $insertPage->execute([
            $p['slug'], $p['title'], $p['eyebrow'], $p['hero_title'], $p['hero_subtitle'],
            $p['hero_image'], $p['cta_eyebrow'], $p['cta_title'], $p['cta_subtitle'],
            $p['cta_btn_text'], $p['cta_btn_link']
        ]);
    }
    echo "✓ 7 Core pages seeded.\n";
} else {
    echo "• Pages already seeded.\n";
}

// 6. Seed Page Sections
$pageSections = [
    // Home Stats
    [
        'page'    => 'home',
        'key'     => 'stats',
        'title'   => 'Key Metrics',
        'content' => json_encode([
            ['value' => 'Pan India / Global', 'label' => 'Reach'],
            ['value' => '10+ Years',         'label' => 'Experience'],
            ['value' => '250+',               'label' => 'Weddings Produced'],
            ['value' => '150+',               'label' => 'Corporate Summits']
        ])
    ],
    // Home Capabilities
    [
        'page'    => 'home',
        'key'     => 'capabilities',
        'title'   => 'A full-service event house',
        'content' => json_encode([
            ['num' => '01', 'title' => 'Concept & Creative Design', 'desc' => 'Themes, narrative arcs, stage and set design, 3D visualisation — the idea before the invoice.'],
            ['num' => '02', 'title' => 'Décor & Floral Artistry',   'desc' => 'Bespoke installations, floral architecture and lighting built by our own master production partners.'],
            ['num' => '03', 'title' => 'Venue & Vendor Curation',   'desc' => 'Access to India\'s premier palaces, resorts, luxury hotels and convention centres, negotiated on your behalf.'],
            ['num' => '04', 'title' => 'Production & Technical',     'desc' => 'Sound, light, LED, rigging, AV and show-calling to international broadcast standards.'],
            ['num' => '05', 'title' => 'Celebrity & Artist Management', 'desc' => 'Headline performers, anchors, emcees and world-class entertainment curated and contracted end to end.'],
            ['num' => '06', 'title' => 'Guest & Hospitality Management', 'desc' => 'Arrivals, VIP accommodation, chartered transfers, RSVP desks and dedicated 24/7 guest concierges.'],
            ['num' => '07', 'title' => 'Premium Catering Direction', 'desc' => 'Curated culinary concepts with India\'s elite master chefs, artisanal live stations and royal service.'],
            ['num' => '08', 'title' => 'Cinematography & Content',  'desc' => 'Cinematic 4K reels, live broadcast feeds, and editorial photography capturing every fleeting moment.']
        ])
    ],
    // About Differences
    [
        'page'    => 'about',
        'key'     => 'differences',
        'title'   => 'Why hosts come back',
        'content' => json_encode([
            ['title' => 'A pan-India network money can’t buy', 'desc' => 'Deep, long-standing relationships with India’s premier venues, caterers, décor houses, production partners and artists.'],
            ['title' => 'White-glove hospitality', 'desc' => 'From arrival logistics and accommodation to in-event hospitality teams, every guest touchpoint is managed with five-star precision.'],
            ['title' => 'Senior-level involvement', 'desc' => 'You work with our senior team directly, from the first brief to the final farewell. No hand-offs to junior coordinators.'],
            ['title' => 'Flawless execution, every time', 'desc' => 'We plan for every contingency, rehearse every detail and coordinate in real time, so complex production appears effortless.'],
            ['title' => 'International standards, an Indian soul', 'desc' => 'A design sensibility drawn from global luxury benchmarks, interpreted through a distinctly Indian understanding of celebration.'],
            ['title' => 'Discretion and trust', 'desc' => 'Many of our clients are high-profile families and public brands. We protect their privacy as carefully as we protect the quality of their event.']
        ])
    ],
    // About Steps
    [
        'page'    => 'about',
        'key'     => 'steps',
        'title'   => 'A simple, proven journey',
        'content' => json_encode([
            ['num' => '01', 'title' => 'We Listen', 'desc' => 'A single conversation to understand the vision, the scale, the budget and the feeling you want people to leave with.'],
            ['num' => '02', 'title' => 'We Design', 'desc' => 'Concepts, themes, floor plans, production plans and timelines. You see the event before it exists.'],
            ['num' => '03', 'title' => 'We Execute', 'desc' => 'Our senior team takes over the ground. Vendors, rehearsals, contingencies and real-time show calling.'],
            ['num' => '04', 'title' => 'We Obsess', 'desc' => 'We stay until the last guest leaves. The details at the end matter as much as the grand reveal at the beginning.']
        ])
    ]
];

$insertSection = $pdo->prepare("INSERT INTO `page_sections` (`page_slug`, `section_key`, `title`, `content_json`) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `content_json` = VALUES(`content_json`)");
foreach ($pageSections as $sec) {
    $insertSection->execute([$sec['page'], $sec['key'], $sec['title'], $sec['content']]);
}
echo "✓ Page sections seeded.\n";

// 7. Seed Portfolio Events (9 signature projects)
$portfolio = [
    [
        'title'       => 'Palace Wedding Spectacle',
        'slug'        => 'palace-wedding-spectacle',
        'category'    => 'Wedding',
        'location'    => 'Udaipur & Kolkata',
        'client'      => 'Private Family',
        'year'        => '2025',
        'scope'       => 'Creative Direction, Production, Guest Logistics & Hospitality',
        'stats'       => '3 Days · 450 Guests · Palace Takeover',
        'hero_image'  => '/images/wedding-ceremony-confetti.webp',
        'summary'     => 'A lakeside palace taken over for three days, mandap, sangeet, and a reception staged across two courtyards, with 450 guests flown in and hosted end to end.',
        'description' => 'From the private boat transfers across mirror-still waters to the starlit sangeet under cascading crystal chandeliers, every hour was choreographed to perfection.',
        'featured'    => 1,
        'order'       => 1
    ],
    [
        'title'       => 'National Brand Summit',
        'slug'        => 'national-brand-summit',
        'category'    => 'Corporate',
        'location'    => 'Kolkata & Mumbai',
        'client'      => 'Leading National Media Group',
        'year'        => '2025',
        'scope'       => 'Broadcast Stage, AV Engineering, VIP Protocol',
        'stats'       => '2 Days · 1,200 Delegates · Live Broadcast',
        'hero_image'  => '/images/kotak-neo-kona-kona-investor.jpeg',
        'summary'     => 'A two-day flagship summit for a national media house, main stage production, four breakout tracks, live broadcast feed and full delegate management.',
        'description' => 'Seamless multi-track audio engineering, 65-foot curved LED backdrop, and real-time broadcast switching reaching 5M+ viewers.',
        'featured'    => 1,
        'order'       => 2
    ],
    [
        'title'       => 'Annual Awards Night',
        'slug'        => 'annual-awards-night',
        'category'    => 'Corporate',
        'location'    => 'Kolkata',
        'client'      => 'Apex Industrial Council',
        'year'        => '2024',
        'scope'       => 'Stage Design, Rigging, Show-Calling, Red Carpet',
        'stats'       => '1 Evening · 600 Leaders · Live Orchestration',
        'hero_image'  => '/images/zee24-krushi-samman-hall.webp',
        'summary'     => 'Black-tie gala for industry leaders with dynamic lighting choreography, custom trophies, and headline live performances.',
        'description' => 'A bespoke black-tie dinner featuring synchronized theatrical lighting, live symphonic performances, and high-impact award presentations.',
        'featured'    => 1,
        'order'       => 3
    ],
    [
        'title'       => 'Heritage Fort Celebrations',
        'slug'        => 'heritage-fort-celebrations',
        'category'    => 'Wedding',
        'location'    => 'Jaipur',
        'client'      => 'Royal Families',
        'year'        => '2024',
        'scope'       => 'Historical Preservation Compliance, Kinetic Stage, Hospitality',
        'stats'       => '3 Days · 350 Guests · Rampart Illumination',
        'hero_image'  => '/images/haldi-mandap-marigold.webp',
        'summary'     => 'Centuries-old ramparts transformed into an open-air amphitheatre with projection mapping and bespoke hospitality suites.',
        'description' => 'Architectural lighting mapping centuries of stone history, accompanied by heritage sufi singers and royal banquet curation.',
        'featured'    => 0,
        'order'       => 4
    ],
    [
        'title'       => 'Global Leadership Conclave',
        'slug'        => 'global-leadership-conclave',
        'category'    => 'Corporate',
        'location'    => 'Kolkata',
        'client'      => 'Fortune 500 Enterprise',
        'year'        => '2024',
        'scope'       => 'Plenary Stage, Breakout Suites, Multi-lingual Simultaneous Interpretation',
        'stats'       => '3 Days · 850 Global Delegates',
        'hero_image'  => '/images/summit-audience.webp',
        'summary'     => 'Plenary sessions, minister-level security clearances, international delegates, and simultaneous translation across four languages.',
        'description' => 'VVIP protocol, multi-tiered security protocols, and state-of-the-art interactive voting displays.',
        'featured'    => 0,
        'order'       => 5
    ],
    [
        'title'       => 'Coastal Sunset Phere',
        'slug'        => 'coastal-sunset-phere',
        'category'    => 'Wedding',
        'location'    => 'Goa Coast',
        'client'      => 'NRI Couple',
        'year'        => '2024',
        'scope'       => 'Tide-timed Mandap, Acoustic Tuning, Private Beach Takeover',
        'stats'       => '2 Days · 220 Guests · Beachfront Mandap',
        'hero_image'  => '/images/outdoor-mandap-phere-setup.jpg',
        'summary'     => 'Barefoot luxury mandap constructed on private shoreline, timed to the precise minute of sunset with sound engineering over ocean waves.',
        'description' => 'Intimate beachfront celebration featuring bespoke wooden architecture, sustainable botanical decor, and candlelit seaside dinners.',
        'featured'    => 0,
        'order'       => 6
    ],
    [
        'title'       => 'Flagship Product Launch',
        'slug'        => 'flagship-product-launch',
        'category'    => 'Corporate',
        'location'    => 'Kolkata',
        'client'      => 'Automotive Major',
        'year'        => '2023',
        'scope'       => '360° Reveal Stage, Kinetic Screen Rig, Media Briefing',
        'stats'       => '1 Day · 400 Journalists · National Reveal',
        'hero_image'  => '/images/zee-mpcg-building-new-india.webp',
        'summary'     => 'Unveiling with a custom revolving stage, hydraulic reveals, laser synchronization, and real-time test drive hospitality.',
        'description' => 'High-voltage kinetic screen unveiling with synchronized laser architecture for a nationwide audience.',
        'featured'    => 0,
        'order'       => 7
    ],
    [
        'title'       => 'Rajbari Aristocratic Nuptials',
        'slug'        => 'rajbari-aristocratic-nuptials',
        'category'    => 'Wedding',
        'location'    => 'Heritage Bengal',
        'client'      => 'Distinguished Kolkata Family',
        'year'        => '2023',
        'scope'       => 'Heritage Conservation, Shehnai Ensembles, Royal Banquet',
        'stats'       => '2 Days · 500 Guests · Colonial Courtyard',
        'hero_image'  => '/images/petal-shower-couple.webp',
        'summary'     => 'Traditional Bengali rituals elevated to royal proportions with heritage shehnai masters, terracotta styling, and five-star culinary art.',
        'description' => 'Recreating aristocratic Zamindari grandeur in a restored 200-year-old courtyard with thousands of floating brass lamps.',
        'featured'    => 0,
        'order'       => 8
    ],
    [
        'title'       => 'Media Summit & Awards Gala',
        'slug'        => 'media-summit-awards-gala',
        'category'    => 'Corporate',
        'location'    => 'Kolkata',
        'client'      => 'Broadcast Network',
        'year'        => '2023',
        'scope'       => 'Dual-stage Setup, Celebrity Management, Live OB Van Integration',
        'stats'       => '2 Days · 1,500 Attendees · Multi-channel Live',
        'hero_image'  => '/images/zee-pride-of-malwa-stage.webp',
        'summary'     => 'Two-day mega conclave featuring political dignitaries, entertainment icons, and televised award distributions.',
        'description' => 'Dual broadcast stages with live satellite OB van integration and complete backstage talent management.',
        'featured'    => 0,
        'order'       => 9
    ]
];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM `portfolio_events`");
$stmt->execute();
if ((int)$stmt->fetchColumn() === 0) {
    $insertProj = $pdo->prepare("INSERT INTO `portfolio_events` (`title`, `slug`, `category`, `client`, `year`, `location`, `scope`, `stats`, `hero_image`, `summary`, `description`, `featured`, `display_order`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($portfolio as $p) {
        $insertProj->execute([
            $p['title'], $p['slug'], $p['category'], $p['client'], $p['year'],
            $p['location'], $p['scope'], $p['stats'], $p['hero_image'],
            $p['summary'], $p['description'], $p['featured'], $p['order']
        ]);
    }
    echo "✓ 9 Portfolio events seeded.\n";
} else {
    echo "• Portfolio events already seeded.\n";
}

// 8. Seed Gallery Photos (from local JSON)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM `gallery_photos`");
$stmt->execute();
if ((int)$stmt->fetchColumn() === 0) {
    $jsPath = __DIR__ . '/../src/data/galleryData.js';
    if (file_exists($jsPath)) {
        $content = file_get_contents($jsPath);
        if (preg_match('/export\s+const\s+galleryData\s*=\s*(\[.*?\]);/s', $content, $matches)) {
            $galleryItems = json_decode($matches[1], true);
            if (is_array($galleryItems)) {
                $insertGal = $pdo->prepare("INSERT INTO `gallery_photos` (`title`, `category`, `image_url`, `display_order`) VALUES (?, ?, ?, ?)");
                $order = 1;
                foreach ($galleryItems as $item) {
                    $insertGal->execute([
                        $item['alt'] ?? 'Eventure Gallery Photo',
                        $item['category'] ?? 'weddings',
                        $item['src'],
                        $order++
                    ]);
                }
                echo "✓ " . count($galleryItems) . " Gallery archive photos seeded.\n";
            }
        }
    }
} else {
    echo "• Gallery photos already seeded.\n";
}

// 9. Seed FAQs
$faqs = [
    [
        'category' => 'general',
        'question' => 'Which cities and destinations do you work in?',
        'answer'   => "We are headquartered in Salt Lake Sector V, Kolkata and work pan-India. Our destination wedding work is concentrated in Udaipur, Jaipur, Jodhpur, Goa, Kerala and Bengal's heritage rajbaris, and our corporate productions regularly take us across Kolkata, Mumbai, Delhi NCR, Bengaluru, and Hyderabad."
    ],
    [
        'category' => 'general',
        'question' => 'How far in advance should we book?',
        'answer'   => "For a multi-day destination wedding we recommend six to twelve months, largely because the best heritage venues and artists are booked that far ahead. Corporate events typically need eight to sixteen weeks, though we have delivered large-format launches in less."
    ],
    [
        'category' => 'general',
        'question' => 'Do you take on full planning, or only execution?',
        'answer'   => "Both. Most clients engage us end to end: concept, design, vendor curation, production and on-ground execution. We also take on production-only or on-ground-management-only mandates where an in-house team has already built the master plan."
    ],
    [
        'category' => 'general',
        'question' => 'What kind of budgets do you work with?',
        'answer'   => "We work across a wide range and will tell you honestly at the first conversation whether your budget and your ambition are aligned. What we do not do is accept a brief we cannot deliver to our own luxury standard."
    ],
    [
        'category' => 'general',
        'question' => 'Will we work with your senior team directly?',
        'answer'   => "Yes. Senior-level involvement is a deliberate part of how Eventure operates: the people who take your brief are the people on the ground directing the show on the day."
    ],
    [
        'category' => 'general',
        'question' => 'Can you keep our event confidential?',
        'answer'   => "Yes. A significant share of our work is for prominent families, business leaders, and listed brands. Discretion is standard practice — non-disclosure agreements are routine, and we never publish without written permission."
    ]
];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM `faqs`");
$stmt->execute();
if ((int)$stmt->fetchColumn() === 0) {
    $insertFaq = $pdo->prepare("INSERT INTO `faqs` (`category`, `question`, `answer`, `display_order`) VALUES (?, ?, ?, ?)");
    $order = 1;
    foreach ($faqs as $f) {
        $insertFaq->execute([$f['category'], $f['question'], $f['answer'], $order++]);
    }
    echo "✓ 6 FAQs seeded.\n";
} else {
    echo "• FAQs already seeded.\n";
}

echo "\n=== ALL 9 TABLES AND INITIAL SEED DATA IMPORTED SUCCESSFULLY! ===\n";

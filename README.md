# chesperry

A native WordPress block theme for The Bruce Blog, inspired by hand-painted grocery-store signs and the supplied Figma design. The display name is **chesperry**; the existing folder and text domain remain `tbbt` for continuity. Version 0.2.0. Requires WordPress 6.6+.

## Design and source

Figma: https://www.figma.com/design/wvXE1fcKJztBS3r33DirH2/?node-id=46-13

The original export is preserved in `design/figma-tokens.json` (its historical theme name is intentionally unchanged). `theme.json` contains editable palette, gradient, font stacks, sizes, spacing, and surface tokens. `assets/css/chesperry.css` implements the responsive poster layout in the front end and editor. `assets/images/paint-band.svg` is a decorative, locally drawn yellow brush band inspired by the reference; the reference photo itself is not published.

White posters sit on a gray-to-warm-beige gradient, with purple/red headlines, red dates, and yellow date/category bands. Full content, including YouTube embeds, appears in the inherited posts query. Post titles and dates link to individual posts. Categories use native WordPress terms; pagination uses the site's existing Reading settings.

## Measurements and deliberate choices

- Desktop poster width: 680px; padding: 28px; body measure: 538px.
- Media max: 630px, capped by available inner width (624px within a 680px poster with 28px padding).
- Desktop post gap: 80px; internal gap: 30px; headline: up to 48px / 1.1; body: 14px / 1.6; date: 20px; category: 10px.
- The export leaves mobile values undefined: this implementation uses a 600px breakpoint, 16px page gutters, 20px poster padding, 40px post gaps, and 24px internal gaps. Headings scale down to 32px.
- YouTube embeds retain 16:9 at available width, including legacy iframe embeds. Other providers keep their own aspect ratios.
- The 380px desktop gutter derives from centering 680px on a 1440px canvas; it is not a fixed gutter on every screen.
- Header/footer remain minimal and use the real site title/tagline. No fabricated navigation, share destinations, or sample content is installed.

## Adobe Fonts

The Adobe Web Project stylesheet `https://use.typekit.net/pto1oll.css` loads through WordPress's `enqueue_block_assets` hook on the public site and inside block-editor content. No raw HTML embed or build dependency is required.

- Headlines and site title: `mikrobe-variable, sans-serif`.
- Dates and categories: `ccsignlanguage, sans-serif` (regular, italic, bold, and bold italic are supplied by the kit).
- Body copy remains system sans.
- Mikrobe's width axis (`wdth`) supports 75–125. `settings.custom.headlineWidth` in `theme.json` defaults to 100; lower values condense lettering and higher values widen it. Heading weight defaults to 400 instead of the previous synthetic 900 fallback.

The font kit requires an internet connection; sans-serif fallbacks remain available if it cannot load. The Adobe stylesheet and font files are hosted by Adobe, not copied into the theme.

## Files and development

- `style.css`: WordPress metadata and display name.
- `functions.php`: enqueue shared stylesheet and register editor styles.
- `theme.json`: global design tokens and block defaults.
- `templates/home.html`: full-post blog index; `index.html`: fallback.
- `templates/single.html`, `page.html`: individual content in the same poster treatment.
- `parts/header.html`, `footer.html`: site identity.
- `patterns/`, `assets/js/`: reserved for future work.
- `.gitignore`: local files, secrets, logs, backups.

No npm, Composer, framework, JavaScript runtime dependency, or build step. Edit files directly. Git initialization/commits are not performed automatically.

Theme installation does not activate the theme or change the database or Reading settings. `home.html` controls the posts page; a static homepage uses `page.html`. WordPress More blocks and protected posts retain their standard behavior. Site Editor customizations stored in the database can override theme files; export intentional edits back into the theme for Git tracking.

Before publishing, preview actual posts, long titles, categories, pagination, and YouTube embeds at desktop and mobile widths. Check the Adobe fonts load for final visual matching.

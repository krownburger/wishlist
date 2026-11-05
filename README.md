# Hitlovers Wishlist

Ønskeliste til festbands. Gæster kan ønske sange via en pæn webfomular, og bandet modtager straks notifikation via ntfy.sh.

## Funktioner

- **Responsive design** - Virker på alle enheder (mobil, tablet, desktop)
- **Festlig styling** - Mørkt tema med animationer og farver
- **Formular med validering** - Kunstnernavn, sangtitel, dit navn + valgfri besked
- **ntfy-integration** - Bandet modtager ønske med det samme i deres ntfy-app
- **Instagram pop-up** - Efter indsendelse vises en modal som opfordrer gæster til at følge bandet på Instagram
- **Sociale medier links** - Direkte links til Instagram og hjemmeside

## Hurtig start

1. **Upload filerne** til din webserver (f.eks. hitlovers.dk/wishlist/)
2. **Abonner på ntfy-topic** i din ntfy-app: `hitloversdk-wishlist`
3. **Test formularen** - Udfyld og send et ønske for at verificere det virker

## Filer

- `index.html` - Hovedsiden med formularen
- `styles.css` - Styling (festlig, responsive)
- `submit.php` - Backend som håndterer formularen og sender til ntfy
- `script.js` - JavaScript til animationer og modal

## Konfiguration

### Ændre ntfy-topic

Rediger `submit.php` og ændr linjen:
```php
$ntfyTopic = 'hitloversdk-wishlist';
```

### Ændre sociale medier links

Rediger `index.html` og opdater links i:
- Info-sektion (social-links)
- Modal (modal-buttons)

### Ændre farver

Rediger CSS-variable i `styles.css` (øverst i filen):
```css
:root {
    --primary-color: #1a1a2e;
    --secondary-color: #e94560;
    --accent-color: #ffd700;
    /* ... */
}
```

## Server krav

- PHP 7.0+ (til submit.php)
- cURL extension (til ntfy-integration)
- SSL certifikat anbefales (for HTTPS)

## Demo

Se siden live på: `https://hitlovers.dk/wishlist/`

## Teknologier

- HTML5
- CSS3 (med CSS Grid og Flexbox)
- Vanilla JavaScript
- PHP
- ntfy.sh (gratis push-notifikation service)
- Font Awesome ikoner
- Google Fonts (Roboto & Pacifico)

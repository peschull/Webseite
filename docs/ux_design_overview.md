# UX- & Accessibility-Guidelines (verein-menschlichkeit-theme)

## 1 Core Design Principles

Konsistenz • Sichtbarkeit des Systemstatus • Fehlertoleranz • Effizienz • Zugänglichkeit

## 2 Design-Token Catalogue

| Token | Wert | Zweck |
| ------------------- | ------- | ------------------------- |
| --color-primary-500 | #0055CC | Primäre CTAs |
| --color-primary-600 | #2563eb | Hover und aktive Elemente |
| --color-primary-700 | #1d4ed8 | Fokus-Styling |
| --color-secondary-500 | #ff6600 | Sekundäre Aktionen |
| --color-gray-10 | #f8fafc | Grundhintergrund |
| --color-gray-50 | #f1f5f9 | Flächenhelligkeit |
| --color-gray-100 | #e2e8f0 | Linien & leichte Flächen |
| --color-gray-200 | #cbd5e1 | Disabled States |
| --color-gray-300 | #94a3b8 | Borders |
| --color-gray-400 | #64748b | Icons |
| --color-gray-500 | #475569 | Sekundärer Text |
| --color-gray-600 | #334155 | Haupttext |
| --color-gray-700 | #1e293b | Headlines |
| --color-gray-800 | #0f172a | Dunkle Hintergründe |
| --radius-sm | 4px | Input- und Button-Corners |

## 3 Responsive Grid & Breakpoints

```scss
$grid-columns: 12;
$breakpoints: (sm: 576px, md: 768px, lg: 1024px, xl: 1280px);
```

## 4 WCAG 2.2 AA Checklist

Kontrast ≥ 4.5⠆1, Fokus-Indikatoren, ARIA Landmarks, skip-links, semantische HTML-Struktur, Fehlerhinweise, sinnvolle Linktexte.

## 5 Block-Editor (Gutenberg) Conventions

– Naming schema (kebab-case) – Attributes API – `block.json` rules – patterns – Überschriftenhierarchie beachten

## 6 Micro-Interactions

– Hover/Fokus Transition ≤ 150 ms – Easing: `cubic-bezier(.4,0,.2,1)` – reduzierte Bewegung respektieren

## 7 Content Style Guide

Plain Language, Lesbarkeit ≥ B1, Inclusive Imagery, Alt-Text-Template


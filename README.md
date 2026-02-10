# PHP Výuka

Repozitář pro výuku PHP na střední škole. Používá PHP 8.3+ s moderní syntaxí a striktním typováním.

## Jak začít

1. Klikni na zelené tlačítko **Code** → **Codespaces** → **Create codespace on main**
2. Počkej až se prostředí načte (cca 1-2 minuty poprvé)
3. Můžeš programovat!

## Struktura projektu

```
lekce/          - PHP skripty pro procvičování (spouští se v terminálu)
public/         - webové stránky (spouští se přes PHP server)
```

## Postup lekcí

| Lekce | Téma | Spuštění |
|-------|------|----------|
| 01 | Proměnné a datové typy | `php lekce/01-promenne.php` |
| 02 | Podmínky (if, match) | `php lekce/02-podminky.php` |
| 03 | Cykly (for, while, foreach) | `php lekce/03-cykly.php` |
| 04 | Pole (arrays) | `php lekce/04-pole.php` |
| 05 | Funkce | `php lekce/05-funkce.php` |

Každá lekce obsahuje příklady a na konci **úkol k vypracování** (hledej `// TODO:`).

## Spuštění PHP

### Skripty z terminálu
```bash
php lekce/01-promenne.php
```

### Webový server
```bash
php -S 0.0.0.0:8080 -t public
```
Po spuštění klikni na odkaz v terminálu, nebo otevři záložku **Ports** a klikni na port 8080.

## Moderní PHP 8.3+

V lekcích používáme moderní PHP syntaxi:

```php
<?php

declare(strict_types=1);  // Striktní typová kontrola
```

### Co můžeme typovat

| Kde | Příklad | Funguje |
|-----|---------|---------|
| Parametry funkcí | `function foo(string $jmeno)` | Ano |
| Návratové hodnoty | `function foo(): string` | Ano |
| Vlastnosti tříd | `public string $jmeno;` | Ano |
| Lokální proměnné | `string $jmeno = 'Jan';` | **Ne** (PHP to nepodporuje) |

### Moderní syntaxe

- `match` expression - moderní náhrada za switch
- Arrow funkce `fn(int $x): int => $x * 2`
- Pojmenované argumenty `funkce(vek: 25, jmeno: 'Jan')`
- Null coalescing `$value ?? 'default'`
- Union typy `int|float|string`
- Nullable typy `?string`

## Uložení práce

Vše co napíšeš se automaticky ukládá v Codespaces. Pro uložení do repozitáře (jako zálohu):

```bash
git add .
git commit -m "Popis změn"
git push
```

## Tipy pro VS Code

- **Ctrl+S** - uložit soubor
- **Ctrl+`** - otevřít/zavřít terminál
- **Ctrl+Shift+P** - příkazová paleta

<?php
declare(strict_types=1);

/**
 * Lekce 10: Zpracování formuláře - Zadání
 *
 * Tato stránka přijímá data z formuláře (10-formular-akce-zadani.php).
 * Doplň zpracování dat podle úkolů v zadání.
 */

// === ZDE PIŠTE SVŮJ KÓD PRO ZPRACOVÁNÍ FORMULÁŘŮ ===

// TODO: Ošetři přímý přístup (pokud nepřišel POST, přesměruj zpět)
// TODO: Přečti data z $_POST
// TODO: Validuj
// TODO: Zobraz výsledek (potvrzení nebo chyby)

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zpracování formuláře - Zadání</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1 { color: #4F5B93; }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        a { color: #4F5B93; }
    </style>
</head>
<body>
    <h1>Zpracování formuláře</h1>
    <p><a href="10-formular-akce-zadani.php">&larr; Zpět na formulář</a></p>

    <div class="card">
        <p><em>--- Tady zobraz výsledek zpracování ---</em></p>
    </div>
</body>
</html>

<?php
declare(strict_types=1);

/**
 * Lekce 10: Zpracování kontaktního formuláře - Příklad
 *
 * Tato stránka přijímá data z formuláře (10-formular-akce-priklad.php).
 * Uživatel sem nepřichází přímo - je sem přesměrován po odeslání formuláře.
 */

// Kontrola, zda přišel POST požadavek (ne přímý přístup přes URL)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Uživatel přišel přímo na URL → přesměrujeme zpět na formulář
    header('Location: 10-formular-akce-priklad.php');
    exit;
}

// Čtení a čištění dat
$jmeno = trim($_POST['jmeno'] ?? '');
$email = trim($_POST['email'] ?? '');
$predmet = trim($_POST['predmet'] ?? '');
$zprava = trim($_POST['zprava'] ?? '');

// Validace
$chyby = [];

if ($jmeno === '') {
    $chyby[] = 'Jméno je povinné.';
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $chyby[] = 'Zadej platný email.';
}

if ($zprava === '') {
    $chyby[] = 'Zpráva je povinná.';
}

// Rozhodnutí: zobrazíme úspěch nebo chyby
$uspech = empty($chyby);

// V reálné aplikaci bychom tu data uložili do databáze nebo odeslali emailem.
// Pro ukázku jen zobrazíme souhrn.
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zpracování formuláře</title>
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
        .success {
            background: #e8f5e9;
            border: 1px solid #c8e6c9;
            padding: 16px;
            border-radius: 8px;
            color: #2e7d32;
        }
        .success h2 { color: #2e7d32; margin-top: 0; }
        .errors {
            background: #fdecea;
            border: 1px solid #f5c6cb;
            padding: 16px;
            border-radius: 8px;
            color: #721c24;
        }
        .errors h2 { color: #721c24; margin-top: 0; }
        .errors li { margin: 4px 0; }
        a { color: #4F5B93; }
        code {
            background: #e8e8e8;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        th { background: #4F5B93; color: white; width: 120px; }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 16px;
            border-radius: 6px;
            overflow-x: auto;
            font-size: 13px;
        }
        .info {
            background: #e3f2fd;
            border-left: 4px solid #4F5B93;
            padding: 12px 16px;
            margin: 15px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Zpracování formuláře</h1>
    <p><a href="10-formular-akce-priklad.php">&larr; Zpět na formulář</a></p>

    <?php if ($uspech): ?>
        <div class="success">
            <h2>Zpráva odeslána!</h2>
            <p>Děkujeme, <?= htmlspecialchars($jmeno) ?>. Tvoje zpráva byla přijata.</p>

            <table>
                <tr>
                    <th>Jméno</th>
                    <td><?= htmlspecialchars($jmeno) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($email) ?></td>
                </tr>
                <tr>
                    <th>Předmět</th>
                    <td><?= htmlspecialchars($predmet !== '' ? $predmet : '(nezadáno)') ?></td>
                </tr>
                <tr>
                    <th>Zpráva</th>
                    <td><?= nl2br(htmlspecialchars($zprava)) ?></td>
                </tr>
            </table>
        </div>
    <?php else: ?>
        <div class="errors">
            <h2>Chyby ve formuláři</h2>
            <ul>
                <?php foreach ($chyby as $chyba): ?>
                    <li><?= htmlspecialchars($chyba) ?></li>
                <?php endforeach; ?>
            </ul>
            <p><a href="10-formular-akce-priklad.php">Zpět na formulář</a></p>
        </div>
    <?php endif; ?>

    <!-- VYSVĚTLENÍ -->
    <div class="card">
        <h2>Co se stalo?</h2>

        <div class="info">
            Tato stránka (<code>10-formular-akce-priklad-zpracovani.php</code>) přijala data
            z formuláře na stránce <code>10-formular-akce-priklad.php</code>.
        </div>

        <h3>Klíčové body tohoto souboru:</h3>
<pre>// 1. Kontrola přímého přístupu
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: 10-formular-akce-priklad.php');
    exit;
}

// 2. Čtení dat - úplně stejné jako v lekci 9
$jmeno = trim($_POST['jmeno'] ?? '');

// 3. Validace, zobrazení výsledku</pre>

        <h3>Nevýhoda odděleného zpracování:</h3>
        <p>Když validace selže, nemůžeme jednoduše znovu zobrazit formulář s vyplněnými hodnotami
           — formulář je na jiné stránce. Řešení:</p>
        <ul>
            <li>Uložit data a chyby do <code>$_SESSION</code> a přesměrovat zpět na formulář</li>
            <li>Nebo použít framework, který to řeší automaticky (např. Nette)</li>
        </ul>
    </div>
</body>
</html>

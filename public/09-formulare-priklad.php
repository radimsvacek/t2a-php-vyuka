<?php
declare(strict_types=1);

/**
 * Lekce 9: Formuláře - Funkční příklad
 * Spuštění: php -S 0.0.0.0:8080 -t public  →  otevři /09-formulare-priklad.php
 *
 * Tento příklad ukazuje:
 * - Různé typy inputů (text, email, number, date, select, radio, checkbox, textarea)
 * - Odeslání formuláře metodou POST
 * - Zpracování dat v PHP ($_POST)
 * - Escapování výstupu (htmlspecialchars) - ochrana proti XSS
 * - Ukládání dat do pole (session/v rámci jednoho požadavku)
 * - Zobrazení dat v HTML tabulce
 */

// Session pro uchování dat mezi požadavky
session_start();

// Inicializace pole pro záznamy
if (!isset($_SESSION['osoby'])) {
    $_SESSION['osoby'] = [];
}

// Zpracování odeslaného formuláře
$chyby = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['akce']) && $_POST['akce'] === 'smazat') {
        // Smazání všech záznamů
        $_SESSION['osoby'] = [];
    } else {
        // Validace
        $jmeno = trim($_POST['jmeno'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $vek = (int)($_POST['vek'] ?? 0);
        $narozeniny = $_POST['narozeniny'] ?? '';
        $pohlavi = $_POST['pohlavi'] ?? '';
        $trida = $_POST['trida'] ?? '';
        $jazyky = $_POST['jazyky'] ?? [];  // checkbox pole
        $poznamka = trim($_POST['poznamka'] ?? '');

        if ($jmeno === '') {
            $chyby[] = 'Jméno je povinné.';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $chyby[] = 'Zadej platný email.';
        }
        if ($vek < 1 || $vek > 120) {
            $chyby[] = 'Věk musí být mezi 1 a 120.';
        }

        // Pokud nejsou chyby, uložíme záznam
        if (empty($chyby)) {
            $_SESSION['osoby'][] = [
                'jmeno' => $jmeno,
                'email' => $email,
                'vek' => $vek,
                'narozeniny' => $narozeniny,
                'pohlavi' => $pohlavi,
                'trida' => $trida,
                'jazyky' => implode(', ', $jazyky),
                'poznamka' => $poznamka,
            ];
        }
    }
}

$osoby = $_SESSION['osoby'];
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lekce 9: Formuláře - Příklad</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1 { color: #4F5B93; }
        h2 { color: #333; margin-top: 30px; }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 12px 0 4px;
            font-weight: 600;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        textarea { resize: vertical; min-height: 60px; }
        .radio-group, .checkbox-group {
            display: flex;
            gap: 20px;
            margin: 6px 0 10px;
        }
        .radio-group label, .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: normal;
            margin: 0;
        }
        button {
            background: #4F5B93;
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            margin-top: 10px;
        }
        button:hover { background: #3d4875; }
        .btn-danger {
            background: #c0392b;
        }
        .btn-danger:hover { background: #a93226; }
        .errors {
            background: #fdecea;
            border: 1px solid #f5c6cb;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            color: #721c24;
        }
        .errors li { margin: 4px 0; }
        .hint {
            font-size: 12px;
            color: #888;
            margin-top: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
            font-size: 13px;
        }
        th {
            background: #4F5B93;
            color: white;
        }
        tr:nth-child(even) { background: #f9f9f9; }
        .empty { color: #999; font-style: italic; padding: 20px; text-align: center; }
        a { color: #4F5B93; }
        code {
            background: #e8e8e8;
            padding: 2px 6px;
            border-radius: 3px;
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
    <h1>Lekce 9: Formuláře - Příklad</h1>
    <p><a href="index.php">&larr; Zpět</a> | <a href="09-formulare-zadani.php">Zadání &rarr;</a></p>

    <div class="info">
        Tento formulář ukazuje různé typy inputů. Po odeslání se data zobrazí v tabulce.
        Data se ukládají v <code>$_SESSION</code>, takže přežijí refresh stránky.
    </div>

    <!-- FORMULÁŘ -->
    <div class="card">
        <h2>Registrace studenta</h2>

        <?php if (!empty($chyby)): ?>
            <div class="errors">
                <strong>Oprav chyby:</strong>
                <ul>
                    <?php foreach ($chyby as $chyba): ?>
                        <li><?= htmlspecialchars($chyba) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <!-- TEXT -->
            <label for="jmeno">Jméno a příjmení:</label>
            <input type="text" id="jmeno" name="jmeno" placeholder="Jan Novák" required>
            <div class="hint">type="text" - základní textový vstup</div>

            <!-- EMAIL -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="jan@skola.cz" required>
            <div class="hint">type="email" - prohlížeč kontroluje formát emailu</div>

            <!-- NUMBER -->
            <label for="vek">Věk:</label>
            <input type="number" id="vek" name="vek" min="10" max="25" value="16">
            <div class="hint">type="number" - jen čísla, atributy min/max</div>

            <!-- DATE -->
            <label for="narozeniny">Datum narození:</label>
            <input type="date" id="narozeniny" name="narozeniny">
            <div class="hint">type="date" - výběr data z kalendáře</div>

            <!-- SELECT -->
            <label for="trida">Třída:</label>
            <select id="trida" name="trida">
                <option value="">-- vyber --</option>
                <option value="1.A">1.A</option>
                <option value="2.A">2.A</option>
                <option value="3.A">3.A</option>
                <option value="4.A">4.A</option>
            </select>
            <div class="hint">&lt;select&gt; - rozbalovací seznam</div>

            <!-- RADIO -->
            <label>Pohlaví:</label>
            <div class="radio-group">
                <label><input type="radio" name="pohlavi" value="muz"> Muž</label>
                <label><input type="radio" name="pohlavi" value="zena"> Žena</label>
                <label><input type="radio" name="pohlavi" value="jine"> Jiné</label>
            </div>
            <div class="hint">type="radio" - výběr jedné možnosti (stejný name)</div>

            <!-- CHECKBOX -->
            <label>Programovací jazyky:</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="jazyky[]" value="PHP"> PHP</label>
                <label><input type="checkbox" name="jazyky[]" value="JavaScript"> JS</label>
                <label><input type="checkbox" name="jazyky[]" value="Python"> Python</label>
                <label><input type="checkbox" name="jazyky[]" value="C#"> C#</label>
            </div>
            <div class="hint">type="checkbox" - více možností, name="jazyky[]" vytvoří pole</div>

            <!-- TEXTAREA -->
            <label for="poznamka">Poznámka:</label>
            <textarea id="poznamka" name="poznamka" placeholder="Cokoliv chceš dodat..."></textarea>
            <div class="hint">&lt;textarea&gt; - víceřádkový text</div>

            <button type="submit">Odeslat</button>
        </form>
    </div>

    <!-- TABULKA S VÝSLEDKY -->
    <div class="card">
        <h2>Registrovaní studenti (<?= count($osoby) ?>)</h2>

        <?php if (empty($osoby)): ?>
            <p class="empty">Zatím žádní studenti. Vyplň formulář výše.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jméno</th>
                        <th>Email</th>
                        <th>Věk</th>
                        <th>Narozeniny</th>
                        <th>Pohlaví</th>
                        <th>Třída</th>
                        <th>Jazyky</th>
                        <th>Poznámka</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($osoby as $i => $osoba): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($osoba['jmeno']) ?></td>
                            <td><?= htmlspecialchars($osoba['email']) ?></td>
                            <td><?= $osoba['vek'] ?></td>
                            <td><?= htmlspecialchars($osoba['narozeniny']) ?></td>
                            <td><?= htmlspecialchars($osoba['pohlavi']) ?></td>
                            <td><?= htmlspecialchars($osoba['trida']) ?></td>
                            <td><?= htmlspecialchars($osoba['jazyky']) ?></td>
                            <td><?= htmlspecialchars($osoba['poznamka']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="POST" action="" style="margin-top: 10px;">
                <input type="hidden" name="akce" value="smazat">
                <button type="submit" class="btn-danger">Smazat vše</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- VYSVĚTLENÍ PRO STUDENTY -->
    <div class="card">
        <h2>Jak to funguje?</h2>
        <ol>
            <li><code>&lt;form method="POST"&gt;</code> - formulář odesílá data metodou POST</li>
            <li>PHP přečte data z <code>$_POST['jmeno']</code>, <code>$_POST['email']</code> atd.</li>
            <li><code>htmlspecialchars()</code> - escapuje HTML znaky (ochrana proti XSS útoku)</li>
            <li><code>$_SESSION</code> - data přežijí refresh stránky (ukládají se na serveru)</li>
            <li>Checkbox s <code>name="jazyky[]"</code> - hranaté závorky vytvoří pole hodnot</li>
            <li>Radio s <code>name="pohlavi"</code> - stejný name = lze vybrat jen jednu hodnotu</li>
        </ol>
    </div>
</body>
</html>

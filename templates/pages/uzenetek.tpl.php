<?php
try {
    // 1. ADATOK BEÁLLÍTÁSA (Használd a már működő adataidat!)
    $host = "localhost"; 
    $db   = "adatbw";    // Nethelyes adatbázis név
    $user = "adatbw";    // Nethelyes felhasználónév
    $pass = "a1b2c3d4";  // Nethelyes jelszó

    // 2. KAPCSOLÓDÁS
    // Itt is dupla idézőjelet használunk a változók miatt!
    $dbh = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

    // 3. LEKÉRDEZÉS
    $sql = "SELECT nev, email, uzenet, datum 
            FROM uzenetek 
            ORDER BY datum DESC";

    $stmt = $dbh->query($sql);
    $uzenetek = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Éles oldalon a die() vagy egy szép hibaüzenet jobb, mint az echo exit
    die("Hiba történt az üzenetek betöltésekor: " . $e->getMessage());
}
?>

<h1>Beérkezett üzenetek</h1>

<!-- Egy kis stílus, hogy ne legyen szétcsúszva a táblázat -->
<style>
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2 f2 f2; }
</style>

<table>
    <tr>
        <th>Név</th>
        <th>Email</th>
        <th>Üzenet</th>
        <th>Dátum</th>
    </tr>

    <?php if (empty($uzenetek)): ?>
        <tr><td colspan="4">Még nem érkezett üzenet.</td></tr>
    <?php else: ?>
        <?php foreach ($uzenetek as $uzenet): ?>
        <tr>
            <td><?= htmlspecialchars($uzenet['nev']) ?></td>
            <td><?= htmlspecialchars($uzenet['email']) ?></td>
            <td><?= nl2br(htmlspecialchars($uzenet['uzenet'])) ?></td>
            <td><?= $uzenet['datum'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
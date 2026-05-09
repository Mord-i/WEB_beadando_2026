<?php
try {
    $dbh = new PDO(
        'mysql:host=localhost;dbname=gyakorlat7',
        'root',
        '',
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

    $sql = "SELECT nev, email, uzenet, datum 
            FROM uzenetek 
            ORDER BY datum DESC";

    $stmt = $dbh->query($sql);
    $uzenetek = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Hiba: " . $e->getMessage();
    exit;
}
?>

<h1>Beérkezett üzenetek</h1>

<table>
    <tr>
        <th>Név</th>
        <th>Email</th>
        <th>Üzenet</th>
        <th>Dátum</th>
    </tr>

    <?php foreach ($uzenetek as $uzenet): ?>
    <tr>
        <td><?= htmlspecialchars($uzenet['nev']) ?></td>
        <td><?= htmlspecialchars($uzenet['email']) ?></td>
        <td><?= htmlspecialchars($uzenet['uzenet']) ?></td>
        <td><?= $uzenet['datum'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
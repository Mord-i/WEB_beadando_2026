<?php
$dbh = new PDO("mysql:host=localhost;dbname=gyakorlat7", "root", "");
$dbh->query("SET NAMES utf8");

$eredmeny = $dbh->query("SELECT * FROM uzenetek ORDER BY kuldve DESC");
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Üzenetek</title>
</head>
<body>

<h1>Beérkezett üzenetek</h1>

<?php while ($row = $eredmeny->fetch()): ?>
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <b><?= $row["nev"] ?></b> (<?= $row["email"] ?>)<br>
        <b>Tárgy:</b> <?= $row["targy"] ?><br>
        <p><?= $row["uzenet"] ?></p>
        <small><?= $row["kuldve"] ?></small>
    </div>
<?php endwhile; ?>

</body>
</html>
<?php
include "db.php";

$szallodak = $pdo->query("SELECT * FROM szalloda")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("
        INSERT INTO tavasz (szalloda_az, indulas, idotartam, ar)
        VALUES (?, ?, 8, ?)
    ");

    $stmt->execute([
        $_POST['szalloda_az'],
        $_POST['indulas'],
        $_POST['ar']
    ]);

    header("Location: index.php");
}
?>

<form method="post">

    Szálloda:
    <select name="szalloda_az">
        <?php foreach($szallodak as $s): ?>
            <option value="<?= $s['az'] ?>">
                <?= $s['nev'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    Indulás: <input type="date" name="indulas"><br>
    Ár: <input name="ar"><br>

    <button>Mentés</button>
</form>
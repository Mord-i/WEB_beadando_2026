<?php
include "db.php";

$id = $_GET['id'];

$szallodak = $pdo->query("SELECT * FROM szalloda")->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM tavasz WHERE sorszam=?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("
        UPDATE tavasz
        SET szalloda_az=?, indulas=?, ar=?
        WHERE sorszam=?
    ");

    $stmt->execute([
        $_POST['szalloda_az'],
        $_POST['indulas'],
        $_POST['ar'],
        $id
    ]);

    header("Location: index.php");
}
?>

<form method="post">

    Szálloda:
    <select name="szalloda_az">
        <?php foreach($szallodak as $s): ?>
            <option value="<?= $s['az'] ?>"
                <?= $s['az'] == $row['szalloda_az'] ? "selected" : "" ?>>
                <?= $s['nev'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    Indulás: <input name="indulas" value="<?= $row['indulas'] ?>"><br>
    Ár: <input name="ar" value="<?= $row['ar'] ?>"><br>

    <button>Módosítás</button>
</form>
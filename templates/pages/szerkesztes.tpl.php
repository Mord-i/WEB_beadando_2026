<?php
include __DIR__ . "/../../db.php";

$id = $_GET['id'] ?? null;
if (!$id) die("Hiányzó ID");

$stmt = $pdo->prepare("SELECT * FROM tavasz WHERE sorszam=?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) die("Nincs ilyen rekord");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['szalloda_nev']) && !empty($_POST['helyseg_nev']) && !empty($_POST['indulas']) && !empty($_POST['ar'])) {

        $stmt = $pdo->prepare("
            UPDATE tavasz
            SET szalloda_nev=?, helyseg_nev=?, indulas=?, ar=?
            WHERE sorszam=?
        ");

        $stmt->execute([
            $_POST['szalloda_nev'],
            $_POST['helyseg_nev'],
            $_POST['indulas'],
            $_POST['ar'],
            $id
        ]);

        header("Location: index.php?oldal=crud");
        exit;
    }
}
?>

<form method="post">

    Szálloda neve:
    <input name="szalloda_nev" value="<?= $row['szalloda_nev'] ?>"><br>

    Helység neve:
    <input name="helyseg_nev" value="<?= $row['helyseg_nev'] ?>"><br>

    Indulás:
    <input type="date" name="indulas" value="<?= $row['indulas'] ?>"><br>

    Ár:
    <input name="ar" value="<?= $row['ar'] ?>"><br>

    <button>Módosítás</button>
</form>
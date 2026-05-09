<?php
ob_start();
include "db.php";

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$error = "";

/* ===================== CREATE ===================== */
if ($action == "create" && $_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        !empty($_POST['szalloda_az']) &&
        !empty($_POST['indulas']) &&
        !empty($_POST['ar'])
    ) {

        $stmt = $pdo->prepare("
            INSERT INTO tavasz (szalloda_az, indulas, ar)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $_POST['szalloda_az'],
            $_POST['indulas'],
            (int)$_POST['ar']
        ]);

        header("Location: index.php?oldal=crud");
        exit;

    } else {
        $error = "Minden mező kötelező!";
    }
}

/* ===================== DELETE ===================== */
if ($action == "delete" && $id) {

    $stmt = $pdo->prepare("
        DELETE FROM tavasz
        WHERE sorszam=?
    ");
    $stmt->execute([$id]);
    header("Location: index.php?oldal=crud");
    exit;
}

/* ===================== EDIT ===================== */
if ($action == "edit" && $id) {

    $stmt = $pdo->prepare("
        SELECT *
        FROM tavasz
        WHERE sorszam=?
    ");

    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if (!$row) {
        die("Nincs ilyen rekord");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("
            UPDATE tavasz
            SET
                szalloda_az=?,
                indulas=?,
                ar=?
            WHERE sorszam=?
        ");
        $stmt->execute([
            $_POST['szalloda_az'],
            $_POST['indulas'],
            (int)$_POST['ar'],
            $id
        ]);
        header("Location: index.php?oldal=crud");
        exit;
    }
}

/* ===================== SZÁLLODÁK LEKÉRÉSE ===================== */

$szallodak = $pdo->query("
    SELECT
        szalloda.az,
        szalloda.nev,
        helyseg.nev AS varos

    FROM szalloda

    JOIN helyseg
        ON szalloda.helyseg_az = helyseg.az

")->fetchAll();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>CRUD rendszer</title>
</head>
<body>
<h1>CRUD rendszer</h1>

<a class="letrehozas"
   href="index.php?oldal=crud&action=create">
   Új létrehozás
</a>
<hr>
<!-- ===================== LISTA ===================== -->
<?php if ($action == "list"): ?>
<?php
$stmt = $pdo->prepare("
    SELECT
        tavasz.sorszam,
        tavasz.indulas,
        tavasz.ar,
        szalloda.nev AS szalloda_nev,
        helyseg.nev AS helyseg_nev
    FROM tavasz
    JOIN szalloda
        ON tavasz.szalloda_az = szalloda.az
    JOIN helyseg
        ON szalloda.helyseg_az = helyseg.az
");

$stmt->execute();
$rows = $stmt->fetchAll();

?>

<table cellpadding="5">
    <tr>
        <th>Autómosó</th>
        <th>Város</th>
        <th>Időpont</th>
        <th>Ár</th>
        <th></th>
    </tr>

    <?php foreach ($rows as $r): ?>

    <tr>
        <td><?= $r['szalloda_nev'] ?></td>
        <td><?= $r['helyseg_nev'] ?></td>
        <td><?= $r['indulas'] ?></td>
        <td><?= $r['ar'] ?></td>
        <td>
            <a href="index.php?oldal=crud&action=edit&id=<?= $r['sorszam'] ?>">
                Szerkesztés
            </a>
            <a  class="szokoz" href="index.php?oldal=crud&action=delete&id=<?= $r['sorszam'] ?>"
               onclick="return confirm('Biztos törlöd?')">
               Törlés
            </a>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

<?php endif; ?>

<!-- ===================== CREATE ===================== -->

<?php if ($action == "create"): ?>

<h2>Új rekord</h2>

<?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form method="POST"
      action="index.php?oldal=crud&action=create">
    <label>Autómosó:</label>
    <select name="szalloda_az">
        <?php foreach ($szallodak as $sz): ?>
            <option value="<?= $sz['az'] ?>">
                <?= $sz['nev'] ?>
                (<?= $sz['varos'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <label>Időpont:</label>
    <input type="datetime-local"
           name="indulas">
    <br><br>
    <label>Ár:</label>
    <input type="number"
           name="ar">
    <br><br>
    <button type="submit">
        Mentés
    </button>
</form>

<?php endif; ?>

<!-- ===================== EDIT ===================== -->

<?php if ($action == "edit" && isset($row)): ?>

<h2>Szerkesztés</h2>

<form method="POST"
      action="index.php?oldal=crud&action=edit&id=<?= $id ?>">
    <label>Autómosó:</label>
    <select name="szalloda_az">
        <?php foreach ($szallodak as $sz): ?>
            <option value="<?= $sz['az'] ?>"
                <?= ($row['szalloda_az'] == $sz['az']) ? 'selected' : '' ?>>
                <?= $sz['nev'] ?>
                (<?= $sz['varos'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <label>Időpont:</label>
    <input type="datetime-local"
           name="indulas"
           value="<?= $row['indulas'] ?>">
    <br><br>
    <label>Ár:</label>
    <input type="number"
           name="ar"
           value="<?= $row['ar'] ?>">
    <br><br>
    <button type="submit">
        Mentés
    </button>
</form>
<?php endif; ?>
</body>
</html>
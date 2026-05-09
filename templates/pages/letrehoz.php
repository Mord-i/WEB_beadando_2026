<?php
include __DIR__ . "/../../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['szalloda_nev']) && !empty($_POST['helyseg_nev']) && !empty($_POST['indulas']) && !empty($_POST['ar'])) {

        $stmt = $pdo->prepare("
            INSERT INTO tavasz (szalloda_nev, helyseg_nev, indulas, ar)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $_POST['szalloda_nev'],
            $_POST['helyseg_nev'],
            $_POST['indulas'],
            $_POST['ar']
        ]);

        header("Location: index.php?oldal=crud");
        exit;
    } else {
        $error = "Minden mező kitöltése kötelező!";
    }
}
?>

<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="post">

    Szálloda neve: <input name="szalloda_nev"><br>
    Helység neve: <input name="helyseg_nev"><br>
    Indulás: <input type="date" name="indulas"><br>
    Ár: <input name="ar"><br>

    <button>Mentés</button>
</form>
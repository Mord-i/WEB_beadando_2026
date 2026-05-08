<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nev = trim($_POST["nev"]);
    $email = trim($_POST["email"]);
    $targy = trim($_POST["targy"]);
    $uzenet = trim($_POST["uzenet"]);

    $hibak = [];

    if ($nev == "") $hibak[] = "Név kötelező!";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $hibak[] = "Hibás email!";
    if ($targy == "") $hibak[] = "Tárgy kötelező!";
    if (strlen($uzenet) < 10) $hibak[] = "Üzenet túl rövid!";

    if (!empty($hibak)) {
        echo implode("<br>", $hibak);
        exit;
    }

    try {
        $dbh = new PDO("mysql:host=localhost;dbname=gyakorlat7", "root", "");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->prepare("INSERT INTO uzenetek (nev, email, targy, uzenet)
                               VALUES (?, ?, ?, ?)");

        $stmt->execute([$nev, $email, $targy, $uzenet]);

        header("Location: uzenetek.php");

    } catch (PDOException $e) {
        echo "Hiba: " . $e->getMessage();
    }
}
?>
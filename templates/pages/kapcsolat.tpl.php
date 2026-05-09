<?php
ob_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nev = trim($_POST["nev"]);
    $email = trim($_POST["email"]);
    $uzenet = trim($_POST["uzenet"]);

    $hibak = [];

    if ($nev == "")
        $hibak[] = "Név kötelező!";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $hibak[] = "Hibás email!";

    if (strlen($uzenet) < 3)
        $hibak[] = "Üzenet túl rövid!";

    if (empty($hibak)) {

        try {

            $dbh = new PDO(
                "mysql:host=localhost;dbname=gyakorlat7",
                "root",
                "",
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );

            $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

            $stmt = $dbh->prepare("
                INSERT INTO uzenetek (nev, email, uzenet)
                VALUES (?, ?, ?)
            ");

            $stmt->execute([$nev, $email, $uzenet]);

            echo "<script>window.location.href='index.php?uzenetek';</script>";
            exit;

        } catch (PDOException $e) {

            echo "Hiba: " . $e->getMessage();
        }

    } else {

        echo "<div style='color:red'>";

        foreach ($hibak as $hiba) {
            echo $hiba . "<br>";
        }

        echo "</div>";
    }
}
?>

<h1>Kapcsolat tartás velünk!</h1>
<h2>Írd meg kérdéseid és ,hogy mi jár a fejedben:)</h2>

<form method="post" action="">

    <label>Név:</label><br>
    <input type="text" name="nev"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Üzenet:</label><br>
    <textarea name="uzenet"></textarea><br><br>

    <button type="submit">Küldés</button>

</form>
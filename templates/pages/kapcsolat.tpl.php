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
            // 1. ADATOK BEÁLLÍTÁSA (Használd a már működő adataidat!)
            $host = "localhost"; 
            $db   = "adatbw";    // Nethelyes adatbázis név
            $user = "adatbw";    // Nethelyes felhasználónév
            $pass = "a1b2c3d4";  // Nethelyes jelszó

            // 2. KAPCSOLÓDÁS
            $dbh = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass,
                            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

            // 3. BESZÚRÁS
            $stmt = $dbh->prepare("
                INSERT INTO uzenetek (nev, email, uzenet)
                VALUES (:nev, :email, :uzenet)
            ");

            $stmt->execute([
                ':nev' => $nev, 
                ':email' => $email, 
                ':uzenet' => $uzenet
            ]);

            // Átirányítás a listázó oldalra
            echo "<script>window.location.href='index.php?oldal=uzenetek';</script>";
            exit;

        } catch (PDOException $e) {
            echo "Hiba: " . $e->getMessage();
        }

    } else {
        echo "<div style='color:red; font-weight:bold; margin-bottom:10px;'>";
        foreach ($hibak as $hiba) {
            echo "⚠️ " . $hiba . "<br>";
        }
        echo "</div>";
    }
}
?>

<h1>Kapcsolattartás velünk!</h1>
<h2>Írd meg kérdéseid, és hogy mi jár a fejedben! :)</h2>

<form method="post" action="">

    <label>Név:</label><br>
    <input type="text" name="nev" value="<?= isset($nev) ? htmlspecialchars($nev) : '' ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"><br><br>

    <label>Üzenet:</label><br>
    <textarea name="uzenet" rows="5" style="width:100%; max-width:400px;"><?= isset($uzenet) ? htmlspecialchars($uzenet) : '' ?></textarea><br><br>

    <button type="submit" style="padding:10px 20px; cursor:pointer;">Küldés</button>

</form>
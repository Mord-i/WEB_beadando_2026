<?php
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo'])) {
    try {
        // 1. ADATOK BEÁLLÍTÁSA (Használd a már működő CRUD/Regisztráció adatait!)
        $host = "localhost"; 
        $db   = "adatbw";    // Nethelyes adatbázis név
        $user = "adatbw";    // Nethelyes felhasználónév
        $pass = "a1b2c3d4";  // Nethelyes jelszó

        // 2. KAPCSOLÓDÁS
        // Dupla idézőjel kell a változók behelyettesítéséhez!
        $dbh = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass,
                        array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // 3. FELHASZNÁLÓ KERESÉSE
        // Fontos: a sha1(:jelszo) csak akkor működik, ha regisztrációnál is sha1-el mentettél!
        $sqlSelect = "SELECT id, csaladi_nev, uto_nev FROM felhasznalok WHERE bejelentkezes = :bejelentkezes AND jelszo = sha1(:jelszo)";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(
            ':bejelentkezes' => $_POST['felhasznalo'], 
            ':jelszo'        => $_POST['jelszo']
        ));
        
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            // SIKERES BELÉPÉS
            $_SESSION['csn'] = $row['csaladi_nev']; 
            $_SESSION['un'] = $row['uto_nev']; 
            $_SESSION['login'] = $_POST['felhasznalo'];
            
            // Visszairányítás a főoldalra
            header("Location: .");
            exit();
        }
        else {
            // SIKERTELEN BELÉPÉS
            $errormessage = "Hibás felhasználónév vagy jelszó!";
        }
    }
    catch (PDOException $e) {
        $errormessage = "Hiba: " . $e->getMessage();
    }      
}
else {
    // Ha nem küldtek adatokat, visszaugrik a főoldalra
    header("Location: .");
    exit();
}
?>
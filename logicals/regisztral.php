<?php
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['utonev'])) {
    try {
        // 1. ADATOK BEÁLLÍTÁSA (Nethely adatai)
        $host = "localhost"; 
        $db   = "adatbw";    // Ellenőrizd a Nethelyen, hogy kell-e elé prefix!
        $user = "adatbw";    
        $pass = "a1b2c3d4";  

        // 2. KAPCSOLÓDÁS 
        // Dupla idézőjelet használunk (" "), hogy a változók behelyettesítődjenek!
        // A végén a 'root' és '' helyett a $user és $pass változókat adjuk át.
        $dbh = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass,
                        array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        
        // Magyar ékezetek beállítása
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // 3. LÉTEZIK MÁR A FELHASZNÁLÓ?
        $sqlSelect = "SELECT id FROM felhasznalok WHERE bejelentkezes = :bejelentkezes";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo']));
        
        if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $uzenet = "A felhasználói név már foglalt!";
            $ujra = true;
        }
        else {
            // 4. REGISZTRÁCIÓ (Beszúrás)
            // Figyelj rá, hogy az adatbázisodban csaladi_nev és uto_nev az oszlopok neve!
            $sqlInsert = "INSERT INTO felhasznalok(id, csaladi_nev, uto_nev, bejelentkezes, jelszo)
                          VALUES(0, :csaladinev, :utonev, :bejelentkezes, :jelszo)";
            
            $stmt = $dbh->prepare($sqlInsert); 
            $stmt->execute(array(
                ':csaladinev'  => $_POST['vezeteknev'], 
                ':utonev'      => $_POST['utonev'],
                ':bejelentkezes' => $_POST['felhasznalo'], 
                ':jelszo'      => sha1($_POST['jelszo']) // SHA1 titkosítás
            )); 
            
            if($stmt->rowCount()) {
                $newid = $dbh->lastInsertId();
                $uzenet = "A regisztrációja sikeres.<br>Azonosítója: {$newid}";                     
                $ujra = false;
            }
            else {
                $uzenet = "A regisztráció nem sikerült.";
                $ujra = true;
            }
        }
    }
    catch (PDOException $e) {
        // Ha hiba van a kapcsolódásban vagy az SQL-ben, itt írja ki
        $uzenet = "Hiba: " . $e->getMessage();
        $ujra = true;
    }      
}
else {
    // Ha nem a formon keresztül érkeztek ide, visszaugrik a főoldalra
    header("Location: .");
    exit;
}
?>
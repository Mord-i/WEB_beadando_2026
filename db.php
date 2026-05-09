<?php
// 1. ADATOK BEÁLLÍTÁSA (A Nethely admin felületéről)
$host = "localhost";             // Ha a Nethely ezt írja az adminon
$db   = "adatbw";    // A Nethely-s adatbázis neved (prefix-szel!)
$user = "adatbw";    // A Nethely-s felhasználóneved (prefix-szel!)
$pass = "a1b2c3d4";     // Amit ott megadtál jelszónak

// 2. CSATLAKOZÁS
try {
    // A DSN-ben CSAK a host, dbname és charset van!
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    // A user és a pass külön, vesszővel elválasztva jön:
    $pdo = new PDO($dsn, $user, $pass);
    // Hibakezelés bekapcsolása (hogy lásd, ha baj van)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Ha nem sikerül, kiírja miért nem (pl. rossz jelszó)
    die("Adatbázis hiba: " . $e->getMessage());
}
?>
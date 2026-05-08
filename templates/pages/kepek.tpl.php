<?php
    // Alkalmazás logika:
    include('C:\xampp\htdocs\WEB_beadando_2026\includes\config.inc.php');
    
    // adatok összegyűjtése:    
    $kepek = array();
    $olvaso = opendir($MAPPA);
    while (($fajl = readdir($olvaso)) !== false)
        if (is_file($MAPPA.$fajl)) {
            $vege = strtolower(substr($fajl, strlen($fajl)-4));
            if (in_array($vege, $TIPUSOK))
                $kepek[$fajl] = filemtime($MAPPA.$fajl);            
        }
    closedir($olvaso);
    
    // Megjelenítés logika:
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Galéria</title>
    <link rel="stylesheet" href="./styles/stilus.css" type="text/css">
</head>
<body>
    <h1 id="alahuz">Galéria:</h1>
    <h2>Feltöltés a galériába:</h2>
<?php
    if (!empty($uzenet))
    {
        echo '<ul>';
        foreach($uzenet as $u)
            echo "<li>$u</li>";
        echo '</ul>';
    }
?>
<?php
include('C:\xampp\htdocs\WEB_beadando_2026\includes\config.inc.php');;
$uzenet = array();
// FÁJL FELTÖLTÉS
if (isset($_POST['kuld'])) {

    foreach ($_FILES as $fajl) {

        if ($fajl['error'] == 4) {
            continue;
        }

        elseif (!in_array($fajl['type'], $MEDIATIPUSOK)) {
            $uzenet[] = "Nem megfelelő típus: " . $fajl['name'];
        }

        elseif (
            $fajl['error'] == 1 ||
            $fajl['error'] == 2 ||
            $fajl['size'] > $MAXMERET
        ) {
            $uzenet[] = "Túl nagy fájl: " . $fajl['name'];
        }
        else {
            $vegsohely = $MAPPA . strtolower($fajl['name']);
            if (file_exists($vegsohely)) {
                $uzenet[] = "Már létezik: " . $fajl['name'];
            }
            else {
                move_uploaded_file(
                    $fajl['tmp_name'],
                    $vegsohely
                );
                $uzenet[] = "Sikeres feltöltés: " . $fajl['name'];
            }
        }
    }
}
    // KÉPEK BEOLVASÁSA
$kepek = array();
$olvas = opendir($MAPPA);
while (($fajl = readdir($olvas)) !== false) {
    if (
        $fajl != "." &&
        $fajl != ".."
    ) {
        $eleres = $MAPPA . $fajl;
        $kepek[$fajl] = filemtime($eleres);
    }
}
closedir($olvas);
arsort($kepek);
    // Megjelenítés logika:
?>
    <form action="" method="post"
        enctype="multipart/form-data">
        <input type="file" name="kep" required>
        <input type="submit" name="kuld" value="Feltöltés">
      </form>    
    <div id="galeria">
    <?php
    arsort($kepek);
    foreach($kepek as $fajl => $datum)
    {
    ?>
        <div class="kep">
            <a href="<?php echo $MAPPA.$fajl ?>">
                <img src="<?php echo $MAPPA.$fajl ?>">
            </a>            
            <p>Név:  <?php echo $fajl; ?></p>
            <p>Dátum:  <?php echo date($DATUMFORMA, $datum); ?></p>
        </div>
    <?php
    }
    ?>
    </div>
</body>
</html>
<?php
include __DIR__ . "/../../db.php";

$stmt = $pdo->query("
    SELECT 
        tavasz.sorszam,
        tavasz.indulas,
        tavasz.ar,
        szalloda.nev AS szalloda_nev,
        helyseg.nev AS helyseg_nev
    FROM tavasz
    JOIN szalloda ON tavasz.szalloda_az = szalloda.az
    JOIN helyseg ON szalloda.helyseg_az = helyseg.az    
");

$lista = $stmt->fetchAll();
?>
<a class="letrehozas" href="index.php?oldal=letrehoz">
    Új adatsor hozzáadása
</a>

<br><br>
<table>
<tr>
    <th>Autómosó</th>
    <th>Város</th>
    <th>Időpont</th>
    <th>Ár</th>
    <th></th>
</tr>

<?php foreach($lista as $s): ?>
<tr>
    <td><?= $s['szalloda_nev'] ?></td>
    <td><?= $s['helyseg_nev'] ?></td>
    <td><?= $s['indulas'] ?></td>
    <td><?= $s['ar'] ?></td>
    <td>
        <a href="index.php?oldal=szerkesztes&id=<?= $s['sorszam'] ?>">Szerkeszt</a>
        <a href="index.php?oldal=torol&id=<?= $s['sorszam'] ?>">Töröl</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
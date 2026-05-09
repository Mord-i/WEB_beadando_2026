<?php
include "db.php";

$stmt = $pdo->query("
SELECT 
    tavasz.sorszam,
    helyseg.nev AS helyseg_nev,
    szalloda.nev AS szalloda_nev,
    tavasz.indulas,
    tavasz.ar
FROM tavasz
JOIN szalloda ON tavasz.szalloda_az = szalloda.az
JOIN helyseg ON szalloda.helyseg_az = helyseg.az
");
?>

<h2>Autómósók Világszerte</h2>

<h3><a href="letrehoz.php" class="idopont">+ Új időpont foglalás</a></h3>

<table>
<tr>
    <th>Város</th>
    <th>Autómosó Neve</th>
    <th>Foglalás</th>
    <th>Ár</th>
    <th></th>
</tr>

<?php while($row = $stmt->fetch()): ?>
<tr>
    <td><?= $row['helyseg_nev'] ?></td>
    <td><?= $row['szalloda_nev'] ?></td>
    <td><?= $row['indulas'] ?></td>
    <td><?= $row['ar'] ?> Ft</td>
    <td>
        <a href="../../szerkesztes.php?id=...">=<?= $row['sorszam'] ?>">Szerkeszt</a>
        <a href="../../torol.php?id=<?= $row['sorszam'] ?>">Töröl</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
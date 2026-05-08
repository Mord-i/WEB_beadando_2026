<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Kapcsolat</title>
    <script src="kapcsolat.js" defer></script>
</head>
<body>

<h1>Kapcsolat</h1>

<form id="kapcsolatForm" method="POST" action="mentes.php">
    
    <label>Név:</label><br>
    <input type="text" name="nev" id="nev"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email" id="email"><br><br>

    <label>Üzenet:</label><br>
    <textarea name="uzenet" id="uzenet"></textarea><br><br>

    <button type="submit">Küldés</button>

</form>

<div id="hibak" style="color:red;"></div>
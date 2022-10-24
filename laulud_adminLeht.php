<?php
require_once ('conf.php');
global $yhendus;
// tabeli andmete lisamine

if(!empty($_REQUEST["uusnimi"])){

    $kask=$yhendus->prepare("INSERT INTO laulud(laulunimi, lisamisaeg) VALUES (?, NOW())");
    $kask->bind_param('s', $_REQUEST["uusnimi"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//peitmine
if(isset($_REQUEST['peitmine'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET avalik=0 Where id=?");
    $kask->bind_param('s', $_REQUEST['peitmine']);
    $kask->execute();
}
//naitamine
if(isset($_REQUEST['naitamine'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET avalik=1 Where id=?");
    $kask->bind_param('s', $_REQUEST['naitamine']);
    $kask->execute();
}

//delete
if(isset($_REQUEST['kustuta'])) {
    $kask = $yhendus->prepare("DELETE FROM laulud Where id=?");
    $kask->bind_param('s', $_REQUEST['kustuta']);
    $kask->execute();
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude adminleht</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav>
     <a href="homepage.php">Koduleht</a>
    <a href="laulud_adminLeht.php">Administreerimise leht</a>
    <a href="laulud.php">Kasutaja leht</a>
    <a href="link">Git HUB</a>
  </nav>
<h1>Laulude admin leht</h1>
<h2>Laulu lisamine</h2>
<form action="?" method="post">
    <label for="nimi">Laulunimi</label>
    <input type="text" name="uusnimi" id="nimi" placeholder="laulunimi">
    <input type="submit" value="Ok">
</form>


<table class="zigzag">
    <tr>
        <th></th>
        <th>Laulunimi</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>Staatus</th>
        <th>Haldus</th>
    </tr>
    <?php
    // tabeli sisu näitamine
    $kask=$yhendus->prepare('SELECT id, laulunimi, punktid, lisamisaeg, avalik 
FROM laulud');
    $kask->bind_result($id, $laulunimi, $punktid, $aeg, $avalik);
    $kask->execute();
    while($kask->fetch()){
        $seisund="Peidetud";
        $param="naitamine";
        $tekst="Näita";
        if($avalik==1){
            $seisund="Avatud";
            $param="peitmine";
            $tekst="Peida";
        }

        echo "<tr>";
        echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
        echo "<td>".htmlspecialchars($laulunimi)."</td>";
        echo "<td>$punktid</td>";
        echo "<td>$aeg</td>";
        echo "<td>".($seisund)."</td>";
        echo "<td><a href='?$param=$id'>$tekst</a></td>";


        echo "</tr>";
    }


    ?>

</table>
</body>
<?php
$yhendus->close();
// Ülesanne:
// Admin lehel - laulu kustutamine
// css table style
// Admin lehel -punktid nulliks
// Üldine Navigeerimismenüü / adminleht/ kasutajaleht
//<nav>
//    <a href="homepage.php">Koduleht</a>
//    <a href="laulud_adminLeht.php">Administreerimise leht</a>
//    <a href="laulud.php">Kasutaja leht</a>
//    <a href="link">Git HUB</a>
//</nav>
// Admin näeb kommentaarid ja saab neid kustutada
// Kasutaja ei saa lisada tühjad kommentaarid

// Homepage - Laulu lisamine --->alert(Laulu on lisatud) või kohe suunatakse Kasutaja lehele
?>
</html>


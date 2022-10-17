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


// punktide lisamine
if(isset($_REQUEST['haal'])) {
    $kask = $yhendus->prepare("UPDATE laulud SET punktid=punktid+1 Where id=?");
    $kask->bind_param('s', $_REQUEST['haal']);
    $kask->execute();
// aadressiriba sisu eemaldamine
    header("Location: $_SERVER[PHP_SELF]");
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Laulude leht</title>
</head>
<body>
<h1>Laulude leht</h1>
<h2>Laulu lisamine</h2>
<form action="?" method="post">
    <label for="nimi">Laulunimi</label>
    <input type="text" name="uusnimi" id="nimi" placeholder="laulunimi">
    <input type="submit" value="Ok">
</form>


<table>
    <tr>
        <th>Laulunimi</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>lisa punktid..</th>
    </tr>
    <?php
    // tabeli sisu näitamine
    $kask=$yhendus->prepare('SELECT id, laulunimi, punktid, lisamisaeg 
FROM laulud Where avalik=1');
    $kask->bind_result($id, $laulunimi, $punktid, $aeg);
    $kask->execute();
while($kask->fetch()){
    echo "<tr>";
    echo "<td>".htmlspecialchars($laulunimi)."</td>";
    echo "<td>$punktid</td>";
    echo "<td>$aeg</td>";
    echo "<td><a href='?haal=$id'>lisa +1 punkt</a></td>";
    echo "</tr>";
}


    ?>

</table>
</body>
<?php
$yhendus->close();
?>
</html>

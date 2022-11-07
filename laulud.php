<?php
require_once ('conf.php');
// sessiooni algus
session_start();
if(!isset($_SESSION['tuvastamine'])){
    header('Location: loginAB.php');
    exit();
}
global $yhendus;
// tabeli andmete lisamine
if(!empty($_REQUEST["uusnimi"])){

    $kask=$yhendus->prepare("INSERT INTO laulud(laulunimi, lisamisaeg) VALUES (?, NOW())");
    $kask->bind_param('s', $_REQUEST["uusnimi"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

// laulude kommenteerimine
if(isSet($_REQUEST['uus_komment'])){
    $kask=$yhendus->prepare("UPDATE laulud SET kommentaarid=Concat(kommentaarid, ?) 
              WHERE id=?");
        $lisakommentaar=$_REQUEST['komment']."\n"; // "\n" - murra teksti ridu
       $kask->bind_param("si", $lisakommentaar, $_REQUEST['uus_komment']);
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
<div>
    <p><?=$_SESSION["kasutaja"]?> on sisse logitud</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form>
</div>
<nav>
    <a href="homepage.php">Koduleht</a>
    <a href="laulud_adminLeht.php">Administreerimise leht</a>
    <a href="laulud.php">Kasutaja leht</a>
    <a href="link">Git HUB</a>
</nav>
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
        <th>Kommentaarid</th>
    </tr>
    <?php
    // tabeli sisu näitamine
    $kask=$yhendus->prepare('SELECT id, laulunimi, punktid, lisamisaeg, kommentaarid 
FROM laulud Where avalik=1');
    $kask->bind_result($id, $laulunimi, $punktid, $aeg, $kommentaarid);
    $kask->execute();
while($kask->fetch()){
    echo "<tr>";
    echo "<td>".htmlspecialchars($laulunimi)."</td>";
    echo "<td>$punktid</td>";
    echo "<td>$aeg</td>";
    echo "<td><a href='?haal=$id'>lisa +1 punkt</a></td>";
    echo "<td>".nl2br($kommentaarid)."</td>";//nl2br - break function before newlines in string
    echo "<td>
            <form action='?'>
            <input type='hidden' name='uus_komment' value='$id'>
            <input type='text' name='komment'>
            <input type='submit' value='OK'> 
            </form>
            </td>";
    echo "</tr>";
}


    ?>

</table>
</body>
<?php
$yhendus->close();
?>
</html>

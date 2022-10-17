<?php
require_once ('conf.php');
global $yhendus;
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
<table>
    <tr>
        <td>Laulunimi</td>
        <td>Punktid</td>
        <td>Lisamisaeg</td>
        <td>lisa punktid..</td>
    </tr>
    <?php
    // tabeli sisu näitamine
    $kask=$yhendus->prepare('SELECT id, laulunimi, punktid, lisamisaeg FROM laulud');
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

<?php
$serverinimi="localhost"; // d70420.mysql.zonevs.eu
$kasutaja="imerkulova21"; // d70420_merk21
$parool="123456"; // ''
$andmebaas="imerkulova21"; //d70420_merk21

$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);

$yhendus->set_charset('UTF8');

/*CREATE TABLE laulud(
id int primary key AUTO_INCREMENT,
laulunimi varchar(50),
lisamisaeg datetime,
punktid int Default 0,
kommentaarid text Default ' ',
avalik int DEFAULT 1)
)
  */
?>
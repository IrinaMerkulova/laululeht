<?php
$parool='irina';
$sool='vagavagatekst';
$krypt=crypt($parool, $sool);
echo $krypt;
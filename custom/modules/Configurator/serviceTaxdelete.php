<?php

//Anamika Khadwal ..For record deletion of Currrency Conversion

$recordID=$_REQUEST["record"];
require_once('custom/modules/Configurator/ServiceTax.php');
$lc = new ServiceTax();
$lc->markdeleted($recordID);

SugarApplication::redirect("index.php?module=Configurator&action=taxSettings&record=");

?>

<?php
require '../broker.php';
$broker = Broker::getBroker();

$rezultat = $broker->izmeni("insert into slikar(ime, prezime, godina_rodjenja, godina_smrti)" .
    " values ('" . $_POST['naziv'] . "','" . $_POST['prezime'] .
    "','" . $_POST['godina_rodjenja'] . "','" . $_POST['godina_smrti'] . "')");
echo json_encode($rezultat);

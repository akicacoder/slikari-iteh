<?php
require '../broker.php';
$broker = Broker::getBroker();

$rezultat = $broker->izmeni("update slikar set ime='" . $_POST['ime'] .
    "', prezime='" . $_POST['prezime'] . "', godina_rodjenja=" . $_POST['godina_rodjenja'] .
    ", godina_smrti=" . $_POST['godina_smrti'] . "  where id=" . $_POST['id']);
echo json_encode($rezultat);

<?php
require '../broker.php';



$broker = Broker::getBroker();
$naziv = $_POST['naziv'];
$pravac = $_POST['pravac'];
$slikar = $_POST['slikar'];
$slika = $_FILES['slika'];
$opis = $_POST['opis'];
$nazivSlike = $slika['name'];
$lokacija = "../../img/" . $nazivSlike;
if (!move_uploaded_file($_FILES['slika']['tmp_name'], $lokacija)) {
    $lokacija = "";
    echo json_encode([
        "status" => false,
        "error" => "Nije uspelo prebacivanje slike"
    ]);
} else {

    $lokacija = substr($lokacija, 4);
}

$rezultat = $broker->izmeni("insert into slika (naziv,opis,slikar,url,pravac) values" .
    " ('" . $naziv . "'," . $opis . "," . $slikar . ",'" . $lokacija . "'," . $pravac . ") ");
echo json_encode($rezultat);

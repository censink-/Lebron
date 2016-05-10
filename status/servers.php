<?php
//$db = mysqli_connect("192.27.70.133", "SYS4", "NCGrptGpAX68N4UL", "mc_status");

$xml = new XMLWriter();
$xml->openUri('php://output');
$xml->startDocument('1.0','UTF-8');
$xml->setIndent(4);
$xml->startElement('servers');
    $xml->startElement('server');
        $xml->writeAttribute('id', '1');
        $xml->writeElement('name', 'Main bungee');
        $xml->writeElement('active', 'false');
        $xml->writeElement('players', '398');
        $xml->writeElement('max_players', '750');
        $xml->writeElement('timestamp', '2015-3-6 13:13:13');
    $xml->endElement();
    $xml->startElement('server');
        $xml->writeAttribute('id', '2');
        $xml->writeElement('name', 'Main hub');
        $xml->writeElement('active', 'true');
        $xml->writeElement('players', '45');
        $xml->writeElement('max_players','250');
        $xml->writeElement('timestamp', '2015-3-6 13:13:09');
    $xml->endElement();
$xml->endElement();
$xml->endDocument();
$xml->flush();
?>
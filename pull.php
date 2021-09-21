<?

require 'db.php';

$db = new DBConnection('localhost', 'spybar', 'fullkamerer', 'spybar');

$sek = $db->fetch('SELECT id, name AS namn FROM sektioner');
$kam = $db->fetch('SELECT id, name AS namn, sektion, pengar FROM kamererer');
$kryss = $db->fetch('SELECT tag, kamerer, amount, device, ts FROM kryss');

print json_encode(array('sektioner' => $sek, 'kamererer' => $kam, 'kryss' => $kryss));


?>

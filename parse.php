<?

require 'db.php';
$db = new DBConnection('localhost', 'spybar', 'fullkamerer', 'spybar');

$f = file_get_contents("/tmp/test.json");
$json = json_decode($f);

$affected = 0;
foreach ($json->kryss as $kryss) {
    if (isset($kryss->device))
        $dev = $kryss->device;
    else
        $dev = "";
    $affected = $affected + $db->pquery('INSERT IGNORE INTO kryss (tag, kamerer, amount, ts, device) VALUES (?, ?, ?, ?, ?)',
        array('sssss', $kryss->tag, $kryss->kamerer, $kryss->amount, $kryss->ts, $dev));
}

if ($affected > 0) {
    echo "Ja jävlar! $affected nya kryss har synkroniserats!";
} else {
    echo "Ni super som kärringar. Inga nya kryss har synkroniserats.";
}

?>

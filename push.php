<?

require 'db.php';

$db = new DBConnection('localhost', 'spybar', 'fullkamerer', 'spybar');

//$json = $_POST['data'];
$json = $HTTP_RAW_POST_DATA;

/*$f = fopen("/tmp/test.json", "w");
fwrite($f, $json);
fclose($f);
die;*/

$json = json_decode($json);

$affected = 0;
foreach ($json->kryss as $kryss) {
    $affected = $affected + $db->pquery('INSERT IGNORE INTO kryss (tag, kamerer, amount, ts, device) VALUES (?, ?, ?, ?, ?)',
        array('sssss', $kryss->tag, $kryss->kamerer, $kryss->amount, $kryss->ts, $kryss->device));
}

if ($affected > 0) {
    echo "Ja jävlar! $affected nya kryss har synkroniserats!";
} else {
    echo "Ni super som kärringar. Inga nya kryss har synkroniserats.";
}

?>

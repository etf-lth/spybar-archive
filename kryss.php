<?

require 'db.php';

$db = new DBConnection('localhost', 'spybar', 'fullkamerer', 'spybar');

header('Content-Type: text/plain; charset=utf-8');

$kryss = $db->fetch('SELECT kamerer, amount, ts FROM kryss2012 ORDER BY ts');

foreach ($kryss as $k) {
    echo $k->ts . "\t" . $k->amount . "\t" . $k->kamerer . "\r\n";
}

$kryss = $db->fetch('SELECT kamerer, amount, ts FROM kryss ORDER BY ts');

foreach ($kryss as $k) {
    echo $k->ts . "\t" . $k->amount . "\t" . $k->kamerer . "\r\n";
}

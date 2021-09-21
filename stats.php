<?

require 'db.php';

$db = new DBConnection('localhost', 'spybar', 'fullkamerer', 'spybar');

header('Content-Type: text/plain; charset=utf-8');

if (isset($_GET['yr']) && $_GET['yr'] == 2012) {
    $year = 2012;
} else {
    $year = '';
}

$kamererer = $db->fetch('SELECT * from kamererer'.$year);

foreach ($kamererer as $kamerer) {
    $stat = $db->fetch_one('SELECT sum(amount) AS k from kryss'.$year.' where kamerer = ?', array("s", $kamerer->id));
    if ($stat->k) 
        echo "$kamerer->id\t$kamerer->name\t$stat->k\n";
}

$k = $db->fetch_one('select sum(amount) as k from kryss'.$year);
echo "\n\nTotalt $k->k kryss";

?>

<?

die;
require 'db.php';

$db = new DBConnection('localhost', 'spybar', 'fullkamerer', 'spybar');

for ($i=0; $i<50*100; $i++) {
    $db->pquery('INSERT IGNORE INTO kryss (tag, kamerer, amount, ts, device) VALUES (?, ?, ?, ?, ?)',
        array('sssss', md5($i), rand(1,50), 1, "1970-01-01", "void"));
}

?>

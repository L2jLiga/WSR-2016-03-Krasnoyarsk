<?PHP
require_once 'config.php';
$id = $_GET['id'];
$res = $db->query("DELETE FROM `goods` WHERE `id` = '$id'");

echo '����� ������� ������!';
?>
<a href="index.php">���������</a>
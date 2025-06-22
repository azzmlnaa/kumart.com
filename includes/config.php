<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ku_mart";


$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} /**else {
    echo "Koneksi berhasil!";
}**/

?>

<?php
/**include '../includes/config.php';**/


?>

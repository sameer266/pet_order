<?php
$conn=mysqli_connect('localhost','root','','pet_order');
if(!$conn){
    die("Could not connect to database");
}

?>
<?php
$host = "localhost";       // Database host
$user = "root";            // Database username
$password = "";            // Database password
$dbname = "pet_order";     // Database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

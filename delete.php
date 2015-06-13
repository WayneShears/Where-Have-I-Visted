<?php
include ('phpsqlajax_dbinfo.php');

$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to delete a record
$userid = $_SESSION['user'];
$markerid = $_GET["id"];
$sql = "DELETE FROM markers WHERE id='$markerid'";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

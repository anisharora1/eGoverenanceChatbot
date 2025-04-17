<?php
$suggestionConn = new mysqli("localhost", "root", "", "suggestions_db");
if ($suggestionConn->connect_error) {
    die("Connection failed: " . $suggestionConn->connect_error);
}
?>

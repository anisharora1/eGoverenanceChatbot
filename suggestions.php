<?php
require 'db_suggestions.php';

$q = $_GET['q'] ?? '';
$suggestions = [];

if ($q !== '') {
    $stmt = $suggestionConn->prepare("SELECT query FROM suggestions WHERE query LIKE CONCAT(?, '%') GROUP BY query ORDER BY MAX(created_at) DESC LIMIT 5");
    $stmt->bind_param("s", $q);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['query'];
    }
    $stmt->close();
}
echo json_encode($suggestions);
?>

<?php
// Assuming you have already established a database connection
include 'dbcon.php';

$department = $_GET['department'];

// Fetch voter list data based on the department
$stmt = $conn->prepare("SELECT name, regno, votepolling FROM voterlist WHERE departmentname = ?");
$stmt->bind_param("s", $department);
$stmt->execute();
$result = $stmt->get_result();

// Create CSV content
$csvContent = "Name,Register Number,Vote Polled\n";
while ($row = $result->fetch_assoc()) {
    $csvContent .= '"' . $row['name'] . '","' . $row['regno'] . '","' . ($row['votepolling'] == 1 ? 'Yes' : 'No') . '"' . "\n";
}

// Set the HTTP headers to force download the CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $department . '_voterlist.csv"');

// Output CSV content
echo $csvContent;
?>

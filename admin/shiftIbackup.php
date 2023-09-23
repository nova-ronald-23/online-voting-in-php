<?php
include 'dbcon.php';

if ($_GET['department']) {
    $department = $_GET['department'];

    $stmt_backup = $conn->prepare("SELECT name, regno, votepolling,departmentname FROM voterlist WHERE shift='I'");
    if ($stmt_backup === false) {
        die("Error in backup.php query: " . $conn->error);
    }

    // No need to bind parameters since we are not using dynamic parameters

    if (!$stmt_backup->execute()) {
        die("Error executing backup.php query: " . $stmt_backup->error);
    }

    $result_backup = $stmt_backup->get_result();

    // Generate CSV content
    $csvContent = "Name,Register Number,department name,Vote Polled\n";
    while ($row_backup = $result_backup->fetch_assoc()) {
        $csvContent .= '"' . $row_backup['name'] . '","' . $row_backup['regno'] . '","' .$row_backup['departmentname'].'","'.($row_backup['votepolling'] == 1 ? 'Yes' : 'No') . "\"\n";
    }

    // Reset vote polling status
    $reset_stmt = $conn->prepare("UPDATE voterlist SET votepolling = 0 WHERE shift='I'");
    if ($reset_stmt === false) {
        die("Error in reset query: " . $conn->error);
    }

    if (!$reset_stmt->execute()) {
        die("Error executing reset query: " . $reset_stmt->error);
    }

    // Set appropriate headers for CSV file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sI_backup.csv"');

    // Output CSV content
    echo $csvContent;
}
?>

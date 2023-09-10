<?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = 'upload/';
                        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
                        $fileType = $_FILES['file']['type'];
                
                        if ($fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                            // Move the uploaded file to the server
                            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                               
                include 'dbcon.php';
               
                
                
                require 'assets/vendor/PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadFile);
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow();

                
                                // Loop through each row in the Excel file and insert data into the database
                                for ($row = 2; $row <= $highestRow; $row++) {
                                    // Extract Excel data (assuming a specific order of columns)
                                    $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                                    $regno = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                                    $password = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                                    $departmentname = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                                    $shift = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                                    $userimage = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                                    $position = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                                    $votepolling = 0;
                                    $attences = 0;
                                    $nomenation = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                
                                    // Insert data into the database (replace 'voterlist' with your table name)
                                    $stmt = $conn->prepare("INSERT INTO voterlist (name, regno, password, departmentname, shift, userimage, position, votepolling, attences, nomenation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                    $stmt->bind_param("sssssssiis", $name, $regno, $password, $departmentname, $shift, $userimage, $position, $votepolling, $attences, $nomenation);
                
                                    if ($stmt->execute()) {
                                        echo "Student data inserted successfully.<br>";
                                    } else {
                                        echo "Error inserting student data: " . $stmt->error . "<br>";
                                    }
                
                                    $stmt->close();
                                }
                
                                // Close the database connection
                                $conn->close();
                
                                // Delete the uploaded file
                                unlink($uploadFile);
                
                                echo "Data from Excel file inserted successfully.";
                            } else {
                                echo "Error uploading Excel file.<br>";
                            }
                        } else {
                            echo "Unsupported file format. Please upload an Excel (XLSX) file.<br>";
                        }
                    } else {
                        echo "Invalid file upload.<br>";
                    }
                }
                ?>
                
 setTimeout(function() {
    window.location.href = "login.php"; 
}, 2000); 
?>
               
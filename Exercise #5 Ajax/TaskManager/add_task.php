<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {                    //pang check kung may laman yung fields
    $taskName = htmlspecialchars(trim($_POST['taskName']));     // yung htmlspeci.. nandyan yan para hindi malagayan ng hacking script yung fields
    $startDate = htmlspecialchars(trim($_POST['startDate']));  
    $endDate = htmlspecialchars(trim($_POST['endDate']));

    if (empty($taskName) || empty($startDate) || empty($endDate)) { 
        echo json_encode(['success' => false, 'message' => 'All fields are required.']); 
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Task added successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>

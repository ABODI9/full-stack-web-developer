<?php
session_start();
include 'action.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];

    // ✅ Update task status to "Completed"
    $sql = "UPDATE tasks SET status = 'Completed' WHERE task_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);

    if ($stmt->execute()) {
        header("Location: view_tasks.php"); // ✅ Redirect to the task list
        exit();
    } else {
        echo "<script>alert('Error updating task status');</script>";
    }
}
?>

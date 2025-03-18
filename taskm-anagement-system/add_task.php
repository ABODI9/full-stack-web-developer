<?php
session_start();
include 'action.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Current logged-in user

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assigned_user_id = $_POST['assigned_user']; // Get the selected user ID
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];

    // Insert task with assigned user_id
    $sql = "INSERT INTO tasks (user_id, title, description, priority, due_date, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $assigned_user_id, $title, $description, $priority, $due_date);

    if ($stmt->execute()) {
        header('Location: view_tasks.php'); // Redirect to tasks list
        exit();
    } else {
        echo "<script>alert('Error adding task: " . $stmt->error . "');</script>";
    }
}

// Fetch all users for the dropdown
$userQuery = "SELECT id, username FROM users";
$userResult = $conn->query($userQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Task</h2>
    <form action="add_task.php" method="post">
        <div class="mb-3">
            <label for="assigned_user" class="form-label">Assign to User</label>
            <select class="form-select" id="assigned_user" name="assigned_user" required>
                <option value="" disabled selected>Select a user</option>
                <?php while ($user = $userResult->fetch_assoc()): ?>
                    <option value="<?= $user['id']; ?>"><?= htmlspecialchars($user['username']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select class="form-select" id="priority" name="priority">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

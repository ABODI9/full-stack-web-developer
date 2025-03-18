<?php
session_start();
include 'action.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// ✅ Fetch only tasks assigned to the logged-in user
$query = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasksResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">My Assigned Tasks</h2>

    <a href="add_task.php" class="btn btn-primary mb-3">Add New Task</a>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
    <a href="view.php" class="btn btn-warning">Home</a>

    <?php if ($tasksResult->num_rows > 0): ?>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($task = $tasksResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['title']); ?></td>
                        <td><?= htmlspecialchars($task['description']); ?></td>
                        <td><?= htmlspecialchars($task['priority']); ?></td>
                        <td><?= htmlspecialchars($task['due_date']); ?></td>
                        <td><?= htmlspecialchars($task['status']); ?></td>
                        <td>
                            <a href="edit_task.php?task_id=<?= $task['task_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_task.php?task_id=<?= $task['task_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="alert alert-info">No tasks found.</p>
    <?php endif; ?>

</body>
</html>

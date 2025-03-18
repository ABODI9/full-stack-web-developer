<?php
session_start();
include 'action.php'; // Database connection

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Logged-in user ID

// Ensure task_id is received
if (!isset($_GET['task_id'])) {
    echo "<script>alert('No task selected.'); window.location.href='view_tasks.php';</script>";
    exit();
}

$task_id = $_GET['task_id'];

// ✅ Fetch task details (No user filter to allow reassignment)
$query = "SELECT * FROM tasks WHERE task_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Task not found.'); window.location.href='view_tasks.php';</script>";
    exit();
}

$task = $result->fetch_assoc();

// ✅ Fetch all users for reassignment dropdown
$userQuery = "SELECT id, username FROM users";
$userResult = $conn->query($userQuery);

// ✅ Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];
    $new_user_id = $_POST['assigned_user']; // New owner of the task

    if (!empty($title) && !empty($description) && !empty($priority) && !empty($due_date) && !empty($status)) {
        // ✅ Update task with new owner
        $updateQuery = "UPDATE tasks SET title = ?, description = ?, priority = ?, due_date = ?, status = ?, user_id = ? WHERE task_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssiii", $title, $description, $priority, $due_date, $status, $new_user_id, $task_id);

        if ($stmt->execute()) {
            echo "<script>alert('Task updated successfully!'); window.location.href='view_tasks.php';</script>";
        } else {
            echo "<script>alert('Error updating task: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Edit Task</h2>
    
    <form action="" method="post" class="card p-4 shadow">
        <div class="mb-3">
            <label for="title" class="form-label">Task Title:</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($task['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Task Description:</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($task['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority:</label>
            <select name="priority" class="form-select">
                <option value="High" <?= ($task['priority'] == 'High') ? 'selected' : ''; ?>>High</option>
                <option value="Medium" <?= ($task['priority'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                <option value="Low" <?= ($task['priority'] == 'Low') ? 'selected' : ''; ?>>Low</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date:</label>
            <input type="date" name="due_date" class="form-control" value="<?= $task['due_date']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" class="form-select">
                <option value="Pending" <?= ($task['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Completed" <?= ($task['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
            </select>
        </div>

        <!-- ✅ Reassign Task to Another User -->
        <div class="mb-3">
            <label for="assigned_user" class="form-label">Assign to User:</label>
            <select name="assigned_user" class="form-select">
                <?php while ($user = $userResult->fetch_assoc()): ?>
                    <option value="<?= $user['id']; ?>" <?= ($task['user_id'] == $user['id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($user['username']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Task</button>
        <a href="view_tasks.php" class="btn btn-secondary">Cancel</a>
    </form>

</body>
</html>

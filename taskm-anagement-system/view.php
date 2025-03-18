<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'action.php';
include 'header.php';

// ✅ Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

echo "<h1>Welcome, " . htmlspecialchars($_SESSION["username"]) . "!</h1>";

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-bordered'>";
    echo "<tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";

        // ✅ Show action buttons only for the logged-in user
        echo "<td>";
        if ($row["id"] == $user_id) {
            echo "<a href='logout.php' class='btn btn-danger mb-3'>Logout</a> ";
            echo "<a href='update.php?id=" . $row["id"] . "' class='btn btn-warning'>Update</a> ";
            echo "<a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger'>Delete</a> ";
            echo "<a href='add_task.php' class='btn btn-primary mb-3'>+ Add New Task</a> ";
            echo "<a href='view_tasks.php' class='btn btn-primary'>View Tasks</a>";
        }
        echo "</td>";
        
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No user found</p>";
}

// ✅ Fetch tasks for the logged-in user only
$taskQuery = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $conn->prepare($taskQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasksResult = $stmt->get_result();

echo "<h2>My Tasks</h2>";

if ($tasksResult->num_rows > 0) {
    echo "<table class='table table-striped'>";
    echo "<tr>
            <th>Title</th>
            <th>Description</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Actions</th>
          </tr>";

    while ($task = $tasksResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($task['title']) . "</td>";
        echo "<td>" . htmlspecialchars($task['description']) . "</td>";
        echo "<td>" . htmlspecialchars($task['priority']) . "</td>";
        echo "<td>" . htmlspecialchars($task['due_date']) . "</td>";
        echo "<td>
                <a href='edit_task.php?task_id=" . $task['task_id'] . "' class='btn btn-info'>Edit</a> 
                <a href='delete_task.php?task_id=" . $task['task_id'] . "' class='btn btn-danger'>Delete</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No tasks found</p>";
}
?>

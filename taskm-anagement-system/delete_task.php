<?php
session_start();
include 'action.php'; // الاتصال بقاعدة البيانات

// تحقق مما إذا كان المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // معرف المستخدم من الجلسة

// التحقق من وجود `task_id` في الرابط
if (!isset($_GET['task_id'])) {
    echo "<script>alert('No task selected.'); window.location.href='view_tasks.php';</script>";
    exit();
}

$task_id = $_GET['task_id'];

// التحقق من أن المهمة تخص المستخدم الحالي قبل الحذف
$query = "DELETE FROM tasks WHERE task_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $task_id, $user_id);

if ($stmt->execute()) {
    echo "<script>alert('Task deleted successfully!'); window.location.href='view_tasks.php';</script>";
} else {
    echo "<script>alert('Error deleting task: " . $conn->error . "');</script>";
}
?>

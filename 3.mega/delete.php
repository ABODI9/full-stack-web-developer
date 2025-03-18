<?php

include 'action.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id=?";
    $bit = $conn->prepare($sql);
    $bit->bind_param("i", $id);

    if ($bit->execute()) {
        header("Location:view.php");
    } else {
        print "error 505";
    }
}

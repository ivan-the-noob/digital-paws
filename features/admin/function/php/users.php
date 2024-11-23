<?php
include '../../../../db.php';

$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            echo "<tr>";
            echo "<td>$count</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";

            echo "<td>";
            echo "<form action='../../function/php/delete_user.php' method='POST'>"; 
            echo "<input type='hidden' name='user_id' value='" . $id . "' />"; 
            echo "<input type='submit' value='Delete' class='btn btn-danger' />";
            echo "</form>";
            echo "</td>";

            echo "</tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='4'>No users found</td></tr>";
    }
    $result->free();
}
?>

<!-- Include SweetAlert -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('msg');

    if (message) {
        if (message === "User deleted successfully") {
            swal("Success!", message, "success");
        } else if (message === "Error deleting user") {
            swal("Error!", message, "error");
        }
    }
</script>

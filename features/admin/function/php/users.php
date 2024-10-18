<?php
include '../../../../db.php';

// Update the SQL query to select from the 'users' table
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

            // Add Delete button
            echo "<td>";
            echo "<form action='../../function/php/delete_user.php' method='POST'>"; // Assuming you have a delete_user.php file
            echo "<input type='hidden' name='user_id' value='" . $id . "' />"; // Change to user_id
            echo "<input type='submit' value='Delete' class='btn btn-danger' />";
            echo "</form>";
            echo "</td>";

            echo "</tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='4'>No users found</td></tr>"; // Adjust colspan to 4 for the new column
    }
    $result->free();
}
?>

<!-- Include SweetAlert -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
    // Check for the 'msg' parameter in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('msg');

    if (message) {
        // Use SweetAlert to display the message
        if (message === "User deleted successfully") {
            swal("Success!", message, "success");
        } else if (message === "Error deleting user") {
            swal("Error!", message, "error");
        }
    }
</script>

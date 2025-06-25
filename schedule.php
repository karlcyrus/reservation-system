<?php
// 1. Connect to the database using PDO
include 'db_connection.php';

$editing = false;
$edit_data = [];

// 2. Check if we're editing a specific reservation
if (isset($_GET['edit_id'])) {
    $editing = true;
    $edit_id = $_GET['edit_id'];

    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

// 3. Insert or update form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $pet_name = $_POST['pet_name'];
    $service = $_POST['service'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $contact = $_POST['contact'];

    if (isset($_POST['edit_id'])) {
        // Update existing reservation
        $edit_id = $_POST['edit_id'];
        $sql = "UPDATE reservations SET customer_name=?, pet_name=?, service=?, reservation_date=?, reservation_time=?, contact=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$customer_name, $pet_name, $service, $reservation_date, $reservation_time, $contact, $edit_id]);
    } else {
        // Insert new reservation
        $sql = "INSERT INTO reservations (customer_name, pet_name, service, reservation_date, reservation_time, contact)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$customer_name, $pet_name, $service, $reservation_date, $reservation_time, $contact]);
    }

    // Redirect to avoid form resubmission
    header("Location: schedule.php");
    exit();
}

// 4. Fetch all reservations
$reservations = [];
$sql = "SELECT * FROM reservations ORDER BY reservation_date, reservation_time";
$stmt = $conn->query($sql);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close connection
$conn = null;
?>


<!-- HTML starts here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="schedule.css">
    <title>Reservation Schedule</title>
</head>
<body>
    <div class="hp_background"> 
        <div class="form_container">
            <h1>Pet Grooming Reservation Form</h1>
            <form method="POST" action="schedule.php" class="reservation_form">
                <?php if ($editing): ?>
                    <input type="hidden" name="edit_id" value="<?= $edit_data['id'] ?>">
                <?php endif; ?>

                <div class="form_input">
                    <label for="customer_name">Your Name:</label>
                    <input type="text" id="customer_name" name="customer_name" value="<?= $editing ? htmlspecialchars($edit_data['customer_name']) : '' ?>" required>
                </div>

                <div class="form_input">
                    <label for="pet_name">Pet Name:</label>
                    <input type="text" id="pet_name" name="pet_name" value="<?= $editing ? htmlspecialchars($edit_data['pet_name']) : '' ?>" required>
                </div>

                <div class="form_input">
                    <label for="service">Service:</label>
                    <select id="service" name="service" required>
                        <?php
                        $services = ['Select Option','Bath', 'Haircut', 'Nail Trimming', 'Full Grooming'];
                        foreach ($services as $svc):
                        ?>
                            <option value="<?= $svc ?>" <?= $editing && $edit_data['service'] == $svc ? 'selected' : '' ?>>
                                <?= $svc ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form_input">
                    <label for="reservation_date">Date:</label>
                    <input type="date" id="reservation_date" name="reservation_date" value="<?= $editing ? $edit_data['reservation_date'] : '' ?>" required>
                </div>

                <div class="form_input">
                    <label for="reservation_time">Time:</label>
                    <input type="time" id="reservation_time" name="reservation_time" value="<?= $editing ? $edit_data['reservation_time'] : '' ?>" required>
                </div>

                <div class="form_input">
                    <label for="contact">Contact Info:</label>
                    <input type="text" id="contact" name="contact" value="<?= $editing ? htmlspecialchars($edit_data['contact']) : '' ?>" required>
                </div>  

                <input type="submit" value="<?= $editing ? 'Update Reservation' : 'Reserve Now' ?>">
            </form>
        </div>

        <div class="table_container">
            <h1>Schedule Records</h1>
                <form method="GET" action="schedule.php" class="new_btn">
                    <button type="submit" class="new_button">New</button>
                </form>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Pet Name</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Contact</th>
                    <th>Status</th>
                </tr>

                <?php foreach ($reservations as $res): ?>
                <tr>
                    <td><?= htmlspecialchars($res['customer_name']) ?></td>
                    <td><?= htmlspecialchars($res['pet_name']) ?></td>
                    <td><?= htmlspecialchars($res['service']) ?></td>
                    <td><?= htmlspecialchars($res['reservation_date']) ?></td>
                    <td><?= htmlspecialchars($res['reservation_time']) ?></td>
                    <td><?= htmlspecialchars($res['contact']) ?></td>
                    <td>
                        <form method="GET" action="schedule.php" style="display:inline;">
                            <input type="hidden" name="edit_id" value="<?= $res['id'] ?>">
                            <button type="submit" class="form_button">UPDATE</button>
                        </form>

                        <form action="delete.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $res['id'] ?>">
                            <button type="submit" class="form_button" onclick="return confirm('Are you sure you want to delete this reservation?');">DELETE</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>

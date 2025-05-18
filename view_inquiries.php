<?php
// Connect to DB
$conn = new mysqli("localhost", "root", "", "pet_adoption");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all entries
$sql = "SELECT * FROM inquiries ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submitted Inquiries</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0fdf4;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #2e7d32;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 128, 0, 0.1);
    }

    th, td {
      padding: 12px;
      border: 1px solid #c8e6c9;
      text-align: left;
    }

    th {
      background-color: #a5d6a7;
      color: #1b5e20;
    }

    tr:hover {
      background-color: #f1f8e9;
    }

    img {
      max-width: 100px;
      height: auto;
    }
  </style>
</head>
<body>
  <h2>Submitted Adoption Inquiries</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Address</th>
      <th>Gmail</th>
      <th>Pet Type</th>
      <th>Breed</th>
      <th>Description</th>
      <th>Image</th>
      <th>Submitted</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['fullName']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['address']) ?></td>
          <td><?= htmlspecialchars($row['gmail']) ?></td>
          <td><?= htmlspecialchars($row['petType']) ?></td>
          <td><?= htmlspecialchars($row['petBreed']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
          <td>
            <?php if (!empty($row['imagePath'])): ?>
              <img src="<?= htmlspecialchars($row['imagePath']) ?>" alt="Image">
            <?php else: ?>
              No Image
            <?php endif; ?>
          </td>
          <td><?= $row['submitted_at'] ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="11" style="text-align:center;">No entries found.</td></tr>
    <?php endif; ?>

  </table>

</body>
</html>

<?php $conn->close(); ?>

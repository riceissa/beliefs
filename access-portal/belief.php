<?php

include_once("backend/globalVariables/passwordFile.inc");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>

<p>Belief:
<?= htmlspecialchars($_REQUEST['text']) ?>
</p>

<p>Here are the users who have expressed their opinion on this belief:</p>

<table>
  <thead>
    <tr>
      <th>Username</th>
      <th>Likert response</th>
      <th>Confidence</th>
    </tr>
  </thead>
  <tbody>

<?php
$query = "select * from beliefs where belief_text = ?";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $_REQUEST['text']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
?>

    <td><?= ($row['username'] ?? '') ? '<a href="/user.php?username=' . urlencode($row['username']) . '">' . $row['username'] . '</a>' : 'N/A' ?></td>
    <td><?= $row['likert_response'] ?></td>
    <td><?= $row['confidence'] ?></td>

<?php
    }
}

?>

</body>
</html>

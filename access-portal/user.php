<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>
<nav><a href="/index.php">Home</a>,
    <a href="/faq.php">FAQ</a>,
    <a href="/belief.php">Beliefs</a>,
    <a href="/user.php">Users</a>;
    <?= $_SESSION['user'] ? 'You are signed in as <a href="' . urlencode($_SESSION['user']) . '">' . $_SESSION['user'] . '</a>' : "You are not signed in" ?>
</nav>


<h1>Beliefs repo for <?= $_REQUEST['username'] ?></h1>

<table>
  <thead>
    <tr>
      <th>Belief</th>
      <th>Likert response</th>
      <th>Confidence</th>
    </tr>
  </thead>
  <tbody>

<?php

include_once("backend/globalVariables/passwordFile.inc");

$query = 'select * from beliefs where username = ?';
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $_REQUEST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    print $mysqli->affected_rows;
    while ($row = $result->fetch_assoc()) {
?>

<tr>
    <td><a href="/belief.php?text=<?= urlencode($row['belief_text']) ?>"><?= $row['belief_text'] ?? 'N/A' ?></a></td>
    <td><?= $row['likert_response'] ?></td>
    <td><?= $row['confidence'] ?></td>
</tr>

<?php
    }
}

?>
  </tbody>
</table>

</body>
</html>

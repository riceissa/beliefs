<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>

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
    <td><?= $row['belief_text'] ?? 'N/A' ?></td>
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

<?php session_start();
include_once("backend/globalVariables/passwordFile.inc");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
    <?php include("table_styling.inc") ?>
</head>

<body>
<?php include('navbar.inc') ?>

<?php if ($_REQUEST['username']) { ?>

<h1>Beliefs repo for <?= $_REQUEST['username'] ?></h1>

<table>
  <thead>
    <tr>
      <th>Belief</th>
      <th>Likert response</th>
      <th>Confidence</th>
      <th>Probability</th>
      <th>Probability lower bound</th>
      <th>Probability upper bound</th>
      <th>Belief held on</th>
      <th>Belief expressed on</th>
      <th>Belief entered on</th>
      <th>Works consumed</th>
      <th>Notes</th>
    </tr>
  </thead>
  <tbody>

<?php


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
    <td><?= $row['likert_response'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['confidence'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['probability_point_estimate'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['probability_lower_bound'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['probability_upper_bound'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['belief_date'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['belief_expression_date'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['belief_entry_date'] ?? '&ndash;' ?></td>
    <td><?= $row['works_consumed'] ?? '&ndash;' ?></td>
    <td><?= $row['notes'] ?? '&ndash;' ?></td>
</tr>

<?php
    }
}

?>
  </tbody>
</table>

<?php } else { ?>

<h1>Users on this site</h1>

<?php
$query = 'select distinct(username) as username, count(*) numBeliefs, count(distinct belief_text) as numDistinctBeliefs from beliefs group by username';
if ($stmt = $mysqli->prepare($query)) {
    $stmt->execute();
    $result = $stmt->get_result();
?>

<p>There are <?= $mysqli->affected_rows ?> users on this site:</p>

<table>
<thead>
    <tr>
        <th>Username</th>
        <th>Total beliefs</th>
        <th>Total distinct beliefs</th>
    </tr>
</thead>

<?php
    while ($row = $result->fetch_assoc()) {
?>
        <tr>
        <td><?= ($row['username'] ?? '') ? '<a href="/user.php?username=' . urlencode($row['username']) . '">' . $row['username'] . '</a>' : 'N/A' ?></td>
        <td align="right"><?= $row['numBeliefs'] ?></td>
        <td align="right"><?= $row['numDistinctBeliefs'] ?></td>
        </tr>
<?php
    }
}
?>
<?php } ?>

</body>
</html>

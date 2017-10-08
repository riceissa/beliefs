<?php session_start();
include_once("backend/globalVariables/passwordFile.inc");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="stylesheet" href="/tablesorter.css">
    <script src="/jquery.min.js"></script>
    <script src="/jquery.tablesorter.js"></script>
    <title>Beliefs repo</title>
    <?php include("table_styling.inc") ?>
</head>

<body>
<?php include('navbar.inc') ?>

<?php if ($_REQUEST['username']) { ?>

<h1>Beliefs repo for <?= $_REQUEST['username'] ?></h1>

<?php if ($_REQUEST['username'] === $_SESSION['user']) { ?>
<p>Welcome back, <?= $_SESSION['user'] ?>. You can
    <a href="/add.php">add a belief</a>.
</p>
<?php } ?>

<p><a href="//<?= $_REQUEST['username'] ?>">Visit this user’s web page</a>.
</p>

<?php


$query = 'select * from beliefs where username = ? order by belief_entry_date desc';
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $_REQUEST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
?>
  <p>This user has <?= $mysqli->affected_rows ?> beliefs.
  </p>

<table class="<?= $_REQUEST['wikitable'] ? 'wikitable' : 'booktabs' ?>">
  <thead>
    <tr>
      <th rowspan="2">Belief</th>
      <th rowspan="2">Likert response</th>
      <th rowspan="2">Confidence</th>
      <th colspan="3">Probability</th>
      <th colspan="3">Date of belief</th>
      <th rowspan="2">Works consumed</th>
      <th rowspan="2">Notes</th>
    </tr>
    <tr>
      <th>Probability</th>
      <th>Probability lower bound</th>
      <th>Probability upper bound</th>
      <th>Belief held on</th>
      <th>Belief expressed on</th>
      <th>Belief entered at (UTC)</th>
    </tr>
  </thead>
  <tbody>

<?php
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
    <td align="right"<?= 'title="' . $row['belief_entry_date'] . '"' ?>><?= $row['belief_entry_date'] ? substr($row['belief_entry_date'], 0, 10) : '&ndash;' ?></td>
    <td><?= preg_replace('|\n|', '<br />', htmlspecialchars($row['works_consumed'])) ?? '&ndash;' ?></td>
    <td><?= preg_replace('|\n|', '<br />', htmlspecialchars($row['notes'])) ?? '&ndash;' ?></td>
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

<table class="<?= $_REQUEST['wikitable'] ? 'wikitable' : 'booktabs' ?>">
<thead>
    <tr>
        <th>Username</th>
        <th>Total beliefs</th>
        <th>Total distinct beliefs</th>
    </tr>
</thead>
<tbody>

<?php
    while ($row = $result->fetch_assoc()) {
?>
        <tr>
        <td><?= ($row['username'] ?? '') ? '<a href="/user.php?username=' . urlencode($row['username']) . '">' . $row['username'] . '</a>' : 'N/A' ?></td>
        <td align="right"><?= $row['numBeliefs'] ?></td>
        <td align="right"><?= $row['numDistinctBeliefs'] ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>
  <?php } ?>
<?php } ?>

<script>
    $(function(){$("table").tablesorter();});
</script>
</body>
</html>

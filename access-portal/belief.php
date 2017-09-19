<?php
session_start();
include_once("backend/globalVariables/passwordFile.inc");
$belief = $_REQUEST['text'];
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

<?php if ($belief) { ?>
    <h1>Belief:
        <?= htmlspecialchars($belief) ?>
    </h1>

    <p>Here are the users who have expressed their opinion on this belief:</p>
<?php } else { ?>
    <h1>Beliefs</h1>

    <p>Here are some beliefs on this site:</p>
<?php } ?>

<table>
    <thead>
        <tr>
            <?= $belief ? '' : '<th>Belief</th>' ?>
            <th>Username</th>
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

if ($belief) {
    $query = "select * from beliefs where belief_text = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $belief);
        $stmt->execute();
        $result = $stmt->get_result();
    }
} else {
    $query = "select * from beliefs";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->execute();
        $result = $stmt->get_result();
    }
}

while ($row = $result->fetch_assoc()) {
?>

<tr>
    <?= $belief ? '' : '<td><a href="/belief.php?text=' . urlencode($row['belief_text']) . '">' . $row['belief_text'] . '</a></td>' ?>
    <td><?= ($row['username'] ?? '') ? '<a href="/user.php?username=' . urlencode($row['username']) . '">' . $row['username'] . '</a>' : 'N/A' ?></td>
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
?>

</body>
</html>

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
    <link rel="stylesheet" href="/tablesorter.css">
    <script src="/jquery.min.js"></script>
    <script src="/jquery.tablesorter.js"></script>
    <title>Beliefs repo</title>
    <?php include("table_styling.inc") ?>
</head>

<body>
<?php include('navbar.inc') ?>

<?php if ($belief) { ?>
    <h1>Belief:
        <?= htmlspecialchars($belief) ?>
    </h1>

    <p><a href="/add.php?text=<?= urlencode($belief) ?>">Add an opinion on this belief</a>.</p>

    <p>Here are the users who have expressed their opinion on this belief:</p>
<?php } else { ?>
    <h1>Beliefs</h1>

    <?php if ($_SESSION['user']) { ?>
    <p>You can <a href="/add.php">add a belief</a>.</p>
    <?php } ?>

    <p>Here are some beliefs on this site:</p>
<?php } ?>

<table class="<?= $_REQUEST['wikitable'] ? 'wikitable' : 'booktabs' ?>">
    <thead>
        <tr>
            <?= $belief ? '' : '<th rowspan="2">Belief</th>' ?>
            <th rowspan="2">Username</th>
            <th rowspan="2">Likert response</th>
            <th rowspan="2">Confidence</th>
            <th colspan="3">Probability</th>
            <th colspan="3">Date of belief</th>
            <th rowspan="2">Works consumed</th>
            <th rowspan="2">Notes</th>
        </tr>
        <tr>
            <th>Point estimate</th>
            <th>Lower bound</th>
            <th>Upper bound</th>
            <th>Held</th>
            <th>Expressed</th>
            <th>Entered</th>
        </tr>
    </thead>
    <tbody>

<?php

if ($belief) {
    $query = "select * from beliefs where belief_text = ? order by belief_entry_date desc";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $belief);
        $stmt->execute();
        $result = $stmt->get_result();
    }
} else {
    $query = "select * from beliefs order by belief_entry_date desc";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->execute();
        $result = $stmt->get_result();
    }
}

while ($row = $result->fetch_assoc()) {
?>

<tr>
    <?= $belief ? '' : '<td><a href="/belief.php?text=' . urlencode($row['belief_text']) . '">' . htmlspecialchars($row['belief_text']) . '</a></td>' ?>
    <td><?= ($row['username'] ?? '') ? '<a href="/user.php?username=' . urlencode($row['username']) . '">' . $row['username'] . '</a>' : 'N/A' ?></td>
    <td><?= $row['likert_response'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['confidence'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['probability_point_estimate'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['probability_lower_bound'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['probability_upper_bound'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['belief_date'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['belief_expression_date'] ?? '&ndash;' ?></td>
    <td align="right"><?= $row['belief_entry_date'] ?? '&ndash;' ?></td>
    <td><?= preg_replace('|\n|', '<br />', htmlspecialchars($row['works_consumed'])) ?? '&ndash;' ?></td>
    <td><?= preg_replace('|\n|', '<br />', htmlspecialchars($row['notes'])) ?? '&ndash;' ?></td>
</tr>

<?php
}
?>

</tbody>
</table>

<script>
    $(function(){$("table").tablesorter();});
</script>

</body>
</html>

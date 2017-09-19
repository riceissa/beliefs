<?php

include_once("backend/globalVariables/passwordFile.inc");
$belief = $_REQUEST['text'];
?>

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
    <a href="/user.php">Users</a>
</nav>


<p>Belief:
<?= htmlspecialchars($_REQUEST['text']) ?>
</p>

<p>Here are the users who have expressed their opinion on this belief:</p>

<table>
    <thead>
        <tr>
            <?= $belief ? '' : '<th>Belief</th>' ?>
            <th>Username</th>
            <th>Likert response</th>
            <th>Confidence</th>
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
    <?= $belief ? '' : '<td>' . $row['belief_text'] . '</td>' ?>
    <td><?= ($row['username'] ?? '') ? '<a href="/user.php?username=' . urlencode($row['username']) . '">' . $row['username'] . '</a>' : 'N/A' ?></td>
    <td><?= $row['likert_response'] ?></td>
    <td><?= $row['confidence'] ?></td>
</tr>

<?php
}
?>

</body>
</html>

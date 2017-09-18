<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>

<h1>Beliefs repo for <?= $_REQUEST['username'] ?></h1>

<p>
<?php

include_once("backend/globalVariables/passwordFile.inc");

$query = 'select * from beliefs';
if ($stmt = $mysqli->prepare($query)) {
    # $stmt->bind_param("s", $donor);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        print '<table>';
        print '  <thead>';
        print '    <tr>';
        print '      <th>Belief</th>';
        print '      <th>Likert response</th>';
        print '      <th>Confidence</th>';
        print '    </tr>';
        print '  </thead>';
        print '  <tbody>';
        print '    <tr>';
        print "<td>" . $row['belief_text'] . "</td>";
        print "<td>" . $row['belief_text'] . "</td>";
        print "<td>" . $row['belief_text'] . "</td>";
        print '    </tr>';
        print '  </tbody>';
        print '</table>';
    }
}

$username = $_REQUEST['username'];

echo 'Beliefs for ' . $username;

?>
</p>

</body>
</html>

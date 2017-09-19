<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>

<h1>hello</h1>

<?php
session_start();
include_once("backend/globalVariables/passwordFile.inc");

function is_probability($p) {
    if (is_numeric($p) && floatval($p) >= 0 && floatval($p) <= 1) {
        return true;
    }
    return false;
}

$query = "insert into beliefs (username, belief_text, likert_response, confidence, probability_point_estimate, probability_lower_bound, probability_upper_bound, belief_date, belief_date_precision, belief_expression_date, belief_expression_date_precision, belief_expression_url, belief_entry_date, works_consumed, entry_method, notes) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $mysqli->prepare($query)) {

    $ppe = $_POST['probability_point_estimate'];
    if (!is_probability($ppe)) {
        echo 'Probability point estimate must be between 0 and 1.';
    }

    $stmt->bind_param("ssss", $_POST['username'], $_POST['belief_text'],
        $_POST['likert_response'], $_POST['confidence']);
    $stmt->execute();
    print $mysqli->error;
    print $mysqli->affected_rows;
} else {
    echo $mysqli->error;
}

?>

</body>
</html>

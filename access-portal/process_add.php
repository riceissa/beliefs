<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>

<h1>hello</h1>

<pre>

<?php
session_start();
include_once("backend/globalVariables/passwordFile.inc");

function is_probability($p) {
    if (is_numeric($p) && floatval($p) >= 0 && floatval($p) <= 1) {
        return true;
    }
    return false;
}

function is_date($x) {
    if (preg_match('/^\d{4}(-\d{2}(-\d{2})?)?$/', $x) === 1) {
        $arr = explode('-', $x);
        if (sizeof($arr) === 1) {
            array_push($arr, 1, 1);
        } else if (sizeof($arr) === 2) {
            array_push($arr, 1);
        }
        return checkdate($arr[1], $arr[2], $arr[0]);
    }
    return false;
}

function date_precision($x) {
    if (is_date($x)) {
        $dashes = substr_count($x, "-");
        if ($dashes === 0) {
            return "year";
        }
        if ($dashes === 1) {
            return "month";
        }
        if ($dashes === 2) {
            return "day";
        }
    }
    return false;
}

$query = "insert into beliefs (username, belief_text, likert_response, confidence, probability_point_estimate, probability_lower_bound, probability_upper_bound, belief_date, belief_date_precision, belief_expression_date, belief_expression_date_precision, belief_expression_url, belief_entry_date, works_consumed, entry_method, notes) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $mysqli->prepare($query)) {

    $params_ok = true;

    if (!isset($_SESSION['user'])) {
        print 'User not signed in.';
        $params_ok = false;
    }

    $ppe = $_POST['probability_point_estimate'];
    if (!is_probability($ppe)) {
        echo 'Probability point estimate must be between 0 and 1.<br />';
        $params_ok = false;
    }

    $plb = $_POST['probability_lower_bound'];
    if (!is_probability($plb)) {
        echo 'Probability lower bound must be between 0 and 1.<br />';
        $params_ok = false;
    }

    $pub = $_POST['probability_upper_bound'];
    if (!is_probability($pub)) {
        echo 'Probability upper bound must be between 0 and 1.<br />';
        $params_ok = false;
    }

    $bdate = $_POST['belief_date'];
    if (!is_date($bdate)) {
        echo 'Belief date is not a date.<br />';
        $params_ok = false;
    }

    if (is_date($bdate)) {
        echo "date: " . date_precision($bdate) . "<br />";
        $params_ok = false;
    }

    $edate = $_POST['belief_expression_date'];
    if (!is_date($edate)) {
        echo 'Belief expression date is not a date.<br />';
        $params_ok = false;
    }

    if ($params_ok) {
        $stmt->bind_param(
            "sssidddsssssssss",
            $_POST['username'],
            $_POST['belief_text'],
            $_POST['likert_response'],
            $_POST['confidence'],
            $ppe,
            $plb,
            $pub,
            $bdate,
            date_precision($bdate),
            $edate,
            date_precision($edate),
            $_POST['belief_expression_url'],
            date('Y-m-d'),
            $_POST['works_consumed'],
            $entry_method = 'add.php',
            $_POST['notes']
        );
        $stmt->execute();
        print $stmt->error;
    } else {
        print "There are problems with the input parameters so the belief was not added.<br />";
    }

    print $mysqli->error;
    print $mysqli->affected_rows;
} else {
    echo $mysqli->error;
}

?>

</pre>

</body>
</html>

<?php
session_start();
include_once("backend/globalVariables/passwordFile.inc");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>
<?php include('navbar.inc') ?>

<h1>hello</h1>

<pre>

<?php
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
    return null;
}

$query = "insert into beliefs (username, belief_text, likert_response, confidence, probability_point_estimate, probability_lower_bound, probability_upper_bound, belief_date, belief_date_precision, belief_expression_date, belief_expression_date_precision, belief_expression_url, belief_entry_date, works_consumed, entry_method, notes) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $mysqli->prepare($query)) {

    $params_ok = true;

    if ($_POST['belief_text'] == '') {
        print 'Belief text must not be empty.<br />';
        $params_ok = false;
    }

    if (!isset($_SESSION['user'])) {
        print 'User not signed in.';
        $params_ok = false;
    }

    $ppe = $_POST['probability_point_estimate'];
    if ($ppe !== '' && !is_probability($ppe)) {
        echo 'Probability point estimate must be between 0 and 1.<br />';
        $params_ok = false;
    }
    if ($ppe === '') {
        $ppe = null;
    }

    $plb = $_POST['probability_lower_bound'];
    if ($plb !== '' && !is_probability($plb)) {
        echo 'Probability lower bound must be between 0 and 1.<br />';
        $params_ok = false;
    }
    if ($plb === '') {
        $plb = null;
    }

    $pub = $_POST['probability_upper_bound'];
    if ($pub !== '' && !is_probability($pub)) {
        echo 'Probability upper bound must be between 0 and 1.<br />';
        $params_ok = false;
    }
    if ($pub === '') {
        $pub = null;
    }

    $bdate = $_POST['belief_date'];
    if ($bdate !== '' && !is_date($bdate)) {
        echo 'Belief date is not a date.<br />';
        $params_ok = false;
    }

    if (is_date($bdate)) {
        echo "date: " . date_precision($bdate) . "<br />";
        $bdate_prec = date_precision($bdate);
    } else {
        $bdate_prec = null;
    }
    if ($bdate == '') {
        $bdate = null;
    }

    $edate = $_POST['belief_expression_date'];
    if ($edate !== '' && !is_date($edate)) {
        echo 'Belief expression date is not a date.<br />';
        $params_ok = false;
    }
    if (is_date($edate)) {
        echo "date: " . date_precision($edate) . "<br />";
        $edate_prec = date_precision($edate);
    } else {
        $edate_prec = null;
    }
    if ($edate == '') {
        $edate = null;
    }

    $conf = $_POST['confidence'];
    if ($conf !== '' && !(intval($conf) <= 10 && intval($conf) >= 1)) {
        echo 'Confidence must be an integer between 1 and 10.';
        $params_ok = false;
    }

    $entry_method = 'add.php';
    $current_date = date('Y-m-d');

    if ($params_ok) {
        $stmt->bind_param(
            "sssidddsssssssss",
            $_SESSION['user'],
            $_POST['belief_text'],
            $_POST['likert_response'],
            $_POST['confidence'],
            $ppe,
            $plb,
            $pub,
            $bdate,
            $bdate_prec,
            $edate,
            $edate_prec,
            $_POST['belief_expression_url'],
            $current_date,
            $_POST['works_consumed'],
            $entry_method,
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

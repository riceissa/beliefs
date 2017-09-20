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

function date_normalized($x) {
    $prec = date_precision($x);
    if ($prec === "day") {
        return $x;
    } else if ($prec === "month") {
        return $x . "-01";
    } else if ($prec === "year") {
        return $x . "-01-01";
    } else {
        // prec is null
        return null;
    }
}

function mysql_quote($x) {
    if ($x === '' || $x === null) {
        return "NULL";
    }
    $x = str_replace("\\", "\\\\", $x);
    $x = str_replace("'", "''", $x);
    $x = str_replace("\n", "\\n", $x);
    $x = str_replace("\r", "", $x);
    return "'" . $x . "'";
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

    echo "bdate: $bdate<br />";
    if (is_date($bdate)) {
        echo "date: " . date_precision($bdate) . "<br />";
        $bdate_prec = date_precision($bdate);
    } else {
        $bdate_prec = null;
    }
    $bdate = date_normalized($bdate);

    echo "edate: $edate<br />";
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
    $edate = date_normalized($edate);

    $conf = $_POST['confidence'];
    if ($conf !== '' && !(intval($conf) <= 10 && intval($conf) >= 1)) {
        echo 'Confidence must be an integer between 1 and 10.';
        $params_ok = false;
    }

    $entry_method = 'add.php';
    $current_date = date('Y-m-d');

    $works_consumed = trim($_POST['works_consumed']);
    if ($works_consumed === '') {
        $works_consumed = null;
    }

    $notes = trim($_POST['notes']);
    if ($notes === '') {
        $notes = null;
    }

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
            $works_consumed,
            $entry_method,
            $notes
        );
        $stmt->execute();
        print "stmt error: " . $stmt->error . "<br />";

        $data_file = fopen("beliefs_data.sql", "a") or die("Could not open data file.");
        $line = ",(" .
            mysql_quote($_SESSION['user']) . "," .
            mysql_quote($_POST['belief_text']) . "," .
            mysql_quote($_POST['likert_response']) . "," .
            mysql_quote($_POST['confidence']) . "," .
            mysql_quote($ppe) . "," .
            mysql_quote($plb) . "," .
            mysql_quote($pub) . "," .
            mysql_quote($bdate) . "," .
            mysql_quote($bdate_prec) . "," .
            mysql_quote($edate) . "," .
            mysql_quote($edate_prec) . "," .
            mysql_quote($_POST['belief_expression_url']) . "," .
            mysql_quote($current_date) . "," .
            mysql_quote($works_consumed) . "," .
            mysql_quote($entry_method) . "," .
            mysql_quote($notes) . ")\n";
        fwrite($data_file, $line);
        fclose($data_file);

    } else {
        print "There are problems with the input parameters so the belief was not added.<br />";
    }

    print "mysqli error: " . $mysqli->error . "<br />";
    print "Number of rows affected: " . $mysqli->affected_rows . "<br />";
} else {
    print "mysqli error: " . $mysqli->error . "<br />";
}

?>

</pre>

</body>
</html>

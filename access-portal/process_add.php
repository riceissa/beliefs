<?php
include_once("backend/globalVariables/passwordFile.inc");

$query = "insert into beliefs (belief_text, likert_response, confidence) values (?, ?, ?)";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("sss", $_POST['belief_text'], $_POST['likert_response'],
        $_POST['confidence']);
    $stmt->execute();
    print $mysqli->info;
    print $mysqli->affected_rows;
}

?>

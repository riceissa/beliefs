<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>
<?php

session_start();
?>

<h1>Add a belief</h1>

<p>Welcome <?= $_SESSION['user'] ?>
</p>

<form method="post">
    <label>Belief text</label>
    <input type="text" name="notes"/>
    <br />

    <label>Agreement</label>
    <select id="likert_response">
        <option value="">NULL</option>
        <option>Strongly agree</option>
        <option>Agree</option>
        <option>Uncertain</option>
        <option>Disagree</option>
        <option>Strongly disagree</option>
        <option>No opinion</option>
    </select>
    <br />

    <label>Notes</label><br />
    <textarea rows="5" cols="80" id="notes"></textarea>
    <br />
</form>

</body>
</html>

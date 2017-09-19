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

<p><a href="/logout.php">Log out</a></p>

<h1>Add a belief</h1>

<p>Welcome <?= $_SESSION['user'] ?>
<?= date('Y-m-d') ?>
</p>

<form action="process_add.php" method="post">
    <label>Belief text</label>
    <input type="text" style="width:300px;" name="belief_text"/>
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

    <label>Confidence</label>
    <input type="radio" name="confidence" value="1"> 1
    <input type="radio" name="confidence" value="2"> 2
    <input type="radio" name="confidence" value="3"> 3
    <input type="radio" name="confidence" value="4"> 4
    <input type="radio" name="confidence" value="5"> 5
    <input type="radio" name="confidence" value="6"> 6
    <input type="radio" name="confidence" value="7"> 7
    <input type="radio" name="confidence" value="8"> 8
    <input type="radio" name="confidence" value="9"> 9
    <input type="radio" name="confidence" value="10"> 10
    <br />

    <label>Notes</label><br />
    <textarea rows="5" cols="80" id="notes"></textarea>
    <br />

    <input type="hidden" name="username" value="<?= $_SESSION['user'] ?>">
    <input type="submit" value="Submit" />
</form>

</body>
</html>

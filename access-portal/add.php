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

<?php if (isset($_SESSION['user'])) { ?>

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

    <label>Date on which the belief was held</label>
    <input type="text" name="belief_date" placeholder="YYYY[-MM[-DD]]" />
    <br />

    <label>Date on which belief was expressed</label>
    <input type="text" name="belief_expression_date" placeholder="YYYY[-MM[-DD]]" />
    <br />

    <label>Link to page where belief was expressed</label>
    <input type="text" name="belief_expression_url" placeholder="http://" />
    <br />

    <label>Point estimate of probability</label>
    <input type="text" name="probability_point_estimate" />
    <br />

    <label>Lower bound of probability (the probability is <em>at least</em>&nbsp;…)</label>
    <input type="text" name="probability_lower_bound" />
    <br />

    <label>Upper bound of probability (the probability is <em>at most</em>&nbsp;…)</label>
    <input type="text" name="probability_upper_bound" />
    <br />

    <label>List of works you consumed to form this belief</label><br />
    <textarea rows="5" cols="80" id="works_consumed"></textarea>
    <br />

    <label>Notes</label><br />
    <textarea rows="5" cols="80" id="notes"></textarea>
    <br />

    <input type="submit" value="Submit" />
</form>

<?php } else { ?>

<p>Please <a href="/login.php">sign in</a> before adding a belief.</p>

<?php } ?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Worldviews quiz - Beliefs repo</title>
    <style type="text/css">
    </style>
</head>

<?php

$questions = array(
    "what is x" => array(
        "blah 1" => 5,
        "blah 2" => 2,
    ),
    "what is y" => array(
        "blah 3" => -2,
        "blah 4" => 8,
    ),
);


$max_score = 0;
foreach ($questions as $question_text => $answer) {
    $max_score += max(array_values($answer));
}

?>

<body>
<h1>Worldviews quiz</h1>

<?php if (!isset($_GET['submit'])) { ?>

<p>
    This is a quiz to test how good your worldviews are.
</p>

<form id="quiz" method="get" action="worldviews-quiz.php">

    <?php
    $question_counter = 0;
    foreach ($questions as $question_text => $answers) {
        $question_counter += 1;
    ?>
        <p><?= $question_text ?></p>
        <?php
        $answer_counter = 0;
        foreach ($answers as $answer_text => $score) {
            $answer_counter += 1;
        ?>
            <label><?= $answer_text ?>
                <input type="radio" name="question-<?= $question_counter ?>" value="<?= $answer_counter ?>">
            </label><br />
        <?php } ?>
    <?php } ?>

    <input type="submit" name="submit" value="Submit">

</form>

<?php } else { ?>

<?php

$total_score = 0;

$question_counter = 0;
foreach ($questions as $question_text => $answers) {
    $question_counter += 1;
    $answer_index = intval($_GET['question-' . $question_counter]);
    $answer_counter = 0;
    echo "answer index is " . $answer_index . "<br>";
    foreach ($answers as $answer_text => $score) {
        $answer_counter += 1;
        if ($answer_counter === $answer_index) {
            $total_score += $score;
        }
    }
}

echo "<p>Your score is $total_score/$max_score.</p>";

?>


<?php } ?>

</body>
</html>

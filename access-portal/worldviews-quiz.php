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
    "What is the probability that God exists?" => array(
        "90-100%" => -20,
        "2-89%" => -18,
        "1%" => -15,
        "0%" => 0,
    ),
    "How would you label yourself?" => array(
        "Religious" => -20,
        "Agnostic" => -15,
        "Atheist" => 0,
    ),
    "What is the answer to consciousness?" => array(
        "Illusionism/type-A physicalism" => 10,
        "Type-B" => -5,
        "Folk psychology" => -10,
        "Wei Dai" => 20,
    ),
    "Free will" => array(
        "Compatibilism" => 5,
        "Libertarianism" => -10,
        "Determinism" => -5,
    ),
    "Is AI safety important?" => array(
    ),
    "Wikipedia" => array(
    ),
    "Eliezer Yudkowsky" => array(
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

    <ol>

    <?php
    $question_counter = 0;
    foreach ($questions as $question_text => $answers) {
        $question_counter += 1;
    ?>
        <li>
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
        </li>
    <?php } ?>

    </ol>

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

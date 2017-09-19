<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>

<body>
<?php include('navbar.inc') ?>

<h1>Frequently asked questions</h1>

<p><strong>Question:</strong>
    Why make this site?
</p>

<p><strong>Question:</strong>
    Why use IndieAuth for authentication?
</p>

<p><strong>Question:</strong>
    Can predictions be entered on this site?
</p>

<p><strong>Question:</strong>
    Who runs the site?
</p>
<p><strong>Answer:</strong>
    Issa Rice.
</p>

<p><strong>Question:</strong>
    Why does the site look so bad?
</p>

<p><strong>Question:</strong>
    Do the forms on this site enforce any sort of consistency?
</p>
<p><strong>Answer:</strong>
    Yes. Each form enforces <em>local</em> consistency, so e.g. you cannot
    enter a probability point estimate that is lower than the probability
    lower bound. However, there is no enforcement of intertemporal
    consistency so e.g. you can enter a probability point estimate that is
    lower than the probability lower bound as long as you enter the two on
    separate occasions.
</p>

<p><strong>Question:</strong>
</p>

<p><strong>Question:</strong>
</p>

</body>
</html>

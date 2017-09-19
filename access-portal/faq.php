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
    Do you have a privacy policy?
</p>

<p><strong>Question:</strong>
    Who owns the data submitted to the site?
</p>
<p><strong>Answer:</strong>
    Everybody! We make the <a href="https://github.com/riceissa/beliefs">full
    source code</a> for the site
    as well as a <a href="">serialized form of all the data</a> available,
    so anyone can host their own version of the site or analyze the data.
    We ask that users release the information they submit on the site under
    the <a href="https://creativecommons.org/publicdomain/zero/1.0/">CC0
    public domain dedication</a>.
</p>

<p><strong>Question:</strong>
    Can we enter values and aesthetic judgments (i.e. things that some
    people consider ‘subjective’ rather than ‘objective’) on this site?
</p>

</body>
</html>

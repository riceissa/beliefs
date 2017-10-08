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

<p><strong>Question:
    Why make this site?</strong><br />
Answer:
    People make parts of their beliefs known in conversations and blog posts,
    but often don’t give enough information about “where they are coming from”,
    making it difficult to understand their statements in full context.
</p>

<p><strong>Question:
    Why use IndieAuth for authentication?</strong><br />
Answer:
    Mostly because it’s easy to implement and I don’t have to deal with
    maintaining a user list, private information, etc.
</p>

<p><strong>Question:
    Can predictions be entered on this site?</strong><br />
Answer:
    They can, but there are more specialized tools for recording predictions,
    allowing for predictions to be marked correct, calculating scores, etc. This
    site has none of that but allows for more general belief tracking over time.
</p>

<p><strong>Question:
    Is this site for opinions on “big questions”, or can more mundane things
    also go here?</strong><br />
Answer:
    Insofar as tracking beliefs about “big questions” is more important, they
    are more important to record on this site, but for now there are no
    restrictions on more mundane things.
</p>

<p><strong>Question:
    What is the status of development?</strong><br />
Answer:
    The core site features currently work. This was implemented as a
    proof-of-concept/prototype to see if having a service like this would
    be useful.
</p>

<p><strong>Question:
    What are the future plans for development?</strong><br />
Answer:
    I’d like to use the site for a while to see what features need to be added
    and so on. So for now the plan is “use it an see”.
</p>

<p><strong>Question:
    Who runs the site?</strong><br />
Answer:
    Issa Rice.
</p>

<p><strong>Question:
    Why does the site look so bad?</strong><br />
Answer:
    I want to test out the site for a while first before investing significant
    time into designing it.
</p>

<p><strong>Question:
    Do the forms on this site enforce any sort of consistency?</strong><br />
Answer:
    Yes. Each form enforces <em>local</em> consistency, so e.g. you cannot
    enter a probability point estimate that is lower than the probability
    lower bound. However, there is no enforcement of intertemporal
    consistency so e.g. you can enter a probability point estimate that is
    lower than the probability lower bound as long as you enter the two on
    separate occasions.
</p>

<p><strong>Question:
    Do you have a privacy policy?</strong><br />
Answer:
    Nope. Everything you enter on this site is recorded in the database and is
    publicly accessible, so don’t enter any private information.
</p>

<p><strong>Question:
    Who owns the data submitted to the site?</strong><br />
Answer:
    Everybody. We make the <a href="https://github.com/riceissa/beliefs">full
    source code</a> for the site as well as a
    <a href="/beliefs_data.sql">serialized form of all the data</a> available,
    so anyone can host their own version of the site or analyze the data.
    We ask that users release the information they submit on the site under
    the <a href="https://creativecommons.org/publicdomain/zero/1.0/">CC0
    public domain dedication</a>.
</p>

<p><strong>Question:
    Can we enter values and aesthetic judgments (i.e. things that some
    people consider ‘subjective’ rather than ‘objective’) on this site?</strong><br />
Answer:
    Sure.
</p>

<p><strong>Question:
    My question isn’t answered on this page; where can I ask a question?</strong><br />
Answer:
    Email riceissa@gmail.com. Be sure to make it clear in the email that you
    are asking about this site. If you want to report a problem on the site,
    you can <a href="https://github.com/riceissa/beliefs/issues">file an issue</a>
    on GitHub.
</p>

</body>
</html>

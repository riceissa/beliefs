<nav><a href="/index.php">Home</a>,
    <a href="/faq.php">FAQ</a>,
    <a href="/belief.php">Beliefs</a>,
    <a href="/user.php">Users</a>;
    <?= $_SESSION['user'] ? 'You are signed in as <a href="/user.php?username=' . urlencode($_SESSION['user']) . '">' . $_SESSION['user'] . '</a>, <a href="/logout.php">Log out</a>' : '<a href="/login.php">Log in</a>' ?>
</nav>

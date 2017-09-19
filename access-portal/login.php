<?php
// Modified from https://gist.github.com/aaronpk/3685554

session_start();

// If a token exists, we verify the token with indieauth.com
if(array_key_exists('token', $_GET)) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://indieauth.com/session?token=' . $_GET['token']);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $auth = json_decode(curl_exec($ch));
  // If we got a reply, store the domain in the session
  if($auth && $auth->me) {
    $user = preg_replace('|https?://|', '', $auth->me);
    $user = preg_replace('|/$|', '', $user);
    $_SESSION['user'] = $user;
  }
  // Redirect back to this page
  header('Location: ' . $_SERVER['PHP_SELF']);
  die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Beliefs repo</title>
</head>
<body>

<nav><a href="/index.php">Home</a>,
    <a href="/faq.php">FAQ</a>,
    <a href="/belief.php">Beliefs</a>,
    <a href="/user.php">Users</a>
</nav>

<?php
// If the user is not logged in, display a login link
if(!array_key_exists('user', $_SESSION)) {
  header('HTTP/1.1 403 Forbidden');
?>

<h1>Login page</h1>
<p>You are not logged in. Log in with your domain name using
    <a href="https://indieauth.com/">IndieAuth</a>.</p>

<form action="http://indieauth.com/auth" method="get">
  <label>Web Address:</label>
  <input type="text" name="me" placeholder="yourdomain.com" />
  <p><button type="submit">Sign In</button></p>
  <input type="hidden" name="redirect_uri" value="<?= 'http://' . $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] == 80 ? '' : ':' . $_SERVER['SERVER_PORT']) . $_SERVER['PHP_SELF'] ?>" />
</form>
</body>
</html>
  <?php
  die();
}
?>

<?php
// Now the user is logged in, and their domain is stored in $_SESSION['user']
?>

<h1>Welcome, <?= $_SESSION['user'] ?></h1>

<p>You are logged in as <?= $_SESSION['user'] ?>.
    <a href="/logout.php">Log out</a>.
</p>

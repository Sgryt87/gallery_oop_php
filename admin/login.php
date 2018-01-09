<?php
require_once 'includes/header.php';

if ($session->is_signed_in()) {
    redirect('index.php');
}


if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user_found = User::verify_user($username,$password);

    if ($user_found) {
        $session->login($user_found);
    } else {
        $the_message = 'Your username or password is not correct';
    }
} else {
    $username = '';
    $password = '';
}
?>

<div class="col-md-4 col-md-offset-3 ">
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" name="password">
        </div>
        <div class="form-group">
            <input type="submit" name="submit" val ue="Submit" class="btn btn-primary">
        </div>
    </form>
</div>

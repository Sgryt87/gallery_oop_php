<?php
include 'includes/header.php';
if (!$session->is_signed_in()) {
    redirect("login.php");
}
$message = '';
$user = new User();
if (isset($_POST['submit'])) {
    if ($user) {
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];
        $user->set_file($_FILES['user_image']);
        $user->upload_photo();
        $session->message("The {$user->username} has been added");
        $user->save();
        redirect('users.php');
    }
}
?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <?php include 'includes/top_nav.php'; ?>

        <?php include 'includes/side_nav.php'; ?>
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Users
                        <small>Add User</small>
                    </h1>
                    <p class="bg-success"><?php echo $message; ?></p>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group">
                                <label for="user_image">User Image</label>
                                <input type="file" name="user_image">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->


<?php
include 'includes/footer.php';
?>
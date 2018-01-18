<?php
require_once "admin/includes/functions.php";
require_once 'admin/includes/new_config.php';
require_once 'admin/includes/database.php';
require_once 'admin/includes/db_object.php';
require_once 'admin/includes/user.php';
require_once 'admin/includes/photo.php';
require_once 'admin/includes/session.php';
require_once 'admin/includes/comment.php';
include 'includes/header.php';
?>

<?php
include 'includes/navigation.php';
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <!--CONTENT HERE-->


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <?php
                include 'includes/sidebar.php';
                ?>

            </div>
            <!-- /.row -->
        </div>



<?php
include 'includes/footer.php';
?>
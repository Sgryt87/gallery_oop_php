<?php

require_once "admin/includes/init.php";
require_once "admin/includes/functions.php";
require_once 'admin/includes/new_config.php';
require_once 'admin/includes/database.php';
require_once 'admin/includes/db_object.php';
require_once 'admin/includes/user.php';
require_once 'admin/includes/photo.php';
require_once 'admin/includes/session.php';
require_once 'admin/includes/comment.php';


if (empty($_GET['id'])) {
    redirect('index.php');
}

$photo = Photo::find_by_id($_GET['id']);


if (isset($_POST['submit'])) {
    $author = trim($_POST['author']);
    $body = trim($_POST['body']);

    $new_comment = Comment::create_comment($photo->id, $author, $body);
    if ($new_comment && $new_comment->save()) {
        redirect("photo.php?id={$photo->id}");
    } else {
        $message = 'There was some saving problems';
    }
} else {
    $author = '';
    $body = '';
}

$comments = Comment::find_the_comments($photo->id);
?>

<?php
include 'includes/header.php';
include 'includes/navigation.php';
?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-12">

            <!-- Blog Post -->

            <!-- Title -->
            <h1><?php echo $photo->title; ?></h1>

            <!-- Author -->
            <p class="lead">
                by <a href="#">Start Bootstrap</a>
            </p>

            <hr>

            <!-- Date/Time -->
            <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

            <hr>

            <!-- Preview Image -->
            <img class="img-responsive" src="admin/<?php echo $photo->picture_path(); ?>" alt="" style="width: 100%;">

            <hr>

            <p class="lead"><?php echo $photo->caption; ?> </p>
            <p><?php echo $photo->description; ?> </p>

            <hr>


            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="author"></label>
                        <input type="text" name="author" class="form-control">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="body" rows="3"></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->
            <?php foreach ($comments as $comment) : ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <!--Users Image-->
                        <img class="media-object" src="http://placehold.it/64x4" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment->author; ?>
                            <!--  Add displaying time-->
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        <?php echo $comment->body; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Comment -->


        </div>

        <!-- Blog Sidebar Widgets Column -->
<!--        <div class="col-md-4">-->
<!---->
<!--            --><?php
//            include 'includes/sidebar.php';
//            ?>
<!---->
<!--        </div>-->
        <!-- /.row -->
    </div>


<?php
include 'includes/footer.php';
?>
<?php
include 'includes/header.php';
if (!$session->is_signed_in()) {
    redirect("login.php");
}

if (empty($_GET['id'])) {
    redirect('comments.php');
} else {
    $comment = Comment::find_by_id($_GET['id']);
    if (isset($_POST['update'])) {
        if ($comment) {
            $comment->author = $_POST['author'];
            $comment->body = $_POST['body'];
            $comment->save();
            redirect('comments.php');
        }
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
                        Comments
                        <small>Edit comment</small>
                    </h1>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h3 class="form-group">Id: <?php echo $comment->id; ?></h3>
                            </div>
                            <div class="form-group">
                                <label for="first_name">Author</label>
                                <input type="text" name="author" class="form-control" value="<?php echo
                                $comment->author; ?>">
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea name="body" id="" rows="3" class="form-control"><?php echo $comment->body;
                                ?></textarea>
                            </div>
                            <div class="form-group">
                                <a href="delete_comment.php?id=<?php echo $comment->id; ?>" class="btn
                                btn-danger pull-left btn-lg">Delete</a>
                                <input type="submit" name="update" value="Update" class="btn btn-primary pull-right
                                btn-lg">
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
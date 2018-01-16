<?php
include 'includes/header.php';
if (!$session->is_signed_in()) {
    redirect("login.php");
}
$comments = Comment::find_all();

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
                        comments
                    </h1>
                    <a href="add_comment.php" class="btn btn-info">Add comment</a>
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Body</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($comments as $comment) : ?>
                                <tr>
                                    <td><?php echo $comment->id; ?></td>
                                    <td><?php echo $comment->author; ?>
                                        <div class="pictures_link">
                                            <a href="delete_comment.php?id=<?php echo $comment->id ?>"
                                               class="btn btn-danger btn-sm">Delete</a>
                                            <a href="edit_comment.php?id=<?php echo $comment->id ?>" class="btn btn-primary
                                            btn-sm">Edit</a>
                                        </div>
                                    </td>
                                    <td><?php echo $comment->body; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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
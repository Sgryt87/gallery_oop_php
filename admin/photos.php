<?php
include 'includes/header.php';
if (!$session->is_signed_in()) {
    redirect("login.php");
}
//$photos = Photo::find_all();

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4;
$items_total_count = Photo::count_all();
$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos LIMIT {$items_per_page} OFFSET {$paginate->offset()}";
$photos = Photo::find_by_query($sql);

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
                        Photos
                    </h1>
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Id</th>
                                <th>File Name</th>
                                <th>Title</th>
                                <th>Size</th>
                                <th>Comments</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($photos as $photo) : ?>
                                <tr>
                                    <td><img class="admin-photo" src="<?php echo $photo->picture_path();
                                        ?>" alt="">
                                        <div class="action_links">
                                            <a href="delete_photo.php?id=<?php echo $photo->id ?>"
                                               class="btn btn-danger">Delete</a>
                                            <a href="edit_photo.php?id=<?php echo $photo->id ?>" class="btn btn-primary
                                            ">Edit</a>
                                            <a href="../photo.php?id=<?php echo $photo->id ?>" class="btn btn-info
                                            ">View</a>
                                        </div>
                                    </td>
                                    <td><?php echo $photo->id; ?></td>
                                    <td><?php echo $photo->filename; ?></td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->size; ?></td>
                                    <td>
                                        <?php
                                        $comments = Comment::find_the_comments($photo->id);
                                        echo count($comments) . "<span> comments</span>";
                                        ?>
                                        <a href="photo_comment.php?id=<?php echo $photo->id ?>" class="btn
                                            btn-default btn-sm
                                            " style="width: 50px;">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <nav aria-label="" class="text-center">
                    <ul class="pagination">
                        <?php if ($paginate->page_total() > 1) {
                            if ($paginate->has_previous()) {
                                echo "<li class='previous'><a href = 'photos.php?page={$paginate->previous()}'>Prev</a></li>";
                            }
                            for ($i = 1; $i <= $paginate->page_total(); $i++) {

                                if ($i == $paginate->current_page) {
                                    echo "<li><a href='photos.php?page={$i}'>{$i}</a></li>";
                                } else {
                                    echo "<li><a href='photos.php?page={$i}'>{$i}</a></li>";
                                }
                            }
                            if ($paginate->has_next()) {
                                echo "<li class='next'><a href = 'photos.php?page={$paginate->next()}'>Next</a></li>";
                            }

                        } ?>
                    </ul>
                </nav>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->


<?php
include 'includes/footer.php';
?>
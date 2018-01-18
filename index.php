<?php
include 'admin/includes/init.php';
include 'includes/header.php';
include 'includes/navigation.php';
//pagination
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4;
$items_total_count = Photo::count_all();
$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos LIMIT {$items_per_page} OFFSET {$paginate->offset()}";
$photos = Photo::find_by_query($sql);

//$photos = Photo::find_all();
?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-12">
            <div class="row thumbnails">
                <?php foreach ($photos as $photo) : ?>

                    <div class="col-xs-6 col-md-3">
                        <a href="photo.php?id=<?php echo "$photo->id"; ?>" class="thumbnail">
                            <img src="admin/<?php echo $photo->picture_path(); ?>" alt="" class="img-responsive"
                                 style="width: 200px; height: 150px;">
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>

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
<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'Applications' . DS . 'MAMP' . DS . 'htdocs' . DS . 'oop_project_gallery');
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');
require_once "admin/includes/functions.php";
require_once 'admin/includes/new_config.php';
require_once 'admin/includes/database.php';
require_once 'admin/includes/db_object.php';
require_once 'admin/includes/user.php';
require_once 'admin/includes/photo.php';
require_once 'admin/includes/session.php';
require_once 'admin/includes/comment.php';
include 'includes/header.php';
include 'includes/navigation.php';

$photos = Photo::find_all();
?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-12">
            <div class="row thumbnails">
                <?php foreach ($photos as $photo) : ?>

                    <div class="col-xs-6 col-md-3">
                        <a href="photo.php?id=<?php echo "$photo->id";?>" class="thumbnail">
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
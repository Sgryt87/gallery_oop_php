<?php
require_once 'init.php';
$photos = Photo::find_all();
?>

<div class="modal fade" id="photo-library">
    <div class="modal-gialog col-md-offset-1">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Gallery System Library</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-9">
                    <div class="thumbnails row">
                        <?php  foreach ($photos as $photo):?>
                        <div class="col-xs-2">
                            <a href="#" role="checkbox" aria-checked="false" tabindex="0" class="thumbnail">
                                <img src="<?php echo $photo->picture_path(); ?>" alt=""
                                     class="modal_thumbnails img-responsive" data="<?php echo $photo->id;?>">
                            </a>
                            <div class="photo-id hidden"></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="modal-sidebar" style="width: 200px;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <button id="set_user_image" class="btn btn-primary" type="button" disabled="true"
                            data-dismiss="modal">Apply Selection
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
$(document).ready(function () {

    var user_href;
    var user_href_splited;
    var user_id;
    var image_href;
    var image_href_splited;
    var image_name;
    var photo_id;

    //Edit photo sidebar
$('.info-box-header').click(function () {
       $('.inside').slideToggle('fast');
       $('#toggle').toggleClass('glyphicon glyphicon-menu-down, glyphicon glyphicon-menu-up');
    });

    //

    // deleting confirmation
$('#delete_link').click(function () {
   return confirm('Do you want to delete this item?');
});
    //

    $('.modal_thumbnails').click(function () {
        $('#set_user_image').prop('disabled', false);
        user_href = $('#user-id').prop('href');
        user_href_splited = user_href.split('=');
        user_id = user_href_splited[user_href_splited.length - 1];

        image_href = $(this).prop('src');
        image_href_splited = image_href.split('/');
        image_name = image_href_splited[image_href_splited.length - 1];
        // did pass data when used .prop();
        photo_id = $(this).attr('data');

        $.ajax({
            url: 'includes/ajax_code.php',
            data: {photo_id: photo_id},
            type: 'POST',
            success: function (data) {
                if (!data.error) {
                    $('#modal-sidebar').html(data);
                }
            }
        });
    });

    $('#set_user_image').click(function () {
        $.ajax({
            url: 'includes/ajax_code.php',
            data: {image_name: image_name, user_id: user_id},
            type: 'POST',
            success: function (data) {
                if (!data.error) {
                    $('.user_image_box a img').prop('src', data);
                    //location.reload(true);
                }
            }
        });
    });
});
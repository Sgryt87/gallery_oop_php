<?php

include 'includes/init.php';

if (!$session->is_signed_in()) {
    redirect("login.php");
}

if (empty($_GET['id'])) {
    redirect('comments.php');
}

$comment = Comment::find_by_id($_GET['id']);

if ($comment) {
    $comment->delete();
    $session->message("The comment with {$comment->photo_id} has been deleted");
    redirect("photo_comment.php?id={$_GET['id']}");
} else {
    redirect("photo_comment.php?id={$_GET['id']}");
}
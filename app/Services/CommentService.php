<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    public function createComment($diyId, $userId, $content)
    {
        $comment = new Comment();
        $comment->diy_id = $diyId;
        $comment->user_id = $userId;
        $comment->content = $content;
        $comment->save();

        return $comment;
    }

    public function deleteComment($comment)
    {
        $comment->delete();
    }
}

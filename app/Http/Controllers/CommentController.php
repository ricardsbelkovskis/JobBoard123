<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request)
    {
        $validatedData = $request->validated();

        $diyId = $validatedData['diy_id'];
        $userId = auth()->user()->id;
        $content = $validatedData['content'];

        $comment = $this->commentService->createComment($diyId, $userId, $content);

        return redirect()
            ->back()
            ->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        $this->commentService->deleteComment($comment);

        return redirect()
            ->back()
            ->with('success', 'Comment deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'diy_id' => 'required|exists:diys,id',
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->diy_id = $validatedData['diy_id'];
        $comment->user_id = auth()->user()->id;
        $comment->content = $validatedData['content'];
        $comment->save();

        return redirect()
            ->back()
            ->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()
            ->back()
            ->with('success', 'Comment deleted successfully');
    }
}


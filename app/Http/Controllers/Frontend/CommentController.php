<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * ADICIONANDO UM COMENTARIO VINCULADO A UMA NOTICIA
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleComment(Request $request): RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->save();

        toast(__('frontend.Comment added successfully'), 'success');
        return redirect()->back();
    }

    /**
     * ADICIONANDO UM COMENTARIO RESPOSTA, A OUTRO COMENTARIO, DE UMA NOTICIA
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleReply(Request $request): RedirectResponse
    {
        $request->validate([
            'reply' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->reply;
        $comment->save();

        toast(__('frontend.Comment added successfully'), 'success');
        return redirect()->back();
    }

    /**
     * APAGANDO O COMENTARIO
     * @param Request $request
     * @return JsonResponse
     */
    public function commentDestroy(Request $request): JsonResponse
    {
        $comment = Comment::findOrFail($request->id);
        if (Auth::user()->id === $comment->user_id) {
            $comment->delete();
            return response()->json(['status' => 'success', 'message' => __('frontend.Deleted Successfully!')]);
        }

        return response()->json(['status' => 'error', 'message' => __('frontend.Someting went wrong!')]);
    }
}

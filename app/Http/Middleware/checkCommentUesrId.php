<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comentari;

class checkCommentUesrId
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $comment = Comentari::find($request->route('id'));

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        if ($user->id !== $comment->user_id && $user->rol !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}

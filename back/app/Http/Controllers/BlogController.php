<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{

/**
 * Get a paginated list of articles.
 *
 * @param  Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function getArticles(Request $request)
{
    $page = $request->input('page', 1);
    $articles = Article::orderBy("created_at", "desc")->paginate(18, ['*'], 'page', $page);
    return response()->json($articles, 200);
}

    /**
     * Show the blogs of a specific user.
     *
     * @param  Request  $request
     * @param  string  $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUserBlog(Request $request, $username)
    {
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $page = $request->input('page', 1);

        $articles = $user->articles($page);

        if ($page > $articles->lastPage()) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        return response()->json([
            'author'        => $user,
            'articles'      => $articles->items(),
            'page'          => $page,
            'total_pages'   => $articles->lastPage()
        ], 200);
    }

    /**
     * Create a new article.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createArticle(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string'
        ]);

        $article            = new Article();
        $article->title     = $request->input('title');
        $article->content   = $request->input('content');
        $article->user_id   = auth()->id();
        $article->save();

        return response()->json(['message' => 'Article created successfully', 'article' => $article], 201);
    }

    /**
     * Show a specific article.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOneArticle($id)
    {
        $article = Article::with('user')->findOrFail($id);
        return response()->json($article, 200);
    }
}

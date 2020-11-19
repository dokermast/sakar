<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(5);
        return response()->json(['articles' => $articles]);
    }


    public function store(Request $request)
    {
        $article = new Article();
        $input = $request->except('_token');

        $validator = Validator::make($input, [
            'title' => ['required', 'string', 'max:10'],
            'content' => ['required', 'string', 'max:300'],
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, "message" => $validator->messages()]);
        }

        $article->title = $input['title'];
        $article->content = $input['content'];

        if ($request->file('image')) {
            $img_path = $request->file('image')->store('uploads', 'public');
            $article->img_path = $img_path;
            $article->img_file = $input['image']->getClientOriginalName();
            if (!$article->save()) {
                unlink('storage/' . $img_path);
                return response()->json(['success' => false, "message" => "didn\'t saved"]);
            }

            return response()->json(['success' => true, "message" => "saved!"]);

        } else {
            $article->save();

            return response()->json(['success' => true, "message" => "saved!"]);
        }
    }


    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if ($article) {
            Article::destroy($id);
            return response()->json( ["success" => true, "message" => "article was removed"]);
        } else {
            return response()->json(["success" => false, "message" => "article wasn\'t removed"]);
        }
    }
}

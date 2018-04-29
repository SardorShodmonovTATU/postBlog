<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Dislike;
use App\Like;
use App\Profile;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use function PHPSTORM_META\type;

class PostController extends Controller
{
    public  function index(){
        $posts = Post::all();
        return view('posts.index', ['posts'=>$posts]);

    }





    public  function post(){
        $categories =  Category::all();
        //$posts = Post::all();

        return view('posts.post', ['categories'=>$categories]);
    }



    public  function search(Request $request){
        $user_id = Auth::user()->id;
        $profile = (new Profile)->find($user_id);
        $keyword = $request->input('search');
        $posts = (new Post)->where('post_title','LIKE', '%'.$keyword.'%')
            ->get();
        $posts = (new Post)->where('post_body','LIKE', '%'.$keyword.'%')
            ->get();
        return  view('posts.searchposts', ['profile' =>$profile,'keyword'=>$keyword, 'posts'=>$posts]);

    }

    /**
     * @param $post_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */



    public function show($post_id){
        $post = (new Post)->find($post_id);
        $categories = Category::all();

        $comments = DB::table('users')
            ->join('comments', 'users.id','=', 'comments.user_id')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->select('users.name','comments.*')
            ->where(['posts.id'=>$post_id])
            ->get();
        $likeStr = (new Like)->where('post_id','=',$post->id)->count();
        $dislikeStr = (new Dislike)->where(['post_id'=>$post->id])->count();

        return view('posts.view',
            [
                'post' => $post,
                'categories'=>$categories,
                'likeStr'=>$likeStr,
                'dislikeStr'=>$dislikeStr,
                'comments'=>$comments
            ]);
    }





    public function edit($post_id){
        $categories = Category::all();
        $post = (new \App\Post)->find($post_id);
        $category = (new \App\Category)->find($post->category_id);
        return view('posts.edit',['categories'=>$categories, 'post'=>$post, 'category'=>$category]);
    }

    /**
     * @param Request $request
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editPost(Request $request, $post_id){
        $this->validate($request,[
                'post_title'=>'required',
                'post_body'=>'required',
                'category_id'=>'required',
                'post_image'=>'required'
            ]
        );
        $posts = new Post();
        $posts ->post_title = $request->input('post_title');
        $posts ->post_body = $request->input('post_body');
        $posts ->user_id = Auth::user()->id;
        $posts ->category_id = $request->input('category_id');
        if(Input::hasFile('post_image')){
            $file = Input::file('post_image');
            $file->move(public_path().'/post_images/', $file->getClientOriginalName());
            $url = URL::to('/') .'/post_images/'. $file->getClientOriginalName();
        }
        $posts -> post_image = $url;
        $data  = array(
            'post_title'=>$posts->post_title,
            'user_id'=>$posts->user_id,
            'post_body'=>$posts->post_body,
            'category_id'=>$posts->category_id,
            'post_image'=>$posts->post_image,

        );
        (new \App\Post)->where('id', $post_id)->update($data);

        return redirect('/home')->with('response', 'Post Update Successfully!!!');

    }

    public function addPost(Request $request){
         $this->validate($request,[
                 'post_title'=>'required',
                 'post_body'=>'required',
                 'category_id'=>'required',
                 'post_image'=>'required'
             ]
         );
         $posts = new Post();
        $posts ->post_title = $request->input('post_title');
        $posts ->post_body = $request->input('post_body');
        $posts ->user_id = Auth::user()->id;
        $posts ->category_id = $request->input('category_id');
        if(Input::hasFile('post_image')){
            $file = Input::file('post_image');
            $file->move(public_path().'/post_images/', $file->getClientOriginalName());
            $url = URL::to('/') .'/post_images/'. $file->getClientOriginalName();
        }
        $posts -> post_image = $url;
        $posts->save();
        return redirect('/home')->with('response', 'Post Added Successfully!!!');
    }

    /**
     * @param $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception

     */

    public  function deletePost($post){
        $post = (new \App\Post)->find($post);
        $post->delete();
        return redirect('/home')->with('response', 'Post Deletes Successfully!!!');
    }



    public  function category($category_id){
        $category = (new Category)->find($category_id);
        $categories = Category::all();
        $posts = DB::table('posts')
            ->join('categories', 'posts.category_id','=', 'categories.id')
            ->select('posts.*','categories.*')
            ->where(['categories.id'=>$category_id])
            ->get();
        return view('categories.categoriesposts',
            [
                'categories'=>$categories,
                'category'=>$category,
                'posts'=>$posts
            ]);
    }


    public function addLike($post_id){
        $loggedin_user = Auth::user()->id;
        $like_user = (new Like)->where(['user_id'=>$loggedin_user, 'post_id'=>$post_id])->first();
       if(empty($like_user->user_id))
        {
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $like = new Like;
            $like->user_id = $user_id;
            $like->email= $email;
            $like->post_id = $post_id;
            $like->save();
            return redirect('/view/{post}')->with('response', 'Comment Added Successfully!!!');

        }
        else{return redirect('/view/{post}');}


    }


    public function disLike($post_id){
        $loggedin_user = Auth::user()->id;
        $like_user = (new Dislike)->where(['user_id'=>$loggedin_user, 'post_id'=>$post_id])->first();
        if(empty($like_user->user_id))
        {
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $like = new Dislike;
            $like->user_id = $user_id;
            $like->email= $email;
            $like->post_id = $post_id;
            $like->save();
            return redirect('/view/{post}');

        }
        else{return redirect('/view/{post}');}

    }



    public  function comment(Request $request , $id){
        $this->validate($request,[
            'comment'=>'required'
        ]);
        $comment = new Comment;
        $comment->comment = $request->input('comment');
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $id;
        $comment->save();
        return redirect('/view/{id}');
    }
}

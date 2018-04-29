@extends('layouts.app')
<style>
    .avatar{
        border-radius:49%;
        max-width: 120px;
    }
    .postimg{
        max-width: 500px;
    }
</style>
@section('content')
<div class="container">
    <div class=""></div>
    <div class="row justify-content-center">
        <div class="card col-lg-12">
            @if(session('response'))
                 <div class=" alert alert-success">{{session('response')}}</div>
            @endif
            <div class="card-header">Post</div>
               <div class="card-body">
                   <div class="row">
                        <div class="col col-md-4">
                                @if(count($categories)>0)
                                      <ul>
                                       @foreach($categories->all() as $category)

                                              <li class="list-group-item">
                                                  <a href="{{url('/category',['category'=>$category])}}">{{$category->category}}</a>
                                              </li>

                                       @endforeach
                                      </ul>
                                @endif
                        </div>
                       <div class="col col-8 text-center">
                             <h4 class="text-danger text-lg-left">{{$post->post_title}}</h4>
                           <img src="{{$post->post_image}}" class="postimg img-thumbnail img-fluid">
                           <p class="">{{$post->post_body}}</p>
                           <ul  class="nav nav-pills">
                               <li class="nav-item">
                                   <a href="{{url('/like',['id'=>$post->id])}}" class="" style="font-size: large;">
                                       <span class="fa fa-thumbs-up nav-link badge badge-pill badge-primary">( {{$likeStr}} )</span>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a role="button" href="{{url('/dislike',['id'=>$post->id])}}" class="mx-2" style="font-size: large;">
                                       <span class="fa fa-thumbs-down nav-link badge badge-pill badge-danger">( {{$dislikeStr}} )</span>
                                   </a>
                               </li>
                               <li class="">
                                   <a>
                                       <span class="fa fa-comment-o nav-link">Comment ( )</span>
                                   </a>
                               </li>
                           </ul>
                           <cite style="float: left;">Posted on: {{date('M j, Y, H : i '), strtotime($post->updated_at)}}.</cite>
                           <form method="post" action="{{url('/comment', [$post->id])}}">
                               {{csrf_field()}}
                               <div class="form-group">
                           <textarea type="text" name="comment" id="comment" rows="6" class="form-control" required autofocus>

                           </textarea>

                               </div>
                               <div class="form-group">
                                   <button type="submit" class="btn btn-success btn-lg btn-block">Post Comment</button>
                               </div>
                           </form>
                           <h3>Comments</h3>
                           @if(count($comments)>0)
                                @foreach($comments as $comment)
                                     <p>{{$comment->comment}} </p>
                                   <p>Commented by : {{$comment->name}} at {{$comment->created_at}}</p>


                                @endforeach
                           @else
                               <p>No Comment Available!</p>
                           @endif
                       </div>


                   </div>

               </div>
        </div>
    </div>
</div>
@endsection

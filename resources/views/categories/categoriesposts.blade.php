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
                <div class="card-header text-center">Posts in {{$category->category}}</div>
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
                                @else
                                <p class="text-danger text-center">Categories not Founded</p>
                            @endif
                        </div>
                        <div class="col col-md-8 text-center">
                        @if(count($posts)>0)
                            @foreach($posts as $post)

                            <h4 class="text-danger text-lg-left">{{$post->post_title}}</h4>
                            <img src="{{$post->post_image}}" class="postimg img-thumbnail img-fluid">
                            <p class="">{{$post->post_body}}</p>

                            <cite style="float: left;">Posted on: {{date('M j, Y, H : i '), strtotime($post->updated_at)}}.</cite>
                             <hr>
                            @endforeach
                        @else
                        <p class="text-center text-danger">Posts not Founded</p>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
<style>
    .avatar{
        border-radius:50%;
        max-width: 200px;
    }
    .postimg{
        max-width: 400px;
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(count($errors)>0)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
                @if(session('response'))
                    <div class="alert alert-success text-center">{{session('response')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="row">

                            <div class="col col-3">Dashboard</div>
                            <div class="col-md-9">
                                <form method="POST" action="{{route('search.input')}}">
                                    {{csrf_field()}}
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control input-group" placeholder="Search for...">
                                        <span class="input-group-btn">
                                   <button type="submit" class="btn btn-danger">Search</button>
                                 </span>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                @if(!empty($profile))
                                    <img src="{{$profile->profile_pic}}" class="avatar" alt="">
                                @else
                                    <img src="{{url('images/avatar.png')}}" class="avatar" alt="">
                                @endif

                                @if(!empty($profile))
                                    <p class="lead">{{$profile->name}}</p>
                                @else
                                    <p></p>
                                @endif

                                @if(!empty($profile))
                                    <p class="lead">{{$profile->designation}}</p>
                                @else
                                    <p></p>
                                @endif
                            </div>
                            <div class="col-md-8 text-center">
                                @if(count($posts)>0)
                                    @foreach($posts->all() as $post)
                                        <h2>{{$post->post_title}}</h2>
                                        <img src="{{$post->post_image}}" class="postimg img-fluid img-thumbnail">
                                        <p>{{substr($post->post_body, 0 , 150)}}....</p>
                                        <ul  class="nav nav-pills">
                                            <li class="presentation">
                                                <a href="{{url('/view',['post'=>$post])}}">
                                                    <span class="fa fa-eye nav-link">View</span>
                                                </a>
                                            </li>
                                            <li class="presentation">
                                                <a href="{{url('/edit',['post'=>$post])}}">
                                                    <span class="fa fa-pencil-square-o nav-link">Edit</span>
                                                </a>
                                            </li>
                                            <li class="presentation">
                                                <a href="{{url('/delete',['post'=>$post])}}">
                                                    <span class="fa fa-trash-o nav-link">Delete</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <cite style="float: left;">Posted on: {{$post->created_at}}.</cite>
                                        <br>
                                        <hr>
                                    @endforeach
                                @else
                                    <p class="text-danger">No Posts Available!!!???</p>
                                @endif


                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

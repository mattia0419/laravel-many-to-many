@extends('layouts.app')

@section('content')
<div class="container">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Type</th>
            <th scope="col">Slug</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{$post->title}}</td>
                    <td>{!! $post->getTypeBadge() !!}</td>
                    <td>{{$post->slug}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>{{$post->updated_at}}</td>
                    <td></td>
                </tr>
        </tbody>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-success my-3">Torna alla lista</a>
      </table>
</div>
    
@endsection
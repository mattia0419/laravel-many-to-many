@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
@endsection

@section('content')
<div class="container">
    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-success my-3">Crea proggetto</a>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Type</th>
            <th scope="col">Technology</th>
            <th scope="col">Slug</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{$post->title}}</td>
                    <td>{!! $post->getTypeBadge() !!}</td>
                    <td>{!! $post->getTechnologyBadges() !!}</td>
                    <td>{{$post->slug}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>{{$post->updated_at}}</td>
                    <td>
                        <a href="{{ route('admin.posts.show', $post) }}"><i class="fa-regular fa-eye"></i></a>
                        <a href="{{ route('admin.posts.edit', $post) }}"><i class="fa-solid fa-pencil"></i></a>
                        <a data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $post->id }}">
                            <i class="fa-solid fa-trash fa-lg mt-3 text-danger"></i>              
                        </a>                   
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="6"><i>Non ci sono risultati</i></td>
            </tr>
            @endforelse
        </tbody>
      </table>

    {{ $posts->links('pagination::bootstrap-5') }}
</div>
    
@foreach($posts as $post)
              <div class="modal fade" id="delete-modal-{{ $post->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Elimina elemento</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Sei scuro di voler eliminare definitivamente?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                      <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Elimina</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
@endforeach

@endsection
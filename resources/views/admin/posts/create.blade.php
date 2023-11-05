@extends('layouts.app')

@section('content')
<div class="container">
  <a href="{{ route('admin.posts.index') }}" class="btn btn-success mt-3">Torna alla lista</a>
    <h1 class="my-5">Crea ptogetto</h1>
    @if($errors->any())
    <div class="alert alert-danger">
          <h3>Correggi i seguenti errori:</h3>
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
    </div>
    @endif
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-3">
      <div class="col-4">
        <label for="title">
          Titolo
      </label>
      <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
      @error('title')
      <div class="invalid-feedback">
          {{ $message }}
      </div>
      @enderror
      </div>
      <div class="col-4">
        <label for="type_id">
          Type
        </label>
        <select name="type_id" id="type_id" class="form-select">
          <option value="" @if(old('type_id') == '') selected @endif>Senza tipo</option>
          @foreach ($types as $type)
          <option value="{{ $type->id }}" @if(old('type_id') == $type->id) selected @endif>{{ $type->name }}</option>
          @endforeach
        </select>
        @error('type_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="col-4">
        <label for="slug">
          Slug
        </label>
        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}">
        @error('slug')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="col-12">
        <div class="row">
          <div class="col-8">
            <label for="cover_image">
              Cover
          </label>
          <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image') is-invalid @enderror" value="{{ old('cover_image') }}">
          @error('cover_image')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
          @enderror
          </div>
          <div class="col-4">
            <img src="" alt="" class="img-fluid" id="cover_image_preview">
          </div>
        </div>
      </div>
      <div class="col-12 mb-4">
        <div class="row form-check @error ('technologies') is-invalid @enderror">
          @foreach ($technologies as $technology)
          <div class="col-2">
            <input type="checkbox" name="technologies[]" id="technologies-{{$technology->id}}" value="{{$technology->id}}" class="form-check-control" @if(in_array($technology->id, old('technologies') ?? [])) checked @endif>
            <label for="technologies-{{$technology->id}}">{{$technology->label}}</label>
          </div>
          @endforeach
        </div>
        @error('technologies')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>
      <div class="col-12">
        <label for="content">
            Contenuto
        </label> 
        <textarea name="content" id="content" cols="30" rows="5" class="form-control @error('content') is-invalid @enderror" value="{{ old('content') }}"></textarea>
        @error('content')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
      </div>
      <div class="col-3">
        <button class="btn btn-primary mt-3">Salva</button>
      </div>
    </div>
    </form>
</div> 
@endsection

@section('scripts')
<script type="text/javascript">
  const inputFileElement = document.getElementById('cover_image');
  const coverImagePreview = document.getElementById('cover_image_preview');
  inputFileElement.addEventListener('change', function(){
    const [file] = this.files;
    coverImagePreview.src = URL.createObjectURL(file);
  })
</script>
@endsection
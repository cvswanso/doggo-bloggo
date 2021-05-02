@extends('layouts.main')

@section('title', 'Create Post')

@section('content')
    <h3 id="name">Create a New Post</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <p class="error">Please correct the following errors prior to posting:</p>
            <ul class="error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ route('post.store') }}">
        @csrf
        <div class="mb-3 form-group row">
            <label class="form-label light-text" for="name">Title</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="mb-3 form-group row">
            <label class="form-label light-text" for="tags">Add Tags</label>
                <select id="tags" data-placeholder="Start typing a tag name" multiple class="form-control form-control-chosen" name="tags[]">
                    @foreach ($tags as $tag)
                        <?php $selected = False; ?>
                        @if (old('tags') != null)
                            @foreach (old('tags') as $oldtag)
                                @if ($tag->id == $oldtag)
                                    <?php $selected = True; ?>
                                @endif
                            @endforeach
                        @endif
                        @if ($selected)
                            <option selected value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </option>
                        @else 
                            <option value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </option>
                        @endif

                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label light-text" for="content">Content</label>
            <textarea id="content" name="content" class="form-control">{{ old('content') }}</textarea>
        </div>
        <button type="submit" value="Post" class="btn btn-accent">Post</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/49954d4722.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <script>
        $('.form-control-chosen').chosen();
    </script>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie</title>
</head>
<body>

  <form method="POST" action="{{ route('lists.update', ['id' => $list->id])}}" class="form">
    {{ csrf_field() }}
  @method('PATCH')

    <div class="form-group">
        <label for="title">映画タイトル</label><br>
        <input type="text" name="title" value="{{ old('title', $list->title) }}" >
        @error('title')
          <div class="error"><span>{{ $message }}</span></div>
        @enderror
    </div>
    <div class="form-group">
        <label for="image_url">画像URL</label><br>
        <input type="text" name="image_url" value="{{ old('image_url', $list->image_url) }}">
        @error('image_url')
          <div class="error"><span>{{ $message }}</span></div>
        @enderror
    </div>
    <div class="form-group">
        <label for="published_year">公開年</label><br>
        <input type="text" name="published_year" value="{{ old('published_year', $list->published_year) }}">
        @error('published_year')
          <div class="error"><span>{{ $message }}</span></div>
        @enderror
    </div>
    <div class="form-group">
        <label for="is_showing">公開中かどうか</label><br>
        <input type="hidden" name="is_showing" id="" value="0">
        <input type="checkbox" name="is_showing" id="" value="1">上映中<br>
        @error('is_showing')
          <div class="is_showing"><span>{{ $message }}</span></div>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">概要</label><br>
        <input type="text" name="description" value="{{ old('description', $list->description) }}">
        @error('description')
          <div class="description"><span>{{ $message }}</span></div>
        @enderror
    </div>
    <div class="form-group">
        <label for="genre">ジャンル</label><br>
        <input type="text" name="genre" value="{{ old('genre', $list->genre->name ) }}">
        @error('genre')
          <div class="genre"><span>{{ $message }}</span></div>
        @enderror
    </div>

    <button type="submit">更新</button>
    </form>
</body>
</html>

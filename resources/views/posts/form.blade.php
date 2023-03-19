<div class="form-group">
        <label for="title">Your title</label>
        <input class="form-control" name="title" id="title" type="text" value="{{old('title',$post->title ?? null)}}" >
    </div>
    <div>
        <label for="content"> Your content</label>
        <input class="form-control" type="text" name="content" id="content" value="{{old('content',$post->content ?? null)}}">
    </div>

    <br>

    <div class="form-group">
        <labael for="picture">Picture</labael><br>
        <input type="file" name="picture" id="picture" class="form-control-file">
    </div>

    <x-errors></x-errors>
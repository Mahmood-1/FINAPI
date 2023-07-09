<div class="form-group">
    <x-form.input label="Food Name" name="name"  :value="$foods->name"/>
</div>

<div class="form-group">
    <x-form.textarea label="Food Description "
       name="desc" :value="$foods->desc"/>
</div>
<div class="form-group">
    <x-form.input label="Food Image"  name="image" type="file"  :value="$foods->image" accept="image/*"/>
    @if($foods->image)
        <img src="{{asset($foods->image)}}" alt="not" height="70">
    @endif
    <br>
</div>
<div>
    <button type="submit" class="btn btn-outline-info">{{$button_label ??'Save'}}</button>
</div>


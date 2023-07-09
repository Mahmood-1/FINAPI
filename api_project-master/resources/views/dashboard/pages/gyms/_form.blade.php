<div class="form-group">
    <x-form.input label="Gym Name" name="name"  :value="$gym->name"/>
</div>

<div class="form-group">
    <x-form.textarea label="Gym Description "
       name="desc" :value="$gym->desc"/>
</div>
<div class="form-group">
    <x-form.input label="Gym location" name="location"  :value="$gym->location"/>
</div>
<div class="form-group">
    <x-form.input label="Gym Image"  name="image" type="file"  :value="$gym->image" accept="image/*"/>
    @if($gym->image)
        <img src="{{asset($gym->image)}}" alt="not" height="70">
    @endif
    <br>
</div>
<div>
    <button type="submit" class="btn btn-outline-info">{{$button_label ??'Save'}}</button>
</div>


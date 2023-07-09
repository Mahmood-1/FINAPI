<div class="form-group">
    <x-form.input label="foodM Name" name="name"  :value="$foodM->name"/>
</div>
<div class="form-group">
    <select style="background-color: #dcdcdc; color: black" class="form-control" id="stars" name="food_id" required>
        <option value="">Select Food</option>
        @foreach($food as $foodItem)
            <option value="{{$foodItem->id }}" {{$foodM->food_id == $foodItem->id ? 'selected' : '' }}>{{ $foodItem->name }}</option>
        @endforeach

    </select>
</div>








<div class="form-group">
    <x-form.input label="foodM desc" name="desc"  :value="$foodM->desc"/>
</div>
<div class="form-group">
    <x-form.input label="foodM Image"  name="image" type="file"  :value="$foodM->image" accept="image/*"/>
    @if($foodM->image)
        <img src="{{asset($foodM->image)}}" alt="not" height="70">
    @endif
    <br>
</div>
<div>
    <button type="submit" class="btn btn-outline-info">{{$button_label ??'Save'}}</button>
</div>


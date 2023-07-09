<div class="form-group">
    <x-form.input label="fitness Name" name="title"  :value="$post->title"/>
</div>
<br>
<div class="form-group">
    <select     style="background-color: #dcdcdc;color:black"
                class="form-control" id="stars" name="stars" required>
        <option value="">Select gender</option>
        <option value="1" <?php if($post->gender === 'male') echo 'selected'; ?>>male</option>
        <option value="2" <?php if($post->gender === 'female') echo 'selected'; ?>>female</option>

    </select>
</div>
<div class="form-group">
    <x-form.input label="fitness youtube" name="youtube"  :value="$post->youtube"/>
</div>

<div>
    <button type="submit" class="btn btn-outline-info">{{$button_label ??'Save'}}</button>
</div>


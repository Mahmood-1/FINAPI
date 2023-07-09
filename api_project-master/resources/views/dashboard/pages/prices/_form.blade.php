<div class="form-group">
    <x-form.input label="prices Name" name="project_name" />
</div>

<div class="form-group">
    <x-form.input label="prices Description "
       name="project_description" />
</div>

<div class="form-group">
    <x-form.input label="Authors  Image "  name="authors_photo" type="file"   accept="image/*"/>

    <br>
</div>

<br><br>
<div>
    <button type="submit" class="btn btn-outline-info">{{$button_label ??'Save'}}</button>
</div>

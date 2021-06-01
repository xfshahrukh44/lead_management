@csrf
<div class="modal-body row">
   <!-- website_keyword_2 -->
   <div class="form-group col-md-6">
    <label for="">keyword Type</label>
    <select class="form-control form-select-sm logo_keyword" name= "keyword_type_id" aria-label=".form-select-sm example">
        <option value="">Select Keyword Type </option>
        @foreach($keywordtypes as $value)
        <option value="{{$value->id}}">{{$value->keyword_name}}</option>
        @endforeach
    </select>
</div>
<!-- website_keyword_1 -->
<div class="form-group col-md-6">
    <label for="">Keyword</label>
    <input type="text" name="website_keyword" placeholder="Enter Keyword" class="form-control website_keyword_1">
</div>

</div>
@csrf
<div class="modal-body row">
    <!-- date -->
    <div class="form-group col-md-4">
        <label for="">Date</label>
        <input type="date" name="date" placeholder="Enter Date" class="form-control date" >
    </div>
    <!-- name -->
    <div class="form-group col-md-4">
        <label for="">Name</label>
        <input type="text" name="name" placeholder="Enter Name" class="form-control name" required>
    </div>
    <!-- location -->
    <div class="form-group col-md-4">
        <label for="">Location</label>
        <input type="text" name="location" placeholder="Enter Location" class="form-control location">
    </div>
    <!-- email -->
    <div class="form-group col-md-4">
        <label for="">Email</label>
        <input type="text" name="email" placeholder="Enter Email" class="form-control email">
    </div>
    <!-- number -->
    <div class="form-group col-md-4">
        <label for="">Number</label>
        <input type="text" name="number" placeholder="Enter Number" class="form-control number">
    </div>
    <!-- lead_from -->
    <div class="form-group col-md-4">
        <label for="">Lead From</label>
        <input type="text" name="lead_from" placeholder="Enter Lead From" class="form-control lead_from">
    </div>
    <!-- assigned_to -->
    <div class="form-group col-md-4">
        <label for="">Assigned To</label>
        <input type="text" name="assigned_to" placeholder="Enter Assigned To" class="form-control assigned_to">
    </div>
    <!-- website -->
    <div class="form-group col-md-4">
        <label for="">Website</label>
        <input type="text" name="website" placeholder="Enter Website" class="form-control website">
    </div>
    <!-- platform -->
    <div class="form-group col-md-4">
        <label for="">Platform</label>
        <input type="text" name="platform" placeholder="Enter Platform" class="form-control platform">
    </div>
    <!-- keyword -->
    <div class="form-group col-md-6">
        <label for="">Keyword</label>
        <input type="text" name="keyword" placeholder="Enter Keyword" class="form-control keyword">
    </div>
    <!-- profile_link -->
    <div class="form-group col-md-6">
        <label for="">Profile Link</label>
        <input type="text" name="profile_link" placeholder="Enter Profile Link" class="form-control profile_link">
    </div>
    <!-- query -->
    <div class="form-group col-md-12">
        <label for="">Query</label>
        <!-- <input name="query" placeholder="Enter Query" class="form-control query"> -->
        <textarea name="query" placeholder="Enter Query" class="form-control query" rows="4" cols="50"></textarea>
    </div>
    <!-- status -->
    <div class="form-group col-md-12">
        <label>Status:</label>
        <br>
        <label class="switch">
            <input type="checkbox" name="status" class="status form-control">
            <span class="slider"></span>
        </label>
    </div>
    </label>
</div>
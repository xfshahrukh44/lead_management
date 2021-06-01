@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-12 col-md-12 col-lg-12">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <h1 class="m-0 text-dark"><i class="nav-icon far fa-star"></i> Logos</h1>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- toggle slider css -->
<style>
/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addLogoModal">
            <i class="fas fa-plus"></i>
          </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_logos')}}" class="form-wrapper">
          <div class="row">
            <!-- search bar -->
            <div class="topnav col-md-4">
              <input name="query" class="form-control" id="search_content" type="text" placeholder="Search..">
            </div>
            <!-- search button-->
            <button type="submit" class="btn btn-primary col-md-0 justify-content-start" id="search_button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="col-md-12" style="overflow-x:auto;">
          <table id="example1" class="table table-bordered table-striped dataTable dtr-inline table-sm" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">S.No</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Date</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Name</th>
                <!-- <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Location</th> -->
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Email</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Number</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Lead From</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Assigned To</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Website</th>
                <!-- <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Platform</th> -->
                <!-- <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Keyword</th> -->
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Profile Link</th>
                <!-- <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Query</th> -->
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Status</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Created By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Modified By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($logos) > 0)
              @foreach($logos as $logo)
              <tr role="row" class="odd">
                <td>{{$logo->id}}</td>
                <td>{{$logo->date ? return_date_wo_time($logo->date) : NULL}}</td>
                <td>{{$logo->name ? $logo->name : NULL}}</td>
                <!-- <td>{{$logo->location ? $logo->location : NULL}}</td> -->
                <td>{{$logo->email ? $logo->email : NULL}}</td>
                <td>{{$logo->number ? $logo->number : NULL}}</td>
                <td>{{$logo->logo_from ? $logo->lead_from : NULL}}</td>
                <td>{{$logo->assigned_to ? $logo->assigned_to : NULL}}</td>
                <td>{{$logo->website ? $logo->website : NULL}}</td>
                <!-- <td>{{$logo->platform ? $logo->platform : NULL}}</td> -->
                <!-- <td>{{$logo->keyword ? $logo->keyword : NULL}}</td> -->
                <td><a href="{{$logo->profile_link ? $logo->profile_link : '#'}}" target="_blank">{{$logo->profile_link ? $logo->profile_link : NULL}}</a></td>
                <!-- <td>{{$logo->query ? $logo->query : NULL}}</td> -->
                <!-- status -->
                <td class="{{'status'.$logo->id}}">
                  <label class="switch">
                    @if($logo->status == "Active")
                      <input type="checkbox" data-id="{{$logo->id}}" class="input_status" checked>
                    @else
                      <input type="checkbox" data-id="{{$logo->id}}" class="input_status">
                    @endif
                    <span class="slider"></span>
                  </label>
                </td>
                <td>{{$logo->created_by ? return_user_name($logo->created_by) : NULL}}</td>
                <td>{{$logo->modified_by ? return_user_name($logo->modified_by) : NULL}}</td>
                <td width="100">
                  <!-- Detail -->
                  <a href="#" class="detailButton" data-id="{{$logo->id}}">
                    <i class="fas fa-eye green ml-1"></i>
                  </a>
                  @if(auth()->user()->type == 'Manager' || auth()->user()->type == 'Admin' || auth()->user()->id == $logo->created_by)
                  <!-- Edit -->
                  <a href="#" class="editButton" data-id="{{$logo->id}}">
                    <i class="fas fa-edit blue ml-1"></i>
                  </a>
                  <!-- Delete -->
                  <a href="#" class="deleteButton" data-id="{{$logo->id}}">
                    <i class="fas fa-trash red ml-1"></i>
                  </a>
                  @endif
                </td>
              </tr>
              @endforeach
              @else
              <tr><td colspan="15"><h6 align="center">No logo(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          @if(count($logos) > 0)
          {{$logos->appends(request()->except('page'))->links('pagination::bootstrap-4')}}
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Create view -->
  <div class="modal fade" id="addLogoModal" tabindex="-1" role="dialog" aria-labelledby="addLogoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 64rem;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addLogoModalLabel">Add New Logo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{route('logo.store')}}" enctype="multipart/form-data">
          @include('admin.logo.logo_master')
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="createButton">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit view -->
  <div class="modal fade" id="editLogoModal" tabindex="-1" role="dialog" aria-labelledby="editLogoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 64rem;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editLogoModalLabel">Edit Logo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editForm" method="POST" action="{{route('logo.update', 1)}}" enctype="multipart/form-data">
          <!-- hidden input -->
          @method('PUT')
          <input id="hidden" type="hidden" name="hidden">
          @include('admin.logo.logo_master')
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Detail view -->
  <div class="modal fade" id="viewLogoModal" tabindex="-1" role="dialog" aria-labelledby="addLogoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Logo Detail</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- tables -->
        <div class="card-body row row overflow-auto col-md-12" style="height:36rem;">
          <!-- section 1 -->
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-sm">
              <tbody id="table_row_wrapper">
                <!-- date -->
                <tr role="row" class="odd">
                  <th class="">Date</th>
                  <td class="date"></td>
                </tr>
                <!-- name -->
                <tr role="row" class="odd">
                  <th class="">Name</th>
                  <td class="name"></td>
                </tr>
                <!-- lcoation -->
                <tr role="row" class="odd">
                  <th class="">Location</th>
                  <td class="location"></td>
                </tr>
                <!-- email -->
                <tr role="row" class="odd">
                  <th class="">Email</th>
                  <td class="email"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- section 2 -->
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-sm">
              <tbody id="table_row_wrapper">
                <!-- number -->
                <tr role="row" class="odd">
                  <th class="">Number</th>
                  <td class="number"></td>
                </tr>
                <!-- lead_from -->
                <tr role="row" class="odd">
                  <th class="">Lead From</th>
                  <td class="lead_from"></td>
                </tr>
                <!-- assigned_to -->
                <tr role="row" class="odd">
                  <th class="">Assigned To</th>
                  <td class="assigned_to"></td>
                </tr>
                <!-- website -->
                <tr role="row" class="odd">
                  <th class="">Website</th>
                  <td class="website"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- section 3 -->
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-sm">
              <tbody id="table_row_wrapper">
                <!-- platform -->
                <tr role="row" class="odd">
                  <th class="">Platform</th>
                  <td class="platform"></td>
                </tr>
                <!-- keyword -->
                <tr role="row" class="odd">
                  <th class="">Keyword</th>
                  <td class="keyword"></td>
                </tr>
                <!-- profile_link -->
                <tr role="row" class="odd">
                  <th class="">Profile Link</th>
                  <td class="profile_link"></td>
                </tr>
                <!-- query -->
                <tr role="row" class="odd">
                  <th class="">Query</th>
                  <td class="query"></td>
                </tr>
                <!-- status -->
                <tr role="row" class="odd">
                  <th class="">Status</th>
                  <td class="status"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>


        <div class="card-footer">
          <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete view -->
  <div class="modal fade" id="deleteLogoModal" tabindex="-1" role="dialog" aria-labelledby="deleteLogoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteLogoModalLabel">Delete Logo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteForm" method="POST" action="{{route('logo.destroy', 1)}}">
          <!-- hidden input -->
          @method('DELETE')
          @csrf
          <input class="hidden" type="hidden" name="hidden">
          <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal">No</button>
            <button type="submit" class="btn btn-danger" id="deleteButton">Yes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function(){
  // $('#area_id').select2();
  // $('#market_id').select2();
  // datatable
  // $('#example1').DataTable();
  // $('#example1').dataTable({
  //   "bPaginate": false,
  //   "bLengthChange": false,
  //   "bFilter": true,
  //   "bInfo": false,
  //   "searching":false
  // });

  // global vars
  var logo = "";
  
  // persistent active sidebar
  var element = $('li a[href*="'+ window.location.pathname +'"]');
  element.parent().parent().parent().addClass('menu-open');
  element.addClass('active');

  // fetch logo
  function fetch_logo(id){
    // fetch logo
    $.ajax({
      url: "<?php echo(route('logo.show', 1)); ?>",
      type: 'GET',
      async: false,
      data: {id: id},
      dataType: 'JSON',
      success: function (data) {
        logo = data.logo;
      }
    });
  }

  // toggle_status
  function toggle_status(id){
    $.ajax({
        url: '<?php echo(route('toggle_logo_status')); ?>',
        type: 'GET',
        data: {
          id: id
        },
        dataType: 'JSON',
        async: false,
        success: function (data) {
          
        }
    });
  }

  // create
  $('#add_logo').on('click', function(){
  });
  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    fetch_logo(id);
    $('#editForm #hidden').val(id);
    $('#editForm .date').val((logo.date) ? (logo.date) : '');
    $('#editForm .name').val((logo.name) ? (logo.name) : '');
    $('#editForm .location').val((logo.location) ? (logo.location) : '');
    $('#editForm .email').val((logo.email) ? (logo.email) : '');
    $('#editForm .number').val((logo.number) ? (logo.number) : '');
    $('#editForm .lead_from').val((logo.lead_from) ? (logo.lead_from) : '');
    $('#editForm .assigned_to').val((logo.assigned_to) ? (logo.assigned_to) : '');
    $('#editForm .website').val((logo.website) ? (logo.website) : '');
    $('#editForm .platform').val((logo.platform) ? (logo.platform) : '');
    $('#editForm .keyword').val((logo.keyword) ? (logo.keyword) : '');
    $('#editForm .profile_link').val((logo.profile_link) ? (logo.profile_link) : '');
    $('#editForm .query').val((logo.query) ? (logo.query) : '');
    $('#editForm .created_by').val((logo.created_by) ? (logo.created_by) : '');
    $('#editForm .modified_by').val((logo.modified_by) ? (logo.modified_by) : '');
    // status
    if(logo.status == "Active"){
      $('#editForm .status').prop('checked', true);
    }
    else{
      $('#editForm .status').prop('checked', false);
    }
    $('#editLogoModal').modal('show');
  });
  // detail
  $('.detailButton').on('click', function(){
    var id = $(this).data('id');
    fetch_logo(id);

    $('#viewLogoModal .date').html(logo.date);
    $('#viewLogoModal .name').html(logo.name);
    $('#viewLogoModal .location').html(logo.location);
    $('#viewLogoModal .email').html(logo.email);
    $('#viewLogoModal .number').html(logo.number);
    $('#viewLogoModal .lead_from').html(logo.lead_from);
    $('#viewLogoModal .assigned_to').html(logo.assigned_to);
    $('#viewLogoModal .website').html(logo.website);
    $('#viewLogoModal .platform').html(logo.platform);
    $('#viewLogoModal .keyword').html(logo.keyword);
    $('#viewLogoModal .profile_link').html(logo.profile_link);
    $('#viewLogoModal .query').html(logo.query);
    $('#viewLogoModal .status').html(logo.status);

    $('#viewLogoModal').modal('show');
  });
  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('logo.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);
    $('#deleteLogoModalLabel').text('Delete Logo ?');
    $('#deleteLogoModal').modal('show');
  });

  // on .input_status click
  $('.input_status').on('click', function(){
    var id = $(this).data('id');
    toggle_status(id);
  });
});
</script>
@endsection('content_body')
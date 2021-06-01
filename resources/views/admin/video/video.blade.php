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
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-photo-video"></i>\ Videos</h1>
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
          <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addVideoModal">
            <i class="fas fa-plus"></i>
          </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_videos')}}" class="form-wrapper">
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
              @if(count($videos) > 0)
              @foreach($videos as $video)
              <tr role="row" class="odd">
                <td>{{$video->id}}</td>
                <td>{{$video->date ? return_date_wo_time($video->date) : NULL}}</td>
                <td>{{$video->name ? $video->name : NULL}}</td>
                <!-- <td>{{$video->location ? $video->location : NULL}}</td> -->
                <td>{{$video->email ? $video->email : NULL}}</td>
                <td>{{$video->number ? $video->number : NULL}}</td>
                <td>{{$video->video_from ? $video->lead_from : NULL}}</td>
                <td>{{$video->assigned_to ? $video->assigned_to : NULL}}</td>
                <td>{{$video->website ? $video->website : NULL}}</td>
                <!-- <td>{{$video->platform ? $video->platform : NULL}}</td> -->
                <!-- <td>{{$video->keyword ? $video->keyword : NULL}}</td> -->
                <td><a href="{{$video->profile_link ? $video->profile_link : '#'}}" target="_blank">{{$video->profile_link ? $video->profile_link : NULL}}</a></td>
                <!-- <td>{{$video->query ? $video->query : NULL}}</td> -->
                <!-- status -->
                <td class="{{'status'.$video->id}}">
                  <label class="switch">
                    @if($video->status == "Active")
                      <input type="checkbox" data-id="{{$video->id}}" class="input_status" checked>
                    @else
                      <input type="checkbox" data-id="{{$video->id}}" class="input_status">
                    @endif
                    <span class="slider"></span>
                  </label>
                </td>
                <td>{{$video->created_by ? return_user_name($video->created_by) : NULL}}</td>
                <td>{{$video->modified_by ? return_user_name($video->modified_by) : NULL}}</td>
                <td width="100">
                  <!-- Detail -->
                  <a href="#" class="detailButton" data-id="{{$video->id}}">
                    <i class="fas fa-eye green ml-1"></i>
                  </a>
                  @if(auth()->user()->type == 'Manager' || auth()->user()->type == 'Admin' || auth()->user()->id == $video->created_by)
                  <!-- Edit -->
                  <a href="#" class="editButton" data-id="{{$video->id}}">
                    <i class="fas fa-edit blue ml-1"></i>
                  </a>
                  <!-- Delete -->
                  <a href="#" class="deleteButton" data-id="{{$video->id}}">
                    <i class="fas fa-trash red ml-1"></i>
                  </a>
                  @endif
                </td>
              </tr>
              @endforeach
              @else
              <tr><td colspan="15"><h6 align="center">No video(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          @if(count($videos) > 0)
          {{$videos->appends(request()->except('page'))->links('pagination::bootstrap-4')}}
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Create view -->
  <div class="modal fade" id="addVideoModal" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 64rem;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addVideoModalLabel">Add New Video</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{route('video.store')}}" enctype="multipart/form-data">
          @include('admin.video.video_master')
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="createButton">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit view -->
  <div class="modal fade" id="editVideoModal" tabindex="-1" role="dialog" aria-labelledby="editVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 64rem;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editVideoModalLabel">Edit Video</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editForm" method="POST" action="{{route('video.update', 1)}}" enctype="multipart/form-data">
          <!-- hidden input -->
          @method('PUT')
          <input id="hidden" type="hidden" name="hidden">
          @include('admin.video.video_master')
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Detail view -->
  <div class="modal fade" id="viewVideoModal" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Video Detail</h5>

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
  <div class="modal fade" id="deleteVideoModal" tabindex="-1" role="dialog" aria-labelledby="deleteVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteVideoModalLabel">Delete Video</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteForm" method="POST" action="{{route('video.destroy', 1)}}">
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
  var video = "";
  
  // persistent active sidebar
  var element = $('li a[href*="'+ window.location.pathname +'"]');
  element.parent().parent().parent().addClass('menu-open');
  element.addClass('active');

  // fetch video
  function fetch_video(id){
    // fetch video
    $.ajax({
      url: "<?php echo(route('video.show', 1)); ?>",
      type: 'GET',
      async: false,
      data: {id: id},
      dataType: 'JSON',
      success: function (data) {
        video = data.video;
      }
    });
  }

  // toggle_status
  function toggle_status(id){
    $.ajax({
        url: '<?php echo(route('toggle_video_status')); ?>',
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
  $('#add_video').on('click', function(){
  });
  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    fetch_video(id);
    $('#editForm #hidden').val(id);
    $('#editForm .date').val((video.date) ? (video.date) : '');
    $('#editForm .name').val((video.name) ? (video.name) : '');
    $('#editForm .location').val((video.location) ? (video.location) : '');
    $('#editForm .email').val((video.email) ? (video.email) : '');
    $('#editForm .number').val((video.number) ? (video.number) : '');
    $('#editForm .lead_from').val((video.lead_from) ? (video.lead_from) : '');
    $('#editForm .assigned_to').val((video.assigned_to) ? (video.assigned_to) : '');
    $('#editForm .website').val((video.website) ? (video.website) : '');
    $('#editForm .platform').val((video.platform) ? (video.platform) : '');
    $('#editForm .keyword').val((video.keyword) ? (video.keyword) : '');
    $('#editForm .profile_link').val((video.profile_link) ? (video.profile_link) : '');
    $('#editForm .query').val((video.query) ? (video.query) : '');
    $('#editForm .created_by').val((video.created_by) ? (video.created_by) : '');
    $('#editForm .modified_by').val((video.modified_by) ? (video.modified_by) : '');
    // status
    if(video.status == "Active"){
      $('#editForm .status').prop('checked', true);
    }
    else{
      $('#editForm .status').prop('checked', false);
    }
    $('#editVideoModal').modal('show');
  });
  // detail
  $('.detailButton').on('click', function(){
    var id = $(this).data('id');
    fetch_video(id);

    $('#viewVideoModal .date').html(video.date);
    $('#viewVideoModal .name').html(video.name);
    $('#viewVideoModal .location').html(video.location);
    $('#viewVideoModal .email').html(video.email);
    $('#viewVideoModal .number').html(video.number);
    $('#viewVideoModal .lead_from').html(video.lead_from);
    $('#viewVideoModal .assigned_to').html(video.assigned_to);
    $('#viewVideoModal .website').html(video.website);
    $('#viewVideoModal .platform').html(video.platform);
    $('#viewVideoModal .keyword').html(video.keyword);
    $('#viewVideoModal .profile_link').html(video.profile_link);
    $('#viewVideoModal .query').html(video.query);
    $('#viewVideoModal .status').html(video.status);

    $('#viewVideoModal').modal('show');
  });
  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('video.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);
    $('#deleteVideoModalLabel').text('Delete Video ?');
    $('#deleteVideoModal').modal('show');
  });

  // on .input_status click
  $('.input_status').on('click', function(){
    var id = $(this).data('id');
    toggle_status(id);
  });
});
</script>
@endsection('content_body')
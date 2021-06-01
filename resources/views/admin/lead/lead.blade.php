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
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-headset "></i> Leads</h1>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addLeadModal">
            <i class="fas fa-plus"></i>
          </button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_leads')}}" class="form-wrapper">
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
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Created By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Modified By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($leads) > 0)
              @foreach($leads as $lead)
              <tr role="row" class="odd">
                <td>{{$lead->id}}</td>
                <td>{{$lead->date ? return_date_wo_time($lead->date) : NULL}}</td>
                <td>{{$lead->name ? $lead->name : NULL}}</td>
                <!-- <td>{{$lead->location ? $lead->location : NULL}}</td> -->
                <td>{{$lead->email ? $lead->email : NULL}}</td>
                <td>{{$lead->number ? $lead->number : NULL}}</td>
                <td>{{$lead->lead_from ? $lead->lead_from : NULL}}</td>
                <td>{{$lead->assigned_to ? $lead->assigned_to : NULL}}</td>
                <td>{{$lead->website ? $lead->website : NULL}}</td>
                <!-- <td>{{$lead->platform ? $lead->platform : NULL}}</td> -->
                <!-- <td>{{$lead->keyword ? $lead->keyword : NULL}}</td> -->
                <td><a href="{{$lead->profile_link ? $lead->profile_link : '#'}}" target="_blank">{{$lead->profile_link ? $lead->profile_link : NULL}}</a></td>
                <!-- <td>{{$lead->query ? $lead->query : NULL}}</td> -->
                <td>{{$lead->created_by ? return_user_name($lead->created_by) : NULL}}</td>
                <td>{{$lead->modified_by ? return_user_name($lead->modified_by) : NULL}}</td>
                <td width="100">
                  <!-- Detail -->
                  <a href="#" class="detailButton" data-id="{{$lead->id}}">
                    <i class="fas fa-eye green ml-1"></i>
                  </a>
                  @if(auth()->user()->type == 'Manager' || auth()->user()->type == 'Admin' || auth()->user()->id == $lead->created_by)
                  <!-- Edit -->
                  <a href="#" class="editButton" data-id="{{$lead->id}}">
                    <i class="fas fa-edit blue ml-1"></i>
                  </a>
                  <!-- Delete -->
                  <a href="#" class="deleteButton" data-id="{{$lead->id}}">
                    <i class="fas fa-trash red ml-1"></i>
                  </a>
                  @endif
                </td>
              </tr>
              @endforeach
              @else
              <tr><td colspan="15"><h6 align="center">No lead(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          @if(count($leads) > 0)
          {{$leads->appends(request()->except('page'))->links('pagination::bootstrap-4')}}
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Create view -->
  <div class="modal fade" id="addLeadModal" tabindex="-1" role="dialog" aria-labelledby="addLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 64rem;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addLeadModalLabel">Add New Lead</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{route('lead.store')}}" enctype="multipart/form-data">
          @include('admin.lead.lead_master')
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="createButton">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit view -->
  <div class="modal fade" id="editLeadModal" tabindex="-1" role="dialog" aria-labelledby="editLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 64rem;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editLeadModalLabel">Edit Lead</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editForm" method="POST" action="{{route('lead.update', 1)}}" enctype="multipart/form-data">
          <!-- hidden input -->
          @method('PUT')
          <input id="hidden" type="hidden" name="hidden">
          @include('admin.lead.lead_master')
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Detail view -->
  <div class="modal fade" id="viewLeadModal" tabindex="-1" role="dialog" aria-labelledby="addLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Lead Detail</h5>

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
  <div class="modal fade" id="deleteLeadModal" tabindex="-1" role="dialog" aria-labelledby="deleteLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteLeadModalLabel">Delete Lead</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteForm" method="POST" action="{{route('lead.destroy', 1)}}">
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
  var lead = "";
  
  // persistent active sidebar
  var element = $('li a[href*="'+ window.location.pathname +'"]');
  element.parent().parent().parent().addClass('menu-open');
  element.addClass('active');

  // fetch lead
  function fetch_lead(id){
      // fetch lead
      $.ajax({
        url: "<?php echo(route('lead.show', 1)); ?>",
        type: 'GET',
        async: false,
        data: {id: id},
        dataType: 'JSON',
        success: function (data) {
          lead = data.lead;
        }
      });
    }


  // create
  $('#add_lead').on('click', function(){
  });
  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    fetch_lead(id);
    $('#editForm #hidden').val(id);
    $('#editForm .date').val((lead.date) ? (lead.date) : '');
    $('#editForm .name').val((lead.name) ? (lead.name) : '');
    $('#editForm .location').val((lead.location) ? (lead.location) : '');
    $('#editForm .email').val((lead.email) ? (lead.email) : '');
    $('#editForm .number').val((lead.number) ? (lead.number) : '');
    $('#editForm .lead_from').val((lead.lead_from) ? (lead.lead_from) : '');
    $('#editForm .assigned_to').val((lead.assigned_to) ? (lead.assigned_to) : '');
    $('#editForm .website').val((lead.website) ? (lead.website) : '');
    $('#editForm .platform').val((lead.platform) ? (lead.platform) : '');
    $('#editForm .keyword').val((lead.keyword) ? (lead.keyword) : '');
    $('#editForm .profile_link').val((lead.profile_link) ? (lead.profile_link) : '');
    $('#editForm .query').val((lead.query) ? (lead.query) : '');
    $('#editForm .created_by').val((lead.created_by) ? (lead.created_by) : '');
    $('#editForm .modified_by').val((lead.modified_by) ? (lead.modified_by) : '');
    $('#editLeadModal').modal('show');
  });
  // detail
  $('.detailButton').on('click', function(){
    var id = $(this).data('id');
    fetch_lead(id);

    $('#viewLeadModal .date').html(lead.date);
    $('#viewLeadModal .name').html(lead.name);
    $('#viewLeadModal .location').html(lead.location);
    $('#viewLeadModal .email').html(lead.email);
    $('#viewLeadModal .number').html(lead.number);
    $('#viewLeadModal .lead_from').html(lead.lead_from);
    $('#viewLeadModal .assigned_to').html(lead.assigned_to);
    $('#viewLeadModal .website').html(lead.website);
    $('#viewLeadModal .platform').html(lead.platform);
    $('#viewLeadModal .keyword').html(lead.keyword);
    $('#viewLeadModal .profile_link').html(lead.profile_link);
    $('#viewLeadModal .query').html(lead.query);

    $('#viewLeadModal').modal('show');
  });
  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('lead.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);
    $('#deleteLeadModalLabel').text('Delete Lead ?');
    $('#deleteLeadModal').modal('show');
  });
});
</script>
@endsection('content_body')
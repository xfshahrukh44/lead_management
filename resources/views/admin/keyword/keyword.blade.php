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
    <h1 class="m-0 text-dark"> Keywords</h1>
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
        <form action="{{route('search_keyword')}}" class="form-wrapper">
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
          <table id="example1" class="table text-nowrap  table-bordered table-striped dataTable dtr-inline table-sm" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">S.No</th>
                <th class="sorting" tabindex="0" aria-controls="example1"  rowspan="1" colspan="1">Keywords</th>
                <th class="sorting" tabindex="0" aria-controls="example1"  rowspan="1" colspan="1">Keyword Type</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Created By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Modified By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($keywords) > 0)
              @foreach($keywords as $keyword)
              <tr role="row" class="odd">
                <td>{{$keyword->id ? $keyword->id : NULL}}</td>
                <td>{{$keyword->website_keyword ? $keyword->website_keyword : NULL}}</td>
                <td>{{$keyword->keyword_type ? $keyword->keyword_type->keyword_name : NULL}}</td>
                <td>{{$keyword->created_by ? return_user_name($keyword->created_by) : NULL}}</td>
                <td>{{$keyword->modified_by ? return_user_name($keyword->modified_by) : NULL}}</td>
                <td width="100">
                  <!-- Detail -->
                  <a href="#" class="detailButton" data-id="{{$keyword->id}}">
                    <i class="fas fa-eye green ml-1"></i>
                  </a>
                  @if(auth()->user()->type == 'Manager' || auth()->user()->type == 'Admin' || auth()->user()->id == $keyword->created_by)
                  <!-- Edit -->
                  <a href="#" class="editButton" data-id="{{$keyword->id}}">
                    <i class="fas fa-edit blue ml-1"></i>
                  </a>
                  <!-- Delete -->
                  <a href="#" class="deleteButton" data-id="{{$keyword->id}}">
                    <i class="fas fa-trash red ml-1"></i>
                  </a>
                  @endif
                </td>
              </tr>
              @endforeach
              @else
              <tr><td colspan="15"><h6 align="center">No keyword(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          @if(count($keywords) > 0)
          {{$keywords->appends(request()->except('page'))->links('pagination::bootstrap-4')}}
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
          <h5 class="modal-title" id="addLeadModalLabel">Add New Keyword</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{route('keyword.store')}}" enctype="multipart/form-data">
          @include('admin.keyword.keyword_master')
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="createButton">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit view -->
  <div class="modal fade" id="editKeywordModal" tabindex="-1" role="dialog" aria-labelledby="editKeywordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 64rem;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editKeywordModalLabel">Edit Keyword</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editForm" method="POST" action="{{route('keyword.update', 1)}}" enctype="multipart/form-data">
          <!-- hidden input -->
          @method('PUT')
          <input id="hidden" type="hidden" name="hidden">
          @include('admin.keyword.keyword_master')
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Detail view -->
  <div class="modal fade" id="viewKeywordModal" tabindex="-1" role="dialog" aria-labelledby="addKeywordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Keyword Detail</h5>

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
                <!-- website_keyword_1 -->
                <tr role="row" class="odd">
                  <th class="">website_keyword</th>
                  <td class="website_keyword_1"></td>
                </tr>
                <!-- logo_keyword -->
                <tr role="row" class="odd">
                  <th class="">Keyword Type</th>
                  <td class="logo_keyword"></td>
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
  <div class="modal fade" id="deleteKeywordModal" tabindex="-1" role="dialog" aria-labelledby="deleteKeywordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteKeywordModalLabel">Delete Keyword</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="deleteForm" method="POST" action="{{route('keyword.destroy', 1)}}">
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
  var keyword = "";
  
  // persistent active sidebar
  var element = $('.keyword_checklist');
  element.parent().parent().parent().addClass('menu-open');
  element.addClass('active');

  // fetch keyword
  function fetch_keyword(id){
      // fetch keyword
      $.ajax({
        url: "<?php echo(route('keyword.show', 1)); ?>",
        type: 'GET',
        async: false,
        data: {id: id},
        dataType: 'JSON',
        success: function (data) {
          keyword = data.keyword;
        }
      });
    }


  // create
  $('#add_keyword').on('click', function(){
  });
  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    fetch_keyword(id);
    $('#editForm #hidden').val(id);
    $('#editForm .website_keyword_1').val((keyword.website_keyword) ? (keyword.website_keyword) : '');
    $('#editForm .logo_keyword [value="'+keyword.keyword_type_id+'"]').prop('selected', true);
    $('#editForm .created_by').val((keyword.created_by) ? (keyword.created_by) : '');
    $('#editForm .modified_by').val((keyword.modified_by) ? (keyword.modified_by) : '');
    $('#editKeywordModal').modal('show');
  });
  // detail
  $('.detailButton').on('click', function(){
    var id = $(this).data('id');

    fetch_keyword(id);

    $('#viewKeywordModal .website_keyword_1').html(keyword.website_keyword);
    $('#viewKeywordModal .logo_keyword ').html(keyword.keyword_type.keyword_name);

    $('#viewKeywordModal').modal('show');
  });
  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('keyword.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);
    $('#deleteKeywordModalLabel').text('Delete Keyword ?');
    $('#deleteKeywordModal').modal('show');
  });
});
</script>
@endsection('content_body')
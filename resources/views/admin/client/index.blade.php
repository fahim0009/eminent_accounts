@extends('admin.layouts.admin')
@section('content')
<!-- Main content -->
<section class="content" id="newBtnSection">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2">
            <button type="button" class="btn btn-secondary my-3">KSA ALL CLIENTS LIST</button>
        </div>
      </div>
    </div>
</section>
  <!-- /.content -->

<!-- Main content -->
<section class="content" id="contentContainer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">KSA ALL CLIENTS</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl</th>
                  {{-- <th>Client ID</th> --}}
                  <th>Passport Name</th>
                  <th>Passport Number</th>
                  <th>Agent Name</th>
                  <th>Assign</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>

                  @php
                      $count1 = $count;                     
                  @endphp

                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ ($count1) }} </td>
                    <td style="text-align: center"><a href="{{route('admin.clientDetails', $data->id)}}">{{$data->passport_name}}</a></td>
                    <td style="text-align: center">{{$data->passport_number}}</td>
                    <td style="text-align: center"><a href="{{route('admin.agentClient', $data->user_id)}}"> <u><b>{{$data->user->name}} {{$data->user->surname}}</b> </u></a> </td>
                    <td style="text-align: center">
                      @if ($data->assign == 1)
                          Assigned
                      @else
                          Not Assigned
                      @endif
                    </td>
                    <td style="text-align: center">
                      <div class="btn-group">
                        <button type="button" class="btn btn-secondary"><span id="stsval{{$data->id}}"> @if ($data->status == 0) New
                          @elseif($data->status == 1) Processing @elseif($data->status == 2) Complete @else Decline @endif</span></button>
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                          <button class="dropdown-item stsBtn" data-id="{{$data->id}}" value="0">New</button>
                          <button class="dropdown-item stsBtn" data-id="{{$data->id}}" value="1">Processing</button>
                          <button class="dropdown-item stsBtn" data-id="{{$data->id}}" value="2">Complete</button>
                          <button class="dropdown-item stsBtn" data-id="{{$data->id}}" value="3">Decline</button>
                        </div>
                      </div>
                    </td>
                  </tr>
                  
                  @php
                      $count1 = $count1 - 1;
                  @endphp
                  @endforeach
                
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->


@endsection
@section('script')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

@endsection
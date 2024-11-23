@extends('manager.layouts.master')


@section('content')





<!-- Main content -->
<section class="content" id="contentContainer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Data</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl</th>
                  <th>Client ID</th>
                  <th>Passport Name</th>
                  <th>Passport Number</th>
                  <th>Package Cost</th>
                  <th>Received Amount</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$data->clientid}}</td>
                    <td style="text-align: center">{{$data->passport_name}}</td>
                    <td style="text-align: center">{{$data->passport_number}}</td>
                    <td style="text-align: center">{{$data->package_cost}}</td>
                    <td style="text-align: center">{{$data->total_rcv}}</td>
                    <td style="text-align: center">
                      @if ($data->status == 0) Processing
                      @elseif($data->status == 1) Complete @else Decline @endif
                    </td>
                    
                  </tr>
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
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });


  </script>

@endsection
@extends('admin.layouts.admin')

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
                  <th>Agent Name</th>
                  <th>Passport Name</th>
                  <th>Passport Number</th>
                  <th>Package Cost</th>
                  <th>Received Amount</th>
                  <th>Decline</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$data->user->name}}</td>
                    <td style="text-align: center">{{$data->passport_name}}</td>
                    <td style="text-align: center">{{$data->passport_number}}</td>
                    <td style="text-align: center">{{$data->package_cost}}</td>
                    <td style="text-align: center">{{$data->total_rcv}}</td>
                    <td style="text-align: center">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input declineBtn" id="decline{{$data->id}}"  data-id="{{$data->id}}" {{ $data->decline ? 'checked' : '' }}>
                        <label class="custom-control-label" for="decline{{$data->id}}"></label>
                      </div>
                    </td>
                    
                    <td style="text-align: center">
                      <a href="{{route('admin.clientDetails', $data->id)}}"><i class="fa fa-eye" style="color: #21f34f;font-size:16px;"></i></a>
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

    $(function() {
      $('.completeBtn').change(function() {
        var url = "{{URL::to('/admin/complete-client')}}";
          var complete = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'complete': complete, 'id': id},
              success: function(d){
                // console.log(data.success)
                if (d.status == 303) {
                        $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'warning',
                            title: d.message
                          });
                        });
                    }else if(d.status == 300){
                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: d.message
                          });
                        });
                    }
                },
                error: function (d) {
                    console.log(d);
                }
          });
      })
    })

    $(function() {
      $('.declineBtn').change(function() {
        var url = "{{URL::to('/admin/decline-client')}}";
          var decline = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'decline': decline, 'id': id},
              success: function(d){
                // console.log(data.success)
                if (d.status == 303) {
                        $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'warning',
                            title: d.message
                          });
                        });
                    }else if(d.status == 300){
                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: d.message
                          });
                        });
                    }
                },
                error: function (d) {
                    console.log(d);
                }
          });
      })
    })


  </script>

<script>
  $(document).ready(function () {
    
      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      
      
      
  });
</script>
@endsection
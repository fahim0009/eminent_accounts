@extends('admin.layouts.admin')

@section('content')





<!-- Main content -->
<section class="content pt-3" id="contentContainer">
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
                  <th>Passport Name</th>
                  <th>Medical Exp Date</th>
                  <th>Mofa</th>
                  <th>RL</th>
                  <th>Agent Name</th>
                  
                </tr>
                </thead>
                <tbody>

                  @php
                      $count1 = $count;                     
                  @endphp

                  @foreach ($clients as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ ($count1) }} </td>
                    <td style="text-align: center">{{$data->passport_name}} ( {{$data->passport_number}} )</td>
                    <td style="text-align: center">

                      @if ($data->medical_exp_date) 

                     <p>{{$data->medical_exp_date}}</p>
 
                      @else            
                    <div class="input-group">
                        <input type="date" class="form-control medical_exp_date" name="medical_exp_date" id="medical_exp_date{{$data->id}}" value="{{$data->medical_exp_date}}">
                        <div class="input-group-append">
                          <button class="btn btn-secondary medical_exp_date_btn" data-id="{{$data->id}}">
                          <i class="fas fa-save"></i>
                          </button>
                        </div>
                        </div>
                        <p><small class="smsg" id="smsg{{$data->id}}"></small></p>
                    </td>
                    @endif
                    <td style="text-align: center">
                     @if ($data->mofa_trade) 

                     <p>{{$data->mofa_trade}}</p>
 
                      @else
                      <div class="input-group">
                        <select name="mofa_trade" id="mofa_trade{{$data->id}}" class="form-control mofa_trade">
                          <option value="">Please Select</option>
                          @foreach (\App\Models\CodeMaster::where('type', 'TRADE')->select('id','type','type_name')->get() as $mofa)
                          <option value="{{$mofa->id}}">{{$mofa->type_name}}</option>
                          @endforeach
                        </select>
                        <div class="input-group-append">
                          <button class="btn btn-secondary mofa_trade_btn" data-id="{{$data->id}}">
                          <i class="fas fa-save"></i>
                          </button>
                        </div>
                        </div>
                        <p><small class="mofa_trade_msg" id="mofa_trade_msg{{$data->id}}"></small></p>
                      @endif

                    </td>
                    
                    <td style="text-align: center">
                    @if ($data->rlname) 

                      <p>{{$data->rlname}}</p>

                      @else
                        <div class="input-group">
                        <select name="rldetail" id="rldetail{{$data->id}}" class="form-control rldetail">
                          <option value="">Please Select</option>
                          @foreach (\App\Models\CodeMaster::where('type', 'RL')->select('id','type','type_name')->get() as $rl)
                          <option value="{{$rl->id}}">{{$rl->type_name}}</option>
                          @endforeach
                        </select>
                        <div class="input-group-append">
                          <button class="btn btn-secondary rldetail_btn" data-id="{{$data->id}}">
                          <i class="fas fa-save"></i>
                          </button>
                        </div>
                        </div>
                        <p><small class="rldetail_msg" id="rldetail_msg{{$data->id}}"></small></p>
                      @endif
                    </td>
                    <td style="text-align: center"><a href="{{route('admin.agentClient', $data->user_id)}}"> <u><b>{{$data->user_name}} {{$data->user_surname}}</b> </u></a> </td>
                    
                    
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
      $('.stsBtn').click(function() {
        var url = "{{URL::to('/admin/change-client-status')}}";
          var id = $(this).data('id');
          var status = $(this).attr('value');
          // console.log(id);
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'status': status, 'id': id},
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
                      
                      $("#stsval"+d.id).html(d.stsval);
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

      $('.medical_exp_date_btn').click(function () {
          var id = $(this).data('id');
          var medical_exp_date = $('#medical_exp_date'+id).val();
          if (medical_exp_date == '') {
              $('#smsg'+id).html('<span class="text-danger">Please select a date</span>');
              return false;
          }
          var url = "{{URL::to('/admin/change-client-medical-exp-date')}}";
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'medical_exp_date': medical_exp_date, 'id': id},
              success: function (data) {
                  if (data.status == 303) {

                    $('#smsg'+id).html(data.message);

                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'warning',
                            title: data.message
                          });
                        });
                  } else if (data.status == 300) {
                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: data.message
                          });
                        });
                  }
              },
              error: function (data) {
                  console.log(data);
              }
          });
      });


      $('.mofa_trade_btn').click(function () {
        
          var id = $(this).data('id');
          var mofa_trade = $('#mofa_trade'+id).val();
          if (mofa_trade == '') {
              $('#mofa_trade_msg'+id).html('<span class="text-danger">Please select a trade</span>');
              return false;
          }
          var url = "{{URL::to('/admin/change-client-mofa-trade')}}";
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'mofa_trade': mofa_trade, 'id': id},
              success: function (data) {
                  if (data.status == 303) {

                    $('#mofa_trade_msg'+id).html(data.message);

                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'warning',
                            title: data.message
                          });
                        });
                  } else if (data.status == 300) {
                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: data.message
                          });
                        });
                  }
              },
              error: function (data) {
                  console.log(data);
              }
          });
      });

      $('.rldetail_btn').click(function () {
        
          var id = $(this).data('id');
          var rldetail = $('#rldetail'+id).val();
          if (rldetail == '') {
              $('#rldetail_msg'+id).html('<span class="text-danger">Please select a RL</span>');
              return false;
          }
          var url = "{{URL::to('/admin/change-client-rl-detail')}}";
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'rldetail': rldetail, 'id': id},
              success: function (data) {
                  if (data.status == 303) {

                    $('#rldetail_msg'+id).html(data.message);

                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'warning',
                            title: data.message
                          });
                        });
                  } else if (data.status == 300) {
                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: data.message
                          });
                        });
                  }
              },
              error: function (data) {
                  console.log(data);
              }
          });
      });



      
  });
</script>
@endsection
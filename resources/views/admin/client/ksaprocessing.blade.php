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
                  <th>Agent Name</th>
                  <th>Mofa/RL</th>
                  <th>Visa Exp Date and Image</th>
                  <th>Training | Finger</th>
                  {{-- <th>Manpower</th> --}}
                  <th>Medical</th>
                  
                </tr>
                </thead>
                <tbody>

                  @php
                      $count1 = $count;                     
                  @endphp

                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ ($count1) }} </td>
                    <td style="text-align: center">{{$data->passport_name}}
                      <br> ({{$data->passport_number}})
                    </td>
                    <td style="text-align: center"><a href="{{route('admin.agentClient', $data->user_id)}}"> <u><b>{{$data->user->name}} {{$data->user->surname}}</b> </u></a> <br> ({{$data->package_cost}}) </td>

                    <td style="text-align: center">
                    {{ \App\Models\CodeMaster::where('id', $data->mofa_trade)->value('type_name') }} <hr>
                    {{ \App\Models\CodeMaster::where('id', $data->rlid)->value('type_name') }}
                    </td>

                    <td style="text-align: center"> 
                        <form id="visaForm{{$data->id}}" enctype="multipart/form-data" class="form-inline">
                          @csrf
                          <input type="date" name="visa_date" id="visa_date{{$data->id}}" value="{{ $data->visa_exp_date }}" class="form-control mb-2 mr-2">
                          <input type="hidden" name="id" value="{{ $data->id }}">
                            @if($data->visa)
                              <a class="btn btn-secondary" href="{{ asset('images/client/visa/' . $data->visa) }}" target="_blank">
                                <i class="fas fa-download"></i>
                              </a>
                            @else
                              <label for="visa_image{{$data->id}}" class="btn btn-secondary mb-2 mr-2">
                                <i class="fas fa-upload"></i>
                              </label>
                              <input type="file" id="visa_image{{$data->id}}" name="visa_image" class="form-control mb-2 mr-2" style="display: none;">
                            @endif
                            <button type="button" class="btn btn-secondary submitVisa" data-id="{{$data->id}}">
                            <i class="fas fa-save"></i>
                            </button>
                        </form>
                        <p><small class="visa_msg" id="visa_msg{{$data->id}}"></small></p>
                      
                    </td>
                    <td style="text-align: center"> 
                      <form id="trainingFingerForm{{$data->id}}" class="form-inline">
                        @csrf
                        <select name="training" id="training{{$data->id}}" class="form-control mb-2 mr-2 d-inline-block" style="width: auto;">
                          <option value="1" {{ $data->training == 1 ? 'selected' : '' }}>Yes</option>
                          <option value="0" {{ $data->training == 0 ? 'selected' : '' }}>No</option>
                        </select>
                        <select name="finger" id="finger{{$data->id}}" class="form-control mb-2 mr-2 d-inline-block" style="width: auto;">
                          <option value="1" {{ $data->finger == 1 ? 'selected' : '' }}>Yes</option>
                          <option value="0" {{ $data->finger == 0 ? 'selected' : '' }}>No</option>
                        </select>
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <button type="button" class="badge badge-success submitTrainingFinger d-inline-block" data-id="{{$data->id}}">
                            <i class="fas fa-check"></i>
                        </button>
                      </form>
                      <p><small class="training_finger_msg" id="training_finger_msg{{$data->id}}"></small></p>
                      
                    </td>
                    {{-- <td style="text-align: center"> 
                      @if($data->visa == 1)
                      <span class="badge badge-success">Yes</span>
                      @else
                      <span class="badge badge-danger">No</span>
                      @endif
                    </td> --}}
                    <td style="text-align: center"> 
                      <form id="medicalForm{{$data->id}}" enctype="multipart/form-data" class="form-inline">
                        @csrf
                        <input type="date" name="medical_exp_date" id="medical_exp_date{{$data->id}}" value="{{ $data->medical_exp_date }}" class="form-control mb-2 mr-2">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        @if($data->medical_report)
                          <a href="{{ asset('images/client/medical/' . $data->medical_report) }}" target="_blank">
                            <img src="{{ asset('images/client/medical/' . $data->medical_report) }}" alt="Medical Report" class="img-thumbnail mb-2 mr-2" style="max-width: 100px;">
                          </a>
                        @else
                          <label for="medical_report{{$data->id}}" class="btn btn-secondary mb-2 mr-2">
                            <i class="fas fa-upload"></i>
                          </label>
                          <input type="file" id="medical_report{{$data->id}}" name="medical_report" class="form-control mb-2 mr-2" style="display: none;">
                        @endif
                        <button type="button" class="btn btn-secondary submitMedical" data-id="{{$data->id}}">
                          <i class="fas fa-save"></i>
                        </button>
                      </form>
                      <p><small class="medical_msg" id="medical_msg{{$data->id}}"></small></p>

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
        "pageLength": 100,
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

      $('.submitVisa').click(function (e) {
          e.preventDefault();
          var id = $(this).data('id');

          var visa_date = $('#visa_date'+id).val();
          if (visa_date == '') {
              $('#visa_msg'+id).html('<span class="text-danger">Please select a Visa Date</span>');
              return false;
          }

          var form = $('#visaForm'+id)[0];
          var formData = new FormData(form);
          var url = "{{URL::to('/admin/visa-update')}}";
          $.ajax({
              type: "POST",
              dataType: "json",
              url: url,
              data: formData,
              processData: false,
              contentType: false,
              success: function (data) {
                  if (data.status == 300) {
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
                  } else {
                      // $('#visa_msg'+id).html(data.message);
                        $(function() {
                          var Toast = Swal.mixin({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000
                          });
                          Toast.fire({
                          icon: 'error',
                          title: data.message
                          });
                        });
                        $('#visa_msg'+id).html(data.errors.visa_date[0]);
                  }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      });


      $('.submitMedical').click(function (e) {
          e.preventDefault();
          var id = $(this).data('id');

          var medical_exp_date = $('#medical_exp_date'+id).val();
          if (medical_exp_date == '') {
              $('#medical_msg'+id).html('<span class="text-danger">Please select a Medical Date</span>');
              return false;
          }

          var form = $('#medicalForm'+id)[0];
          var formData = new FormData(form);
          var url = "{{URL::to('/admin/medical-update')}}";
          $.ajax({
              type: "POST",
              dataType: "json",
              url: url,
              data: formData,
              processData: false,
              contentType: false,
              success: function (data) {
                  if (data.status == 300) {
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
                  } else {
                      // $('#medical_msg'+id).html(data.message);
                        $(function() {
                          var Toast = Swal.mixin({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000
                          });
                          Toast.fire({
                          icon: 'error',
                          title: data.message
                          });
                        });
                        $('#medical_msg'+id).html(data.errors.medical_exp_date[0]);
                  }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      });

      $('.submitTrainingFinger').click(function (e) {
          e.preventDefault();
          var id = $(this).data('id');

          var training = $('#training'+id).val();
          var finger = $('#finger'+id).val();
          if (training == '' || finger == '') {
            $('#training_finger_msg'+id).html('<span class="text-danger">Please select both Training and Finger options</span>');
            return false;
          }

          var url = "{{URL::to('/admin/training-finger-update')}}";
          $.ajax({
              type: "POST",
              dataType: "json",
              url: url,
              data: {'id': id, 'training': training, 'finger': finger},
              success: function (data) {
                  if (data.status == 300) {
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
                  } else {
                      // $('#training_finger_msg'+id).html(data.message);
                        $(function() {
                          var Toast = Swal.mixin({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000
                          });
                          Toast.fire({
                          icon: 'error',
                          title: data.message
                          });
                        });
                  }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      });
      
  });
</script>
@endsection
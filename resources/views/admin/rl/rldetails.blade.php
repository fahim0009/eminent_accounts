@extends('admin.layouts.admin')

@section('content')
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- Main content -->
    <section class="content" id="contentContainer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-secondary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Processing</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Completed</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link " id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true">New</a>
                  </li> 
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    
    
                  <div class="tab-pane fade active show" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
    
                    <!-- visa and others transaction start  -->
    
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">KSA Client Processing</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                       <table id="processingTable" class="table table-bordered table-striped">

                          <thead>
                          <tr>
                            <th>Sl</th>
                            <th>Passport Name</th>
                            <th>Agent Name</th>
                            <th>Mofa</th>
                            <th>Mofa Count</th>
                            <th>Visa Exp Date</th>
                            <th>Manpower</th>                            
                          </tr>
                          </thead>
                          <tbody>

                            @foreach ($clientsProcessing as $pkey => $data)
                            <tr>
                              <td style="text-align: center">{{ $loop->remaining + 1 }} </td>
                              <td style="text-align: center"><a href="{{route('admin.clientDetails', $data->id)}}">{{$data->passport_name}}
                                 ({{$data->passport_number}})</a>
                              </td>
                              <td style="text-align: center"><a href="{{route('admin.agentClient', $data->user_id)}}"> <u><b>{{$data->user->name}} {{$data->user->surname}}</b> </u></a></td>

                              <td style="text-align: center">
                              {{ \App\Models\CodeMaster::where('id', $data->mofa_trade)->value('type_name') }}
                              </td>
                              <td>{{$data->mofa_count}}</td>
                              <td style="text-align: center"> 
                                  <form id="visaForm{{$data->id}}" enctype="multipart/form-data" class="form-inline">
                                    @csrf

                                    @if($data->visa_exp_date)
                                    <p>{{$data->visa_exp_date}} &nbsp &nbsp</p>
                                    @else
                                    <input type="date" name="visa_date" id="visa_date{{$data->id}}" value="" class="form-control mb-2 mr-2">
                                    @endif

                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                     
                                      @if(empty($data->visa_exp_date))
                                      <button type="button" class="btn btn-secondary submitVisa" data-id="{{$data->id}}">
                                      <i class="fas fa-save"></i>
                                      </button>
                                      @endif
                                  </form>
                                  <p><small class="visa_msg" id="visa_msg{{$data->id}}"></small></p>
                                
                              </td>

                              <td style="text-align: center"> 
                                <form id="manpoerForm{{$data->id}}" enctype="multipart/form-data" class="form-inline">
                                  @csrf
                                  <input type="hidden" name="id" value="{{ $data->id }}">
                                  @if($data->manpower_image)
                                    <a class="btn btn-secondary" href="{{ asset('images/client/manpower/' . $data->manpower_image) }}" target="_blank">
                                    <i class="fas fa-download"></i>
                                    </a>                    
                                  @else
                                    <label for="manpower_image{{$data->id}}" class="btn btn-secondary mb-2 mr-2">
                                      <i class="fas fa-upload"></i>
                                    </label>
                                    <input type="file" id="manpower_image{{$data->id}}" name="manpower_image" class="form-control mb-2 mr-2" style="display: none;">
                                    <button type="button" class="btn btn-secondary submitManpower" data-id="{{$data->id}}">
                                    <i class="fas fa-save"></i>
                                  </button>
                                  @endif
                                </form>
                                <p><small class="manpower_msg" id="manpower_msg{{$data->id}}"></small></p>

                              </td>                      
                           
                              
                            </tr>
                            @endforeach
                          
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                        
                     <!-- End visa and others transaction End  -->
                  </div>
    
    
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                        <!-- Start visa and others transaction Start  -->
                       
                    
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">KSA Client Completed</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                       <table id="completedTable" class="table table-bordered table-striped">

                          <thead>
                          <tr>
                            <th>Sl</th>
                            <th>Passport Name</th>
                            <th>Agent Name</th>
                            <th>Mofa</th>
                             <th>Mofa Count</th>
                            <th>Visa Exp Date and Image</th>
                            <th>Manpower</th>
                            
                          </tr>
                          </thead>
                          <tbody>

                            @foreach ($clientsCompleted as $ckey => $data)
                            <tr>
                              <td style="text-align: center">{{ count($clientsCompleted) - $ckey }}</td>
                              <td style="text-align: center"><a href="{{route('admin.clientDetails', $data->id)}}">{{$data->passport_name}}
                                ({{$data->passport_number}})</a>
                              </td>
                              <td style="text-align: center"><a href="{{route('admin.agentClient', $data->user_id)}}"> <u><b>{{$data->user->name}} {{$data->user->surname}}</b> </u></a></td>

                              <td style="text-align: center">
                              {{ \App\Models\CodeMaster::where('id', $data->mofa_trade)->value('type_name') }} 
                              </td>
                              <td>{{$data->mofa_count}}</td>
                              <td style="text-align: center"> 
                                  <form id="visaForm{{$data->id}}" enctype="multipart/form-data" class="form-inline">
                                    @csrf

                                    @if($data->visa_exp_date)
                                    <p>{{$data->visa_exp_date}} &nbsp &nbsp</p>
                                    @else
                                    <input type="date" name="visa_date" id="visa_date{{$data->id}}" value="" class="form-control mb-2 mr-2">
                                    @endif
                                  </form>
                                  <p><small class="visa_msg" id="visa_msg{{$data->id}}"></small></p>
                                
                              </td>
        
          
                              <td style="text-align: center"> 
                                <form id="manpoerForm{{$data->id}}" enctype="multipart/form-data" class="form-inline">
                                  @csrf
                                  <input type="hidden" name="id" value="{{ $data->id }}">
                                  @if($data->manpower_image)
                                    <a class="btn btn-secondary" href="{{ asset('images/client/manpower/' . $data->manpower_image) }}" target="_blank">
                                    <i class="fas fa-download"></i>
                                    </a>                    
                                  @else
                                    <label for="manpower_image{{$data->id}}" class="btn btn-secondary mb-2 mr-2">
                                      <i class="fas fa-upload"></i>
                                    </label>
                                    <input type="file" id="manpower_image{{$data->id}}" name="manpower_image" class="form-control mb-2 mr-2" style="display: none;">
                                    <button type="button" class="btn btn-secondary submitManpower" data-id="{{$data->id}}">
                                    <i class="fas fa-save"></i>
                                  </button>
                                  @endif
                                </form>
                                <p><small class="manpower_msg" id="manpower_msg{{$data->id}}"></small></p>

                              </td>                      
                              
                            </tr>
                     
                            @endforeach
                          
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    
                    <!-- End visa and others transaction End  -->
                  </div>
    
                  
                  <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                    
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">KSA Client New</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                       <table id="newTable" class="table table-bordered table-striped">

                          <thead>
                          <tr>
                            <th>Sl</th>
                            <th>Passport Name</th>
                            <th>Agent Name</th>
                            <th>Mofa</th>
                             <th>Mofa Count</th>
                            <th>Medical Exp Date</th>
                            
                          </tr>
                          </thead>
                          <tbody>

                            @foreach ($clientsNew as $nkey => $data)
                            <tr>
                              <td style="text-align: center">  {{ count($clientsNew) - $nkey }} </td>
                              <td style="text-align: center"><a href="{{route('admin.clientDetails', $data->id)}}">{{$data->passport_name}}
                                 ({{$data->passport_number}})</a>
                              </td>
                              <td style="text-align: center"><a href="{{route('admin.agentClient', $data->user_id)}}"> <u><b>{{$data->user->name}} {{$data->user->surname}}</b> </u></a></td>

                              <td style="text-align: center">
                              {{ \App\Models\CodeMaster::where('id', $data->mofa_trade)->value('type_name') }} 
                              </td>
                              <td>{{$data->mofa_count}}</td>
                              <td style="text-align: center"> 
                                  <form id="visaForm{{$data->id}}" enctype="multipart/form-data" class="form-inline">
                                    @csrf

                                    @if($data->medical_exp_date)
                                    <p>{{$data->medical_exp_date}} &nbsp &nbsp</p>
                                    @else
                                    <input type="date" name="medical_date" id="medical_date{{$data->id}}" value="" class="form-control mb-2 mr-2">
                                    @endif

                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    
                                      @if(empty($data->medical_exp_date))
                                      <button type="button" class="btn btn-secondary submitVisa" data-id="{{$data->id}}">
                                      <i class="fas fa-save"></i>
                                      </button>
                                      @endif
                                  </form>
                                  <p><small class="visa_msg" id="visa_msg{{$data->id}}"></small></p>
                                
                              </td> 
                            
                            </tr>
                    
                            @endforeach
                          
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    


                  </div>
    
    
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          
        </div>
      </div>
    </section>
    <!-- /.content -->



<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>



@endsection
@section('script')

<script>
  // helper to apply descending serial numbers per table
  function applyDescendingIndex(tableSelector) {
    const t = $(tableSelector).DataTable({
      responsive: true,
      autoWidth: false,
      columnDefs: [
        { targets: 0, orderable: false, searchable: false } // SL column
      ]
    });

    t.on('order.dt search.dt draw.dt', function () {
      const info = t.page.info(); // has start and recordsDisplay after filtering
      t.column(0, { search: 'applied', order: 'applied', page: 'current' })
        .nodes()
        .each(function (cell, i) {
          // Descending across the filtered set + current page
          cell.innerHTML = info.recordsDisplay - (info.start + i);
        });
    }).draw();

    return t;
  }

  $(function () {
    applyDescendingIndex('#processingTable');
    applyDescendingIndex('#completedTable');
    applyDescendingIndex('#newTable');
  });
</script>

<script>

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

          var visa = $('#visa_image'+id).val();
          if (visa == '') {
              $('#visa_msg'+id).html('<span class="text-danger">Please upload Visa Copy</span>');
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

// fly or delivery date update 
      $('.submitFlydate').click(function (e) {
          e.preventDefault();
          var id = $(this).data('id');

          var flight_date = $('#flight_date'+id).val();
          if (flight_date == '') {
              $('#fly_msg'+id).html('<span class="text-danger">Please select a Fly Date</span>');
              return false;
          }

          var form = $('#flydateform'+id)[0];
          var formData = new FormData(form);
          var url = "{{URL::to('/admin/flyDate-update')}}";
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
                        $('#fly_msg'+id).html(data.errors.medical_exp_date[0]);
                  }
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
      });


  // manpower file uload................. 
      $('.submitManpower').click(function (e) {
          e.preventDefault();
          var id = $(this).data('id');
         var form = $('#manpoerForm'+id)[0];
          var formData = new FormData(form);
          var url = "{{URL::to('/admin/manpower-update')}}";
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

      // submit training & finger 
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
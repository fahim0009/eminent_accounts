@extends('admin.layouts.admin')

@section('content')



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-secondary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{asset('images/client/'.$data->client_image)}}"
                       alt="User profile picture" style="height: 200px; width:auto">
                </div>

                <h3 class="profile-username text-center">{{$data->passport_name}}</h3>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <strong><i class="fas fa-book mr-1"></i> Agent Details</strong>
                <p class="text-muted">
                  {{$data->user->name}} <br>
                  {{$data->user->email}} <br>
                  {{$data->user->phone}}
                </p>
                <hr>
                {{-- <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                <p class="text-muted">Malibu, California</p>
                <hr> --}}

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">{{$data->description}}</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Client Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Documents</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Transactions</a></li>
                  <li class="nav-item"><a class="nav-link" href="#btob_partner" data-toggle="tab">Business Partner</a></li>
                  <li class="nav-item"><a class="nav-link" href="#btob_payment" data-toggle="tab">B2B Payment</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <form class="form-horizontal">
                      @csrf
                      <div class="row">
                        <div class="col-sm-6">
                            <label>Name <small>(Passport Name)</small></label>
                            <input type="text" class="form-control" value="{{$data->passport_name}}" id="passport_name" name="passport_name">
                            <input type="hidden" name="codeid" id="codeid" value="{{$data->id}}">
                        </div>
                        <div class="col-sm-6">
                            <label>Passport Number</label>
                            <input type="text" id="passport_number" name="passport_number" class="form-control" value="{{$data->passport_number}}">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                            <label>Passport Image</label>
                            <input type="file" class="form-control" id="passport_image" name="passport_image">
                        </div>
                        <div class="col-sm-6">
                            <label>Visa Image</label>
                            <input type="file" class="form-control" id="visa_image" name="visa_image">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                            <label>Client Image</label>
                            <input type="file" class="form-control" id="client_image" name="client_image">
                        </div>
                        <div class="col-sm-6">
                            <label>Manpower Image</label>
                            <input type="file" class="form-control" id="manpower_image" name="manpower_image">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                            <label>Passport Receive Date</label>
                            <input type="date" class="form-control" id="passport_rcv_date" name="passport_rcv_date" value="{{$data->passport_rcv_date}}">
                        </div>
                        <div class="col-sm-6">
                            <label>Flight  Date</label>
                            <input type="date" class="form-control" id="flight_date" name="flight_date" value="{{$data->flight_date}}">
                        </div>
    
                        

                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                            <label>Package Cost</label>
                            <input type="number" class="form-control" id="package_cost" name="package_cost"  value="{{$data->package_cost}}">
                        </div>

                        
                        
                      </div>


                      <div class="row">
                        <div class="col-sm-6">
                            <label>Country</label>
                            <select class="form-control" id="country" name="country">
                              <option value="">Select</option>
                              @foreach ($countries as $country)
                                <option value="{{$country->id}}"@if ($country->id == $data->country_id) selected @endif >{{$country->name}}</option>
                              @endforeach
                            </select>
                        </div>

                        
                        <div class="col-sm-6">
                            <label>Agents</label>
                            <select name="user_id" id="user_id" class="form-control">
                              <option value="">Select</option>
                              @foreach ($agents as $item)
                              <option value="{{$item->id}}" @if ($item->id == $data->user_id) selected @endif>{{$item->name}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                            <label>Description</label>
                            <textarea name="description" id="description" cols="30" rows="2" class="form-control">{{$data->description}}</textarea>
                        </div>
                      </div>

                      <div class="form-group row mt-3">
                        <div class="col-sm-10">
                          <button type="button" id="updatebtn" class="btn btn-secondary">Update</button>
                        </div>
                      </div>

                    </form>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    
                    <!-- Post -->
                    <div class="post">
                      <!-- /.user-block -->
                      
                      <div class="user-block">
                        <span class="username">
                          <h3>Client Image</h3>
                        </span>
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('images/client/'.$data->client_image)}}" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <label>Client Image</label>
                              <input type="file" class="form-control" id="client_image" name="client_image">
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <!-- /.user-block -->
                      
                      <div class="user-block">
                        <span class="username">
                          <h3>Passport Image</h3>
                        </span>
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('images/client/passport/'.$data->passport_image)}}" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <label>Passport Image</label>
                              <input type="file" class="form-control" id="passport_image" name="passport_image">
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <!-- /.user-block -->
                      
                      <div class="user-block">
                        <span class="username">
                          <h3>Visa Image</h3>
                        </span>
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('images/client/visa/'.$data->visa)}}" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <label>Visa Image</label>
                              <input type="file" class="form-control" id="visa_image" name="visa_image">
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <!-- /.user-block -->
                      
                      <div class="user-block">
                        <span class="username">
                          <h3>Manpower Image</h3>
                        </span>
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="{{asset('images/client/manpower/'.$data->manpower_image)}}" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <label>Passport Image</label>
                              <input type="file" class="form-control" id="manpower_image" name="manpower_image">
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->

                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <div class="row">
                          <h3>Payment</h3>
                    </div>
                    <form class="form-horizontal">

                      <div class="row">
                        <div class="col-sm-6">
                            <label>Transaction method</label>
                            <select class="form-control" id="method" name="method">
                              <option value="">Select</option>
                              @foreach ($accounts as $method)
                                <option value="{{$method->id}}">{{$method->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label>Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                            <label>Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount">
                        </div>
                      </div>
                      
                      
                      <div class="form-group row">
                        <div class="col-sm-12 mt-2">
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>

                    <div class="row">
                          <h3>Transaction</h3>
                    </div>

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
                                  <th>Date</th>
                                  <th>Transaction Method</th>
                                  <th>Amount</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($accounts as $key => $data)
                                  <tr>
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td style="text-align: center">{{$data->date}}</td>
                                    <td style="text-align: center">{{$data->account_id}}</td>
                                    <td style="text-align: center">{{$data->amount}}</td>
                                    <td style="text-align: center">
                                      <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
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

                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="btob_partner">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="btob_payment">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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

<script>
  $(document).ready(function () {
    
      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      var url = "{{URL::to('/admin/client-update')}}";
      // console.log(url);
      $("#updatebtn").click(function(){

          var passport_image = $('#passport_image').prop('files')[0];
          if(typeof passport_image === 'undefined'){
              passport_image = 'null';
          }
          var client_image = $('#client_image').prop('files')[0];
          if(typeof client_image === 'undefined'){
            client_image = 'null';
          }

          var visa_image = $('#visa_image').prop('files')[0];
          if(typeof visa_image === 'undefined'){
            visa_image = 'null';
          }
          var manpower_image = $('#manpower_image').prop('files')[0];
          if(typeof manpower_image === 'undefined'){
            manpower_image = 'null';
          }

          var form_data = new FormData();
          form_data.append('passport_image', passport_image);
          form_data.append('client_image', client_image);
          form_data.append('manpower_image', manpower_image);
          form_data.append('visa_image', visa_image);
          form_data.append("passport_number", $("#passport_number").val());
          form_data.append("passport_name", $("#passport_name").val());
          form_data.append("passport_rcv_date", $("#passport_rcv_date").val());
          form_data.append("country", $("#country").val());
          form_data.append("user_id", $("#user_id").val());
          form_data.append("package_cost", $("#package_cost").val());
          form_data.append("description", $("#description").val());
          form_data.append("flight_date", $("#flight_date").val());
          form_data.append("codeid", $("#codeid").val());



          $.ajax({
            url: url,
            method: "POST",
            contentType: false,
            processData: false,
            data:form_data,
            success: function (d) {
                if (d.status == 303) {
                    $(".ermsg").html(d.message);
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
                        title: 'Data updated successfully.'
                      });
                    });
                  window.setTimeout(function(){location.reload()},2000)
                }
            },
            error: function (d) {
                console.log(d);
            }
        });
        //update  end
          
      });
      
  });
</script>
@endsection
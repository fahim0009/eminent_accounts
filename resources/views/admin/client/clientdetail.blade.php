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

                      <div class="row">
                        <div class="col-sm-6">
                            <label>Name <small>(Passport Name)</small></label>
                            <input type="text" class="form-control" id="passport_name" name="passport_name">
                        </div>
                        <div class="col-sm-6">
                            <label>Passport Number</label>
                            <input type="text" id="passport_number" name="passport_number" class="form-control">
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
                            <input type="date" class="form-control" id="passport_rcv_date" name="passport_rcv_date">
                        </div>
    
                        <div class="col-sm-6">
                            <label>Payment Method</label>
                            <select class="form-control" id="account_id" name="account_id">
                              <option value="">Select</option>
                              @foreach ($accounts as $account)
                                <option value="{{$account->id}}">{{$account->name}}</option>
                              @endforeach
                            </select>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                            <label>Package Cost</label>
                            <input type="number" class="form-control" id="package_cost" name="package_cost">
                        </div>

                        <div class="col-sm-6">
                            <label>Received Amount</label>
                            <input type="number" class="form-control" id="total_rcv" name="total_rcv">
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-sm-6">
                            <label>Country</label>
                            <select class="form-control" id="country" name="country">
                              <option value="">Select</option>
                              @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                              @endforeach
                            </select>
                        </div>

                        
                        <div class="col-sm-6">
                            <label>Agents</label>
                            <select name="user_id" id="user_id" class="form-control">
                              <option value="">Select</option>
                              @foreach ($agents as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                            <label>Description</label>
                            <textarea name="description" id="description" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                      </div>

                      <div class="form-group row mt-3">
                        <div class="col-sm-10">
                          <button type="button" class="btn btn-secondary">Update</button>
                        </div>
                      </div>

                    </form>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
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

                  <div class="tab-pane" id="settings">
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
      var url = "{{URL::to('/admin/client')}}";
      // console.log(url);
      $("#addBtn").click(function(){
      //   alert("#addBtn");
          if($(this).val() == 'Create') {

              var passport_image = $('#passport_image').prop('files')[0];
              if(typeof passport_image === 'undefined'){
                  passport_image = 'null';
              }
              var client_image = $('#client_image').prop('files')[0];
              if(typeof client_image === 'undefined'){
                client_image = 'null';
              }

              var form_data = new FormData();
              form_data.append('passport_image', passport_image);
              form_data.append('client_image', client_image);
              form_data.append("passport_number", $("#passport_number").val());
              form_data.append("passport_name", $("#passport_name").val());
              form_data.append("passport_rcv_date", $("#passport_rcv_date").val());
              form_data.append("country", $("#country").val());
              form_data.append("account_id", $("#account_id").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("package_cost", $("#package_cost").val());
              form_data.append("total_rcv", $("#total_rcv").val());
              form_data.append("description", $("#description").val());



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
                            title: 'Data create successfully.'
                          });
                        });
                      window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error: function (d) {
                    console.log(d);
                }
            });
          }
          //create  end
          
      });
      
      
      
  });
</script>
@endsection
@extends('admin.layouts.admin')

@section('content')

<!-- Main content -->
<section class="content" id="newBtnSection">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2">
            <button type="button" class="btn btn-secondary my-3" id="newBtn">Add new</button>
        </div>
      </div>
    </div>
</section>
  <!-- /.content -->



    <!-- Main content -->
    <section class="content" id="addThisFormContainer">
      <div class="container-fluid">
        <div class="row justify-content-md-center">
          <!-- right column -->
          <div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Add new vendor</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="ermsg"></div>
                <form id="createThisForm">
                  @csrf
                  <input type="hidden" class="form-control" id="codeid" name="codeid">
                  <div class="row">

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Surname</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname">
                      </div>
                    </div>
                    </div>
                    <div class="row">

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Phone</label>
                        <input type="number" id="phone" name="phone" class="form-control" placeholder="Enter phone">
                      </div>
                    </div>
                    
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" id="address" name="address" class="form-control" >
                      </div>
                    </div>

                  </div>

                </form>
              </div>

              
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" id="addBtn" class="btn btn-secondary" value="Create">Create</button>
                <button type="submit" id="FormCloseBtn" class="btn btn-default">Cancel</button>
              </div>
              <!-- /.card-footer -->
              <!-- /.card-body -->
            </div>
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
              <h3 class="card-title">All Data</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">
                      <a href="{{route('admin.vendorHistory', $data->id)}}" class="btn btn-xs btn-success">{{$data->name}} {{$data->surname}}</a>
                      
                    </td>
                    <td style="text-align: center">{{$data->email}}</td>
                    <td style="text-align: center">{{$data->phone}}</td>
                    <td style="text-align: center">{{$data->address}}</td>

                    <td>
                      <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input toggle-status" id="customSwitchStatus{{ $data->id }}" data-id="{{ $data->id }}" {{ $data->status == 1 ? 'checked' : '' }}>
                          <label class="custom-control-label" for="customSwitchStatus{{ $data->id }}"></label>
                      </div>
                    </td>
                    
                    <td style="text-align: center">
                      <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                      <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
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

<script>
  $(document).ready(function () {
      $("#addThisFormContainer").hide();
      $("#newBtn").click(function(){
          clearform();
          $("#newBtn").hide(100);
          $("#addThisFormContainer").show(300);

      });
      $("#FormCloseBtn").click(function(){
          $("#addThisFormContainer").hide(200);
          $("#newBtn").show(100);
          clearform();
      });
      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      var url = "{{URL::to('/admin/vendor')}}";
      var upurl = "{{URL::to('/admin/vendor-update')}}";
      var stsurl = "{{URL::to('/admin/vendor')}}";
      // console.log(url);
      $("#addBtn").click(function(){
        $(this).prop('disabled', true);
      //   alert("#addBtn");
          if($(this).val() == 'Create') {
              var form_data = new FormData();
              form_data.append("name", $("#name").val());
              form_data.append("name", $("#surname").val());
              form_data.append("email", $("#email").val());
              form_data.append("phone", $("#phone").val());
              form_data.append("address", $("#address").val());
              $.ajax({
                url: url,
                method: "POST",
                contentType: false,
                processData: false,
                data:form_data,
                success: function (d) {
                    if (d.status == 303) {
                        $(".ermsg").html(d.message);
                        $("#addBtn").prop('disabled', false);
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
          //Update
          if($(this).val() == 'Update'){
              var form_data = new FormData();
              form_data.append("name", $("#name").val());
              form_data.append("surname", $("#surname").val());
              form_data.append("email", $("#email").val());
              form_data.append("phone", $("#phone").val());
              form_data.append("address", $("#address").val());
              form_data.append("codeid", $("#codeid").val());
              
              $.ajax({
                  url:upurl,
                  type: "POST",
                  dataType: 'json',
                  contentType: false,
                  processData: false,
                  data:form_data,
                  success: function(d){
                      console.log(d);
                      if (d.status == 303) {
                          $(".ermsg").html(d.message);
                          pagetop();
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
                  error:function(d){
                      console.log(d);
                  }
              });
          }
          //Update
      });
      //Edit
      $("#contentContainer").on('click','#EditBtn', function(){
          //alert("btn work");
          codeid = $(this).attr('rid');
          //console.log($codeid);
          info_url = url + '/'+codeid+'/edit';
          //console.log($info_url);
          $.get(info_url,{},function(d){
              populateForm(d);
              pagetop();
          });
      });
      //Edit  end
      //Delete 
      $("#contentContainer").on('click','#deleteBtn', function(){
            if(!confirm('Sure?')) return;
            codeid = $(this).attr('rid');
            info_url = url + '/'+codeid;
            $.ajax({
                url:info_url,
                method: "GET",
                type: "DELETE",
                data:{
                },
                success: function(d){
                    if(d.success) {
                        alert(d.message);
                        location.reload();
                    }
                },
                error:function(d){
                  alert(d.message);
                    console.log(d);
                }
            });
        });
      //Delete  
      function populateForm(data){
          $("#name").val(data.name);
          $("#surname").val(data.surname);
          $("#phone").val(data.phone);
          $("#email").val(data.email);
          $("#address").val(data.address);
          $("#codeid").val(data.id);
          $("#addBtn").val('Update');
          $("#addBtn").html('Update');
          $("#addThisFormContainer").show(300);
          $("#newBtn").hide(100);
      }
      function clearform(){
          $('#createThisForm')[0].reset();
          $("#addBtn").val('Create');
      }

      // active-deactive users
      $(document).on('change', '.toggle-status', function() {
            var userId = $(this).data('id');
            var status = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: stsurl + '/' + userId + '/status',
                method: 'POST',
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: response.message
                          });
                        });
                      window.setTimeout(function(){location.reload()},2000)

                },
                error: function(xhr, status, error) {
                    showError('An error occurred. Please try again.');
                }
            });
      });
  });
</script>
@endsection
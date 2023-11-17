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
        <div class="row">
          <!-- right column -->
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Add new admin</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form id="createThisForm">
                  @csrf
                  <input type="hidden" class="form-control" id="codeid" name="codeid">
                  <div class="row">

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Agents</label>
                        <select name="user_id" id="user_id" class="form-control">
                          <option value="">Select</option>
                          @foreach ($agents as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Amount</label>
                        <input type="number" id="amount" name="amount" class="form-control">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Account</label>
                        <select name="account_id" id="account_id" class="form-control">
                          <option value="">Select</option>
                          @foreach ($accounts as $account)
                          <option value="{{$account->id}}">{{$account->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" id="note" name="note">
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
                  <th>Date</th>
                  <th>Agent Name</th>
                  <th>Amount</th>
                  <th>Due Amount</th>
                  <th>Note</th>
                  <th>Receive</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$data->date}}</td>
                    <td style="text-align: center">{{$data->user->name}}</td>
                    <td style="text-align: center">{{$data->amount}}</td>
                    <td style="text-align: center">{{$data->due_amount}}</td>
                    <td style="text-align: center">{{$data->note}}</td>
                    <td style="text-align: center">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$data->id}}">
                        Receive
                      </button>  
                    </td>
                    
                    <td style="text-align: center">
                      <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                      <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
                    </td>

                    {{-- modal start  --}}
                    <div class="modal fade" id="exampleModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Receive</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            
                            <div class="container">
                              <div class="returnermsg"></div>
                              <form action="">
                                @csrf
                                <div class="row">

                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Date</label>
                                      <input type="date" class="form-control" id="rcvdate" name="rcvdate" value="{{date('Y-m-d')}}">
                                    </div>
                                  </div>
              
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Agents</label>
                                      <input type="text" value="{{$data->user->name}}" class="form-control" readonly>
                                      <input type="hidden" value="{{$data->user_id}}" name="rcvuser_id" id="rcvuser_id" class="form-control">
                                      <input type="hidden" value="{{$data->id}}" name="loan_id" id="loan_id" class="form-control">
                                    </div>
                                  </div>
                                </div>
              
                                <div class="row">
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Amount</label>
                                      <input type="number" id="rcvamount" name="rcvamount" class="form-control">
                                    </div>
                                  </div>
              
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Account</label>
                                      <select name="rcvaccount_id" id="rcvaccount_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                </div>
              
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="form-group">
                                      <label>Note</label>
                                      <input type="text" class="form-control" id="rcvnote" name="rcvnote">
                                    </div>
                                  </div>
                                </div>
                              </form>

                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="rcvBtn" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    {{-- modal end --}}



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
      var url = "{{URL::to('/admin/loan')}}";
      var upurl = "{{URL::to('/admin/loan-update')}}";
      // console.log(url);
      $("#addBtn").click(function(){
      //   alert("#addBtn");
          if($(this).val() == 'Create') {
              var form_data = new FormData();
              form_data.append("date", $("#date").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("account_id", $("#account_id").val());
              form_data.append("amount", $("#amount").val());
              form_data.append("note", $("#note").val());
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
          //Update
          if($(this).val() == 'Update'){
              var form_data = new FormData();
              form_data.append("date", $("#date").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("account_id", $("#account_id").val());
              form_data.append("amount", $("#amount").val());
              form_data.append("note", $("#note").val());
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
                    console.log(d);
                }
            });
        });
      //Delete  

      var rcvurl = "{{URL::to('/admin/loan-receive')}}";
      // loan receive
      $("#rcvBtn").click(function(){
        
          var form_data = new FormData();
          form_data.append("date", $("#rcvdate").val());
          form_data.append("user_id", $("#rcvuser_id").val());
          form_data.append("loan_id", $("#loan_id").val());
          form_data.append("account_id", $("#rcvaccount_id").val());
          form_data.append("amount", $("#rcvamount").val());
          form_data.append("note", $("#rcvnote").val());

          $.ajax({
            url: rcvurl,
            method: "POST",
            contentType: false,
            processData: false,
            data:form_data,
            success: function (d) {
                if (d.status == 303) {
                    $(".returnermsg").html(d.message);
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


      });
      // loan receive




      function populateForm(data){
          $("#date").val(data.date);
          $("#user_id").val(data.user_id);
          $("#account_id").val(data.account_id);
          $("#amount").val(data.amount);
          $("#note").val(data.note);
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
  });
</script>
@endsection
@extends('admin.layouts.admin')

@section('content')

<!-- Main content -->
<section class="content" id="newBtnSection">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2">
            <a href="{{route('admin.agent')}}" class="btn btn-secondary my-3">Back</a>
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
          <div class="col-md-8">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Add new client</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form id="createThisForm">
                  @csrf
                  <input type="hidden" class="form-control" id="codeid" name="codeid">

                  
                  <div class="row">
                    <div class="col-sm-12">
                        <label>Client ID</label>
                        <input type="number" class="form-control" id="clientid" name="clientid" value="">
                    </div>
                  </div>

                  <div class="row">
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
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Passport Number</label>
                        <input type="text" id="passport_number" name="passport_number" class="form-control">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Passport Name</label>
                        <input type="text" class="form-control" id="passport_name" name="passport_name">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Passport Image</label>
                        <input type="file" class="form-control" id="passport_image" name="passport_image">
                      </div>
                    </div>

                  </div>

                  <div class="row">

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Client Image</label>
                        <input type="file" class="form-control" id="client_image" name="client_image">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Country</label>
                        <select class="form-control" id="country" name="country">
                          <option value="">Select</option>
                          @foreach ($countries as $country)
                            <option value="{{$country->id}}">{{$country->type_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    


                  </div>

                  <div class="row">
                    
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Passport Receive Date</label>
                        <input type="date" class="form-control" id="passport_rcv_date" name="passport_rcv_date">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Package Cost</label>
                        <input type="number" class="form-control" id="package_cost" name="package_cost">
                      </div>
                    </div>

                  </div>
                  

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" id="description" name="description">
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
                  <h2 class="card-title"></h2>
                  <h3 class="card-title">All Data</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <table class="table table-bordered table-striped mt-4 mb-5">
                    <thead>
                    <tr>
                      <th>Processing</th>
                      <th>Complete</th>
                      <th>Decline</th>
                      <th>Receive Amount</th>
                      <th>Others Bill</th>
                      <th>Due Amount</th>
                      <th>Total Received</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td style="text-align: center">{{ $processing }}</td>
                        <td style="text-align: center">{{$completed}}</td>
                        <td style="text-align: center">{{$decline}}</td>
                        <td style="text-align: center">{{$rcvamntForProcessing}}</td>
                        <td style="text-align: center">{{$totalBillamt}}</td>
                        <td style="text-align: center">{{($totalPackageAmount + $totalBillamt) - $totalReceivedAmnt}}</td>
                        <td style="text-align: center">{{$totalReceivedAmnt}}</td>
                        <td style="text-align: center">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Receive Amount
                          </button>

                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                            Create Bill
                          </button>

                          <a href="{{route('admin.agentTran', $id)}}" class="btn btn-primary" >
                            All transaction
                          </a>

                        </td>
                      </tr>
                    
                    </tbody>
                  </table>

                  


                  <table id="example1" class="table table-bordered table-striped mt-4">
                    <thead>
                    <tr>
                      <th>Sl</th>
                      <th>Passport Name</th>
                      <th>Passport Number</th>
                      <th>Package Cost</th>
                      <th>Received Amount</th>
                      <th>Status</th>
                      <!-- <th>Action</th> -->
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $key => $data)
                      <tr>
                        <td style="text-align: center">{{ $key + 1 }}</td>
                        <td style="text-align: center"><a href="{{route('admin.clientDetails', $data->id)}}">{{$data->passport_name}}</a></td>
                        <td style="text-align: center">{{$data->passport_number}}</td>
                        <td style="text-align: center">{{$data->package_cost}}</td>
                        <td style="text-align: center">{{$data->total_rcv}}</td>
                        <td style="text-align: center">
                          @if ($data->status == 0) New
                          @elseif($data->status == 1)Processing
                          @elseif($data->status == 2) Complete @else Decline @endif
                        </td>
                        
                        <!-- <td style="text-align: center">
                          <a href="{{route('admin.clientDetails', $data->id)}}"><i class="fa fa-eye" style="color: #21f34f;font-size:16px;"></i></a>
                          <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                          <a id="deleteBtn" rid="{{$data->id}}"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                          </a> 
                        </td> -->
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


<!-- Modal Receive Payment-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tranermsg"></div>
        <form class="form-horizontal">

          <div class="row">
            <div class="col-sm-6">
              <label>Transaction method</label>
              <select class="form-control" id="account_id" name="account_id">
                <option value="">Select</option>
                @foreach (\App\Models\Account::all() as $method)
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
          <div class="col-sm-6">
              <label>Transaction Type</label>
              <select class="form-control" id="tran_type" name="tran_type">
                <option value="">Select</option>               
                  <option value="package_received">Package Received</option>
                  <option value="okala_received">Okala Received</option>
                  <option value="service_received">Service Received</option>
              </select>
          </div>
            <div class="col-sm-6">
                <label>Amount</label>
                <input type="number" class="form-control" id="amount" name="amount">
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
                <label>Note</label>
                <input type="text" class="form-control" id="note" name="note">
                <input type="hidden" id="agent_id" name="agent_id" value="{{$id}}">
            </div>
          </div>
          
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="rcptBtn">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- end  -->

<!-- modal create bill  -->
 
<!-- Modal -->
<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tranermsg"></div>
        <form class="form-horizontal">

          <div class="row">
            <div class="col-sm-12">
                <label>Date</label>
                <input type="date" class="form-control" id="bdate" name="bdate">
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
                <label>Amount</label>
                <input type="number" class="form-control" id="bamount" name="bamount">
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
                <label>Note</label>
                <input type="text" class="form-control" id="bnote" name="bnote">
                <input type="hidden" id="bagent_id" name="bagent_id" value="{{$id}}">
            </div>
          </div>
          
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="billBtn">Create</button>
      </div>
    </div>
  </div>
</div>
<!-- create bill end  -->


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
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'status': status, 'id': id},
              success: function(d){
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
      var url = "{{URL::to('/admin/client')}}";
      var upurl = "{{URL::to('/admin/client-update')}}";
      // console.log(url);
      $("#addBtn").click(function(){
      //   alert("#addBtn");
            $(this).prop('disabled', true);
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
              form_data.append("clientid", $("#clientid").val());
              form_data.append("passport_number", $("#passport_number").val());
              form_data.append("passport_name", $("#passport_name").val());
              form_data.append("passport_rcv_date", $("#passport_rcv_date").val());
              form_data.append("country", $("#country").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("package_cost", $("#package_cost").val());
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
              form_data.append("clientid", $("#clientid").val());
              form_data.append("passport_number", $("#passport_number").val());
              form_data.append("passport_name", $("#passport_name").val());
              form_data.append("passport_rcv_date", $("#passport_rcv_date").val());
              form_data.append("country", $("#country").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("package_cost", $("#package_cost").val());
              form_data.append("description", $("#description").val());
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
                          $("#addBtn").prop('disabled', false);
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
      // $("#contentContainer").on('click','#EditBtn', function(){
      //     //alert("btn work");
      //     codeid = $(this).attr('rid');
      //     //console.log($codeid);
      //     info_url = url + '/'+codeid+'/edit';
      //     //console.log($info_url);
      //     $.get(info_url,{},function(d){
      //         populateForm(d);
      //         pagetop();
      //     });
      // });
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
      // function populateForm(data){
      //     $("#clientid").val(data.clientid);
      //     $("#passport_number").val(data.passport_number);
      //     $("#passport_name").val(data.passport_name);
      //     $("#passport_rcv_date").val(data.passport_rcv_date);
      //     $("#country").val(data.country);
      //     $("#user_id").val(data.user_id);
      //     $("#package_cost").val(data.package_cost);
      //     $("#description").val(data.description);
      //     $("#codeid").val(data.id);
      //     $("#addBtn").val('Update');
      //     $("#addBtn").html('Update');
      //     $("#addThisFormContainer").show(300);
      //     $("#newBtn").hide(100);
      // }
      function clearform(){
          $('#createThisForm')[0].reset();
          $("#addBtn").val('Create');
      }

      // add money from agent
      var tranurl = "{{URL::to('/admin/money-receipt')}}";
      // console.log(url);
      $("#rcptBtn").click(function(){

          var form_data = new FormData();
          form_data.append("account_id", $("#account_id").val());
          form_data.append("user_id", $("#agent_id").val());
          form_data.append("date", $("#date").val());
          form_data.append("amount", $("#amount").val());
          form_data.append("note", $("#note").val());
          form_data.append("tran_type", $("#tran_type").val());
          form_data.append("ref", "Received");

          $.ajax({
            url: tranurl,
            method: "POST",
            contentType: false,
            processData: false,
            data:form_data,
            success: function (d) {
                if (d.status == 303) {
                    $(".tranermsg").html(d.message);
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
                        title: 'Data saved successfully.'
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
      // add money from agent

// bill create start
      var bctranurl = "{{URL::to('/admin/bill-create')}}";
      // console.log(url);
      $("#billBtn").click(function(){

          var form_data = new FormData();
          form_data.append("user_id", $("#bagent_id").val());
          form_data.append("date", $("#bdate").val());
          form_data.append("amount", $("#bamount").val());
          form_data.append("note", $("#bnote").val());
          form_data.append("tran_type", "service_sales");
          form_data.append("ref", "Bill");

          $.ajax({
            url: bctranurl,
            method: "POST",
            contentType: false,
            processData: false,
            data:form_data,
            success: function (d) {
                if (d.status == 303) {
                    $(".tranermsg").html(d.message);
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
                        title: 'Bill created successfully.'
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
      // bill create end


  });
</script>
@endsection
@extends('admin.layouts.admin')

@section('content')
<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<!-- Main content -->
<section class="content mt-3" id="newBtnSection">
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
          <div class="col-md-8">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Add new okala</h3>
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
                        <label>Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Number of Okala</label>
                        <input type="number" id="datanumber" name="datanumber" class="form-control">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Visa Id</label>
                        <input type="number" id="visaid" name="visaid" class="form-control">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Sponsor Id</label>
                        <input type="number" id="sponsorid" name="sponsorid" class="form-control">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>RL</label>
                        <select name="r_l_detail_id" id="r_l_detail_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\RLDetail::orderby('id', 'DESC')->where('status', 1)->get() as $rl)
                          <option value="{{$rl->id}}">{{$rl->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Agent</label>
                        <select name="user_id" id="user_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\User::orderby('id', 'DESC')->where('is_type', 2)->get() as $agent)
                          <option value="{{$agent->id}}">{{$agent->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Trade</label>
                        <select name="trade" id="trade" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\Trade::orderby('id', 'DESC')->where('status', 1)->get() as $trade)
                          <option value="{{$trade->id}}">{{$trade->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\Vendor::orderby('id', 'DESC')->where('status', 1)->get() as $vendor)
                          <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <h3>Purchase </h3> 
                    </div>

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Purchase Amount in BDT</label>
                          <input type="number" id="bdt_amount" name="bdt_amount" class="form-control">
                        </div>
                      </div>
  
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Purchase Amount in Riyal</label>
                          <input type="number" id="riyal_amount" name="riyal_amount" class="form-control">
                        </div>
                      </div>
                    
                    <div class="col-sm-12">
                      <h3>Sales </h3> 
                    </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label> Sales Amount in BDT</label>
                          <input type="number" id="sales_bdt_amount" name="sales_bdt_amount" class="form-control">
                        </div>
                      </div>
  
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Sales Amount in Riyal</label>
                          <input type="number" id="sales_riyal_amount" name="sales_riyal_amount" class="form-control">
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
              <input type="hidden" id="okalaCount" value="{{$data->count()}}">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl</th>
                  <th>Date</th>
                  <th>Visa Id</th>
                  <th>Sponsor Id</th>
                  <th>Trade</th>
                  <th>Assign To</th>
                  <th>Vendor</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  @php
                      $tradename = \App\Models\Trade::where('id', $data->trade)->first();
                  @endphp
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$data->date}}</td>
                    <td style="text-align: center">{{$data->visaid}}</td>
                    <td style="text-align: center">{{$data->sponsorid}}</td>
                    <td style="text-align: center">
                      @if (isset($tradename))
                      {{$tradename->name}}
                      @endif
                    </td>
                    <td style="text-align: center">
                      @if (isset($data->assign_to))
                      {{$data->client->passport_name}}
                      @else
                      <select name="assignto" id="assignto" class="form-control clientselect assignto"  data-okala-id="{{ $data->id }}">
                        <option value="">Select</option>
                        @foreach (\App\Models\Client::select('id', 'passport_name', 'status')->where('status', 0)->get() as $client)

                        <option value="{{$client->id}}">{{$client->passport_name}}</option>
                            
                        @endforeach
                      </select>
                      @endif
                      
                      <p id="message"></p>
                    </td>
                    <td style="text-align: center">{{$data->vendor->name}}</td>
                    
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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


    $(document).ready(function () {
      $('.clientselect').select2({
            placeholder: 'Select a client',
            width: '100%'
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
      var url = "{{URL::to('/admin/okala-sales')}}";
      var upurl = "{{URL::to('/admin/okala-sales-update')}}";
      // console.log(url);
      $("#addBtn").click(function(){
        $(this).prop('disabled', true);
      //   alert("#addBtn");
          if($(this).val() == 'Create') {
              var form_data = new FormData();
              form_data.append("date", $("#date").val());
              form_data.append("datanumber", $("#datanumber").val());
              form_data.append("visaid", $("#visaid").val());
              form_data.append("sponsorid", $("#sponsorid").val());
              form_data.append("trade", $("#trade").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("vendor_id", $("#vendor_id").val());
              form_data.append("r_l_detail_id", $("#r_l_detail_id").val());
              form_data.append("bdt_amount", $("#bdt_amount").val());
              form_data.append("riyal_amount", $("#riyal_amount").val());
              form_data.append("sales_bdt_amount", $("#sales_bdt_amount").val());
              form_data.append("sales_riyal_amount", $("#sales_riyal_amount").val());
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
              form_data.append("date", $("#date").val());
              form_data.append("datanumber", $("#datanumber").val());
              form_data.append("visaid", $("#visaid").val());
              form_data.append("sponsorid", $("#sponsorid").val());
              form_data.append("trade", $("#trade").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("vendor_id", $("#vendor_id").val());
              form_data.append("r_l_detail_id", $("#r_l_detail_id").val());
              form_data.append("bdt_amount", $("#bdt_amount").val());
              form_data.append("riyal_amount", $("#riyal_amount").val());
              form_data.append("sales_bdt_amount", $("#sales_bdt_amount").val());
              form_data.append("sales_riyal_amount", $("#sales_riyal_amount").val());
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
          $("#date").val(data.date);
          $("#visaid").val(data.visaid);
          $("#sponsorid").val(data.sponsorid);
          $("#trade").val(data.trade);
          $("#user_id").val(data.user_id);
          $("#vendor_id").val(data.vendor_id);
          $("#r_l_detail_id").val(data.r_l_detail_id);
          $("#bdt_amount").val(data.bdt_amount);
          $("#riyal_amount").val(data.riyal_amount);
          $("#sales_bdt_amount").val(data.sales_bdt_amount);
          $("#sales_riyal_amount").val(data.sales_riyal_amount);
          $("#codeid").val(data.id);
          $("#addBtn").val('Update');
          $("#addBtn").html('Update');
          $("#addThisFormContainer").show(300);
          $("#datanumber").hide(100);
          $("#newBtn").hide(100);
      }
      function clearform(){
          $('#createThisForm')[0].reset();
          $("#addBtn").val('Create');
      }
  });
</script>
@endsection
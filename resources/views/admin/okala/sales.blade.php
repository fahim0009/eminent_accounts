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
                <h3 class="card-title">Add new okala Sales</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="ermsg"></div>
                <form id="createThisForm">
                  @csrf
                  <input type="hidden" class="form-control" id="codeid" name="codeid">
                  <input type="hidden" class="form-control" id="tran_type" name="tran_type" value="okala_sales">
                  <div class="row">

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Oakala No</label>
                        <select name="okalaNo" id="okalaNo" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\OkalaPurchase::where('purchase_type', '1')->where('status', '0')->get() as $purchase)
                          <option value="{{$purchase->id}}">Visa Id-{{$purchase->visaid}}- Total Visa-{{($purchase->number)}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    {{-- <div class="col-sm-6">
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
                          @foreach (\App\Models\CodeMaster::where('type', 'RL')->where('status', 1)->get() as $rl)
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
                    </div> --}}

                    {{-- <div class="col-sm-3">
                      <div class="form-group">
                        <label>Trade</label>
                        <select name="trade" id="trade" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\CodeMaster::where('type', 'TRADE')->where('status', 1)->get() as $trade)
                          <option value="{{$trade->id}}">{{$trade->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div> --}}

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Agent</label>
                        <select name="agentId" id="agentId" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\User::orderby('id', 'DESC')->where('is_type', 2)->get() as $agent)
                          <option value="{{$agent->id}}">{{$agent->name}}</option>
                          @endforeach
                        </select>
                      </div>
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
                <th style="text-align: center">Sl</th>
                <th style="text-align: center">Date</th>
                <th style="text-align: center">Number</th>
                <th style="text-align: center">VISA Id</th>
                <th style="text-align: center">Sponsor Id</th>
                <th style="text-align: center">Agent</th>
                <th style="text-align: center">Transaction</th>
                <!-- <th style="text-align: center">Action</th> -->
              </tr>
              </thead>
              <tbody>
                @foreach (\App\Models\OkalaSale::orderby('id', 'DESC')->get() as $key => $okala)
                <tr>
                  <td style="text-align: center">{{ $key + 1 }}</td>
                  <td style="text-align: center">{{$okala->date}}</td>
                  <td style="text-align: center">{{$okala->number}}</td>
                  <td style="text-align: center">{{$okala->visaid}}</td>
                  <td style="text-align: center">{{$okala->sponsor_id}}</td>
                  <td style="text-align: center">{{$okala->user->name}}</td>
                  <td style="text-align: center">

                    <span class="btn btn-secondary btn-xs rcv-btn" style="cursor: pointer;" data-id="{{ $okala->id }}" data-agent-id="{{ $okala->user_id }}" data-rl-id="">Receive</span>

                    <span class="btn btn-success btn-xs trn-btn" style="cursor: pointer;" data-id="{{ $okala->id }}" data-vendor-id="{{ $okala->user_id }}" data-program-id="">Transaction</span>
                  </td>
                  
                  <!-- <td style="text-align: center">
                    <a href="{{route('okalasalesDetails', $okala->id)}}"><i class="fa fa-eye" style="color: #24ae2f;font-size:16px;"></i></a>
                    <a id="EditBtn" rid="{{$okala->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                    <a id="deleteBtn" rid="{{$okala->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
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




<div class="modal fade" id="rcvModal" tabindex="-1" role="dialog" aria-labelledby="rcvModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="rcvModalLabel">Received Form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form id="rcvForm">
              <div class="modal-body">
                <div class="permsg"></div>
                <div class="form-group">
                  <label for="paymentDate">Payment Date <span style="color: red;">*</span></label>
                  <input type="date" class="form-control" id="paymentDate" name="paymentDate" placeholder="Enter payment Date">
              </div>
                  <div class="form-group">
                      <label for="rcvamount">Amount in Bdt <span style="color: red;">*</span></label>
                      <input type="number" class="form-control" id="rcvamount" name="rcvamount">
                  </div>

                  
                  <div class="form-group">
                    <label for="rcvriyalamount">Amount in Riyal <span style="color: red;">*</span></label>
                    <input type="number" class="form-control" id="rcvriyalamount" name="rcvriyalamount">
                  </div>

                  {{-- <div class="form-group">
                      <label for="rcvaccount_id">Type <span style="color: red;">*</span></label>
                      <select name="rcvaccount_id" id="rcvaccount_id" class="form-control" >
                        <option value="">Select</option>
                        @foreach (\App\Models\Account::orderby('id', 'ASC')->get() as $acc)
                          <option value="{{$acc->id}}">{{$acc->name}}</option>
                        @endforeach
                      </select>
                  </div> --}}
                  <div class="form-group">
                    <label for="paymentType">Payment Type <span style="color: red;">*</span></label>
                    <select name="paymentType" id="paymentType" class="form-control" >
                      <option value="">Select</option>
                      <option value="Cash">Cash</option>
                      <option value="Bank">Bank</option>
                    </select>
                </div>
                  <div class="form-group" id="accountField" style="display: none;">
                    <label for="rcvaccount_id">Account Id</label>
                    <select name="rcvaccount_id" id="rcvaccount_id" class="form-control">
                        <option value="">Select</option>
                        @foreach (\App\Models\Account::orderby('id', 'ASC')->get() as $acc)
                            <option value="{{$acc->id}}">{{$acc->name}}</option>
                        @endforeach
                    </select>
                </div>

                  <div class="form-group">
                    <label for="rcvdocument">Document</label>
                    <input type="file" class="form-control" id="rcvdocument" name="rcvdocument">
                </div>

                  <div class="form-group">
                      <label for="note">Note</label>
                      <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-warning">Receive</button>
              </div>
          </form>
      </div>
  </div>
</div>

{{-- transaction  --}}
<div class="modal fade" id="tranModal" tabindex="-1" role="dialog" aria-labelledby="tranModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="tranModalLabel">Vendor Payment Form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>


          <div class="modal-body">
            
            <table id="trantable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Payment Method</th>
                  <th>Payment Type</th>
                  <th>Dr. Amount</th>
                  <th>Cr. Amount</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                  <p>Balance: <span id="balance"></span></p>
                </tfoot>
            </table>

          </div>
        
          
      </div>
  </div>
</div>


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
          if($(this).val() == 'Create') {
              var form_data = new FormData();
              form_data.append("date", $("#date").val());
              form_data.append("okalaNo", $("#okalaNo").val());
              form_data.append("agentId", $("#agentId").val());
              form_data.append("sales_bdt_amount", $("#sales_bdt_amount").val());
              form_data.append("sales_riyal_amount", $("#sales_riyal_amount").val());
              form_data.append("tran_type", $("#tran_type").val());
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


      // receive 
      $("#contentContainer").on('click', '.rcv-btn', function () {
          var id = $(this).data('id');
          var agentId = $(this).data('agent-id');
          console.log(agentId);
          $('#rcvModal').modal('show');
          $('#rcvForm').off('submit').on('submit', function (event) {
              event.preventDefault();

              
              var document = $('#rcvdocument').prop('files')[0];
              if(typeof document === 'undefined'){
                document = 'null';
              }

              var form_data = new FormData();
              form_data.append("okalaId", id);
              form_data.append("agentId", agentId);
              form_data.append("paymentDate", $("#paymentDate").val());
              form_data.append("paymentType", $("#paymentType").val());
              form_data.append("tran_type", $("#tran_type").val());
              form_data.append('document', document);
              form_data.append("amount", $("#rcvamount").val());
              form_data.append("riyalamount", $("#rcvriyalamount").val());
              $("#rcvaccount_id").val() && form_data.append("account_id", $("#rcvaccount_id").val());
              form_data.append("note", $("#note").val());
              form_data.append("ref", "Received");

              // alert("from work");
              // exit;

              if (!$("#rcvamount").val()) {
                  alert('Please enter a amount.');
                  return;
              }

              if (!$("#rcvriyalamount").val()) {
                  alert('Please enter a riyal amount.');
                  return;
              }

              if (!$("#rcvaccount_id").val() && $("#paymentType").val() == 'Bank') {
                  alert('Please enter a Account type.');
                  return;
              }

              if (!$("#paymentType").val()) {
                  alert('Please enter a Account type.');
                  return;
              }

              $.ajax({
                  url: '{{ URL::to('/admin/okala-sales-receive') }}',
                  method: 'POST',
                  data:form_data,
                  contentType: false,
                  processData: false,
                  // dataType: 'json',
                  success: function (response) {
                    if (response.status == 303) {
                        $(".permsg").html(d.message);
                    }else if(response.status == 300){

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
                    
                      console.log(response);
                      $('#rcvModal').modal('hide');

                  },
                  error: function (xhr) {
                      console.log(xhr.responseText);
                  }
              });
          });
      });

        $('#rcvModal').on('hidden.bs.modal', function () {
            $('#rcvamount').val('');
            $('#note').val('');
        });
      // receive end 

        $('#payModal').on('hidden.bs.modal', function () {
            $('#paymentAmount').val('');
            $('#paymentNote').val('');
        });


        $("#contentContainer").on('click', '.trn-btn', function () {
          var id = $(this).data('id');
          var vendorId = $(this).data('vendor-id');
          $('#tranModal').modal('show');
              console.log(id, vendorId);
              var form_data = new FormData();
              form_data.append("okalaId", id);
              form_data.append("vendorId", vendorId);

              $.ajax({
                  url: '{{ URL::to('/admin/vendor-transaction') }}',
                  method: 'POST',
                  data:form_data,
                  contentType: false,
                  processData: false,
                  // dataType: 'json',
                  success: function (response) {
                    console.log(response);
                      $('#trantable tbody').html(response.data);
                      $('#balance').html(response.balance);
                  },
                  error: function (xhr) {
                      console.log(xhr.responseText);
                  }
              });
        });

  });
</script>
<script>
  // Use plain JavaScript
  document.getElementById('paymentType').addEventListener('change', function () {
      const paymentType = this.value;
      const accountField = document.getElementById('accountField');
      if (paymentType === 'Bank') {
          accountField.style.display = 'block'; // Show the Account Id field
      } else {
          accountField.style.display = 'none'; // Hide the Account Id field
      }
  });
</script>
@endsection
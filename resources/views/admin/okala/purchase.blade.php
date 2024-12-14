@extends('admin.layouts.admin')

@section('content')
<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

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

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>RL </label>
                        <select name="r_l_detail_id" id="r_l_detail_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\CodeMaster::where('type', 'RL')->where('status', 1)->get() as $rl)

                          <option value="{{$rl->id}}">{{$rl->type_name}}</option>
                              
                          @endforeach
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Trade</label>
                        <select name="trade" id="trade" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\CodeMaster::where('type', 'TRADE')->where('status', 1)->get() as $trade)

                          <option value="{{$trade->id}}">{{$trade->type_name}}</option>
                              
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Vendor</label>
                        <select name="user_id" id="user_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\User::where('is_type', '3')->where('status', 1)->get() as $vendor)

                          <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                              
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Purchase Type</label>
                        <select name="purchase_type" id="purchase_type" class="form-control">
                          <option value="">Select</option>
                          <option value="0">Own</option>
                          <option value="1">Other</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Amount in BDT</label>
                        <input type="number" id="bdt_amount" name="bdt_amount" class="form-control">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Amount in Riyal</label>
                        <input type="number" id="riyal_amount" name="riyal_amount" class="form-control">
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
                  <th>Number</th>
                  <th>Visa Number</th>
                  <th>Sponsor ID</th>
                  <th>Vendor</th>
                  <th>Payment</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$data->date}}</td>
                    <td style="text-align: center">{{$data->number}}</td>
                    <td style="text-align: center">{{$data->visaid}}</td>
                    <td style="text-align: center">{{$data->sponsorid}}</td>
                    {{-- <td style="text-align: center">{{$data->vendor->name}}</td> --}}
                    <td style="text-align: center">
                      <span class="btn btn-block btn-info btn-xs payment-btn" style="cursor: pointer;" data-id="{{ $data->id }}" data-vendor-id="{{ $data->user_id }}" data-rl-id="">Pay</span>

                      <span class="btn btn-block btn-success btn-xs trn-btn" style="cursor: pointer;" data-id="{{ $data->id }}" data-vendor-id="{{ $data->user_id }}" data-program-id="">Transaction</span>

                    </td>
                    <td style="text-align: center">
                      <a href="{{route('admin.okalapurchaseDetails', $data->id)}}"><i class="fa fa-eye" style="color: #2cc16a;font-size:16px;"></i></a>
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


<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="payModalLabel">Vendor Payment Form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form id="payForm">
              <div class="modal-body">
                <div class="permsg"></div>
                  <div class="form-group">
                      <label for="paymentAmount">Payment Amount <span style="color: red;">*</span></label>
                      <input type="number" class="form-control" id="paymentAmount" name="paymentAmount" placeholder="Enter payment amount">
                  </div>

                  <div class="form-group">
                      <label for="account_id">Payment Type <span style="color: red;">*</span></label>
                      {{-- <select name="account_id" id="account_id" class="form-control" >
                        <option value="">Select</option>
                        @foreach (\App\Models\Account::orderby('id', 'ASC')->get() as $acc)
                          <option value="{{$acc->id}}">{{$acc->name}}</option>
                        @endforeach
                      </select> --}}
                  </div>

                  <div class="form-group">
                    <label for="document">Document</label>
                    <input type="file" class="form-control" id="document" name="document">
                </div>

                  <div class="form-group">
                      <label for="paymentNote">Payment Note</label>
                      <textarea class="form-control" id="paymentNote" name="paymentNote" rows="3" placeholder="Enter payment note"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-warning">Pay</button>
              </div>
          </form>
      </div>
  </div>
</div>

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
                  <th>Payment Type</th>
                  <th>Payment Method</th>
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
  $(document).ready(function() {
    var okalaurl = "{{URL::to('/admin/client-add-okala')}}";
      $('.assignto').change(function() {
          let clientId = $(this).val();
          let okalaId = $(this).data('okala-id'); 

          console.log(clientId, okalaId);
          $.ajax({
              url: okalaurl,
              type: 'POST',
              data: {
                clientId: clientId,
                okalaId: okalaId,
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
                    title: 'Data assigned successfully.'
                  });
                });
                window.setTimeout(function(){location.reload()},2000)
              },
              error: function(xhr) {
                  $('#message').text('Error updating status');
              }
          });
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
      var url = "{{URL::to('/admin/okala')}}";
      var upurl = "{{URL::to('/admin/okala-update')}}";
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
              // form_data.append("agent_id", $("#agent_id").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("r_l_detail_id", $("#r_l_detail_id").val());
              form_data.append("bdt_amount", $("#bdt_amount").val());
              form_data.append("riyal_amount", $("#riyal_amount").val());
              form_data.append("purchase_type", $("#purchase_type").val());
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
              form_data.append("visaid", $("#visaid").val());
              form_data.append("sponsorid", $("#sponsorid").val());
              form_data.append("trade", $("#trade").val());
              form_data.append("user_id", $("#user_id").val());
              form_data.append("r_l_detail_id", $("#r_l_detail_id").val());
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
          $("#r_l_detail_id").val(data.r_l_detail_id);
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




      $("#contentContainer").on('click', '.payment-btn', function () {
          var id = $(this).data('id');
          var vendorId = $(this).data('vendor-id');
          console.log(vendorId);
          $('#payModal').modal('show');
          $('#payForm').off('submit').on('submit', function (event) {
              event.preventDefault();

              
              var document = $('#document').prop('files')[0];
              if(typeof document === 'undefined'){
                document = 'null';
              }

              var form_data = new FormData();
              form_data.append("okalaId", id);
              form_data.append("vendorId", vendorId);
              form_data.append('document', document);
              form_data.append("paymentAmount", $("#paymentAmount").val());
              form_data.append("account_id", $("#account_id").val());
              form_data.append("paymentNote", $("#paymentNote").val());

              if (!$("#paymentAmount").val()) {
                  alert('Please enter a payment amount.');
                  return;
              }

              if (!$("#account_id").val()) {
                  alert('Please enter a payment type.');
                  return;
              }

              $.ajax({
                  url: '{{ URL::to('/admin/vendor-pay') }}',
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
                      $('#payModal').modal('hide');

                  },
                  error: function (xhr) {
                      console.log(xhr.responseText);
                  }
              });
          });
      });

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
@endsection
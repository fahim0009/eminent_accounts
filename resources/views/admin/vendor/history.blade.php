@extends('admin.layouts.admin')

@section('content')

<!-- Main content -->
<section class="content" id="newBtnSection">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2">
            <a href="{{route('admin.vendor')}}" class="btn btn-secondary my-3">Back</a>
        </div>
      </div>
    </div>
</section>
  <!-- /.content -->
   


    <!-- Main content -->
<section class="content" id="newBtnSection">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12">
        <div class="card card-secondary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Okala Purchase</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Payment</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link " id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true">Tab 2</a>
              </li> -->
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                

              <div class="tab-pane fade active show" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                <!-- visa and others transaction start  -->

                {{-- <form method="GET" action="{{ route('admin.agentClient', $id) }}">
                  <div class="row">
                    <div class="col-sm-3">
                      <label>From Date</label>
                      <input type="date" class="form-control" name="from_date" value="{{ request()->get('from_date') }}">
                    </div>
                    <div class="col-sm-3">
                      <label>To Date</label>
                      <input type="date" class="form-control" name="to_date" value="{{ request()->get('to_date') }}">
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-secondary">Search</button>
                    </div>
                  </div>
                </form> --}}
                
                <!--get total balance -->
                  <?php
                    $tbalance = 0;
                  ?> 
                  @forelse ($okalaPurchase as $sdata)
                          
                    @if(($sdata->tran_type == 'package_sales') || ($sdata->tran_type == 'service_sales') || ($sdata->tran_type == 'package_adon') || ($sdata->tran_type == 'service_adon'))
                    <?php $tbalance = $tbalance + $sdata->bdt_amount;?>
                    @elseif(($sdata->tran_type == 'package_received') || ($sdata->tran_type == 'service_received') || ($sdata->tran_type == 'package_discount') || ($sdata->tran_type == 'service_discount'))
                    <?php $tbalance = $tbalance - $sdata->bdt_amount;?>
                    @endif
  
                  @empty
                  @endforelse

                  <!-- /.card-header -->
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h2>Okala Purchase</h2>
                        </div>
                    </div>

                    <div id="contentContainer">

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
                            </tr>
                            </thead>
                            <tbody>
                              @foreach ($okalaPurchase as $key => $data)
                              <tr>
                                <td style="text-align: center">{{ $key + 1 }}</td>
                                <td style="text-align: center">{{$data->date}}</td>
                                <td style="text-align: center">{{$data->number}}</td>
                                <td style="text-align: center"><a href="{{route('admin.okalapurchaseDetails', $data->id)}}">{{$data->visaid}}</a></td>
                                <td style="text-align: center">{{$data->sponsorid}}</td>
                                <td style="text-align: center">{{$data->user->name}}</td>
                                <td style="text-align: center">
                                  <span class="btn btn-info btn-xs payment-btn" style="cursor: pointer;" data-id="{{ $data->id }}" data-vendor-id="{{ $data->user_id }}" data-rl-id="">Pay</span>
            
                                  <span class="btn btn-success btn-xs trn-btn" style="cursor: pointer;" data-id="{{ $data->id }}" data-vendor-id="{{ $data->user_id }}" data-program-id="">Transaction</span>
            
                                </td>
                               
                              </tr>
                              @endforeach
                            
                            </tbody>
                        </table>
                    </div>

                    
                 <!-- End visa and others transaction End  -->
              </div>


              <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                <!-- Start visa and others transaction Start  -->

                <!--get total okala balance -->
                <?php
                    $tokala_bal = 0;
                ?> 
                  @forelse ($okalaPurchase as $okala_data)
                          
                    @if(($okala_data->tran_type == 'okala_sales') || ($okala_data->tran_type == 'okalasales_adon'))
                    <?php $tokala_bal = $tokala_bal + $okala_data->bdt_amount;?>
                    @elseif(($okala_data->tran_type == 'okala_received') || ($okala_data->tran_type == 'okalasales_discount'))
                    <?php $tokala_bal = $tokala_bal - $okala_data->bdt_amount;?>
                    @endif
  
                  @empty
                  @endforelse

                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h2>Transaction</h2>
                        </div>
                    </div>

                <table id="example2" class="table table-bordered table-striped example1">
                  <thead>
                  
                    <tr>
                        <th>Date</th>
                        <th>Tran Id</th>
                        <th>Tran Type</th>
                        <th>Payment Type</th>
                        <th>Payment Method</th>
                        <th>Dr. Amount</th>
                        <th>Cr. Amount</th>
                    </tr>

                  </thead>
                  <tbody>
                    @foreach ($trans as $trans_key => $tran)
                    <tr>

                        <td>{{$tran->date}}</td>
                        <td>{{$tran->tran_id}}</td>
                        <td>{{$tran->tran_type}}</td>
                        <td>{{$tran->payment_type}}</td>
                        <td>{{$tran->account->name ?? ""}}</td>
                        <td>{{$tran->bdt_amount}}</td>
                        <td>{{$tran->riyal_amount}}</td>
  
                    </tr>
                    @endforeach
                  
                  </tbody>
                </table>

                <!-- End visa and others transaction End  -->
              </div>

                <!-- 
              <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                coming soon
              </div> -->


            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      
    </div>
  </div>
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
                    <label for="paymentDate">Payment Date <span style="color: red;">*</span></label>
                    <input type="date" class="form-control" id="paymentDate" name="paymentDate" placeholder="Enter payment Date">
                </div>
                    <div class="form-group">
                        <label for="paymentAmount">Payment BDT Amount <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="paymentAmount" name="paymentAmount" placeholder="Enter payment amount">
                    </div>
                    <div class="form-group">
                        <label for="paymentRiyalAmount">Payment Riyal Amount <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="paymentRiyalAmount" name="paymentRiyalAmount" placeholder="Enter payment amount">
                    </div>
                    <div class="form-group">
                      <label for="paymentType">Payment Type <span style="color: red;">*</span></label>
                      <select name="paymentType" id="paymentType" class="form-control" >
                        <option value="">Select</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank">Bank</option>
                      </select>
                  </div>
                    <div class="form-group" id="accountField" style="display: none;">
                      <label for="account_id">Account Id</label>
                      <select name="account_id" id="account_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\Account::orderby('id', 'ASC')->get() as $acc)
                              <option value="{{$acc->id}}">{{$acc->name}}</option>
                          @endforeach
                      </select>
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
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      
      $("#example2").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

      
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
      
      
      function clearform(){
          $('#createThisForm')[0].reset();
          $("#addBtn").val('Create');
      }


      
      $("#contentContainer").on('click', '.payment-btn', function () {
          var id = $(this).data('id');
          var vendorId = $(this).data('vendor-id');
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
              form_data.append("paymentDate", $("#paymentDate").val());
              form_data.append("paymentAmount", $("#paymentAmount").val());
              form_data.append("paymentRiyalAmount", $("#paymentRiyalAmount").val());
              $("#account_id").val() && form_data.append("account_id", $("#account_id").val());
              form_data.append("paymentType", $("#paymentType").val());
              form_data.append("paymentNote", $("#paymentNote").val());
              form_data.append("ref", "Payment for okala purchase");

              // alert("from work");
              // exit;


              if (!$("#paymentDate").val()) {
                  alert('Please enter a payment date.');
                  return;
              }
              if (!$("#paymentAmount").val()) {
                  alert('Please enter a payment amount.');
                  return;
              }

              if (!$("#account_id").val() && $("#paymentType").val() == 'Bank') {
                  alert('Please enter a Account type.');
                  return;
              }
              if (!$("#paymentType").val()) {
                  alert('Please enter a Account type.');
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
              var form_data = new FormData();
              form_data.append("okalaId", id);
              form_data.append("vendorId", vendorId);

              $.ajax({
                  url: '{{ URL::to('/admin/purchase-transaction') }}',
                  method: 'POST',
                  data:form_data,
                  contentType: false,
                  processData: false,
                  // dataType: 'json',
                  success: function (response) {
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
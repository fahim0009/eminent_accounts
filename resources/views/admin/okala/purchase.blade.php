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

                          <option value="{{$vendor->id}}">{{$vendor->name}} {{$vendor->surname}}</option>
                              
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Purchase Type</label>
                        <select name="purchase_type" id="purchase_type" class="form-control">
                          <option value="0">Own</option>
                          <option value="1">Re-Sale</option>
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
              <input type="hidden" class="form-control" id="tran_type" name="tran_type" value="okala_purchase">
              
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
                  <a class="nav-link" id="custom-tabs-one-cancel-tab" data-toggle="pill" href="#custom-tabs-one-cancel" role="tab" aria-controls="custom-tabs-one-cancel" aria-selected="false">Okala Cancel</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-replace-tab" data-toggle="pill" href="#custom-tabs-one-replace" role="tab" aria-controls="custom-tabs-one-replace" aria-selected="false">Okala Cancel & Replace</a>
                </li>

              
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                

              <div class="tab-pane fade active show" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">

                <!-- visa and others transaction start  -->

                
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
                        <th>Status</th>
                        <th>Payment</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $key => $data)

                        
                        @if ($data->status == 0)

                        <tr>
                          <td style="text-align: center">{{ $key + 1 }}</td>
                          <td style="text-align: center">{{$data->date}}</td>
                          <td style="text-align: center">{{$data->number}}</td>
                          <td style="text-align: center"><a href="{{route('admin.okalapurchaseDetails', $data->id)}}">{{$data->visaid}}</a></td>
                          <td style="text-align: center">{{$data->sponsorid}}</td>
                          <td style="text-align: center">{{$data->user->name}} {{$data->user->surname}}</td>

                          <td style="text-align: center">
                            <div class="btn-group">
                              <button type="button" class="btn btn-secondary"><span id="stsval{{$data->id}}"> @if($data->status == 0) Processing @elseif($data->status == 1) Complete @else New @endif</span></button>
                              <button type="button" class="btn btn-secondary dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu" role="menu">
                                <button class="dropdown-item stsBtn" data-id="{{$data->id}}" value="0">Processing</button>
                                <button class="dropdown-item stsBtn" data-id="{{$data->id}}" value="1">Complete</button>
                              </div>
                            </div>
                          </td>


                          <td style="text-align: center">
                            <span class="btn btn-info btn-xs payment-btn" style="cursor: pointer;" data-id="{{ $data->id }}" data-vendor-id="{{ $data->user_id }}" data-rl-id="">Pay</span>

                            <span class="btn btn-success btn-xs trn-btn" style="cursor: pointer;" data-id="{{ $data->id }}" data-vendor-id="{{ $data->user_id }}" data-program-id="">Transaction</span>

                          </td>
                        
                        </tr>
                            
                        @endif
                        
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
                    <h3 class="card-title">All Data</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="example2" class="table table-bordered table-striped">
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

                        @foreach ($complete as $key2 => $cdata)
                        <tr>
                          <td style="text-align: center">{{ $key2 + 1 }}</td>
                          <td style="text-align: center">{{$cdata->date}}</td>
                          <td style="text-align: center">{{$cdata->number}}</td>
                          <td style="text-align: center"><a href="{{route('admin.okalapurchaseDetails', $cdata->id)}}">{{$cdata->visaid}}</a></td>
                          <td style="text-align: center">{{$cdata->sponsorid}}</td>
                          <td style="text-align: center">{{$cdata->user->name}} {{$cdata->user->surname}}</td>

                          <td style="text-align: center">
                            <span class="btn btn-info btn-xs payment-btn" style="cursor: pointer;" data-id="{{ $cdata->id }}" data-vendor-id="{{ $cdata->user_id }}" data-rl-id="">Pay</span>

                            <span class="btn btn-success btn-xs trn-btn" style="cursor: pointer;" data-id="{{ $cdata->id }}" data-vendor-id="{{ $cdata->user_id }}" data-program-id="">Transaction</span>

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

                  {{-- Okala Cancel --}}
              <div class="tab-pane fade" id="custom-tabs-one-cancel" role="tabpanel" aria-labelledby="custom-tabs-one-cancel-tab">
                
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Okala Cancel</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>VISA ID</th>
                      <th>Sponsor ID</th>
                      <th>Vendor Name</th>
                      <th>Note</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($visaCancel as $key4 => $row)
                      <tr>
                       <td style="text-align: center">{{ $key4 + 1 }}</td>
                        <td>{{ $row->visa_id }}</td>
                        <td>{{ $row->sponsor_id }}</td>
                         <td>{{ $row->vendor_name ?? '' }} {{ $row->vendor_surname ?? '' }}</td>
                        <td></td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

              {{-- Okala Cancel & Replace --}}
              <div class="tab-pane fade" id="custom-tabs-one-replace" role="tabpanel" aria-labelledby="custom-tabs-one-replace-tab">
                
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Okala Cancel & Replaced</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">

                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>VISA ID</th>
                      <th>Sponsor ID</th>
                      <th>Vendor Name</th>
                      <th>Note</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($okalaReplace as $key4 => $row)
                      <tr>
                        <td style="text-align: center">{{ $key4 + 1 }}</td>
                        <td>{{ $row->visa_id }}</td>
                        <td>{{ $row->sponsor_id }}</td>
                        <td>{{ $row->vendor_name ?? '' }} {{ $row->vendor_surname ?? '' }}</td>
                        <td></td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

            </div>
          </div>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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

<script>
$(document).ready(function () {
  var t1 = $('#example1').DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    ordering: true,
    buttons: ["copy", "csv", "excel", "pdf", "print"],
    columnDefs: [
      { targets: 0, orderable: false, searchable: false, className: 'all' } // SL col
    ]
  });

  // continuous reverse numbering
  t1.on('order.dt search.dt draw.dt', function () {
    const total = t1.rows({ search: 'applied', order: 'applied' }).count();
    const info  = t1.page.info();
    let num     = total - info.start;

    t1.cells(null, 0, { search: 'applied', order: 'applied', page: 'current' })
      .every(function () {
        this.data(num--);
      });
  }).draw();
});

var t2 = $("#example2").DataTable({
  responsive: true,
  lengthChange: false,
  autoWidth: false,
  ordering: true,
  buttons: ["copy", "csv", "excel", "pdf", "print"],
  columnDefs: [
    { targets: 0, orderable: false, searchable: false, className: 'all' } // SL column
  ]
});

// Continuous reverse SL across all pages
t2.on('order.dt search.dt draw.dt', function () {
  // Total rows after filter + order
  const total = t2.rows({ search: 'applied', order: 'applied' }).count();
  const info  = t2.page.info();

  // The first number on the current page (descending)
  // e.g., total=37; page 0 start=0 -> startNum=37
  //       page 1 start=10 -> startNum=27, etc.
  let num = total - info.start;

  // Fill only current page cells
  t2.cells(null, 0, { search: 'applied', order: 'applied', page: 'current' })
    .every(function () {
      this.data(num--);
    });
}).draw();


    $(function() {
      $('.stsBtn').click(function() {
        var url = "{{URL::to('/admin/change-okala-purchase-status')}}";
          var id = $(this).data('id');
          var status = $(this).attr('value');
          // console.log(value);
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
              form_data.append("user_id", $("#user_id").val());
              form_data.append("r_l_detail_id", $("#r_l_detail_id").val());
              form_data.append("bdt_amount", $("#bdt_amount").val());
              form_data.append("riyal_amount", $("#riyal_amount").val());
              form_data.append("purchase_type", $("#purchase_type").val());
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
                  url: '{{ URL::to('/admin/purchase-transaction') }}',
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
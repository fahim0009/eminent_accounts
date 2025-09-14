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
                          <!-- Image loader -->
          <!-- Loader Overlay -->
          <div id="loading" style="display:none; position: absolute; top: 0; left: 0; z-index: 9999; width: 100%; height: 100%; background-color: rgba(255,255,255,0.7); text-align: center;">
              <img src="{{ asset('assets/common/loader.gif') }}" id="loading-image" alt="Loading..." style="margin-top: 20%;">
          </div>

        <!-- Image loader -->
              <div class="ermsg"></div>
                <form id="createThisForm">
                  @csrf
                  <input type="hidden" class="form-control" id="codeid" name="codeid">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Agents</label>
                        <select name="user_id" id="user_id" class="form-control" disabled>
                          <option value="">Select</option>
                          @foreach ($agents as $item)
                          <option value="{{$item->id}}" selected>{{$item->name}}</option>
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
                  
                  <!-- toggle swich  -->
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="is_ticket">Ticket</label><br>
                        <input type="checkbox" id="is_ticket" name="is_ticket" value="1" data-toggle="toggle" data-on="Yes" data-off="No">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="is_job">Job</label><br>
                        <input type="checkbox" id="is_job" name="is_job" value="1" data-toggle="toggle" data-on="Yes" data-off="No">
                      </div>
                    </div>

                  <!-- discription  -->
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Note</label>
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
                      <th>Discount Amount</th>
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
                        <td style="text-align: center">{{$totalPkgDiscountAmnt}}</td>
                        <td style="text-align: center">{{$totaServiceamt}}</td>
                        <td style="text-align: center">{{$dueForvisa}}</td>
                        <td style="text-align: center">{{$ttlVisanSrvcRcv}}</td>
                        <td style="text-align: center">
                          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
                            Receive Amount
                          </button>

                          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModa2">
                            Create Bill
                          </button>


                        </td>
                      </tr>
                    
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


    <!-- Main content -->
<section class="content" id="newBtnSection">
  <div class="container-fluid">
    
  <div class="row">
  <div class="col-12 col-sm-12">
    <div class="card card-secondary card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab">All Client</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab">VISA Transaction</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab">Okala Transaction</a>
          </li>
        </ul>
      </div>

      <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">

          <!-- All Clients Main Tab -->
          <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

            <!-- Sub-tabs under All Clients -->
            <ul class="nav nav-pills mb-3" id="client-subtabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="subtab-processing-tab" data-toggle="pill" href="#subtab-processing" role="tab">Processing</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="subtab-new-tab" data-toggle="pill" href="#subtab-new" role="tab">New</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="subtab-complete-tab" data-toggle="pill" href="#subtab-complete" role="tab">Complete</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="subtab-decline-tab" data-toggle="pill" href="#subtab-decline" role="tab">Visa Cancel/Decline</a>
              </li>
            </ul>

            <!-- Sub-tab contents -->
            <div class="tab-content" id="client-subtabContent">
              <div class="tab-pane fade show active" id="subtab-processing" role="tabpanel">
                @include('partials.processing-clients', ['datas' => $datas->where('status', 1)->values()])
              </div>
              <div class="tab-pane fade" id="subtab-new" role="tabpanel">
                @include('partials.new-clients', ['datas' => $datas->where('status', 0)->values()])
              </div>
              <div class="tab-pane fade" id="subtab-complete" role="tabpanel">
                @include('partials.completed-clients', ['datas' => $datas->where('status', 2)->values()])
              </div>
              <div class="tab-pane fade" id="subtab-decline" role="tabpanel">
                @include('partials.decline-cancel-clients', ['datas' => $datas->whereIn('status', [3, 4])->values()])
              </div>
            </div>
          </div>

          <!-- Other main tabs -->
          <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
            {{-- VISA Transaction content --}}
            
              <!-- visa and others transaction start  -->
              <form method="GET" action="{{ route('admin.agentClient', $id) }}">
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
                </form>
                
                <!--get total balance -->
                @php
                    $tbalance = 0;
                @endphp

                @forelse ($clientTransactions as $sdata)
                    @php
                        $addTypes = ['package_sales', 'service_sales', 'package_adon', 'service_adon'];
                        $subTypes = ['package_received', 'service_received', 'package_discount', 'service_discount'];

                        // Skip if transaction is canceled
                        if ($sdata->status == 1) {
                            if (in_array($sdata->tran_type, $addTypes)) {
                                $tbalance += $sdata->bdt_amount;
                            } elseif (in_array($sdata->tran_type, $subTypes)) {
                                $tbalance -= $sdata->bdt_amount;
                            }
                        }
                    @endphp
                @empty
                @endforelse

                  <!-- /.card-header -->
                    <div class="row">
                    <div class="col-sm-12 text-center">
                      <h2>Transaction</h2>
                    </div>
                    </div>

                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>Date</th>
                          <th>Description</th>
                          <th>Received</th>
                          <th>Bill</th>
                          <th>Balance</th>                  
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($clientTransactions as $key => $tran)
                          @php

                          if ($tran->tran_type == 'package_received') {
                                  $dsc = 'Package';
                              } elseif ($tran->tran_type == 'service_received') {
                                  $dsc = 'Service';
                              } else {
                                  $dsc = '';
                              }

                              $description = trim("{$dsc} {$tran->ref} {$tran->note}");
                              $received = '';
                              $bill = '';
                              $rowClass = '';

                              // Flag for canceled transaction (status = 2)
                              $isCanceled = ($tran->status == 2);
                              if ($isCanceled) {
                                  $rowClass = 'table-danger'; // Bootstrap red row
                              }
                          @endphp

                          @if(in_array($tran->tran_type, ['package_received', 'service_received', 'package_discount', 'service_discount']))
                              @php $received = $tran->bdt_amount; @endphp
                              <tr class="{{ $rowClass }}">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $tran->date }}</td>
                                <td class="text-center">{{ $description }}</td>
                                <td class="text-center">{{ $received }}</td>
                                <td class="text-center"></td>
                                <td class="text-center">{{ number_format($tbalance, 2) }}</td>
                              </tr>
                              @if(!$isCanceled)
                                  @php $tbalance += $tran->bdt_amount; @endphp
                              @endif

                          @elseif(in_array($tran->tran_type, ['package_sales', 'service_sales', 'package_adon', 'service_adon']))
                              @php $bill = $tran->bdt_amount; @endphp
                              <tr class="{{ $rowClass }}">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $tran->date }}</td>
                                <td class="text-center">{{ $description }}</td>
                                <td class="text-center"></td>
                                <td class="text-center">{{ $bill }}</td>
                                <td class="text-center">{{ number_format($tbalance, 2) }}</td>
                              </tr>
                              @if(!$isCanceled)
                                  @php $tbalance -= $tran->bdt_amount; @endphp
                              @endif
                          @endif
                        @endforeach
                      </tbody>
                    </table>
               <!-- End visa and others transaction End  -->
              </div>


              <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
            {{-- Okala Transaction content --}}

              <!--get total okala balance -->
              <?php
                    $tokala_bal = 0;
                ?> 
                  @forelse ($clientTransactions as $okala_data)
                          
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

                <table id="example3" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sl</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Dr.</th>
                    <th>Cr.</th>
                    <th>Balance</th>                  
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($clientTransactions as $okala_key => $okala_tran)

                    
  
                      @if(($okala_tran->tran_type == 'okala_received') || ($okala_tran->tran_type == 'okalasales_discount'))
                      <tr>
                      <td style="text-align: center">{{ $okala_key + 1 }}</td>
                      <td style="text-align: center">{{$okala_tran->date}}</td>
                      <td style="text-align: center">{{$okala_tran->ref}}  @if(isset($okala_tran->note)){{$okala_tran->note}}@endif</td>
  
                      <td style="text-align: center">{{$okala_tran->bdt_amount}}</td>
                      <td style="text-align: center"></td>
                      <td style="text-align: center">{{$tokala_bal}}</td>
                      </tr>
                      <?php $tokala_bal = $tokala_bal + $okala_tran->bdt_amount;?>
  
                      @elseif(($okala_tran->tran_type == 'okala_sales') || ($okala_tran->tran_type == 'okalasales_adon'))
                      <tr>
                      <td style="text-align: center">{{ $okala_key + 1 }}</td>
                      <td style="text-align: center">{{$okala_tran->date}}</td>
                      <td style="text-align: center">{{$okala_tran->ref}}  @if(isset($okala_tran->note)){{$okala_tran->note}}@endif</td>
  
                      <td style="text-align: center"></td>
                      <td style="text-align: center">{{$okala_tran->bdt_amount}}</td>
                      <td style="text-align: center">{{$tokala_bal}}</td>
                      </tr>
                      <?php $tokala_bal = $tokala_bal - $okala_tran->bdt_amount;?>
                      @endif
  
                    </tr>
                    @endforeach                 
                  </tbody>
                </table>

                <!-- End visa and others transaction End  -->
              </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
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
          <div class="col-sm-6">
                <label>Riyal Amount</label>
                <input type="number" class="form-control" id="riyal_amount" name="riyal_amount">
            </div>
            <div class="col-sm-6">
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
      function initReversedTable(selector) {
        var $sel = $(selector);
        var table = $sel.DataTable({
          responsive: true,
          lengthChange: false,
          autoWidth: false,
          buttons: ["copy", "csv", "excel", "pdf", "print"]
        });

        // move buttons (same as your previous code)
        table.buttons().container().appendTo(selector + '_wrapper .col-md-6:eq(0)');

        // On every draw, rewrite the first cell (SL column) for rows on current page
        table.on('draw', function () {
          var info = table.page.info(); // { start, end, length, recordsTotal, recordsDisplay, ... }
          // iterate current page rows and set first <td>
          table.rows({ page: 'current' }).nodes().each(function (row, i) {
            // reversed SL: total_after_filtering - (start_index + index_on_page)
            var reversed = info.recordsDisplay - (info.start + i);
            $('td:eq(0)', row).html(reversed);
          });
        });

        // initial draw to fill SL immediately
        table.draw(false);
        return table;
      }

      // initialize whichever tables you have
      initReversedTable('#example1');
      initReversedTable('#example2');
      initReversedTable('#example3');
      initReversedTable('#example4');
      initReversedTable('#example5');
      initReversedTable('#example6');
      initReversedTable('#example7');
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
          if($(this).val() == 'Create') {

            $('#addBtn').prop('disabled', true).text('Saving...');

            $('#loading').show();
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
              form_data.append("user_id", $("#user_id").val());
              form_data.append("package_cost", $("#package_cost").val());
              form_data.append("description", $("#description").val());
              form_data.append("is_ticket", $('#is_ticket').is(':checked') ? 1 : 0);
              form_data.append("is_job", $('#is_job').is(':checked') ? 1 : 0);




              $.ajax({
                url: url,
                method: "POST",
                contentType: false,
                processData: false,
                data:form_data,
                success: function (d) {
                console.log(d);
                    if (d.status == 303) {
                        $(".ermsg").html(d.message);
                        $('#loading').hide();
                        $('#addBtn').prop('disabled', false).text('Create');
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
                      $('#loading').hide();
                      $('#addBtn').prop('disabled', false).text('Create');  
                      window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error: function (d) {
                  $('#loading').hide();
                    console.log(d);
                }
            });
          }
          //create  end
          //Update
          if($(this).val() == 'Update'){

            $('#addBtn').prop('disabled', true).text('Updating...');

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
              form_data.append("user_id", $("#user_id").val());
              form_data.append("package_cost", $("#package_cost").val());
              form_data.append("description", $("#description").val());
              form_data.append("codeid", $("#codeid").val());
              form_data.append("is_ticket", $('#is_ticket').is(':checked') ? 1 : 0);
              form_data.append("is_job", $('#is_job').is(':checked') ? 1 : 0);
              
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
                          $('#addBtn').prop('disabled', false).text('Create');
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
                        $('#addBtn').prop('disabled', false).text('Create');
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
      function populateForm(data){
          $("#passport_number").val(data.passport_number);
          $("#passport_name").val(data.passport_name);
          $("#passport_rcv_date").val(data.passport_rcv_date);
          $("#country").val(data.country_id);
          $("#user_id").val(data.user_id);
          $("#package_cost").val(data.package_cost);
          $("#description").val(data.description);
          $("#codeid").val(data.id);

           // Update toggle switches
            if (data.is_ticket == 1) {
                $('#is_ticket').bootstrapToggle('on');
            } else {
                $('#is_ticket').bootstrapToggle('off');
            }

            if (data.is_job == 1) {
                $('#is_job').bootstrapToggle('on');
            } else {
                $('#is_job').bootstrapToggle('off');
            }

    // Switch to Update Mode
          $("#addBtn").val('Update');
          $("#addBtn").html('Update');
          $("#addThisFormContainer").show(300);
          $("#newBtn").hide(100);
      }
      function clearform(){
          $('#createThisForm')[0].reset();
          $("#addBtn").val('Create');
      }

      // add money from agent
      var tranurl = "{{URL::to('/admin/money-receipt')}}";
      // console.log(url);
      $("#rcptBtn").click(function(){
        $("#rcptBtn").prop('disabled', true);
          var form_data = new FormData();
          form_data.append("account_id", $("#account_id").val());
          form_data.append("user_id", $("#agent_id").val());
          form_data.append("date", $("#date").val());
          form_data.append("amount", $("#amount").val());
          form_data.append("riyal_amount", $("#riyal_amount").val());
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
                    $("#rcptBtn").prop('disabled', false);
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



  //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //

      $('.medical_exp_date_btn').click(function () {
        
          var $btn = $(this); // store reference to the button
          var id = $btn.data('id');
          var medical_exp_date = $('#medical_exp_date' + id).val();

          if (medical_exp_date === '') {
              $('#smsg' + id).html('<span class="text-danger">Please select a date</span>');
              return false;
          }

    $btn.prop('disabled', true); 
          var url = "{{URL::to('/admin/change-client-medical-exp-date')}}";
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'medical_exp_date': medical_exp_date, 'id': id},
              success: function (data) {
                  if (data.status == 303) {

                    $('#smsg'+id).html(data.message);

                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'warning',
                            title: data.message
                          });
                        });
                  } else if (data.status == 300) {
                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: data.message
                          });
                        });
                        
            // Reload page after short delay
            setTimeout(function () {
                location.reload();
            }, 2000);

                        
                  }
              },
              error: function (data) {
                  console.log(data);
              }
          });
      });






  });
</script>
@endsection
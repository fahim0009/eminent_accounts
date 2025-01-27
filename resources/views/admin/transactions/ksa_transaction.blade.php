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
          <div class="col-md-8">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Add new ksa transaction</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="ermsg"></div>
                <form id="createThisForm" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" class="form-control" id="codeid" name="codeid">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date" class="control-label">Date</label>
                            <input type="date" name="date" class="form-control" id="date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" id="chart_of_account_container">
                            <label for="chart_of_account_id" class="control-label ">Chart of Account</label>
                            <select class="form-control select2" id="chart_of_account_id" name="chart_of_account_id">
                                <option value="">Select chart of account</option>
                                @php
                                use App\Models\ChartOfAccount;
                                $accounts = ChartOfAccount::where('sub_account_head', 'Account Payable')->get(['account_name', 'id']);
                                $expenses = ChartOfAccount::where('account_head', 'Expenses')->get();
                                @endphp
                                @foreach($expenses as $expense)
                                <option value="{{ $expense->id }}">{{ $expense->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 d-none">
                        <div class="form-group">
                            <label for="transaction_type" class="control-label">Type</label>
                            <select class="form-control" id="transaction_type" name="transaction_type">
                                <option value="KSA-Expense">KSA</option>
                            </select>
                        </div>
                    </div>

                    
                </div>

                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group" id="payment_type_container">
                            <label for="payment_type" class="control-label">Payment Type</label>
                            <select class="form-control" id="payment_type" name="payment_type">
                                <option value="">Select payment type</option>
                                @foreach (\App\Models\Account::where('status', 1)->get() as $account)
                                    
                                <option value="{{$account->id}}">{{$account->name}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document" class="control-label">Document</label>
                            <input type="file" name="document" class="form-control" id="document">
                        </div>
                    </div>

                    
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount" class="control-label">Amount</label>
                            <input type="text" name="amount" class="form-control" id="amount">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="riyal_amount" class="control-label">Riyal Amount</label>
                            <input type="text" name="riyal_amount" class="form-control" id="riyal_amount">
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
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Tabs -->
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#transactions" data-toggle="tab">Transactions</a></li>
              <li class="nav-item"><a class="nav-link" href="#otherTab" data-toggle="tab">Monthly Statement</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="transactions">
                <!-- Transactions content -->
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
                                  <th>ID</th>
                                  <th>Date</th>
                                  <th>Account</th>
                                  <th>Document</th>
                                  <th>Payment Type</th>
                                  <th>Amount</th>
                                  <th>Riyal Amount</th>
                                  <th>Balance</th>
                                  <th><i class=""></i> Action</th>
                                </tr>
                              </thead>
                              @php
                                $ksaBalance = $ksaTotal - $ksaExp;
                              @endphp
                              <tbody>
                                @foreach ($data as $key => $data)
                                <tr>
                                  <td style="text-align: center">{{ $key + 1 }}</td>
                                  <td style="text-align: center">{{$data->date}}</td>
                                  <td style="text-align: center">
                                    {{$data->chartOfAccount->account_name ?? ''}}
                                    @if ($data->tran_type == 'KSA-Deposit')
                                      <span class="badge badge-success">Deposit</span>
                                    @endif
                                  </td>
                                  <td style="text-align: center">
                                    @if ($data->document)
                                      <a href="{{ asset('images/expense/'.$data->document) }}" class="btn btn-success btn-xs" target="_blank">View</a>
                                    @endif
                                  </td>
                                  <td style="text-align: center">{{$data->account->name ?? ''}}</td>
                                  <td style="text-align: center">{{$data->amount ?? ''}}</td>
                                  <td style="text-align: center">{{$data->riyal_amount ?? ''}}</td>
                                  <td style="text-align: center">{{$ksaBalance}}</td>
                                  @php
                                    if ($data->tran_type == 'KSA-Deposit') {
                                      $ksaBalance -= $data->riyal_amount;
                                    } else {
                                      $ksaBalance += $data->riyal_amount;
                                    }
                                  @endphp
                                  <td style="text-align: center">
                                    @if ($data->tran_type == 'KSA-Expense')
                                    <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                                    @endif
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th style="text-align: right">Total: </th>
                                  <th style="text-align: center">{{$bdtTotal ?? ''}}</th>
                                  <th style="text-align: center">{{$ksaTotal ?? ''}}</th>
                                  <th></th>
                                </tr>
                              </tfoot>
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
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="otherTab">
                <!-- Other tab content -->
                <table class="table">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>Month-Year</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  @php
                  
                      $mdata = \DB::table('expenses')
                        ->select(\DB::raw('DATE_FORMAT(date, "%M-%Y") as month_year'), \DB::raw('SUM(riyal_amount) as total'))
                        ->whereIn('tran_type', ['KSA-Expense'])
                        ->where('status', 2)
                        ->groupBy('month_year')
                        ->orderBy('date', 'DESC')
                        ->get();




                  @endphp
                  <tbody>
                    @foreach ($mdata as $key => $monthly)
                    <tr>
                      <td>{{$key + 1}}</td>
                      <td>{{$monthly->month_year}}</td>
                      <td>{{$monthly->total}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
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
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->


@endsection
@section('script')
<script>
    

    
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
      var url = "{{URL::to('/admin/ksa-transaction')}}";
      var upurl = "{{URL::to('/admin/ksa-transaction-update')}}";


      // console.log(url);
      $("#addBtn").click(function(){
        $(this).prop('disabled', true);
      //   alert("#addBtn");
          if($(this).val() == 'Create') {

            $(this).find('.fa-spinner').remove();
            $(this).prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(this).attr("disabled", 'disabled');

            
            var formData = new FormData($('#createThisForm')[0]);

              $.ajax({
                url: url,
                method: "POST",
                contentType: false,
                processData: false,
                data:formData,
                success: function (d) {
                    if (d.status == 200) {

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
                      
                    }else if(d.status == 300){

                      $(".ermsg").html(d.message);
                        $("#addBtn").prop('disabled', false);
                      
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

            $(this).find('.fa-spinner').remove();
            $(this).prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(this).attr("disabled", 'disabled');

            
            var formData = new FormData($('#createThisForm')[0]);
              
              $.ajax({
                  url:upurl,
                  type: "POST",
                  dataType: 'json',
                  contentType: false,
                  processData: false,
                  data:formData,
                  success: function(d){
                      console.log(d);
                      if (d.status == 200) {

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


                          
                      }else if(d.status == 300){
                        $(".ermsg").html(d.message);
                          pagetop();
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
          $("#chart_of_account_id").val(data.chart_of_account_id);
          $("#transaction_type").val(data.transaction_type);
          $("#payment_type").val(data.payment_type);
          $("#amount").val(data.amount);
          $("#riyal_amount").val(data.riyal_amount);
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
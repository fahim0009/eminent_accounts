@extends('admin.layouts.admin')

@section('content')

<section class="content pt-3" id="contentContainer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="alert-container"></div>
                <div class="card card-secondary card-tabs">

                    <div class="card-header p-0 pt-1">

                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">All Transaction</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-Expenses-tab" data-toggle="pill" href="#custom-tabs-one-Expenses" role="tab" aria-controls="custom-tabs-one-Expenses" aria-selected="false">Expense</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-Income-tab" data-toggle="pill" href="#custom-tabs-one-Income" role="tab" aria-controls="custom-tabs-one-Income" aria-selected="false">Income</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-Assets-tab" data-toggle="pill" href="#custom-tabs-one-Assets" role="tab" aria-controls="custom-tabs-one-Assets" aria-selected="false">Asset</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-Liabilities-tab" data-toggle="pill" href="#custom-tabs-one-Liabilities" role="tab" aria-controls="custom-tabs-one-Liabilities" aria-selected="false">Liability</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-Equity-tab" data-toggle="pill" href="#custom-tabs-one-Equity" role="tab" aria-controls="custom-tabs-one-Equity" aria-selected="false">Equity</a>
                            </li>
                            

                            
                            <li class="nav-item ml-auto px-2">
                                <button class="btn btn-xs btn-success " data-toggle="modal" data-target="#chartModal" data-purpose="0">+ Add New Transaction</button>
                                <a href="{{route('admin.coa', ['office' => 'dhaka'])}}" class="btn btn-xs btn-success " target="blank">
                                    <i class="fas fa-plus"></i>COA
                                </a>
                            </li>
                        </ul>
                        
                    </div>

                    <div class="card-body">


                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                
                                {{-- exp start  --}}
                                <div class="row mb-3">
                                    <form class="form-inline" role="form" method="POST" action="{{ route('admin.expense.filter') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group mx-sm-3">
                                            <label class="sr-only">Start Date</label>
                                            <input type="date" class="form-control" name="start_date" value="{{ request()->input('start_date') }}">
                                        </div>

                                        <div class="form-group mx-sm-3">
                                            <label class="sr-only">End Date</label>
                                            <input type="date" class="form-control" name="end_date" value="{{ request()->input('end_date') }}">
                                        </div>

                                        <div class="form-group mx-sm-3">
                                            <label class="sr-only">Account</label>
                                            <select class="form-control select2" name="account_name">
                                                <option value="">Select Account..</option>
                                                @foreach ($accounts as $account)
                                                <option value="{{ $account->account_name }}" {{ request()->input('account_name') == $account->account_name ? 'selected' : '' }}>
                                                    {{ $account->account_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </form>
                                </div>
                                @component('components.table')
                                @slot('tableID')
                                assetTBL
                                @endslot
                                @slot('head')
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>Document</th>
                                    <th>Payment Type</th>
                                    <th>Amount</th>
                                    <th><i class=""></i> Action</th>
                                @endslot
                                @endcomponent
                                {{-- exp end  --}}

                            </div>

                            @foreach (['Expenses', 'Income', 'Assets', 'Liabilities', 'Equity'] as $type)
                                <div class="tab-pane fade" id="custom-tabs-one-{{ $type }}" role="tabpanel" aria-labelledby="custom-tabs-one-{{ $type }}-tab">
                                    
                                    @component('components.table')
                                    @slot('tableID')
                                    {{ $type }}TBL
                                    @endslot
                                    @slot('head')
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Account</th>
                                        <th>Document</th>
                                        <th>Payment Type</th>
                                        <th>Amount</th>
                                    @endslot
                                    @endcomponent
                                </div>
                            @endforeach
                            
              
              
              
                          </div>




                                




                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="chartModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Transaction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form class="form-horizontal" id="customer-form" enctype="multipart/form-data">
                <div id="alert-container1"></div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date" class="control-label">Date</label>
                                <input type="date" name="date" class="form-control" id="date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label class="form-label" for="account_head">Account Head</label>
                            <select name="account_head" id="account_head" class="form-control">
                                <option value="">Select</option>
                                <option value="Assets">Assets</option>
                                <option value="Expenses">Expenses</option>
                                <option value="Income">Income</option>
                                <option value="Liabilities">Liabilities</option>
                                <option value="Equity">Equity</option>
                            </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="chart_of_account_container">
                                <label for="chart_of_account_id" class="control-label">Chart of Account</label>
                                <input type="hidden" name="chart_of_account_val" id="chart_of_account_val">
                                <select class="form-control select2" id="chart_of_account_id" name="chart_of_account_id">
                                    <option value="">Select chart of account</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transaction_type" class="control-label">Type</label>
                                <select class="form-control" id="transaction_type" name="transaction_type">
                                    <option value="">Select type</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="col-md-6 d-none">
                            <div class="form-group">
                                <label for="office" class="control-label">Office</label>
                                <select class="form-control" id="office" name="office">
                                    <option value="ksa" selected>KSA</option>
                                </select>
                            </div>
                        </div>

                        

                        
                    </div>
                    
                    @php
                    use App\Models\ChartOfAccount;
                    
                    @endphp

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
                        <div class="col-md-12"id="employeeDiv">
                            <div class="form-group">
                                <label for="employee_id" class="control-label">Employee</label>
                                <select  name="employee_id" class="form-control" id="employee_id">
                                    <option value="">Select</option>
                                    @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="amount" class="control-label">BDT Amount</label>
                                <input type="text" name="amount" class="form-control" id="amount">
                            </div>
                        </div>
                        <div class="col-md-6 d-none">
                            <div class="form-group">
                                <label for="riyal_amount" class="control-label">Riyal Amount</label>
                                <input type="text" name="riyal_amount" class="form-control" id="riyal_amount">
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary submit-btn save-btn">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@section('script')

<!-- Payable holder id -->
<script>
    $(document).ready(function() {

        $('#employeeDiv').hide();
        $("#account_head").change(function () {
            var accountHead = $(this).val();
            var office = $('#office').val();

            if (!accountHead) {
                $("#chart_of_account_id").empty().append('<option value="">Select chart of account</option>');
                return;
            }

            $.ajax({
                url: "{{ route('admin.get.chart.of.accounts') }}",
                type: "GET",
                data: {
                    account_head: accountHead,
                    office: office
                },
                success: function (response) {
                    var $select = $("#chart_of_account_id");
                    $select.empty().append('<option value="">Select chart of account</option>');

                    $.each(response.data, function (index, account) {
                        $select.append('<option value="' + account.id + '" data-name="' + account.account_name.toLowerCase() + '">' + account.account_name + '</option>');
                    });

                    // Optional: reset salary div when loading new data
                    $('#employeeDiv').hide();

                    // Fetch related transaction type if needed
                    fetchTranType(accountHead);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching chart of accounts:", xhr.responseText);
                }
            });
        });

        $('#chart_of_account_id').on('change', function () {
            let selectedText = $("#chart_of_account_id option:selected").text().toLowerCase();

                $('#chart_of_account_val').val(selectedText);
            if (selectedText.includes('salary')) {
                $('#employeeDiv').show();
            } else {
                $('#employeeDiv').hide();
            }
        });

        // Optionally trigger change on page load if value is pre-selected
        $('#chart_of_account_id').trigger('change');



        function fetchTranType(accountHead) {
            if (accountHead) {
            
                if (accountHead == "Assets") {

                    $("#transaction_type").html('<option value="">Select type</option><option value="purchase">Purchase</option><option value="sales">Sales</option><option value="received">Received</option><option value="payment">Payment</option>');

                } else if (accountHead == "Expenses") {

                    $("#transaction_type").html('<option value="">Select type</option><option value="received">Received</option><option value="payment">Payment</option>');

                } else if (accountHead == "Income") {

                    $("#transaction_type").html('<option value="">Select type</option><option value="received">Received</option><option value="payment">Payment</option>');

                } else if (accountHead == "Liabilities") {

                    $("#transaction_type").html('<option value="">Select type</option><option value="received">Received</option><option value="payment">Payment</option>');

                } else if (accountHead == "Equity") {

                    $("#transaction_type").html('<option value="">Select type</option><option value="received">Received</option><option value="withdraw">Withdraw</option>');

                } else {
                    $("#transaction_type").html("<option value=''>Please Select</option>");
                }

            }
        }

        $("#payment_type").change(function() {
            $(this).find("option:selected").each(function() {
                var val = $(this).val();
                if (val == "Account Payable") {
                    $("#showpayable").show();
                } else {
                    $("#showpayable").hide();
                    clearPayableHolder();
                }
            });
        }).change();

        function clearPayableHolder() {
            $("#payable_holder_id").val('');
        }
        
        
        
    var charturl = "{{URL::to('/admin/ksa-account')}}";
    var storeurl = "{{URL::to('/admin/account-store')}}";
    var editurl = "{{URL::to('/admin/account-edit')}}";
    var upurl = "{{URL::to('/admin/account-update')}}";
    var customerTBL = $('#assetTBL').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50, // Show 50 entries per page
        order: [[0, 'desc']], // Order by the first column (ID) in descending order
        ajax: {
            url: charturl,
            type: 'GET',
            data: function(d) {

                d.start_date = $('input[name="start_date"]').val();
                d.end_date = $('input[name="end_date"]').val();
                d.account_name = $('select[name="account_name"]').val();
            },
            error: function(xhr, error, thrown) {
                console.log(xhr.responseText);
            }
        },
        deferRender: true,
        columns: [{
                data: 'tran_id',
                name: 'tran_id'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'chart_of_account',
                name: 'chart_of_account'
            },
            {
                data: 'document',
                name: 'document',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (row.document) {
                        return `<a class="btn btn-success btn-xs" href="{{asset('images/expense')}}/${row.document}" target="_blank">View</a>`;
                    } else {
                        return '';
                    }
                }
            },
            {
                data: 'account_name',
                name: 'account_name'
            },
            {
                data: 'bdt_amount',
                name: 'bdt_amount'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    let button = `<button type="button" class="btn btn-warning btn-xs edit-btn" data-toggle="modal" data-target="#chartModal" value="${row.id}" title="Edit" data-purpose='1'><i class="fa fa-edit" aria-hidden="true"></i> Edit</button>`;
                    if (row.amount < 0) {}
                    return button;
                }
            },
        ]
    });



    // Initialize DataTables for each tab
    ['Assets', 'Expenses', 'Income', 'Liabilities', 'Equity'].forEach(function(type) {
        $('#' + type + 'TBL').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: charturl,
                type: 'GET',
                data: function(d) {
                    
                    d.start_date = $('input[name="start_date"]').val();
                    d.end_date = $('input[name="end_date"]').val();
                    d.account_name = $('select[name="account_name"]').val();
                    d.type = type; // Pass the type to the server
                },
                error: function(xhr, error, thrown) {
                    console.log(xhr.responseText);
                }
            },
            deferRender: true,
            columns: [
                { data: 'tran_id', name: 'tran_id' },
                { data: 'date', name: 'date' },
                { data: 'chart_of_account', name: 'chart_of_account' },
                {
                    data: 'document',
                    name: 'document',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        if (row.document) {
                            return `<a class="btn btn-success btn-xs" href="{{asset('images/expense')}}/${row.document}" target="_blank">View</a>`;
                        } else {
                            return '';
                        }
                    }
                },
                { data: 'account_name', name: 'account_name' },
                { data: 'bdt_amount', name: 'bdt_amount' }
            ]
        });
    });

    $('form').on('submit', function(e) {
        e.preventDefault();
        customerTBL.ajax.reload();
    });
    // modal

    $('#chartModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        let purpose = button.data('purpose');
        var modal = $(this);
        if (purpose) {
            let id = button.val();
            $.ajax({
                url: editurl + '/' + id,
                type: 'GET',
                beforeSend: function(request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(response) {
                    console.log(response);

                    var $select = $("#chart_of_account_id");
                    $select.empty().append('<option value="">Select chart of account</option>');

                    $.each(response.coa, function (index, account) {
                        $select.append('<option value="' + account.id + '" data-name="' + account.account_name.toLowerCase() + '">' + account.account_name + '</option>');
                    });

                    $('#date').val(response.date);
                    $('#ref').val(response.ref);

                    fetchTranType(response.account_head);
                    
                    $('#office').val(response.office);
                    $('#transaction_type').val(response.transaction_type);
                    $('#amount').val(response.amount);
                    $('#riyal_amount').val(response.riyal_amount);
                    $('#payment_type').val(response.payment_type);

                    $('#account_head').val(response.account_head);
                    $('#chart_of_account_id').val(response.chart_of_account_id);
                    $('#chart_of_account_val').val(response.chart_of_account_val);
                    $('#employee_id').val(response.employee_id);

                    var payableHolderId = response.payable_holder_id;
                    $('#payable_holder_id').val(payableHolderId);

                    $('#chartModal .submit-btn').removeClass('save-btn').addClass('update-btn').text('Update').val(response.id);
                }
            });
        } else {
            $('#customer-form').trigger('reset');
            $('#customer-form textarea').text('');
            $('#chartModal .submit-btn').removeClass('update-btn').addClass('save-btn').text('Save').val("");
        }
    });


    $('#chartModal').on('hidden.bs.modal', function(e) {
        $('#customer-form')[0].reset();
        $('#customer-form textarea').text('');

        $('#chartModal .submit-btn').removeClass('update-btn').addClass('save-btn').text('Save').val("");

    });


    // save button event
    $("body").delegate(".save-btn", "click", function(event) {
            event.preventDefault();

            $(this).find('.fa-spinner').remove();
            $(this).prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(this).attr("disabled", 'disabled');

            
            var formData = new FormData($('#customer-form')[0]);

            $.ajax({
                url: storeurl,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(d) {
                    console.log(d);
                    $("#loader").removeClass('fa fa-spinner fa-spin');
                    $(".btn-submit").removeAttr("disabled", true);

                    if (d.status == 400) {
                        $(".ermsg").html(d.message);
                    } else {$('#chartModal').modal('toggle');
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
                error: function(xhr, status, error) {
                    $("#loader").removeClass('fa fa-spinner fa-spin');
                    $(".btn-submit").removeAttr("disabled", true);
                    console.error(xhr.responseText);
                }
            });

        })





    // update button event

    $(document).on('click', '.update-btn', function() {
        let formData = $('#customer-form').serialize();
        let id = $(this).val();
        // console.log(id);
        $.ajax({
            url: upurl + '/' + id,
            type: 'PUT',
            data: formData,
            beforeSend: function(request) {
                request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(response) {
                if (response.status === 200) {
                    $('#chartModal').modal('toggle');
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
                    customerTBL.draw();
                    $('#alert-container').html('');
                } else if (response.status === 303) {
                    let alertMessage = `<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>${response.message}</b></div>`;
                    $('#alert-container1').html(alertMessage);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    
});
</script>

<script>
    $('#chartModal').on('hidden.bs.modal', function(e) {

        $('#customer-form')[0].reset();
        $("#pre_adjust").show();
        $('#customer-form textarea').text('');

        $('#chartModal .submit-btn').removeClass('update-btn').addClass('save-btn').text('Save').val("");

    });
</script>

@endsection
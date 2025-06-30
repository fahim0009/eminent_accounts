@extends('admin.layouts.admin')

@section('content')



    <!-- Main content -->
    <section class="content">
      
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-secondary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  @if ($data->client_image)
                    <img class="profile-user-img img-fluid img-circle"
                  src="{{asset('images/client/'.$data->client_image)}}"
                  alt="User profile picture" style="height: 200px; width:auto">
                  @else
                  <img class="profile-user-img img-fluid img-circle" src="{{asset('default.png')}}" alt="User profile picture" style="height: 200px; width:auto">                     
                  @endif
                </div>

                <h3 class="profile-username text-center">{{$data->passport_name}}</h3>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <strong><i class="fas fa-book mr-1"></i> Agent Details</strong>
                <p class="text-muted">
                  {{$data->user->name}} {{$data->user->surname}}<br>
                  {{$data->user->email}} <br>
                  {{$data->user->phone}} <br>
                  
                </p>
                <input type="hidden" id="agent_id" value="{{$data->user_id}}">
                <hr>


                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">{{$data->description}}</p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->



            <!-- Okala assign -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Okala Assign Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              @foreach($assign as $item)   
                <div class="row">
                      <div class="col-sm-12 d-flex align-items-center gap-2">
                          <strong>Assign Date:</strong>
                          @if($item->date)
                              <p class="text-muted mb-0">&nbsp {{ $item->date }}</p> 
                          @else
                              <p class="mb-0">Not assign</p> 
                          @endif  
                      </div>

                      <div class="col-sm-12 d-flex align-items-center gap-2">
                          <strong>VISA ID:</strong>
                          @if($item->visa_id)                        
                              <p class="text-muted mb-0">&nbsp {{ $item->visa_id }}</p> 
                          @else
                              <p class="mb-0">Not assign</p> 
                          @endif  
                      </div>

                      <div class="col-sm-12 d-flex align-items-center gap-2">
                          <strong>Sponsor ID:</strong>                        
                          @if($item->sponsor_id)                        
                              <p class="text-muted mb-0">&nbsp {{ $item->sponsor_id }}</p> 
                          @else
                              <p class="mb-0">Not assign</p>  
                          @endif  
                      </div>

                      <div class="col-sm-12 d-flex align-items-center gap-2">
                          <strong>Vendor:</strong>
                          @if($item->vendor_name)                        
                              <p class="text-muted mb-0">&nbsp {{ $item->vendor_name }} {{ $item->vendor_surname }}</p> 
                          @else
                              <p class="mb-0">Not assign</p>
                          @endif    
                      </div>
                       </div>
                    @endforeach
             

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->



          </div>
          <!-- /.col -->


          



          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Client Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Documents</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Transaction</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <form class="form-horizontal">
                      @csrf
                      <div class="row">
                        <div class="col-sm-12">
                            <label>Client ID</label>
                            <div class="ermsg"></div>
                            <input type="number" class="form-control" id="clientid" name="clientid" value="{{$data->clientid}}" readonly="readonly">
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-sm-6">
                            <label>Name <small>(Passport Name)</small></label>
                            <input type="text" class="form-control" value="{{$data->passport_name}}" id="passport_name" name="passport_name" readonly="readonly">
                            <input type="hidden" name="codeid" id="codeid" value="{{$data->id}}">
                        </div>
                        <div class="col-sm-6">
                            <label>Passport Number</label>
                            <input type="text" id="passport_number" name="passport_number" class="form-control" value="{{$data->passport_number}}" readonly="readonly">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                            <label>Passport Image</label>
                            <input type="file" class="form-control" id="passport_image" name="passport_image">
                        </div>
                        <div class="col-sm-6">
                            <label>Visa Image</label>
                            <input type="file" class="form-control" id="visa_image" name="visa_image" readonly="readonly">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                            <label>Client Image</label>
                            <input type="file" class="form-control" id="client_image" name="client_image">
                        </div>
                        <div class="col-sm-6">
                            <label>Manpower Image</label>
                            <input type="file" class="form-control" id="manpower_image" name="manpower_image">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                            <label>Passport Receive Date</label>
                            <input type="date" class="form-control" id="passport_rcv_date" name="passport_rcv_date" value="{{$data->passport_rcv_date}}" readonly="readonly">
                        </div>
                        <div class="col-sm-6">
                            <label>Flight Date/Delivery Date</label>
                            <input type="date" class="form-control" id="flight_date" name="flight_date" value="{{$data->flight_date}}" readonly="readonly">
                        </div>
    
                        

                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                            <label>Package Cost</label>
                            <input type="number" class="form-control" id="package_cost" name="package_cost"  value="{{$data->package_cost}}" readonly="readonly">
                        </div>

                        <div class="col-sm-6">
                          <label>Visa Expired  Date</label>
                          <input type="date" class="form-control" id="visa_exp_date" name="visa_exp_date" value="{{$data->visa_exp_date}}" readonly="readonly">
                        </div>
                        
                        
                      </div>


                      <div class="row">
                        <div class="col-sm-6">
                            <label>Country</label>
                            <select class="form-control" id="country" name="country" disabled>
                              <option value="">Select</option>
                              @foreach ($countries as $country)
                                <option value="{{$country->id}}"@if ($country->id == $data->country_id) selected @endif >{{$country->type_name}}</option>
                              @endforeach
                            </select>
                        </div>

                        
                        <div class="col-sm-6">
                            <label>Agents</label>
                            <select name="user_id" id="user_id" class="form-control" disabled>
                              <option value="">Select</option>
                              @foreach ($agents as $item)
                              <option value="{{$item->id}}" @if ($item->id == $data->user_id) selected @endif>{{$item->name}} {{$item->surname}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                            <label>Description</label>
                            <textarea name="description" id="description" cols="30" rows="2" class="form-control" readonly="readonly">{{$data->description}}</textarea>
                        </div>
                      </div>

                      <div class="form-group row mt-3">
                        <div class="col-sm-10">
                          <button type="button" id="updatebtn" class="btn btn-secondary updateBtn">Update</button>
                          <button id="editBtn" class="btn btn-secondary editBtn">Edit</button>
                        </div>
                      </div>

                    </form>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    
                    <!-- Post -->
                    <div class="post">
                      <!-- /.user-block -->
                      
                      <div class="user-block">
                        <span class="username">
                          <h3>Client Image</h3>
                        </span>
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">
                          @if ($data->client_image)
                            <img class="img-fluid" src="{{asset('images/client/'.$data->client_image)}}" alt="Photo">
                          @else
                              
                            <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg')}}" class="img-fluid" alt="User Image">
                          @endif
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <a href="{{ route('client_image.download',$data->id)}}" class="btn btn-secondary">Download</a>
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <!-- /.user-block -->
                      
                      <div class="user-block">
                        <span class="username">
                          <h3>Passport Image</h3>
                        </span>
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">
                          @if ($data->passport_image)
                            <img class="img-fluid" src="{{asset('images/client/passport/'.$data->passport_image)}}" alt="Photo">
                          @else
                              
                            <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg')}}" class="img-fluid" alt="User Image">
                          @endif
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <a href="{{ route('passport_image.download',$data->id)}}" class="btn btn-secondary">Download</a>
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <!-- /.user-block -->
                      
                      <div class="user-block">
                        <span class="username">
                          <h3>Visa Image</h3>
                        </span>
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">

                          @if ($data->visa)
                          @php
                              $foo = \File::extension($data->visa);
                          @endphp
                              
                          @if ($foo == "pdf")
                            <div class="row justify-content-center">
                              <iframe src="{{asset('images/client/visa/'.$data->visa)}}" width="100%" height="600">
                                <a href="{{asset('images/client/visa/'.$data->visa)}}">Download PDF</a>
                              </iframe>
                            </div>
                          @else
                              <img class="img-fluid" src="{{asset('images/client/visa/'.$data->visa)}}" alt="Photo">
                          @endif

                          
                        
                          @else
                            <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg')}}" class="img-fluid" alt="User Image">
                          @endif
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <a href="{{ route('visa_image.download',$data->id)}}" class="btn btn-secondary">Download</a>
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <!-- /.user-block -->
                      
                      <div class="user-block">
                        <span class="username">
                          <h3>Manpower Image</h3>
                        </span>
                      </div>

                      <div class="row mb-3">
                        <div class="col-sm-6">

                          @if ($data->manpower_image)

                          @php
                              $chkmp = \File::extension($data->manpower_image);
                          @endphp

                          @if ($chkmp == "pdf")
                            <div class="row justify-content-center">
                              <iframe src="{{asset('images/client/manpower/'.$data->manpower_image)}}" width="100%" height="600">
                                <a href="{{asset('images/client/manpower/'.$data->manpower_image)}}">Download PDF</a>
                              </iframe>
                            </div>
                          @else
                              <img class="img-fluid" src="{{asset('images/client/manpower/'.$data->manpower_image)}}" alt="Photo">
                          @endif

                          @else
                          <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg')}}" class="img-fluid" alt="User Image">
                          @endif
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-12">
                              <a href="{{ route('manpower_image.download',$data->id)}}" class="btn btn-secondary">Download</a>
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                    </div>
                    <!-- /.post -->

                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                <!-- Image loader -->
                <div id='loading' style='display:none ;'>
                    <img src="{{ asset('assets/common/loader.gif') }}" id="loading-image" alt="Loading..." />
                </div>
                <!-- Image loader -->
                    <div class="row">
                          <h3>Money Received</h3>
                    </div>
                    <div class="tranermsg"></div>

                    <form class="form-horizontal">

                      <div class="row">
                      <div class="col-sm-4">
                            <label>Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                            <input type="hidden" class="form-control" id="tran_id" name="tran_id">
                            <input type="hidden" class="form-control" id="client_name" name="client_name" value="{{$data->passport_name}}">
                            <input type="hidden" class="form-control" id="client_passport" name="client_passport" value="{{$data->passport_number}}">
                        </div>
                        <div class="col-sm-4">
                              <label>Transaction Type</label>
                              <select class="form-control" id="tran_type" name="tran_type">
                                <option value="">Select</option>               
                                  <option value="package_received">Package Received</option>
                                  <option value="package_adon">Package Ad-On</option>
                                  <option value="package_discount">Package Discount</option>
                              </select>
                          </div>
                      </div>

                      <div class="row">
                      <div class="col-sm-4">
                            <label>Transaction method</label>
                            <select class="form-control" id="account_id" name="account_id">
                              <option value="">Select</option>
                              @foreach ($accounts as $method)
                                <option value="{{$method->id}}">{{$method->name}}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label>Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-8">
                            <label>Note</label>
                            <input type="text" class="form-control" id="note" name="note">
                        </div>
                      </div>
                      
                      
                      <div class="form-group row rcptBtn">
                        <div class="col-sm-12 mt-2">
                          <button type="button" id="rcptBtn" class="btn btn-success">Save</button>
                        </div>
                      </div>
                      <div class="form-group row rcptUpBtn" style="display: none">
                        <div class="col-sm-12 mt-2">
                          <button type="button" id="rcptUpBtn" class="btn btn-success">Update</button>
                          <button type="button" id="rcptCloseBtn" class="btn btn-warning">Close</button>
                        </div>
                      </div>
                    </form>

                    <div class="row">
                          <h3>Receive History</h3>
                    </div>

                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-12">
                          <!-- /.card -->
                
                          <div class="card">
                            <div class="card-header">
                              <h3 class="card-title">All Data</h3>
                            </div>
                            <!-- /.card-header -->

                  <!--get total balance -->
                  <?php
                    $tbalance = 0;
                    ?> 
                    @forelse ($trans as $sdata)
                            
                    @if((($sdata->tran_type == 'package_sales') || ($sdata->tran_type == 'package_adon')) && ($sdata->status == 1))
                    <?php $tbalance = $tbalance + $sdata->bdt_amount;?>
                    @elseif((($sdata->tran_type == 'package_received') || ($sdata->tran_type == 'package_discount')) && ($sdata->status == 1))
                    <?php $tbalance = $tbalance - $sdata->bdt_amount;?>
                    @endif
     
                    @empty
                    @endforelse

                            <div class="card-body" id="rcvContainer">
                              <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>Sl</th>
                                  <th>Date</th>
                                  <th>Transaction Method</th>
                                  <th>Dr.</th>
                                  <th>Cr.</th>
                                  <th>Balance</th>
                                  <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($trans as $key => $tran)
                                  <tr>
                                    <td style="text-align: center">{{ $key + 1 }}</td>
                                    <td style="text-align: center">{{$tran->date}}</td>
                                    <td style="text-align: center">@if(isset($tran->account_id)){{$tran->account->short_name}}@else {{$tran->ref}} @endif @if(isset($tran->note))({{$tran->note}})@endif</td>
                                    <!-- <td style="text-align: center">{{$tran->bdt_amount}}</td> -->

                                    @if(($tran->tran_type == 'package_received') || ($tran->tran_type == 'package_discount'))

                                    <td style="text-align: center">{{$tran->bdt_amount}}</td>
                                    <td style="text-align: center"></td>
                                    <td style="text-align: center">{{$tbalance}}</td>
                                    <?php $tbalance = $tbalance + $tran->bdt_amount;?>

                                    @elseif(($tran->tran_type == 'package_sales') || ($tran->tran_type == 'package_adon'))

                                    <td style="text-align: center"></td>
                                    <td style="text-align: center">{{$tran->bdt_amount}}</td>
                                    <td style="text-align: center">{{$tbalance}}</td>
                                    <?php $tbalance = $tbalance - $tran->bdt_amount;?>

                                    @endif

                                    <td style="text-align: center">
                                      <a id="tranEditBtn" rid="{{$tran->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
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

                  </div>
                  
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Status</h3>
              </div>
              <div class="card-body">
                
              <div class="row">
                  <!-- decline charge  -->
              <div class="col-sm-4">            
              <div class="form-group mt-3 decline-charge-wrapper d-none" id="declineChargeRow{{$data->id}}">
                        <label for="declineChargeInput{{$data->id}}"><strong>Decline Charge</strong></label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="declineChargeInput{{$data->id}}" placeholder="Enter decline charge">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger submitDeclineBtn" data-id="{{$data->id}}">Submit</button>
                            </div>
                        </div>
                    </div>
              </div>
              <!-- end decline charge  -->

              
                  <!-- ################# client statu ############## -->

                  <div class="col-sm-4">                    
                    <label>Status</label>
                    <div  class="input-group">                    

                        @if ($data->status == 0)
                        <button type="button" class="btn btn-secondary"><span id="stsval{{$data->id}}"> @if ($data->status == 0) New
                        @elseif($data->status == 1) Processing @elseif($data->status == 2) Complete @else Decline @endif</span>
                        </button>
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                        <button class="dropdown-item stsBtn" data-id="{{$data->id}}" data-status="{{$data->status}}" value="1">Processing</button>
                        <button class="dropdown-item stsBtn" data-id="{{$data->id}}" data-status="{{$data->status}}" value="3">Decline</button>
                        @elseif($data->status == 1)
                        <button type="button" class="btn btn-secondary"><span id="stsval{{$data->id}}"> @if ($data->status == 0) New
                        @elseif($data->status == 1) Processing @elseif($data->status == 2) Complete @else Decline @endif</span>
                        </button>
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                        <button class="dropdown-item stsBtn" data-id="{{$data->id}}" data-status="{{$data->status}}"  value="2">Complete</button>
                        <button class="dropdown-item stsBtn" data-id="{{$data->id}}" data-status="{{$data->status}}"  value="3">Decline</button>
                        @elseif($data->status == 2)
                        <p class="btn btn-success" >Complete</p>
                        @elseif($data->status == 3)
                        <p class="btn btn-danger" >Decline</p>
                        @elseif($data->status == 4)
                        <p class="btn btn-danger" >Visa Decline</p>                        
                        @endif
                        </div>                          
                    </div>
                    
                  </div>
                </div>
            <!-- ################# END client statu ############## -->

                    <br> <br>

        <!-- Toggle Button -->
        <button type="button" class="btn btn-outline-primary mb-2 toggle-mofa-form" data-id="{{ $data->id }}">
            <i class="fas fa-plus-circle"></i> New MOFA
        </button>


        <!-- *************** New MOFA Section *************** -->
        <div class="row mofa-form-row" id="mofaFormRow{{ $data->id }}" style="display: none;">

                <!-- Date Input -->
                <div class="col-sm-2">
                    <label>Date</label>
                    <div class="input-group">
                        <span class="input-group-text">Date</span>
                        <input type="date" id="mofa_date{{ $data->id }}" name="date" class="form-control" value="{{ old('date') }}">
                    </div>
                    <p><small class="mofa_date_msg" id="mofa_date_msg{{ $data->id }}"></small></p>
                </div>

                <!-- MOFA Trade Dropdown -->
                <div class="col-sm-3">
                    <label>MOFA</label>
                    <div class="input-group">
                        <select name="mofa_trade" id="mofa_trade{{ $data->id }}" class="form-control mofa_trade">
                            <option value="">Please Select</option>
                            @foreach (\App\Models\CodeMaster::where('type', 'TRADE')->select('id', 'type_name')->get() as $mofa)
                                <option value="{{ $mofa->id }}">{{ $mofa->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p><small class="mofa_trade_msg" id="mofa_trade_msg{{ $data->id }}"></small></p>
                </div>

                <!-- RL Dropdown -->
                <div class="col-sm-3">
                    <label>RL</label>
                    <div class="input-group">
                        <select name="rldetail" id="rldetail{{ $data->id }}" class="form-control rldetail">
                            <option value="">Please Select</option>
                            @foreach (\App\Models\CodeMaster::where('type', 'RL')->select('id', 'type_name')->get() as $rl)
                                <option value="{{ $rl->id }}">{{ $rl->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p><small class="rldetail_msg" id="rldetail_msg{{ $data->id }}"></small></p>
                </div>


                <div class="col-sm-2 d-flex align-items-start" style="margin-top: 2rem;">

                    <button class="btn btn-primary save-mofa-all-btn w-100" data-userid="{{ $data->user_id }}" data-id="{{ $data->id }}">
                        <i class="fas fa-save"></i> Save All
                    </button>
                </div>




                </div>


            <!-- Previous all mofa details  -->
            @foreach ($data->mofaHistories as $history)
            <div class="row">

               <div class="col-sm-2">
                    <label>Date</label>
                    @if ($history->date) 
                     <p>{{$history->date}}</p> 
                      @else                        
                    <p> Null </p>                    
                    @endif
                </div>



                  <div class="col-sm-3">
                    <label>Mofa</label>
                    @if ($history->mofaTrade->type_name) 
                     <p>{{$history->mofaTrade->type_name}}</p> 
                      @else
                      <p> Null </p>                    
                    @endif
                </div>


                  <div class="col-sm-3">
                    <label>RL</label>
                    @if ($history->rlidCode->type_name)
                      <p>{{$history->rlidCode->type_name}}</p>
                      @else                        
                      <p> Null </p>
                    @endif
                  </div>  
                  
                  
                  </div>
                @endforeach

          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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


    $(function() {
      $('.stsBtn').click(function() {
        var url = "{{URL::to('/admin/change-client-status')}}";
          var id = $(this).data('id');
          var status = $(this).attr('value');
          var past_status = $(this).attr('data-status');

          // alert(status+past_status);
          
          // return;

            if ((status == '3') && (past_status == '1')) {

              $('#declineChargeRow' + id).removeClass('d-none');


            } else {
              // if not decline complete will start 
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
          // status complete end hare
            }
      })
    });

    // decline charge start 
    $(document).on('click', '.submitDeclineBtn', function() {
    var id = $(this).data('id');
    var amount = $('#declineChargeInput' + id).val();
    var url = "{{ URL::to('/admin/change-client-status') }}";
// alert(id);return;
    if (amount == '') {
      alert('Please enter a decline charge amount');
      return;
    }

    $.ajax({
      type: "GET",
      url: url,
      data: {
        _token: "{{ csrf_token() }}",
        id: id,
        status: 4,
        decline_charge: amount
      },
      success: function(d) {
        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });

        if (d.status == 300) {
          $('#stsval' + id).html(d.stsval);
          $('#declineChargeRow' + id).remove(); // remove input row after success
          Toast.fire({
            icon: 'success',
            title: d.message
          });
        } else {
          Toast.fire({
            icon: 'warning',
            title: d.message
          });
        }
      },
      error: function(d) {
        console.log("Error:", d);
      }
    });
  });


  </script>

<script>


      $(document).on('click', '.toggle-mofa-form', function () {
          var id = $(this).data('id');
          $('#mofaFormRow' + id).slideToggle(); // smooth toggle effect
      });

      $('.save-mofa-all-btn').click(function (e) {
          e.preventDefault();

          var $btn = $(this);
          $btn.prop('disabled', true); // Disable button
          
          var client_id = $(this).data('id');
          var agent_id = $(this).data('userid');
          var mofa_date = $('#mofa_date' + client_id).val();
          var mofa_trade = $('#mofa_trade' + client_id).val();
          var rldetail = $('#rldetail' + client_id).val();
          // Clear previous error messages
          $('#mofa_date_msg' + client_id).html('');
          $('#mofa_trade_msg' + client_id).html('');
          $('#rldetail_msg' + client_id).html('');


          
    if (!mofa_date || !mofa_trade || !rldetail) {
        if (!mofa_date) $('#mofa_date_msg' + client_id).html('<span class="text-danger">Please select a date</span>');
        if (!mofa_trade) $('#mofa_trade_msg' + client_id).html('<span class="text-danger">Please select a trade</span>');
        if (!rldetail) $('#rldetail_msg' + client_id).html('<span class="text-danger">Please select an RL</span>');
        $btn.prop('disabled', false); // Re-enable button on validation fail
        return;
    }

          $.ajax({
              url: "{{ url('/admin/change-client-mofa-rl') }}",
              type: "GET",
              dataType: "json",
              data: {
                client_id: client_id,
                agent_id: agent_id,
                  date: mofa_date,
                  mofa_trade: mofa_trade,
                  rlid: rldetail
              },
              success: function (data) {
                  if (data.status == 303) {
                      $('#mofa_trade_msg' + client_id).html(data.message);
                      Swal.fire({ icon: 'warning', toast: true, position: 'top-end', timer: 3000, title: data.message });
                  } else if (data.status == 300) {
                      Swal.fire({ icon: 'success', toast: true, position: 'top-end', timer: 3000, title: data.message });
                              // Clear the form fields
                    $('#mofa_date' + client_id).val('');
                    $('#mofa_trade' + client_id).val('');
                    $('#rldetail' + client_id).val('');



                  }
              },
              error: function (xhr, status, error) {
                  console.error(error);
                  Swal.fire({ icon: 'error', toast: true, position: 'top-end', timer: 3000, title: 'Something went wrong' });
              }
          });
      });

</script>

<script>
  $(document).ready(function () {
    
      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      var url = "{{URL::to('/admin/client-update')}}";
      // console.log(url);
      $("#updatebtn").click(function(){

          var passport_image = $('#passport_image').prop('files')[0];
          if(typeof passport_image === 'undefined'){
              passport_image = 'null';
          }
          var client_image = $('#client_image').prop('files')[0];
          if(typeof client_image === 'undefined'){
            client_image = 'null';
          }

          var visa_image = $('#visa_image').prop('files')[0];
          if(typeof visa_image === 'undefined'){
            visa_image = '';
          }
          var manpower_image = $('#manpower_image').prop('files')[0];
          if(typeof manpower_image === 'undefined'){
            manpower_image = '';
          }

          var form_data = new FormData();
          form_data.append('passport_image', passport_image);
          form_data.append('client_image', client_image);
          form_data.append('manpower_image', manpower_image);
          form_data.append('visa_image', visa_image);
          form_data.append("clientid", $("#clientid").val());
          form_data.append("passport_number", $("#passport_number").val());
          form_data.append("passport_name", $("#passport_name").val());
          form_data.append("passport_rcv_date", $("#passport_rcv_date").val());
          form_data.append("country", $("#country").val());
          form_data.append("user_id", $("#user_id").val());
          form_data.append("package_cost", $("#package_cost").val());
          form_data.append("description", $("#description").val());
          form_data.append("flight_date", $("#flight_date").val());
          form_data.append("visa_exp_date", $("#visa_exp_date").val());
          form_data.append("codeid", $("#codeid").val());



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
                        title: 'Data updated successfully.'
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


      var purl = "{{URL::to('/admin/client-partner-update')}}";
      // console.log(url);
      $("#partnerUpdate").click(function(){

          var form_data = new FormData();
          form_data.append("business_partner_id", $("#business_partner_id").val());
          form_data.append("b2b_contact", $("#b2b_contact").val());
          form_data.append("codeid", $("#codeid").val());

          $.ajax({
            url: purl,
            method: "POST",
            contentType: false,
            processData: false,
            data:form_data,
            success: function (d) {
                if (d.status == 303) {
                    $(".partnerermsg").html(d.message);
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
            error: function (d) {
                console.log(d);
            }
        });
        //update  end
      });


      var tranurl = "{{URL::to('/admin/money-receipt')}}";
      var tranupurl = "{{URL::to('/admin/money-receipt-update')}}";
      // console.log(url);
      $("#rcptBtn").click(function(){    

        $("#rcptBtn").prop('disabled', true);

          $("#loading").show();

          var tran_type = $("#tran_type").val();
          var ref;
          if(tran_type == "package_discount"){
            var ref = "Discount";
          }else if(tran_type == "package_adon"){
            var ref = "Extra Charge";
          }else if(tran_type == "package_received"){
            var ref = "Package Received";
          }

          var form_data = new FormData();
          form_data.append("account_id", $("#account_id").val());
          form_data.append("user_id", $("#agent_id").val());
          form_data.append("date", $("#date").val());
          form_data.append("amount", $("#amount").val());
          form_data.append("note", $("#note").val());
          form_data.append("client_id", $("#codeid").val());
          form_data.append("tran_type", $("#tran_type").val());
          form_data.append("ref", ref+" For ("+$("#client_name").val()+"-"+$("#client_passport").val()+")");


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
                  window.setTimeout(function(){location.reload()},2000);

                }
            },
            complete:function(d){
                        $("#loading").hide();
                    },
            error: function (d) {
                console.log(d);
            }
        });
        //update  end
      });

      
      //Edit
      $("#rcvContainer").on('click','#tranEditBtn', function(){
          //alert("btn work");
          codeid = $(this).attr('rid');
          //console.log($codeid);
          info_url = tranurl + '/'+codeid+'/edit';
          //console.log($info_url);
          $.get(info_url,{},function(d){
              populateForm(d);
              pagetop();
          });
      });

      function populateForm(data){
        console.log({data})
          $("#account_id").val(data.account_id);
          $("#date").val(data.date);
          $("#amount").val(data.bdt_amount);
          $("#note").val(data.note);
          $("#tran_id").val(data.id);
          $(".rcptUpBtn").show(300);
          $(".rcptBtn").hide(100);
      }

      $("#rcptUpBtn").click(function(){

          var form_data = new FormData();
          form_data.append("account_id", $("#account_id").val());
          form_data.append("user_id", $("#agent_id").val());
          form_data.append("date", $("#date").val());
          form_data.append("amount", $("#amount").val());
          form_data.append("note", $("#note").val());
          form_data.append("client_id", $("#codeid").val());
          form_data.append("tran_id", $("#tran_id").val());

          $.ajax({
            url: tranupurl,
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
                        title: 'Data Updated Successfully.'
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

      $("#rcptCloseBtn").click(function(){
      
        $("#account_id").val('');
        $("#date").val('');
        $("#amount").val('');
        $("#note").val('');
        $("#tran_id").val('');
        $(".rcptUpBtn").hide(300);
        $(".rcptBtn").show(100);
      });
      //Edit  end

     
      //Edit
      $("#paymentContainer").on('click','#pmtEditBtn', function(){
          //alert("btn work");
          codeid = $(this).attr('rid');
          //console.log($codeid);
          info_url = tranurl + '/'+codeid+'/edit';
          //console.log($info_url);
          $.get(info_url,{},function(d){
              populateForm(d);
              pagetop();
          });
      });

      function populateForm(data){
          $("#account_id").val(data.account_id);
          $("#date").val(data.date);
          $("#amount").val(data.bdt_amount);
          $("#note").val(data.note);
          $("#tran_id").val(data.id);
          $("#tran_type").val(data.tran_type);
          $(".rcptUpBtn").show(300);
          $(".rcptBtn").hide(100);
      }

      $("#rcptUpBtn").click(function(){

          var form_data = new FormData();
          form_data.append("account_id", $("#account_id").val());
          form_data.append("user_id", $("#agent_id").val());
          form_data.append("date", $("#date").val());
          form_data.append("amount", $("#amount").val());
          form_data.append("note", $("#note").val());
          form_data.append("client_id", $("#codeid").val());
          form_data.append("tran_id", $("#tran_id").val());

          $.ajax({
            url: tranupurl,
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
                        title: 'Data Updated Successfully.'
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

      $("#rcptCloseBtn").click(function(){
      
        $("#account_id").val('');
        $("#date").val('');
        $("#amount").val('');
        $("#note").val('');
        $("#tran_id").val('');
        $(".rcptUpBtn").hide(300);
        $(".rcptBtn").show(100);
      });
      //Edit  end


      $(".updateBtn").hide();
        $("body").delegate(".editBtn","click",function(event){
            event.preventDefault();
            $("#clientid").attr("readonly", false);
            $("#passport_name").attr("readonly", false);
            $("#passport_number").attr("readonly", false);
            $("#visa_image").attr("readonly", false);
            $("#passport_rcv_date").attr("readonly", false);
            $("#description").attr("readonly", false);
            $("#user_id").attr("disabled", false);
            $("#country").attr("disabled", false);
            $("#visa_exp_date").attr("readonly", false);
            $("#package_cost").attr("readonly", false);
            $("#flight_date").attr("readonly", false);
            $("#editBtn").hide();
            $(".updateBtn").show();
        });
      
  });
</script>
@endsection
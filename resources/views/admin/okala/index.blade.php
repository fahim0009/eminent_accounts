@extends('admin.layouts.admin')

@section('content')
<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<!-- Main content -->
<section class="content pt-5" id="newBtnSection">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2">
            <a href="{{route('admin.okalapurchase')}}" class="btn btn-secondary my-3">Back</a>
        </div>
      </div>
    </div>
</section>
  <!-- /.content -->



    <!-- Main content -->
    <section class="content " id="addThisFormContainer">
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

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>RL </label>
                        <select name="r_l_detail_id" id="r_l_detail_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\CodeMaster::where('type', 'RL')->where('status', 1)->get() as $rl)

                          <option value="{{$rl->id}}">{{$rl->name}}</option>
                              
                          @endforeach
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Trade</label>
                        <select name="trade" id="trade" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\CodeMaster::where('type', 'TRADE')->where('status', 1)->get() as $trade)

                          <option value="{{$trade->id}}">{{$trade->name}}</option>
                              
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\User::orderby('id', 'DESC')->where('status', 1)->get() as $user)

                          <option value="{{$user->id}}">{{$user->name}}</option>
                              
                          @endforeach
                        </select>
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
                  <!-- <h3 class="card-title">All Data</h3> -->
                  <form method="GET" action="#">
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
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Sl</th>
                      <th>Date</th>
                      <th>Visa Id</th>
                      <th>Sponsor Id</th>
                      <th>Trade</th>
                      <th>Assign To</th>
                      <th>RL Id</th>
                      {{-- <th>Purchase Type</th> --}}
                      <th>Vendor</th>
                      <!-- <th>Action</th> -->
                    </tr>
                    </thead>
                    <tbody>
                  @foreach ($data as $row)
    <tr>
      <td style="text-align:center"></td> {{-- SL filled by DataTables --}}
      <td style="text-align:center" data-order="{{ \Carbon\Carbon::parse($row->date)->timestamp }}">
        {{ \Carbon\Carbon::parse($row->date)->format('Y-m-d') }}
      </td>
      <td style="text-align:center">{{ $row->visa_id }}</td>
      <td style="text-align:center">{{ $row->sponsor_id }}</td>
      <td style="text-align:center">{{ $row->trade_name ?? '' }}</td>

      {{-- Assign To (single visible control; remove the hidden duplicate TD) --}}
      <td style="text-align:center">
        <div class="input-group">
          <select class="form-control assignto" id="assignto{{ $row->id }}">
            <option value="">Please Select</option>
            @foreach ($clients as $c)
              <option value="{{ $c->id }}">{{ $c->passport_name }} ({{ $c->passport_number }})</option>
            @endforeach
          </select>
          <div class="input-group-append">
            <button class="btn btn-secondary assignto_btn" data-id="{{ $row->id }}">
              <i class="fas fa-save"></i>
            </button>
          </div>
        </div>
        <p><small class="message" id="message{{ $row->id }}"></small></p>
      </td>

      <td style="text-align:center">{{ $row->rl_name ?? '' }}</td>
      <td style="text-align:center">{{ $row->vendor_name ?? '' }}</td>
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
  </script>
<script>
  $(document).ready(function() {
 
      $('.assignto_btn').click(function () {
        
        var okalaId = $(this).data('id');
        var clientId = $('#assignto'+okalaId).val();
        if (clientId == '') {
            $('#message'+okalaId).html('<span class="text-danger">Please select first</span>');
            return false;
        }
        console.log(okalaId, clientId);
        var okalaurl = "{{URL::to('/admin/client-add-okala')}}";
        $.ajax({
            type: "POST",
            dataType: "json",
            url: okalaurl,
            data: {
              clientId: clientId,
              okalaId: okalaId,
            },
            success: function (data) {

                if (data.status == 303) {

                  $('#message'+clientId).html(data.message);

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
                }
            },
            error: function (data) {
                console.log(data);
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
              form_data.append("agent_id", $("#agent_id").val());
              form_data.append("vendor_id", $("#vendor_id").val());
              form_data.append("r_l_detail_id", $("#r_l_detail_id").val());
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
              form_data.append("vendor_id", $("#vendor_id").val());
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
          $("#vendor_id").val(data.vendor_id);
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
  });
</script>
@endsection
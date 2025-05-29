@extends('admin.layouts.admin')

@section('content')
<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
   
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
              <!-- <li class="nav-item">
                <a class="nav-link " id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="true">Tab 2</a>
              </li> -->
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
                        <th>Availeable</th>
                        <th>Visa Number</th>
                        <th>Sponsor ID</th>
                        <th>RL</th>
                        <th>Vendor</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $key => $entry)

                        
                        @if (($entry->number - $entry->assigned_count) > 0)

                        <tr>
                          <td style="text-align: center">{{ $key + 1 }}</td>

                          <td style="text-align: center" data-order="{{ \Carbon\Carbon::parse($entry->date)->timestamp }}">
                          {{ \Carbon\Carbon::parse($entry->date)->format('d-m-Y') }}
                          </td>
                          <td style="text-align: center">{{$entry->number}}</td>
                          <td style="text-align: center">{{$entry->number - $entry->assigned_count}}</td>
                          <td style="text-align: center"><a href="{{route('admin.okalapurchaseDetails', $entry->id)}}">{{$entry->visaid}}</a></td>
                          <td style="text-align: center">{{$entry->sponsorid}}</td>
                          <td style="text-align: center">{{$entry->type_name}}</td>
                          <td style="text-align: center">{{$entry->vendor_name}}</td>

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
                        <th>Availeable</th>
                        <th>Visa Number</th>
                        <th>Sponsor ID</th>
                        <th>RL</th>
                        <th>Vendor</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach ($complete as $key => $cdata)

                                            
                    @if (($cdata->number - $cdata->assigned_count) == 0)

                    <tr>
                      <td style="text-align: center">{{ $key + 1 }}</td>
                      <td style="text-align: center" data-order="{{ \Carbon\Carbon::parse($cdata->date)->timestamp }}">
                          {{ \Carbon\Carbon::parse($cdata->date)->format('d-m-Y') }}
                      </td>
                      <td style="text-align: center">{{$cdata->number}}</td>
                      <td style="text-align: center">{{$cdata->number - $cdata->assigned_count}}</td>
                      <td style="text-align: center"><a href="{{route('admin.okalapurchaseDetails', $cdata->id)}}">{{$cdata->visaid}}</a></td>
                      <td style="text-align: center">{{$cdata->sponsorid}}</td>
                      <td style="text-align: center">{{$cdata->type_name}}</td>
                      <td style="text-align: center">{{$cdata->vendor_name}}</td>                     
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
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      
    </div>
  </div>
</section>
<!-- /.content -->

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
$(function () {
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "ordering": true,
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  $('#example2').DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "ordering": true,
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

  // Fix: Recalculate DataTables when switching tabs
  $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust()
      .responsive.recalc();
  });
});
</script>


<script>

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
@endsection
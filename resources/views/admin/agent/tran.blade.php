@extends('admin.layouts.admin')

@section('content')

<!-- Main content -->
<section class="content" id="newBtnSection">
  <div class="container-fluid">
    <div class="row">
      <div class="col-2">
          <a href="{{route('admin.agent')}}" class="btn btn-secondary my-3">Back</a>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->

<!-- Main content -->
<section class="content mt-4" id="contentContainer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Data</h3>
            </div>

            <!--get total balance -->
                    <?php
                    $tbalance = 0;
                    ?> 
                    @forelse ($data as $sdata)
                            
                    @if(($sdata->tran_type == 'package_sales') || ($sdata->tran_type == 'service_sales') || ($sdata->tran_type == 'okala_sales'))
                    <?php $tbalance = $tbalance + $sdata->bdt_amount;?>
                    @elseif(($sdata->tran_type == 'package_received') || ($sdata->tran_type == 'service_received') || ($sdata->tran_type == 'okala_received'))
                    <?php $tbalance = $tbalance - $sdata->bdt_amount;?>
                    @endif
     
                    @empty
                    @endforelse

            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
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
                  @foreach ($data as $key => $tran)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$tran->date}}</td>
                    <td style="text-align: center">{{$tran->ref}}  @if(isset($tran->note)){{$tran->note}}@endif</td>

                    @if(($tran->tran_type == 'package_received') || ($tran->tran_type == 'service_received') || ($tran->tran_type == 'okala_received'))

                    <td style="text-align: center">{{$tran->bdt_amount}}</td>
                    <td style="text-align: center"></td>
                    <td style="text-align: center">{{$tbalance}}</td>
                    <?php $tbalance = $tbalance + $tran->bdt_amount;?>

                    @elseif(($tran->tran_type == 'package_sales') || ($tran->tran_type == 'service_sales') || ($tran->tran_type == 'okala_sales'))

                    <td style="text-align: center"></td>
                    <td style="text-align: center">{{$tran->bdt_amount}}</td>
                    <td style="text-align: center">{{$tbalance}}</td>
                    <?php $tbalance = $tbalance - $tran->bdt_amount;?>

                    @endif

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
  </script>


@endsection
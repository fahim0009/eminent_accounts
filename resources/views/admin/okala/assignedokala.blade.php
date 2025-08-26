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
<section class="content" id="contentContainer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
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
                  <th>Agent Name</th>
                  <th>RL Id</th>
                  <th>Vendor</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                   <tr>
                    <td style="text-align: center"></td>
                    <td style="text-align: center">{{$data->date}}</td>
                    <td style="text-align: center">{{$data->visa_id}}</td>
                    <td style="text-align: center">{{$data->sponsor_id}}</td>
                    <td style="text-align: center">
                      @if (isset($data->mofa))
                      {{$data->mofa}}
                      @endif
                    </td>
  
                    <td style="text-align: center">
                      {{$data->passport_name}} ({{$data->passport_number}})                    

                    </td>
                    <td style="text-align: center">{{$data->agent_name}} {{$data->agent_surname}}</td>
                    <td style="text-align: center">
                    @if (isset($data->rl))
                      {{$data->rl}}
                      @endif
                    </td>

                    <td style="text-align: center">{{$name= \App\Models\User::where('id', $data->user_id)->first()?->name }}
                     </td>
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
@endsection
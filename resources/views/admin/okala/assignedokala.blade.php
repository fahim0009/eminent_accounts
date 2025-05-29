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
                  <th>RL Id</th>
                  <th>Vendor</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                   <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
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
  $('#example1').DataTable();
});
 </script>
@endsection
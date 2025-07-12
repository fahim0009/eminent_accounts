@extends('admin.layouts.admin')

@section('content')
<section class="content" id="contentContainer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card card-secondary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="active-tab" data-toggle="pill" href="#active" role="tab">Active</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="inactive-tab" data-toggle="pill" href="#inactive" role="tab">Inactive</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-tabContent">

                            <!-- Active Tab -->
                            <div class="tab-pane fade show active" id="active" role="tabpanel">
                                <table id="activeTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>RL Name</th>
                                            <th>RL Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activeData as $key => $data)
                                        <tr data-id="{{ $data->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td><a href="{{route('admin.rldetails', $data->id)}}"><b>{{ $data->type_name }}</b></a></td>
                                            <td>{{ $data->type_description }}</td>
                                            <td>
                                          <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input toggle-status" id="customSwitchStatus{{ $data->id }}" data-id="{{ $data->id }}" {{ $data->status == 1 ? 'checked' : '' }}>
                                              <label class="custom-control-label" for="customSwitchStatus{{ $data->id }}"></label>
                                          </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Inactive Tab -->
                            <div class="tab-pane fade" id="inactive" role="tabpanel">
                                <table id="inactiveTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>RL Name</th>
                                            <th>RL Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inactiveData as $key => $data)
                                        <tr data-id="{{ $data->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td><a href="{{route('admin.rldetails', $data->id)}}"><b>{{ $data->type_name }}</b></a></td>
                                            <td>{{ $data->type_description }}</td>
                                            <td>
                                          <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input toggle-status" id="customSwitchStatus{{ $data->id }}" data-id="{{ $data->id }}" {{ $data->status == 1 ? 'checked' : '' }}>
                                              <label class="custom-control-label" for="customSwitchStatus{{ $data->id }}"></label>
                                          </div>
                                            </td>
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
</section>
@endsection

@section('script')
<script>
var stsurl = "{{URL::to('/admin/toggle-status-ajax')}}";

       // active-deactive users
      $(document).on('change', '.toggle-status', function() {
            var code_id = $(this).data('id');
            var status = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: stsurl,
                method: 'POST',
                data: {
                    id: code_id,
                    status: status,
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
                            title: response.message
                          });
                        });
                      window.setTimeout(function(){location.reload()},2000)

                },
                error: function(xhr, status, error) {
                    showError('An error occurred. Please try again.');
                }
            });
      });
</script>
@endsection

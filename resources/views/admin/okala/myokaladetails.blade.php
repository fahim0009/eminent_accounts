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
              <!-- /.card -->

              <div class="card">

              <div class="card-header">
                  <h1 class="card-title">All Availeable Okala</h1>
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
                      <td style="text-align:center"></td>
                      <td style="text-align:center">{{ $row->date }}</td>
                      <td style="text-align:center">{{ $row->visa_id }}</td>
                      <td style="text-align:center">{{ $row->sponsorid }}</td>
                      <td style="text-align:center">{{ $row->trade_name ?? '' }}</td>

                      {{-- Assign To --}}
                      <td style="text-align:center">
                        @if ($row->assign_to) 
                          {{-- already assigned --}}
                          {{ $row->passport_name }} ({{ $row->passport_number }})
                        @else
                        {{-- Not assigned: show dropdown + save button --}}
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
                        @endif
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
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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

@endsection
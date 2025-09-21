
<div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
              <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                
<table id="example5" class="table table-bordered table-striped mt-4">
  <thead>
    <tr>
      <th>Sl</th>
      <th>Passport Name</th>
      <th>Passport Number</th>
      <th>Package Cost</th>
      <th>Received Amount</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($datas as $key => $entry)
    <tr>
      <td style="text-align: center">{{ $key + 1 }}</td>
      <td style="text-align: center"><a href="{{ route('admin.clientDetails', $entry->id) }}">{{ $entry->passport_name }}</a></td>
      <td style="text-align: center">{{ $entry->passport_number }}</td>
      <td style="text-align: center">{{ ($entry->total_package - $entry->package_cost) }}</td>
      <td style="text-align: center">{{ $entry->total_received }}</td>
      <td style="text-align: center">
        @if ($entry->status == 0) New
        @elseif($entry->status == 1) Processing
        @elseif($entry->status == 2) Complete
        @else Decline @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
</div>

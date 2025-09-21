
<div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
              <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                
<table id="example6" class="table table-bordered table-striped mt-4">
  <thead>
    <tr>
      <th>Sl</th>
      <th>Passport Name</th>
      <th>Passport Number</th>
      <th>Medical Exp Date</th>
      <!-- <th>Package Cost</th> -->
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
       <td style="text-align: center">
                            @if ($entry->medical_exp_date) 

                      @php

                      $expiryDate = \Carbon\Carbon::parse($entry->medical_exp_date);
                      $today = \Carbon\Carbon::today();
                      $color = '';

                      if ($expiryDate->lessThan($today)) {
                          // Already expired
                          $color = 'background-color: black; color: white;';
                      } else {
                          // Not yet expired — check how close
                          $daysRemaining = $today->diffInDays($expiryDate);

                          if ($daysRemaining <= 8) {
                              $color = 'background-color: red; color: white;';
                          } elseif ($daysRemaining <= 15) {
                              $color = 'background-color: yellow;';
                          }
                      }
                      @endphp

                <p style="{{ $color }}">{{$entry->medical_exp_date}}</p>

                  @else            
                      <div class="input-group">
                        <input type="date" class="form-control medical_exp_date" name="medical_exp_date" id="medical_exp_date{{$entry->id}}" value="{{$entry->medical_exp_date}}">
                        <div class="input-group-append">
                          <button class="btn btn-secondary medical_exp_date_btn" data-id="{{$entry->id}}">
                          <i class="fas fa-save"></i>
                          </button>
                        </div>
                        </div>
                        <p><small class="smsg" id="smsg{{$entry->id}}"></small></p>
                    </td>
                    @endif

      <!-- <td style="text-align: center">{{ $entry->total_package }}</td> -->
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

@include('energy-report.filter')
<table class="table table-bordered" id="electricity-datatable">
    <thead>
        <tr>
            <th>Day</th>
            <th>LWBP</th>
            <th>LWBP Total</th>
            <th>LWBP Cost</th>
            <th>WBP</th>
            <th>WBP Total</th>
            <th>WBP Cost</th>
            <th>Cost Total</th>
            <th>Occupancy</th>
            <th>Electricity per Room</th>
            <th>Month to Date Cost</th>
            @if(in_array(auth()->user()->role_id, [1,2]))
            <th class="no-sort no-search text-center">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

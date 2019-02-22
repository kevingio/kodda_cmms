@include('energy-report.filter')
<table class="table table-bordered" id="water-datatable" style="width: 100%;">
    <thead>
        <tr>
            <th>Day</th>
            <th>PDAM</th>
            <th>PDAM Consumption</th>
            <th>PDAM Cost</th>
            <th>PDAM Month to Date</th>
            <th>Deep Well</th>
            <th>Deep Well Consumption</th>
            <th>Deep Well Total</th>
            <th>Occupancy</th>
            <th>Water per Room</th>
            @if(in_array(auth()->user()->role_id, [1,2]))
            <th class="no-sort no-search text-center">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

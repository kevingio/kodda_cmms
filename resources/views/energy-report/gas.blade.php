@include('energy-report.filter')
<table class="table table-bordered" id="gas-datatable" style="width: 100%;">
    <thead>
        <tr>
            <th>Day</th>
            <th>Gas</th>
            <th>Comsumption</th>
            <th>Cost</th>
            <th>Gas Month to Date</th>
            @if(in_array(auth()->user()->role_id, [1,2]))
            <th class="no-sort no-search text-center">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

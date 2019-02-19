@include('energy-report.filter')
<table class="table table-bordered dt-table">
    <thead>
        <tr>
            <th>Tgl</th>
            <th>PDAM</th>
            <th>PDAM Konsumsi</th>
            <th>Harga PDAM</th>
            <th>PDAM Month to Date</th>
            <th>Deep Well</th>
            <th>Deep Well Konsumsi</th>
            <th>Total Harga</th>
            <th>Occupancy</th>
            <th>Listrik per Kamar</th>
            <th>Harga Month to date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>12</td>
            <td>4.023</td>
            <td>4.000.000</td>
            <td>1.200.000</td>
            <td>240.000</td>
            <td>200.000</td>
            <td>300.000</td>
            <td>5.000.000</td>
            <td>1</td>
            <td>50.000</td>
            <td>45.000</td>
            <td>
                <a href="javascript: void(0)" class="btn btn-warning edit waves-effect waves-light" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-danger edit waves-effect waves-light" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete">
                    <i class="mdi mdi-delete"></i>
                </a>
            </td>
        </tr>
        <tr>
            <td>13</td>
            <td>5.023</td>
            <td>3.000.000</td>
            <td>3.200.000</td>
            <td>240.000</td>
            <td>300.000</td>
            <td>200.000</td>
            <td>3.000.000</td>
            <td>2</td>
            <td>10.000</td>
            <td>25.000</td>
            <td>
                <a href="javascript: void(0)" class="btn btn-warning edit waves-effect waves-light" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a href="javascript: void(0)" class="btn btn-danger edit waves-effect waves-light" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete">
                    <i class="mdi mdi-delete"></i>
                </a>
            </td>
        </tr>
    </tbody>
</table>

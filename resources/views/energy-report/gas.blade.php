@include('energy-report.filter')
<table class="table table-bordered dt-table" style="width: 100%;">
    <thead>
        <tr>
            <th>Tgl</th>
            <th>Gas</th>
            <th>Gas Komsumsi</th>
            <th>Harga Gas</th>
            <th>Gas Month to Date</th>
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
            <td>6.023</td>
            <td>5.000.000</td>
            <td>3.200.000</td>
            <td>40.000</td>
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

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Electricity Report</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style media="screen">
            body {
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h4 class="text-center mb-4">Electricity Report {{ $reportMonth }}</h4>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
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
                            </tr>
                        </thead>
                        <tbody class="table-striped">
                            @foreach($reportData as $item)
                            <tr>
                                <td>{{ date('d', strtotime($item->created_at)) }}</td>
                                <td>{{ $item->lwbp }}</td>
                                <td>{{ $item->lwbp_total }}</td>
                                <td>{{ $item->lwbp_cost }}</td>
                                <td>{{ $item->wbp }}</td>
                                <td>{{ $item->wbp_total }}</td>
                                <td>{{ $item->wbp_cost }}</td>
                                <td>{{ $item->cost_total }}</td>
                                <td>{{ $item->occupancy }}</td>
                                <td>{{ $item->electricity_per_room }}</td>
                                <td>{{ $item->month_to_date_cost }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

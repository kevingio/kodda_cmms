<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Gas Report</title>
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
                    <h4 class="text-center mb-4">Gas Report {{ $reportMonth }}</h4>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Day</th>
                                <th>Gas</th>
                                <th>Consumption</th>
                                <th>Cost</th>
                                <th>Gas Month to Date</th>
                            </tr>
                        </thead>
                        <tbody class="table-striped">
                            @foreach($reportData as $item)
                            <tr>
                                <td>{{ date('d', strtotime($item->created_at)) }}</td>
                                <td>{{ $item->value }}</td>
                                <td>{{ $item->consumption }}</td>
                                <td>{{ $item->cost }}</td>
                                <td>{{ $item->month_to_date }}</td>
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

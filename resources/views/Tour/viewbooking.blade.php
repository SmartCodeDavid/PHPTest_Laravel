<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Home page - Tour">
    <link rel="stylesheet"    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <title>Home</title>
</head>

<body>
<div class="container">
    <div class="row">
        <div class='col-md-2'><a href="{{ route('tour') }}" class="btn btn-success">Tours</a></div>
    </div>
    <table class="table table-striped table-hove">
        <thead>
        <tr>
            <th class="col-md-1">Booking Id</th>
            <th class="col-md-3">Tour name</th>
            <th class="col-md-3">Tour date</th>
            <th class="col-md-3">Number of Passengers</th>
            <th class="col-md-2">Actions</th>
        </tr>
        </thead>
        <tbody >
        {{--'bookings', 'tourNames', 'numberOfPassengers'--}}
        @for($i = 0; $i < sizeof($bookings); $i++)
        <tr>
            <td>{{ $bookings[$i]->id }}</td>
            <td>{{ $tourNames[$i] }}</td>
            <td>{{ $bookings[$i]->tour_date }}</td>
            <td>{{ $numberOfPassengers[$i] }}</td>
            <td><a class="btn btn-success"
                   href="{{ route('bookingedit', $bookings[$i]->id) }}">Edit</a>
            </td>
        </tr>
        @endfor
        </tbody>
    </table>
</div>
</body>
</html>
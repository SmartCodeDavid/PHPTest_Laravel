<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body  style="padding: 40px">
    <div class="container">
        <div class='row'>
            <a class='btn btn-success' href="{{ route('create_tour') }}">Create new tour</a>
            <a class='btn btn-primary' href="{{ route('viewbooking') }}">View booking</a>
        </div>
        <div class="row">
            <table class='table table-striped table-hover'>
                <thead>
                    <th class="col-md-3">Tour Id</th>
                    <th class="col-md-7">Tour name</th>
                    <th class="col-md-3">Actions</th>
                </thead>
                
                <tbody>
                    @foreach($tours as $tour)
                    <tr>
                    <td>{{ $tour->id }}</td>
                        <td>{{ $tour->name }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('editUrl', $tour->id) }}">Edit</a>
                            <a class="btn btn-success" href="{{ route('book', $tour->id) }}">Booking</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
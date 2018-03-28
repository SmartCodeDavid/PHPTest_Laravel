<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
	<script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker3.standalone.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>

    <title>Document</title>
</head>
<body>
    {{--  template for table cration  --}}
    <div class="clone_area" style="display: none"> 
        <table>
            <tbody>
                <tr id='clone_tr'>
                    <td><input type="text" class="form-control" name='dates[]' data-provide="datepicker"></td>
                    <td><a href="javascript:void(0)" class="btn btn-danger" id='removeBtn'>Remove</a></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="container" style="margin: 40px">
    <form action="{{ route('create_tour') }}" method="POST">    
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-8 col-md-offset-3">
            <div class="form-group">
                <label class="control-label">Your Name:</label>
                <input type="text" class="form-control" id="name" name='name' value="{{ old('name') }}">
                @if($errors->has('name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }} 
                    </div>
                @endif
                
            </div>
            <div class="form-group">
                <label class="control-label">Itinerary:</label>
                <textarea class="form-control" id="itinerary" name='itinerary'>{{ old('itinerary') }}</textarea>
                @if($errors->has('itinerary'))
                    <div class="alert alert-danger">
                        {{ $errors->first('itinerary') }}
                    </div>
                @endif
            </div>                
            <div class="form-group">
                    <label class="control-label">Tour available Dates:</label>
                    <a id='add_date' href="javascript:void(0);" class="btn btn-primary pull-right">Add Date</a>
            </div>  
        </div>
        <br>
        <div class="col-md-8 col-md-offset-3">
            <div class="form-group">
                <table id='datesTable' class="table table-striped table-hover table-bordered">
                    <thead class="bg-success">
                        <th class="col-md-8">Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody id='tablebody'>
                        @if(old('dates'))
                            @foreach(old('dates') as $date)
                                <tr id="clone_tr">
                                <td><input type="text" class="form-control" name='dates[]' data-provide="datepicker" value="{{ $date }}">
                                    @if(!$date)
                                        <div class="alert alert-danger">warning</div>
                                    @endif
                                </td>
                                <td><a href="javascript:void(0)" class="btn btn-danger" id='removeBtn'>Remove</a></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <a href="/tour" class="btn btn-danger">Cancle</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button href="javacript:void(0)" type="submit" class="btn btn-primary text-right" id='submit'>Submit</button>                        
                    </div>
                </div>
            </div>
        </div>
        </div>
        </form>
    </div>

    <script>
            $.fn.datepicker.defaults.format = "yyyy-mm-dd";
            $.fn.datepicker.defaults.autoclose = true;
    </script>

    <script>
         $(function () {
            $('#add_date').click(function(){
                //.clone().appendTo('#tablebody');
                var trclone = $('.clone_area').find('tr#clone_tr').clone();
                $('#tablebody').append(trclone);
            });

            $('#datesTable').on('click', '#removeBtn', function(){
                $(this).closest('tr#clone_tr').remove();
            })

            $('#submit').click(function(){
                //name  itinerary
            })
        });
    </script>
</body>
</html>



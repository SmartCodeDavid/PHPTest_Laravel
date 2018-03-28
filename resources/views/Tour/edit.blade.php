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
    <form action="{{ route('saveEdit', $tour[0]->id) }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-8 col-md-offset-3">
            <div class="form-group">
                <label class="control-label">Your Name:</label>
                <input readonly="readonly" type="text" class="form-control" id="name" name='name' value="{{ old('name')? old('name') : $tour[0]->name }}">
                @if($errors->has('name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">Itinerary:</label>
                <input type="hidden" value="{{ $tour[0]->itinerary }}" name="originalItinerary">
                <textarea class="form-control" id="itinerary" name='itinerary'>{{ old('itinerary')? old('itinerary') : $tour[0]->itinerary }}</textarea>
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
                        @if(old('dates') || $dates)
                            @if(old('dates'))
                                @foreach(old('dates') as $key => $date)
                                    <tr id="clone_tr">
                                        <td>
                                            <input type="text" class="form-control" name='dates[]' data-provide="datepicker"
                                                   value="{{ $date }}">
                                            @if($errors->has('dates.'.$key))
                                                <div class="alert alert-danger">
                                                     warning
                                                </div>
                                            @endif
                                        </td>
                                        @if($key >= sizeof(old('statusInput')))
                                            <td><a href="javascript:void(0)" class="btn btn-danger" id='removeBtn'>Remove</a></td>
                                        @elseif(old('statusInput')[$key] == 'Enable')
                                            <input type="hidden" value="{{ $dates[$key]->date }}" name="originalDates[]">
                                            <td>
                                                <input type="hidden" name="statusInput[]" value="Enable">
                                                <a href="javascript:void(0)" class="btn btn-danger statusBtn">Disable</a>
                                            </td>
                                        @elseif(old('statusInput')[$key] == 'Disable')
                                            <input type="hidden" value="{{ $dates[$key]->date }}" name="originalDates[]">
                                            <td>
                                                <input type="hidden" name="statusInput[]" value="Disable">
                                                <a href="javascript:void(0)" class="btn btn-danger statusBtn">Enable</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                @foreach($dates as $key => $date)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" name='dates[]' data-provide="datepicker"
                                               value="{{ $date->date }}">
                                        <input type="hidden" value="{{ $date->date }}" name="originalDates[]">
                                    </td>
                                    @if($date->status == 1)
                                        <td>
                                            <input type="hidden" name="statusInput[]" value="Enable">
                                            <a href="javascript:void(0)" class="btn btn-danger statusBtn">Disable</a>
                                        </td>
                                    @else
                                        <td>
                                            <input type="hidden" name="statusInput[]" value="Disable">
                                            <a href="javascript:void(0)" class="btn btn-danger statusBtn">Enable</a>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            @endif
                        @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <a href="/tour" class="btn btn-danger">Cancle</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-primary text-right" id='submit'>Submit</button>
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

        //status button
        $('.statusBtn').click(function(){
            if($(this).html() === 'Disable') {
                $(this).text('Enable')
                var input = $(this).prev();
                input.val('Disable');
            }else{
                $(this).text('Disable');
                var input = $(this).prev();
                input.val('Enable');
            }
        })
    });
</script>
</body>
</html>



<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Home page - Tour">
    <link rel="stylesheet"    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!--   Style for date picker     -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">

    <!--   Date picker JS reference    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <title>Home</title>

    {{--<link rel="stylesheet" href="main.css">--}}
</head>


<body>
<div class="container">
    <div class="row">
        <form class="form-horizontal" id="formid" method="post" action="{{ route('book', $tour->id) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type='hidden' name='tourid' value="{{ $tour->id }}">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-md-3 control-label">Tour name</label>
                    <label class="col-md-3 control-label" style="text-align: left">{{ $tour->name }}</label>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tour Date</label>
                    <div class="col-md-5">
                        <select class="form-control" name="tourdate">
                            @foreach($dates as $date)
                                <option value="{{ $date->date }}">{{ $date->date }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-2">
                        <label class="col-md-3 control-label">Passenger</label>
                        <div class="col-md-3" style="float: right">
                            <a href="javascript:void(0)" class="btn btn-success" onclick='addPassengerBtnPressDown(this)' style="float:right">Add passenger</a>
                        </div>
                    </div>
                </div>

                <div id='divClone'>

                </div>

                <div class="form-group">
                    <div class="col-md-4 col-md-offset-3">
                        <a href="{{ route('tour') }}" class="btn btn-default">cancel</a>
                    </div>
                    <div class="col-md-4">
                        <button type="button" href="javascript:void(0)" onclick='submitBtnPressDown(this)' class="btn btn-primary">submit</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Template - div -->
        <div id='copyDiv' style="display: none">
            <div class="form-group" style="backgroup-color: grey">
                <label class="col-md-3 control-label" >Given name</label>
                <div class="col-md-3">
                    <input type='text' class="form-control" name="givenname[]"></input>
                    <span style="color:red; display:none">warning</span>
                </div>
                <label class="control-label col-md-1" >Surname</label>
                <div class="col-md-3">
                    <input type='text' class="form-control" name=surname[]></input>
                    <span style='color:red; display:none'>warning</span>
                </div>
            </div>


            <div class="form-group" style="backgroup-color: grey">
                <label class="col-md-3 control-label">Email</label>
                <div class="col-md-3">
                    <input type='text' class="form-control" name="email[]"></input>
                    <span style='color:red; display:none'>warning</span>
                </div>
                <label class="control-label col-md-1" >Mobile</label>
                <div class="col-md-3">
                    <input type='text' class="form-control" name="mobile[]"></input>
                    <span style='color:red; display:none'>warning</span>
                </div>
            </div>

            <div class="form-group" style="backgroup-color: grey">
                <label class="col-md-3 control-label">Passport</label>
                <div class="col-md-3">
                    <input type='text' class="form-control" name="passport[]"></input>
                    <span style='color:red; display:none'>warning</span>
                </div>
                <label class="control-label col-md-1" >dateofbirth</label>
                <div class="col-md-3">
                    <input type='text' class="form-control datepickerGroup" name="dateofbirth[]" id='datepicker' data-provide='datepicker'></input>
                    <span style='color:red; display:none'>warning</span>
                </div>
            </div>

            <div class="form-group" style="backgroup-color: grey">
                <label class="col-md-3 control-label">Special Request</label>
                <div class="col-md-5">
                    <input type='text' class="form-control" name="specialrequest[]">
                    <span style='color:red; display:none'>warning</span>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-success" onclick='removeBtnPressDown(this)'>Remove</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addPassengerBtnPressDown(e){
        var elementClone = $("#copyDiv").find(".form-group").clone();
        // var elementwraper = document.createElement("div");
        var ele = $("<div id='divwrapper' class='copyDivGroup'>");
        ele.append(elementClone);
        $("#divClone").append(ele);
    }

    function removeBtnPressDown(e) {
        e.closest("div#divwrapper").remove();
    }

    function submitBtnPressDown(e) {
        var flag = true;
        //$divGroup = $(".copyDivGroup");
        $('div.copyDivGroup input').each(function(){
            if($(this).val() == "") {
                $(this).next().text("warning");
                $(this).next().css("display", "block");
                flag = false;
            }else{
                $(this).next().css("display", "none");
                //validate email formate
                if($(this).attr("name") == "email[]"){
                    var email = $(this).val();
                    var reg = /\w+[@]{1}\w+[.]\w+/;
                    if(reg.test(email)){
                        //set defatul
                        $(this).next().text("warning");
                        $(this).next().css("display", "none");
                    }else{
                        //set text with invalidate email
                        $(this).next().css("display", "block");
                        $(this).next().text("invalidate email");
                        flag = false;
                    }
                }
            }

        });

        if(flag) {
            $('#formid').submit();
        }
    }

</script>


<!--   Datepicker config     -->
<script>
    $(".datepickerGroup").datepicker.defaults.format = 'yyyy-mm-dd';
    $(".datepickerGroup").datepicker.defaults.autoclose = true;
</script>

</body>

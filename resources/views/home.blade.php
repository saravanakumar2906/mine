@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged insss!') }}


                    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <select  name="year" class="form-control" id='year' >
                     
  <option value="2010">2010</option>
  <option value="2011">2011</option>
  <option value="2012">2012</option>
  <option value="2013">2013</option>
  <option value="2014">2014</option>

  <option value="2015">2015</option>

  <option value="2016">2016</option>
  <option value="2017">2017</option>
  <option value="2018">2018</option>
  <option value="2019">2019</option>
  <option value="2020">2020</option>
  
</select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button id="ddd" class="btn btn-primary submit">Submit</button>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <p id="success"></p>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
$("#ddd").click(function(){
//e.preventDefault();
//alert('am i here');

    var id = $('#year').val();
   
    $.ajax({
        method: "POST",
        url: "{{url('/home_ajx')}}",
        data: {"_token": "{{ csrf_token() }}","year": id},
        }).done(function( msg ) {
        if(msg.error == 0){
            $('#success').html(msg);
          //  alert(msg.message);
        }else{
            $('#success').html(msg);
           // alert(msg.message);
            //$('.error-favourite-message').html(msg.message);
        }
    });
});
});
</script>
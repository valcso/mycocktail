@if(isset($data))
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12' >
    <div class='row'>
@foreach($data['drinks'] as $value)

<div class='col-xl-3 col-lg-3 col-md-3 col-sm-3 d-none d-sm-block' style='text-align:right; '>
<img src="{{$value['strDrinkThumb']}}" id='roundedImg'>
</div>
<div class='col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6' style='text-align:center; font-weight:bolder;'>
<a href='http://localhost:81/cocktailAPP/public/single?id={{$value['idDrink']}}'><p id='searchTitle'>{{$value['strDrink']}}</p></a>
</div>
<div class='col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-6 d-none d-sm-block '>
<a class='viewSingle' href='http://localhost:81/cocktailAPP/public/single?id={{$value['idDrink']}}'>view</a>
</div>

@endforeach
</div>
</div>
@endif

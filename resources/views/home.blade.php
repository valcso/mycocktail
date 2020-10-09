
@extends('inc.template')
@section('content')
<!--<div class='row' style='margin-left:0; margin-right:0;'>-->
@foreach ($res['drinks'] as $value)
<div class='col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6'  id='itemBox'>
    <div class='col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-10' id='insideItemBox'>
    <img src='{{$value['strDrinkThumb']}}' width="100%">
    
        <p>{{$value['strDrink']}}</p>
    <a href='single?id={{$value['idDrink']}}' class='exploreBtn'>Explore &rarr;</a>
</div>
</div>
@endforeach
<!--</div>-->
@endsection

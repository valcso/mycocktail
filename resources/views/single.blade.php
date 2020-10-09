@extends('inc.template')
@section('content')
<div class='row' style='padding:15px; margin-left: 0px;
margin-right: 0px;'>
<div class='col-xl-5 col-lg-5 col-md-5 col-sm-5' style='text-align:left;'>
<div style='padding:2px;'> 
  <a  class='backBtn' href='{{ url()->previous() }}'>&larr; Go back</a><br></div>
<img class='fullImg' src='{{$image}}' width="80%">
<ul class="tags">
<li><a  class="tag">{{$category}}</a></li>
<li><a class='tag'>{{$isAlcoholic}}</a></li>
<li><a class='tag'>{{$glass}}</a></li>  
</ul>

</div>
<div class='col-xl-7 col-lg-7 col-md-7 col-sm-7' style='text-align:center;'>
<h1>{{$name['strDrink']}}</h1>
<h6>{{$instruction['strInstructions']}}</h6>
<div class='row' style='margin-left: 0px;
margin-right: 0px;'>
@php 
$i=0;
foreach($measure['ingredient'] as $key=>$value){
 if(isset($measure['measure'][$i])){
  echo "<div class='col-xl-4 col-lg-4 col-md-5 col-sm-5' style='margin:0 auto;'>";
  echo "<p class='measure'>";
echo "<a id='ingr'href='http://localhost:81/cocktailAPP/public/ingredient?ingredient=$value'>#".$value."</a>";
echo"</p>";
echo "<img src='https://www.thecocktaildb.com/images/ingredients/".$value."-Small.png'>";
echo "<p>".$measure['measure'][$i]."</p>";
echo "</div>";

$i++;
 }else{
  echo "<div class='col-xl-4 col-lg-4 col-md-5 col-sm-5' style='margin:0 auto;'>";
  echo "<p class='measure'>";
echo $value;
echo"</p>";
echo "<img src='https://www.thecocktaildb.com/images/ingredients/".$value."-Small.png'>";
echo "</div>";
 }
 
}


@endphp
</div>
</div>

</div>

@endsection




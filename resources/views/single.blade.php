@extends('inc.template')
@section('content')
<div class='modal' id='modal'>
  <img class='modal-content' src='{{$image}}'>
  <span class="close" onclick='imgModal(2)'>&times;</span>
</div>
<div class='row' style='padding:15px; margin-left: 0px;
margin-right: 0px;'>
<div class='col-xl-5 col-lg-5 col-md-5 col-sm-5' style='text-align:left;'>
<div style='padding:2px;'> 
  <a  class='backBtn' href='{{ url()->previous() }}'>&larr; Go back</a><br></div>
<img class='fullImg' src='{{$image}}' width="80%" onclick="imgModal(this)">
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
echo "<a id='ingr'href='http://127.0.0.1:81/cocktailAPP/public/ingredient?ingredient=$value'>#".$value."</a>";
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
@section('comments')
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12'>
  <h5 id='calorieTitle'>Check out cocktails nutrition data</h5>
</div>
<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12' id='calories'>
<table>
@php 
$size=sizeof($calories);
$i=0;

if($size>0){
  while($i<=$size-1){
  echo "<table id='calTable'>";
    if(isset($calories[$i]['parsed'][0])){
    echo "<tr><td id='tTitle'>".$calories[$i]['text']."</td><tr>";
    foreach($calories[$i]['parsed'][0]['food']['nutrients'] as $key=> $value){
   echo "<tr><td>&#9724;".$key.": ".$value."</td></tr>";
  }

  }
  else{
    echo "<tr><td id='tTitle'>".$calories[$i]['text']."</td></tr>";
    if(isset($calories[$i]['hints'][0]['food']['nutrients'])){
      foreach($calories[$i]['hints'][0]['food']['nutrients'] as $key=> $value){
   echo "<tr><td>&#9724;".$key.": ".$value."</td></tr>";
  }
    }
    else{
      echo "<tr><td>No data &#129300</td></tr>";
    }
  
  }
 
echo "</table>";
  $i++;
}

}
@endphp
</table>
</div>
@endsection




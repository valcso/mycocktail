<?php

namespace App\Http\Controllers;
use App\Cocktail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Request;

class SingleCocktailController extends Controller
{
    public function single(){
        $id=Request::get('id');
        $response = Http::get('https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i='.$id.'');
        $resp=$response->json();
        $ingredients=[];
        $measure=[];
        $name=[];
        $image='';
        $instruction=[];
        $isAlcoholic="";
        $glass="";
        $i=0;
        $category='';
        foreach($resp['drinks'][0] as $key=> $value){
            if(Str::contains($key,['strDrink'])){
                $name[$key]=$value;
            }
            if(Str::contains($key,['strMeasure'])){
                if($value !== NULL){
                    $measure['measure'][$i]=$value;
                    $i++;
                }
            }
            if(Str::contains($key,['strIngredient'])){
                if($value !== NULL){
                    $measure['ingredient'][$key]=$value;
                }
             }
             if(Str::contains($key,['strGlass'])){
                if($value !== NULL){
                    $glass=$value;
                }
             }
             if(Str::contains($key,['strAlcoholic'])){
                if($value !== NULL){
                    $isAlcoholic=$value;
                }
             }
             if(Str::contains($key,['strDrinkThumb'])){
                if($value !== NULL){
                    $image=$value;
                }
             }
             if(Str::contains($key,['strInstructions'])){
                if($value !== NULL){
                    $instruction[$key]=$value;
                }
             }
             if(Str::contains($key,['strCategory'])){
                if($value !== NULL){
                    $category=$value;
                }
             }
             
        }

      // return view('cocktail.single')->with('data',$response->json());
       // return view('cocktail.single')->with('data',$ingredients);


       return view('single',compact('name','measure','image','instruction','category','isAlcoholic','glass'));
    }
}
?>
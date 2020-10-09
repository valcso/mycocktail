<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class MyCocktailController extends Controller
{
    public function soft(){
        $response = Http::get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=Ordinary_Drink');
        return view('home')->with('res',$response->json());
    }
    public function nonAlc(){
        $response = Http::get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?a=Non_Alcoholic');
        return view('nonalc')->with('res',$response->json());
    }
    public function cocktail(){
        $response = Http::get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=Cocktail');
        return view('cocktail')->with('res',$response->json());
    }
    public function shot(){
        $response = Http::get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=shot');
        return view('shot')->with('res',$response->json());
    }
    public function search(Request $request){
        $string=$request->input('string');
         // var_dump($string);
       //  $string='xx11';
      $response= Http::get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?i='.$string.'');
      
          return view('/search')->with('data',$response->json());
       
      }
      public function ingredient(Request $request){
        $string=$request->input('ingredient');
         // var_dump($string);
       //  $string='xx11';
      $response= Http::get('https://www.thecocktaildb.com/api/json/v1/1/filter.php?i='.$string.'');
      
          return view('/ingredient')->with('res',$response->json()); 
      }
   
}

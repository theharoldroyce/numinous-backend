<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use  Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::all();
        return response()->json(['products' =>$products],200);
    }

    public function show($id)
    {
        $products = Products::find($id);
        if($products)
        {
            return response()->json(['products' =>$products],200);
        }
        else
        {
            return response()->json(['message' =>'Sorry No Record Found'],404);
        }
    }

    public function store(Request $request)
    {
        $request-> validate([
         'name' =>'required|max:191',
         'color' =>'required|max:191',
         'size' =>'required|max:191',
         'category' =>'required|max:191',
         'qty' =>'required|max:191',
         'price' =>'required|max:191',
         'image' =>'required|max:191',
        ]);

        $products = new Products;
        $products-> name = $request -> name;
        $products -> color= $request -> color;
        $products -> size= $request -> size;
        $products-> category = $request -> category;
        $products -> qty = $request -> qty;
        $products -> price= $request -> price;
        if($request->hasfile('image'))
        {
            $file = $request ->file('image');
            $extension = $file->getclientOriginalExtension();
            $filename = time() .'   '.$extension;
            $file->move('image/products/',$filename);
            $products->image=$filename;
        }
        $products -> save();
        return response()->json(['message'=> 'Product Successfuly Added'],200);
    }

    public function update(Request $request,$id)
    {
        $request-> validate([
            'name' =>'required|max:191',
            'color' =>'required|max:191',
            'size' =>'required|max:191',
            'category' =>'required|max:191',
            'qty' =>'required|max:191',
            'price' =>'required|max:191',
            'image' =>'required|max:191',
           ]);

           $products = Products::find($id);
           if($products)
           {
            $products-> name = $request -> name;
            $products -> color= $request -> color;
            $products -> size= $request -> size;
            $products-> category = $request -> category;
            $products -> qty = $request -> qty;
            $products -> price= $request -> price;
            if($request->hasfile('image'))
            {
                $sedtination_path ='image/products/'.$post->image;
                if(File::exists($destination_path))
                {
                    File::delete($destination_path);
                }
                $file = $request ->file('image');
                $extension = $file->getclientOriginalExtension();
                $filename = time() .'   '.$extension;
                $file->move('image/products/',$filename);
                $products->image=$filename;
            }
            $products-> update();
            return response()->json(['message'=> 'Product Successfuly Updated'],200);
           }
           else
           {
            return response()->json(['message'=> 'NO Product Found'],404);
           }
    }

    public function destroy($id)
    {
        $products = Products::find($id);
        if($products)
        {
            $products ->delete();
            return response()->json(['message'=> 'Product Deleted'],200);
        }
        else
        {
            return response()->json(['message'=> 'ProductsNot Found'],404);
        }
    }
}

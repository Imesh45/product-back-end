<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function store(Request $request)
    { 
        $validate_data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'status' => 'required',
     ]);

        $image = $request->file('image');

        $name_gen = hexdec(uniqid());
        $img_extention = strtolower($image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_extention;                                   //21232323.png
        $upload_location = 'image/user/';
        $image = $upload_location . $img_name;
       //  $image->move($upload_location, $img_name);

     $data = Product::create([
         'name' => $validate_data['name'],
         'price' => $validate_data['price'],
         'status' => $validate_data['status'],
         'image' => $image,
     ]);

      if($data) {
        return response()->json(['Product Saved']);
      } else {
        return response()->json(['Product Note Saved']);
      }

    }
       public function show($id){
      $product = Product::find($id);
      if (is_null($product)) {
      return $this->sendError('Product not found.');
      }
      return response()->json([
      "success" => true,
      "message" => "Product retrieved successfully.",
      "data" => $product,
      ]);
      }
      public function update(){
                

      }
      
      public function destroy(Product $product)
      {
      $product->delete();
      return response()->json([
      "success" => true,
      "message" => "Product deleted successfully.",
      "data" => $product,
      ]);
      }
    }
 


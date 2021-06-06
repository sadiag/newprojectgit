<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;


class ProductController extends Controller
{
    public function ALLProduct()
    {
        // $products = Produc::all();
        // $products = DB::table('products')->join('users','products.user_id','users.id')
        // ->select('products.*','users.name')->paginate(5);
        $products = Product::latest()->paginate(5);
        $trashCat = Product::onlyTrashed()->latest()->paginate(3);
        return view('admin.product.index', compact('products', 'trashCat'));
    }

    public function AddProduct(Request $request)
    {

        $request->validate([
            'product_name' => 'required|max:255',
        ],

            [

                'product_name.required' => 'please input Product name',
                'product_name.max' => 'Product less than 255 chars',

            ]);

            Product::insert([
            'product_name' => $request->product_name,
             'user_id' => Auth::user()->id,
             'created_at' => Carbon::now()
            

         ]);

        return Redirect()->back()->with('success', 'Product inserted');

    }

    // edit

    public function Edit($id)
    {
        $products = Product::find($id);
        //dd($products);

        //$products = DB::table('products')->where('id', $id)->first();
        return view('admin.product.edit', compact('products'));
    }

    // update

    public function update(Request $request, $id)
    {

        $request->validate([
            'product_name' => 'required|max:255',
        ],

            [

                'product_name.required' => 'please input Product  name',
                'product_name.max' => 'Product  less than 255 chars',

            ]);

         $update = Product ::find($id)->update([

        'product_name' => $request->product_name,
         'user_id' => Auth::user()->id

          ]);

          //$data = array();
         //$data['product_name'] = $request->product_name;
          //$data['user_id'] = Auth::user()->id;
          //DB::table('products')->where('id', $id)->update($data);
  
        return Redirect()->route('all.product')->with('success', 'Product updated');

    }

    //soft delete
    public function SoftDelete($id)
    {
        $delete = Product::find($id)->delete();
        return Redirect()->back()->with('success', 'Product Deleted');
    }

    //Restore
    public function Restore($id)
    {
        $delete = Product::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Product Restore');
    }

    //permanentdelete
    public function pdelete($id)
    {
        $delete = Product::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Product permanently deleted');
    }

}

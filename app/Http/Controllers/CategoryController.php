<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class CategoryController extends Controller
{
    public function ALLCat()
    {
        // $categories = Category::all();
        // $categories = DB::table('categories')->join('users','categories.user_id','users.id')
        // ->select('categories.*','users.name')->paginate(5);
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);
        return view('admin.category.index', compact('categories', 'trashCat'));
    }

    public function AddCat(Request $request)
    {

        $request->validate([
            'category_name' => 'required|max:255',
        ],

            [

                'category_name.required' => 'please input Category name',
                'category_name.max' => 'Category less than 255 chars',

            ]);

          Category::insert([
            'category_name' => $request->category_name,
             'user_id' => Auth::user()->id,
            

         ]);

        return Redirect()->back()->with('success', 'Category inserted');

    }

    // edit

    public function Edit($id)
    {
        $categories = Category::find($id);
        //dd($categories);

        //$categories = DB::table('categories')->where('id', $id)->first();
        return view('admin.category.edit', compact('categories'));
    }

    // update

    public function update(Request $request, $id)
    {

        $request->validate([
            'category_name' => 'required|max:255',
        ],

            [

                'category_name.required' => 'please input Category name',
                'category_name.max' => 'Category less than 255 chars',

            ]);

         $update = Category::find($id)->update([

        'category_name' => $request->category_name,
         'user_id' => Auth::user()->id

          ]);

          //$data = array();
         //$data['category_name'] = $request->category_name;
          //$data['user_id'] = Auth::user()->id;
          //DB::table('categories')->where('id', $id)->update($data);
  
        return Redirect()->route('all.category')->with('success', 'Category updated');

    }

    //soft delete
    public function SoftDelete($id)
    {
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Deleted');
    }

    //Restore
    public function Restore($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restore');
    }

    //permanentdelete
    public function pdelete($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category permanently deleted');
    }

}

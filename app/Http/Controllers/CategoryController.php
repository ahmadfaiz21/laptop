<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function AllCat(){

        // $categories = DB::table('categories')
        //     ->join('users','categories.user_id','users.id')
        //     ->select('categories.*','users.name')
        //     ->latest()->paginate('5');
        
        $categories = Category::latest()->paginate(5);
        $trachCat = Category::onlyTrashed()->latest()->paginate(3);

        // $categories = DB::table('categories')->latest()->paginate(5);
        return view('admin.category.index',compact('categories','trachCat'));
    }
    public function AddCat(Request $request){

        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Max 255 Charecter',
            
        ]
        );

        Category::insert([
            'category_name'=> $request->category_name,
            'user_id'=>Auth::user()->id,
            'created_at'=> Carbon::now(),
        ]);

        // $category = new Category;
        // $category -> category_name = $request->category_name;
        // $category -> user_id = Auth::user()->id;
        // $category ->save();

        // $data = array();
        // $data['category_name'] = $request->category_name; //'database_name' = -> form field
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data); //'table names'


        return Redirect()->back()->with('success','Category Inserted Successfull');

    }

    public function Edit($id){
        // $categories = Category::find($id);

        $categories = DB::table('categories')->where('id',$id)->first();
        return view('admin.category.edit',compact('categories'));

    }
    public function Update(Request $request , $id){
        // $update = Category::find($id)->update([
            
        //     'category_name' => $request->category_name,
        //     'user_id' =>Auth::user()->id
        // ]);

        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id',$id)->update($data);
        return Redirect()->route('all.category')->with('success','Category Updated Successfull');
    }

    public function SoftDelete($id){
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success','Category Soft Delete Successfully');
    }
}

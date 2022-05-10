<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function AllBrand(){

        $brands = Brand::latest()->paginate('5');
        return view('admin.brand.index', compact('brands'));
    }
}

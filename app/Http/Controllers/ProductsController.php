<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * @var Products
     */
    protected $product;

    /**
     * ProductsController constructor.
     */

    public function __construct()
    {
        $this->product = new Products();
    }

    public function welcomePage()
    {
        $products = $this->product->orderBy('created_at', 'DESC')->get();



        return view('welcome', [
            'products' => $products,
        ]);
    }

    public function addProduct(Request $request)
    {
        $input = $request->all();


        $inputDatabase = array_except($input, ['_token']);

        // validate
        $this->validate($request, [
            'name' => 'required',
            'quantity'  => 'required|numeric',
            'price'  => 'required|numeric'
        ], [
            'name.required' => 'Product name is required',
            'quantity.required' => 'Product name is required',
            'quantity.number' => 'Please insert number',
            'price.required' => 'Product name is required',
            'price.number' => 'Please insert number',
        ]);


        // prepreare database article
        $added_data = $this->product->create($inputDatabase);

        if ($added_data) :
            // If the data was added, redirect with success message
            return response()->json(['success' => 'You successful add new post!', 'product' => $added_data]);
        else :
            // Else return error
            return response()->json(['error' => 'Somethins is wrong!']);
        endif;


    }
}

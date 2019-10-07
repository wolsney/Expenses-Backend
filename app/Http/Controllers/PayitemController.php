<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Payitem;
use App\Rules\Type;

class PayitemController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request){

    	$validatedData = $request->validate([
	        'type' => ['required', new Type],
	        'amount' => 'required|numeric',
	    ]);


    	$user = auth()->user();

    	$payitem = new Payitem;

    	$payitem->user_id = $user->id;

    	$payitem->type = request("type");

    	$payitem->amount = request("amount");

    	$payitem->save();

    	return response()->json($payitem);

    }

}

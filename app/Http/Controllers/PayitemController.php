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

    	$validator = $request->validate([
	        'type' => ['required', new Type],
	        'amount' => 'required|numeric',
	        'date' => 'required|date'
	    ]);


    	$user = auth()->user();

    	$payitem = new Payitem;

    	$payitem->user_id = $user->id;

    	$payitem->type = request("type");

    	$payitem->amount = request("amount");

    	$payitem->payment_date = request("date");

    	$payitem->save();

    	return response()->json($payitem);

    }

    public function getItems(Request $request){
    	$validator = $request->validate([
    		'type' => [new Type],
    		'datestart' => 'date',
    		'dateend'=>'date'
    	]);

    	$user = auth()->user();

    	$payitems = $user->payItems();

    	if(isset($request["type"])){
    		$payitems = $payitems->where("type", $request["type"]);
    	}

    	if(isset($request["datestart"])){
    		$payitems = $payitems->where("payment_date", ">=", $request["datestart"]);
    	}

    	if(isset($request["dateend"])){
    		$payitems = $payitems->where("payment_date", "<=", $request["dateend"]);
    	}

    	$payitems = $payitems->paginate();

    	return $payitems;
    }

}

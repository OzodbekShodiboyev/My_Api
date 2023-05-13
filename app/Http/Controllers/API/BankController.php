<?php
namespace App\Http\Controllers\API;
    
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Bank as BankResource;
use App\Models\Bank;
use Validator;
 
class BankController extends BaseController
{
 
    public function index()
    {
        $banks = Bank::all();
        return $this->handleResponse(BankResource::collection($banks), 'List of banks successfully retrieved!');
    }
 
     
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'bank_name' => 'required',
            'ceo_name' => 'required',
            'about_bank'=>'required'
        ]);
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
        $bank = Bank::create($input);
        return $this->handleResponse(new BankResource($bank), 'Bank successfully created!');
    }
 
    
    public function show($id)
    {
        $bank = Bank::find($id);
        if (is_null($bank)) {
            return $this->handleError('Bank not found!');
        }
        return $this->handleResponse(new BankResource($bank), 'The information about bank ID '.$id.' was received successfully');
    }
     
 
    public function update(Request $request, Bank $bank)
    {
        $input = $request->all();
 
        $validator = Validator::make($input, [
            'bank_name' => 'required',
            'ceo_name' => 'required',
            'about_bank'=>'required'
        ]);
 
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
 
        $bank->bank_name = $input['bank_name'];
        $bank->ceo_name = $input['ceo_name'];
        $bank->about_bank = $input['about_bank'];
        $bank->save();
         
        return $this->handleResponse(new BankResource($bank), 'Bank successfully updated!');
    }
    
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return $this->handleResponse([], 'Bank deleted!');
    }
}
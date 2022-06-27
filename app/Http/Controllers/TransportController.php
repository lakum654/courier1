<?php

namespace App\Http\Controllers;

use App\Http\Validation\TransportValidation;
use App\Models\Transport;
use Exception;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public $moduleName = 'Transport';
    public $view = 'admin/transport';
    public $route = 'admin/transport';

    public function index()
    {
        $moduleName = $this->moduleName;
        $transports = Transport::get();
        return view($this->view . '/index', compact('moduleName', 'transports'));
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        return view($this->view . '/form', compact('moduleName'));
    }

    public function store(TransportValidation $request)
    {


        try {
            if ($request->hasFile('logo')) {
                $logo = singleFile($request->file('logo'), 'transport');
            } else {
                $logo = '';
            }

            if ($request->hasFile('store_cover_photo')) {
                $store_cover_photo = singleFile($request->file('store_cover_photo'), 'transport');
            } else {
                $store_cover_photo = '';
            }


            $inputs = $request->all();
            $inputs['logo'] = $logo;
            $inputs['store_cover_photo'] = $store_cover_photo;

            unset($inputs['_token']);

            Transport::create($inputs);
            return response(['status' => 'success', 'msg' => 'Transport Created Successfully!']);
        } catch (Exception $e) {
            return response(['status' => 'error', 'msg' => 'Transport Not Created!']);
        }
    }


    public function update(TransportValidation $request, $id)
    {
        try {
            if ($request->hasFile('logo')) {
                $logo = singleFile($request->file('logo'), 'transport');
            } else {
                $logo = $request->old_logo;
            }

            if ($request->hasFile('store_cover_photo')) {
                $store_cover_photo = singleFile($request->file('store_cover_photo'), 'transport');
            } else {
                $store_cover_photo = $request->old_store_cover_photo;
            }

            $transport = Transport::find($id);
            $transport->transport_from = $request->transport_from;
            $transport->owner_name = $request->owner_name;
            $transport->mobile_no = $request->mobile_no;
            $transport->business_name = $request->business_name;
            $transport->gst_no   = $request->gst_no;
            $transport->whatsapp_no = $request->whatsapp_no;
            $transport->phone = $request->phone;
            $transport->email = $request->email;
            $transport->country = $request->country;
            $transport->state = $request->state;
            $transport->city = $request->city;
            $transport->pincode = $request->pincode;
            $transport->address = $request->address;
            $transport->payment_accept = $request->payment_accept;
            $transport->service_area = $request->service_area;
            $transport->business_description = $request->business_description;
            $transport->status = $request->status;
            $transport->logo = $logo;
            $transport->store_cover_photo = $store_cover_photo;
            $transport->save();
            return response(['status' => 'success', 'msg' => 'Transport Updated Successfully!']);
        } catch (Exception $e) {
            return response(['status' => 'error', 'msg' => 'Transport Not Updated!']);
        }
    }

    public function changeStatus($id)
    {

        try {
            $address = Transport::find($id);
            if ($address->status == 1) {
                $address->update(['status' => 0]);
            } else {
                $address->update(['status' => 1]);
            }
        } catch (Exception $e) {
        }

        return redirect($this->route)->with('message', 'Transport Status Change Succesfully.');
    }
}

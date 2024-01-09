<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Device;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function view_devices(){
    	$devices = Device::all();

        return DataTables::of($devices)
            ->addColumn('label', function($device){
                $result = "";
                $result .= "<center>";
                if($device->status == 1){
                    $result .= '<span class="badge badge-pill badge-success">Active</span>';
                }
                else{
                    $result .= '<span class="badge badge-pill badge-danger">Inactive</span>';
                }
                $result .= "</center>";

                return $result;
            })
            ->addColumn('action', function($device){
                $result = '<center><div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle btn-xs" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Action">
                            <i class="fa fa-cog"></i> 
                          </button>
                          <div class="dropdown-menu dropdown-menu-right">';
                if($device->status == 1){
                	$result .= '<button class="dropdown-item aEditDevice" type="button" device-id="' . $device->id . '" style="padding: 1px 1px; text-align: center;" data-toggle="modal" data-target="#modalEditDevice" data-keyboard="false">Edit</button>';

                    $result .= '<button class="dropdown-item aChangeDeviceStat" type="button" device-id="' . $device->id . '" status="2" style="padding: 1px 1px; text-align: center;" data-toggle="modal" data-target="#modalChangeDeviceStat" data-keyboard="false">Deactivate</button>';

                    // $result .= '<button class="dropdown-item aShowDeviceDevProc" device-id="' . $device->id . '" device-name="' . $device->name . '" type="button" style="padding: 1px 1px; text-align: center;">Show Device Process</button>';

                    // $result .= '<button class="dropdown-item aGenDeviceBarcode" device-id="' . $device->barcode . '" type="button" style="padding: 1px 1px; text-align: center;">Generate Barcode</button>';

                    // Removed temporarily - undefined value from barcode
                    // $result .= '<button class="dropdown-item aGenerateBarcode" device-id="' . $device->id . '" barcode="' . $device->barcode . '" type="button" style="padding: 1px 1px; text-align: center;" data-toggle="modal" data-target="#modalGenBarcode">Generate Barcode</button>';
                }
                else{
                    $result .= '<button class="dropdown-item aChangeDeviceStat" type="button" style="padding: 1px 1px; text-align: center;" device-id="' . $device->id . '" status="1" data-toggle="modal" data-target="#modalChangeDeviceStat" data-keyboard="false">Activate</button>';
                }

                $result .= '<input type="hidden" value="' . $device->id . '" class="form-control td_device_id">';
                $result .= '<input type="hidden" value="' . $device->name . '" class="form-control td_device_name">';
                            
                $result .= '</div>
                        </div></center>';

                return $result;
            })
            ->addColumn('process_name', function($device){
                $result = "";
                $result .= "<center>";

                if($device->process == 0){
                    $result .= '<span class="badge bg-info">Stamping</span>';
                }
                else if($device->process == 1){
                    $result .= '<span class="badge bg-info">Molding/Assy</span>';
                }
                else{
                    $result .= '<span class="badge bg-info">N/A</span>';
                }
                $result .= "</center>";

                return $result;
            })
            ->rawColumns(['label', 'action', 'process_name'])
            ->make(true);
    }

    public function add_device(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        // return $data;
        if(!isset($request->id)){
            $validation = array(
                    // 'name' => ['required', 'string', 'max:255', 'unique:devices'],
                'name' => ['required', 'string', 'max:255'],
                'code' => ['required', 'string', 'max:255', 'unique:devices']
            );
        }
        else{
            $validation = array(
                // 'name' => ['required', 'string', 'max:255', 'unique:devices'],
                'name' => ['required', 'string', 'max:255'],
                'code' => ['required', 'string', 'max:255']
            );
        }
        $validator = Validator::make($data, $validation);
        
        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();

            try{
                $device_array = array(
                    'code'                      => $request->code,
                    'name'                      => $request->name,
                    'process'                   => $request->process,
                    
                );
                if(isset($request->id)){
                    $device_array['last_updated_by'] = Auth::user()->id;

                    Device::where('id', $request->id)
                    ->update($device_array);
                }
                else{
                    $device_array['created_by'] = Auth::user()->id;
                    $device_array['last_updated_by'] = Auth::user()->id;
                    $device_array['created_at'] = NOW();

                    Device::insert($device_array);
                }
                DB::commit();
                
                return response()->json(['result' => 1, 'msg' => 'Successfully Added']);
            }
            catch(Exemption $e){
                DB::rollback();
                return $e;
            }
        }
    }

    public function get_device_by_id(Request $request){
        $device = Device::where('id', $request->device_id)
        ->where('status', 1)
        ->first();

        return response()->json(['device' => $device]);

    }

    public function change_device_stat(Request $request){
        DB::beginTransaction();
        try{
            Device::where('id', $request->device_id)
            ->update([
                'status' => $request->status
            ]);

            DB::commit();

            return response()->json([
                'result' => 1,
                'msg'   => 'Transaction Success'
            ]);
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Ward;
use App\Models\Province;
class LocationController extends Controller
{
    public function getDistricts($provinceId)
    {
        try {
            // Kiểm tra $provinceId có hợp lệ không
            if (!is_numeric($provinceId) || $provinceId <= 0) {
                return response()->json(['error' => 'ID tỉnh/thành phố không hợp lệ.'], 400);
            }
    
            // Lấy danh sách quận/huyện dựa vào province_id
            $districts = District::where('province_id', $provinceId)->get();
  
            if ($districts->isEmpty()) {
                return response()->json(['districts' => [], 'message' => 'Không có quận/huyện nào.']);
            }
    
            // Trả về dữ liệu quận/huyện
            return response()->json(['districts' => $districts]);
        } catch (\Exception $e) {
            // Ghi log lỗi và trả về thông báo lỗi
            Log::error('Error fetching districts:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Lỗi khi lấy dữ liệu quận huyện.'.$e->getMessage()], 500);
        }
    }
    
    public function getWards($districtId)
    {
       /*  dd(json_decode($districtId)); */

        try {
            $wards = Ward::where('district_id', $districtId)->get();
            return response()->json(['wards' => $wards]);
        } catch (\Exception $e) {
            Log::error('Error fetching wards:', [$e->getMessage()]);
            return response()->json(['error' => 'Lỗi khi lấy dữ liệu phường xã.'], 500);
        }
    }
    public function getProvinces(){
        $provinces = Province::all();
        return response()->json(['provinces' => $provinces]);
    }
}

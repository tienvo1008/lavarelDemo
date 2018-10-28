<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TheLoai;

use App\LoaiTin;

class LoaiTinController extends Controller
{
    //
     public function getDanhSach(){
    	$loaitin = LoaiTin::all();
    	return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }
    public function getThem(){

    	$theloai = TheLoai::all();

    	return view('admin.loaitin.them',['theloai' => $theloai]);
    }
    public function postThem(Request $request){

    	// echo $request -> Ten;
    	$this -> validate($request,
    		[
    			'txtTen'  => 'required|min:3|max:100|unique:Loaitin,Ten',
    			'TheLoai' => 'required'
    		],
    		[	
    			'txtTen.required' => 'Bạn chưa nhập tên loại tin',
    			'txtTen.unique' => 'Tên loại tin đã tồn tại',
    			'txtTen.min'	  => 'Tên loại tin phải có độ dài từ 1 đến 100  kí tự',
    			'txtTen.max'	  => 'Tên loại tin phải có độ dài từ 1 đến 100  kí tự',
    			'TheLoai.required'=> 'Bạn chưa chọn thể loại'
    		]);
    	$loaitin = new LoaiTin;
    	$loaitin -> Ten = $request -> txtTen;
    	$loaitin -> TenKhongDau = changeTitle($request -> txtTen);
    	$loaitin -> idTheLoai	= $request -> TheLoai;
    	$loaitin -> save();

    	return redirect('admin/loaitin/them') -> with('thongbao','bạn đã thêm thành công');
    }
    public function getSua($id){

    	$loaitin = LoaiTin::find($id);
    	$theloai = TheLoai::all();	
    	return view('admin.loaitin.sua',['loaitin' => $loaitin,'theloai' => $theloai]);

    }
    public function postSua(Request $request,$id){
    		
    	$this -> validate($request,
            [
                'txtTen'  => 'required|min:3|max:100|unique:Loaitin,Ten',
                'TheLoai' => 'required'
            ],
            [   
                'txtTen.required' => 'Bạn chưa nhập tên loại tin',
                'txtTen.unique' => 'Tên loại tin đã tồn tại',
                'txtTen.min'      => 'Tên loại tin phải có độ dài từ 1 đến 100  kí tự',
                'txtTen.max'      => 'Tên loại tin phải có độ dài từ 1 đến 100  kí tự',
                'TheLoai.required'=> 'Bạn chưa chọn thể loại'
            ]);
        $loaitin = Loaitin::find($id);
        $loaitin -> Ten = $request -> txtTen;
        $loaitin -> TenKhongDau = changeTitle($request -> txtTen);
        $loaitin -> idTheLoai   = $request -> TheLoai;
        $loaitin -> save();

        return redirect('admin/loaitin/sua/'.$id) -> with('thongbao','bạn đã sữa thành công');
    }

    public function getXoa($id){
    	$loaitin = Loaitin::find($id);
        $loaitin -> delete();

        return redirect('admin/loaitin/danhsach') -> with('thongbao','Bạn đã xóa thành công');
    }
}

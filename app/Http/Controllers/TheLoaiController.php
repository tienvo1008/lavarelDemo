<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Theloai;

class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
    	$theloai = Theloai::all();
    	return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }
    public function getThem(){
    	return view('admin.theloai.them');
    }
    public function postThem(Request $request){

    	// echo $request -> Ten;
    	$this -> validate($request,
    		[
    			'txtTen' => 'required|min:3|max:100|unique:TheLoai,Ten'
    		],
    		[
    			'txtTen.required' => 'Bạn chưa nhập thể loại',
    			'txtTen.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
    			'txtTen.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
    			'Ten.unique' => 'Tên thể loại đã tồn tại',
    		]);
    	$theloai = new TheLoai;
    	$theloai -> Ten = $request -> txtTen;
    	$theloai -> TenKhongDau = changeTitle($request -> txtTen);
    	// echo changeTitle($request -> txtTen);
    	$theloai -> save();

    	return redirect('admin/theloai/them') -> with('thongbao',' Thêm thành công');

    }
    public function getSua($id){

    	$theloai = TheLoai::find($id);
    	return view('admin.theloai.sua',['theloai' => $theloai]);

    }
    public function postSua(Request $request,$id){
    	$theloai = TheLoai::find($id);
    	$this -> validate($request, 
    		[
    			'txtTen' => 'required|unique:TheLoai,Ten|min:3|max:100'
    		],
    		[
    			'Ten.required' => 'Bạn chưa nhập thể loại',
    			'Ten.unique' => 'Tên thể loại đã tồn tại',
    			'txtTen.min' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự',
    			'txtTen.max' => 'Tên thể loại phải có độ dài từ 3 đến 100 kí tự'
    		]);
    	
    	$theloai -> Ten = $request -> txtTen;
    	$theloai -> TenKhongDau = changeTitle($request -> Ten);
    	$theloai -> save();

    	return redirect('admin/theloai/sua/'.$id)-> with('thongbao','sữa thành công') ;
    	
    }

    public function getXoa($id){
    	$theloai = TheLoai::find($id);
    	$theloai -> delete();

    	return redirect('admin/theloai/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Slide;

class SlideController extends Controller
{
    //
    public function getDanhSach(){
    	$slide = Slide::all();
    	return view('admin.slide.danhsach',['slide' => $slide]);
    }
    public function getThem(){

    	return view('admin.slide.them');
    }
    public function postThem(Request $request){

    	$this -> validate($request,
    		[
    			'txtTen' => 'required',
    			'txtNoiDung' => 'required'
    		],
    		[
    			'txtTen.required' => 'Bạn chưa nhập tên',
    			'txtNoiDung.required' => 'Bạn chưa nhập nội dung'
    		]);
    	$slide = new Slide;
    	$slide -> Ten = $request -> txtTen;
    	$slide -> NoiDung = $request -> txtNoiDung;
    	if($request -> has('link'))
    		$slide -> link = $request -> link; 

    	if($request -> hasFile('Hinh'))
        {
            $file = $request -> file('Hinh');

            $duoi = $file -> getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jepg')
            {
                return redirect('admin/slide/them')->with('loi','Bạn chỉ chọn được file có đuôi jpg,png,jepg');
            }

            $name = $file -> getClientOriginalName();

            $Hinh = str_random(4) ."_" .$name;

            while (file_exists("upload/slide/".$Hinh)) {
              # code...
              $Hinh = str_random(4) ."_" .$name;
            }
            $file -> move("upload/slide",$Hinh);
            $slide -> Hinh = $Hinh;
          
        }
        else
        {
            $tintuc -> Hinh ="";
        }

        $slide -> save();

        return redirect('admin/slide/them')->with('thongbao','Thêm thành công');
    }

    public function getSua($id){
    	$slide = Slide::find($id);

    	return view('admin.slide.sua',['slide' => $slide]);
    }
    public function postSua(Request $request,$id){
    	$this -> validate($request,
    		[
    			'txtTen' => 'required',
    			'txtNoiDung' => 'required'
    		],
    		[
    			'txtTen.required' => 'Bạn chưa nhập tên',
    			'txtNoiDung.required' => 'Bạn chưa nhập nội dung'
    		]);
    	$slide =  Slide::find($id);
    	$slide -> Ten = $request -> txtTen;
    	$slide -> NoiDung = $request -> txtNoiDung;
    	if($request -> has('link'))
    		$slide -> link = $request -> link; 

    	if($request -> hasFile('Hinh'))
        {
            $file = $request -> file('Hinh');

            $duoi = $file -> getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jepg')
            {
                return redirect('admin/slide/them')->with('loi','Bạn chỉ chọn được file có đuôi jpg,png,jepg');
            }

            $name = $file -> getClientOriginalName();

            $Hinh = str_random(4) ."_" .$name;

            while (file_exists("upload/slide/".$Hinh)) {
              # code...
              $Hinh = str_random(4) ."_" .$name;
            }
            unlink("upload/slide/".$slide -> Hinh);
            $file -> move("upload/slide",$Hinh);
            $slide -> Hinh = $Hinh;
          
        }

        $slide -> save();

        return redirect('admin/slide/sua/'.$id) -> with('thongbao','Sữa thành công');
    }
}

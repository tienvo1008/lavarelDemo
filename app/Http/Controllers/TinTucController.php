<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TheLoai;

use App\LoaiTin;

use App\TinTuc;

use App\Comment;

class TinTucController extends Controller
{
    //
    public function getDanhSach(){
    	$tintuc = TinTuc::orderBy('id','DESC') -> get( );
    	return view('admin.tintuc.danhsach',['tintuc' => $tintuc]);
    }
   public function getThem(){
   		$theloai = TheLoai::all();
   		$loaitin = LoaiTin::all();
    	return view('admin.tintuc.them',['theloai' => $theloai,'loaitin' => $loaitin]);
    }
    public function postThem(Request $request){
        $this -> validate($request,
          [
            'LoaiTin' => 'required',
            'txtTieuDe'  => 'required|min:3|unique:TinTuc,TieuDe', 
            'txtTomTat' => 'required',
            'txtNoiDung' => 'required'
          ]
          ,
          [
            'LoaiTin.required' => 'Bạn chưa nhập loại tin',
            'txtTieuDe.required'  => 'Bạn chưa nhập tiêu đề',
            'txtTieuDe.min'       => 'Tiêu đề phải ít nhất 3 kí tự',
            'txtTieuDe.unique'    => 'Tiêu đề đã tồn tại',
            'txtTomTat.required'           => 'Bạn chưa nhập tóm tắt',
            'txtNoiDung.required'          => 'Bạn chưa nhập nội dung'
          ]);
        $tintuc = new TinTuc;
        $tintuc -> TieuDe = $request -> txtTieuDe;
        $tintuc -> TieuDeKhongDau = changeTitle($request -> txtTieuDe);
        $tintuc -> idLoaiTin = $request -> LoaiTin;
        $tintuc -> TomTat = $request -> txtTomTat;
        $tintuc -> NoiDung = $request -> txtNoiDung;
        $tintuc -> SoLuotXem = 0;

        if($request -> hasFile('Hinh'))
        {
            $file = $request -> file('Hinh');

            $duoi = $file -> getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jepg')
            {
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ chọn được file có đuôi jpg,png,jepg');
            }

            $name = $file -> getClientOriginalName();

            $Hinh = str_random(4) ."_" .$name;

            while (file_exists("upload/tintuc/".$Hinh)) {
              # code...
              $Hinh = str_random(4) ."_" .$name;
            }
            $file -> move("upload/tintuc",$Hinh);
            $tintuc -> Hinh = $Hinh;
          
        }
        else
        {
            $tintuc -> Hinh ="";
        }

        //
        $tintuc -> save();

        return redirect('admin/tintuc/them')->with('thongbao','Thêm tin thành công');
    }

    public function getSua($id){
      $tintuc = TinTuc::find($id);
      $theloai = TheLoai::all();
      $loaitin = LoaiTin::all();
      
      return view('admin.tintuc.sua',['tintuc' => $tintuc,'theloai' => $theloai,'loaitin' => $loaitin]);
    }
    public function postSua(Request $request,$id){

        $tintuc = TinTuc::find($id);
        $this -> validate($request,
          [
            'LoaiTin' => 'required',
            'txtTieuDe'  => 'required|min:3|unique:TinTuc,TieuDe', 
            'txtTomTat' => 'required',
            'txtNoiDung' => 'required'
          ]
          ,
          [
            'LoaiTin.required' => 'Bạn chưa nhập loại tin',
            'txtTieuDe.required'  => 'Bạn chưa nhập tiêu đề',
            'txtTieuDe.min'       => 'Tiêu đề phải ít nhất 3 kí tự',
            'txtTieuDe.unique'    => 'Tiêu đề đã tồn tại',
            'txtTomTat.required'           => 'Bạn chưa nhập tóm tắt',
            'txtNoiDung.required'          => 'Bạn chưa nhập nội dung'
          ]);

        $tintuc -> TieuDe = $request -> txtTieuDe;
        $tintuc -> TieuDeKhongDau = changeTitle($request -> txtTieuDe);
        $tintuc -> idLoaiTin = $request -> LoaiTin;
        $tintuc -> TomTat = $request -> txtTomTat;
        $tintuc -> NoiDung = $request -> txtNoiDung;
     

        if($request -> hasFile('Hinh'))
        {
            $file = $request -> file('Hinh');

            $duoi = $file -> getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jepg')
            {
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ chọn được file có đuôi jpg,png,jepg');
            }

            $name = $file -> getClientOriginalName();

            $Hinh = str_random(4) ."_" .$name;

            while (file_exists("upload/tintuc/".$Hinh)) {
              # code...
              $Hinh = str_random(4) ."_" .$name;
            }

            unlink("upload/tintuc/".$tintuc -> Hinh);

            $file -> move("upload/tintuc",$Hinh);
            $tintuc -> Hinh = $Hinh;
          
        }
    
        //
        $tintuc -> save();


        return redirect('admin/tintuc/sua/'.$id) -> with('thongbao','Sữa thành công');

    }

     public function getXoa($id){
      $tintuc = TinTuc::find($id);
      $tintuc -> delete();

      return redirect('admin/tintuc/danhsach')->with('thongbao','Bạn đã xóa thành công');
    }
}

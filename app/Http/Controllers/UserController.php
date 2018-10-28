<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

class UserController extends Controller
{
    //
    public function getDanhSach(){
    	$user = User::all();
    	return view('admin.user.danhsach',['user' => $user]);
    }
    public function getThem(){
    	return view('admin.user.them');
    }
    public function postThem(Request $request){
    	 $this -> validate($request,
    	 	[
    	 		'txtName' => 'required|min:3',
    	 		'txtEmail' => 'required|email|unique:users,email',
    	 		'txtPassword' => 'required|min:3|max:32',
    	 		'txtPasswordAgain' => 'required|same:txtPassword'
    	 	],
    	 	[
    	 		'txtName.required' => 'Bạn chưa nhập tên người dùng',
    	 		'txtName.min' => 'Tên người dùng ít nhất 3 kí tự',
    	 		'txtEmail.required' => 'Bạn chưa nhập Email',
    	 		'txtEmail.email' => 'Bạn chưa nhập đúng định dạng email',
    	 		'txtEmail.unique' => 'Email đã tồn tại',
    	 		'txtPassword.required' => 'Bạn chưa nhập mật khẩu',
    	 		'txtPassword.min' => 'Mật khẩu phải có ít nhất 3 kí tự',
    	 		'txtPassword.max' => 'Mật khẩu phải tối đa 32 kí tự',
    	 		'txtPasswordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
    	 		'txtPasswordAgain.same'  => 'Mật khẩu nhập lại không khớp'
    	 	]);
    	 $user = new User;
    	 $user -> name = $request -> txtName;
    	 $user -> email = $request -> txtEmail;
    	 $user -> password = bcrypt($request -> txtPassword);
    	 $user -> quyen = $request -> quyen;

    	 $user -> save();

    	 return redirect('admin/user/them') -> with('thongbao','Thêm thành công');
    }

    public function getSua($id){
    	$user = User::find($id);
    	return view('admin.user.sua',['user' => $user]);
    }
    public function postSua(Request $request,$id){
    	$this -> validate($request,
    	 	[
    	 		'txtName' => 'required|min:3'
    	 		
    	 		
    	 	],
    	 	[
    	 		'txtName.required' => 'Bạn chưa nhập tên người dùng',
    	 		'txtName.min' => 'Tên người dùng ít nhất 3 kí tự',
    	 		
    	 	]);
    	 $user = User::find($id);
    	 $user -> name = $request -> txtName;
    	 $user -> email = $request -> txtEmail;
    	 $user -> quyen = $request -> quyen;
    	
    	 if($request -> changePassword == "on"){
    	 	$this -> validate($request,
    	 	[
    	 		
    	 		'txtPassword' => 'required|min:3|max:32',
    	 		'txtPasswordAgain' => 'required|same:txtPassword'
    	 	],
    	 	[
    	 		'txtPassword.required' => 'Bạn chưa nhập mật khẩu',
    	 		'txtPassword.min' => 'Mật khẩu phải có ít nhất 3 kí tự',
    	 		'txtPassword.max' => 'Mật khẩu phải tối đa 32 kí tự',
    	 		'txtPasswordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
    	 		'txtPasswordAgain.same'  => 'Mật khẩu nhập lại không khớp'
    	 	]);
    	  $user -> password = bcrypt($request -> txtPassword);
    	}

    	 $user -> save();

    	 return redirect('admin/user/sua/'.$id) -> with('thongbao','Sữa thành công');
    }
    public function getXoa($id){
    	$user = User::find($id);
    	$user -> delete();

    	return redirect('admin/user/danhsach')->with('thongbao','Bạn đã xóa người dùng thành công');
    }

    public function getdangnhapAdmin(){
    	return view('admin.login');
    }
    public function postdangnhapAdmin(Request $request){
    	$this -> validate($request,
    		[
    			'email' => 'required',
    			'password' => 'required|min:3|max:32'
    		],
    		[
    			'email.required' => 'Bạn chưa nhập email',
    			'password.required' => 'Bạn chưa nhập password',
    			'password.min'    => 'Password không được nhỏ hơn 3 kí tự',
    			'password.max' => 'password không lớn hơn 32 kí tự'
    		]);

    	if(Auth::attempt(['email' => $request -> email,'password' => $request -> password])){
    		return redirect('admin/theloai/danhsach');
    	}
    	else{
    		return redirect('admin/dangnhap') -> with('thongbao','Đănh nhập không thành công');
    	}
    }
    public function getdangxuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}

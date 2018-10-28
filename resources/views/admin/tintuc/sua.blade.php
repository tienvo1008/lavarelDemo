@extends('admin.layout.index')
@section('content')
  <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin Tức
                            <small>{{$tintuc -> TieuDe}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                         @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach($errors -> all() as $err)
                                {{$err}}<br>
                            @endforeach
                        </div>
                        @endif

                        @if(session('thongbao'))
                            <div class="alert alert-success" >
                                {{session('thongbao')}}
                            </div>
                        @endif
                        <form action="admin/tintuc/sua/{{$tintuc -> id}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label>Thể loại</label>
                                <select class="form-control" name="TheLoai" id="TheLoai">
                                    @foreach($theloai as $tl)
                                    <option
                                        @if($tintuc -> loaitin -> theloai -> id == $tl -> id )
                                        {{"selected"}}
                                        @endif
                                     value="{{ $tl -> id }}">{{ $tl -> Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loại tin</label>
                                <select class="form-control" name="LoaiTin" id="LoaiTin">
                                    @foreach($loaitin as $lt)
                                    <option 

                                        @if($tintuc -> loaitin -> id == $tl -> id )
                                        {{"selected"}}
                                        @endif

                                    value="{{ $lt -> id }}">{{ $lt -> Ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input class="form-control" name="txtTieuDe" placeholder="Nhập tiêu đề" value="{{$tintuc -> TieuDe}}" />
                            </div>
                            <div class="form-group">
                                <label>Tóm tắt</label>
                                <textarea class="form-control ckeditor" rows="3" id="demo" name="txtTomTat" placeholder="Nhập tóm tắt">{{$tintuc -> TomTat}}</textarea> 
                            </div>
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea class="form-control ckeditor" rows="5" id="demo" name="txtNoiDung" placeholder="Nhập nội dung">{{$tintuc -> NoiDung}}</textarea> 
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <p>
                                <img width="400px" src="upload/tintuc/{{$tintuc -> Hinh}}">
                                </p>
                                <input type="file" name="Hinh" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Nổi bật</label>
                                <label class="radio-inline">
                                    <input name="rdoNoiBat" value="0"
                                    @if($tintuc -> NoiBat == 0)
                                        {{"checked"}}
                                    @endif
                                    type="radio">Không
                                </label>
                                <label class="radio-inline">
                                    <input name="rdoNoiBat" value="1"
                                     @if($tintuc -> NoiBat == 1)
                                        {{"checked"}}
                                    @endif
                                     type="radio">có
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Sữa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Bình luận
                            <small>Danh sách</small>
                        </h1>
                    </div>
                     @if(session('thongbao'))

                            <div class="alert alert-success" >
                                {{session('thongbao')}}
                            </div>
                        
                    @endif
                    <!-- /.col-lg-12 -->
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Người dùng</th>
                                <th>Ngày đăng</th>
                               
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tintuc -> comment as $cm)
                            <tr class="odd gradeX" align="center">
                                <td>{{ $cm -> id }}</td>
                                <td>{{ $cm -> user -> name }}</td>
                                <td>{{ $cm -> NoiDung }}</td>
                                <td>{{ $cm -> created_at }}</td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{ $cm -> id }}/{{$tintuc -> id}}"> Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end -row -comment -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->



@endsection 

@section('script')
    <script>
        $(document).ready(function(){
            $("#TheLoai").change(function(){
                var idTheLoai = $(this).val();
                $.get("admin/ajax/loaitin/" +idTheLoai,function(data){
                    // alert(data);
                    $("#LoaiTin").html(data);
                });
            });
        });
    </script>
@endsection
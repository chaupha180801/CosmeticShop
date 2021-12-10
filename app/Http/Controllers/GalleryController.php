<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\GalleryModel;
session_start();

class GalleryController extends Controller
{
    public function add_gallery($id){
        $pro_id = $id;
        return view('gallery_admin.add_gallery')->with(compact('pro_id'));
    }

    public function saveImage($image){
        $path = 'public/backEnd/images';
        $image_name = $image->getClientOriginalName();
        $image_name = current(explode('.', $image_name));
        $new_image_name = $image_name.rand(0,99).'.'.$image->getClientOriginalExtension();
        $image->move($path, $new_image_name);
        return $new_image_name;
    }

    public function insert_gallery(Request $request, $id){
        $get_image = $request->file('file');
        if($get_image){
            foreach($get_image as $key => $image){
                $path = 'public/backEnd/images';
                $image_name = $image->getClientOriginalName();
                $image_name = current(explode('.', $image_name));
                $new_image_name = $image_name.rand(0,99).'.'.$image->getClientOriginalExtension();
                $image->move($path, $new_image_name);
                $gallery = new GalleryModel();
                $gallery->gallery_name =  $new_image_name;
                $gallery->gallery_img =  $new_image_name;
                $gallery->product_id = $id;
                $gallery->save();
            }
        }
        Session::put('message','Thêm thư viện thành công');
        return redirect()->back();
    }

    public function select_gallery(Request $request){
       $product_id = $request->pro_id;
       $gallery = DB::table('tbl_gallery')->where('product_id', $product_id)->get();
       $gallery_count = $gallery->count();
       $output = '<form>
                '.csrf_field().'
                <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Tên hình</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
       ';
        if($gallery_count > 0){
            $i = 0;
            foreach($gallery as $key => $gal){
                $i++;
                $output.='
                    <tr>
                        <td>'.$i.'</td>
                        <td contenteditable class="edit_gallery_name" data-gal_id="'.$gal->gallery_id.'">'.$gal->gallery_name.'</td>
                        <td>
                            <img src="'.url('public/backEnd/images/'.$gal->gallery_img).'" height="100" width="100">
                            <input type="file" class="file_imgae"  data-gal_id="'.$gal->gallery_id.'" id="file-'.$gal->gallery_id.'" name="files" accept="imgae/*" style="width:40%" />
                        </td>
                        <td>
                            <button type="button" data-gal_id = "'.$gal->gallery_id.'" class="btn btn-danger delete-gal">Xóa</button>
                        </td>
                    </tr>              
                ';
            }
        }else{
            $output.='
                    <tr>
                        <td colspan="4">Sản phẩm chưa có thư viện ảnh</td>                      
                    </tr>                 
                ';
        }
        
        $output.='                  
                    </tbody>
                    </table>
                    <form>
                ';
        
        echo $output;
       
    }

    public function update_gallery_name(Request $request){
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = GalleryModel::find($gal_id);
        $gallery->gallery_name = $gal_text;
        $gallery->save();
    }

    public function delete_gallery(Request $request){
        $gal_id = $request->gal_id;
        $gallery = GalleryModel::find($gal_id);
        unlink('public/backEnd/images/'.$gallery->gallery_img);
        $gallery->delete();
    }

    public function update_gallery(Request $request){
        $get_image = $request->file('file');
        $gal_id = $request->gal_id;
        if($get_image){
                $path = 'public/backEnd/images';
                $image_name = $get_image->getClientOriginalName();
                $image_name = current(explode('.', $image_name));
                $new_image_name = $image_name.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image_name);
                $gallery = GalleryModel::find($gal_id);
                unlink('public/backEnd/images/'.$gallery->gallery_img);
                $gallery->gallery_img =  $new_image_name;
                $gallery->save();
            }
        }
    
}

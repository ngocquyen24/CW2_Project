<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Services\Slider\SliderService;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }

    public function create()
    {
        return view('admin.slider.add', [
           'title' => 'Thêm SLider mới'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        // $this->slider->insert($request);

        try {
            $slides = new Slider();
            $slides->name = (string)$request->input('name');
            $slides->url = (string)$request->input('url');

            $slides->sort_by = (int)$request->input('sort_by');


            $slides->active = (string)$request->input('active');
            if ($request->hasFile('thumb')){
                $file = $request->file('thumb');
                $ext = $file->getClientOriginalExtension();
                $filename= time().'.'.$ext;
                $file->move('thumb',$filename);
                $slides->thumb = $filename;

            }



            $slides->save();

            Session::flash('success', 'Thêm slides thành công');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            Log::info($err->getMessage());
            return  false;
        }

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.slider.list', [
            'title' => 'Danh Sách Slider Mới Nhất',
            'sliders' => $this->slider->get()
        ]);
    }

    public function show(Slider $slider)
    {
        return view('admin.slider.edit', [
            'title' => 'Chỉnh Sửa Slider',
            'slider' => $slider
        ]);
    }

    public function update(Request $request, Slider $slider)
    {
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $result = $this->slider->update($request, $slider);
        if ($result) {
            return redirect('/admin/sliders/list');
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->slider->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công Slider'
            ]);
        }

        return response()->json([ 'error' => true ]);
    }
}

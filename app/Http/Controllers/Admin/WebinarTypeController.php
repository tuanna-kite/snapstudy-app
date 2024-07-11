<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebinarType;
use Illuminate\Http\Request;

class WebinarTypeController extends Controller
{

    public function index()
    {
        $types = WebinarType::all();

        $data = [
            'pageTitle' => trans('admin/pages/roles.page_lists_title'),
            'types' => $types,
        ];

        return view('admin.webinar_type.lists', $data);
    }


    public function create()
    {
        $data = [
            'pageTitle' => trans('admin/main.role_new_page_title'),
        ];

        return view('admin.webinar_type.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:64',
            'price' => 'required',
        ]);
        $data = $request->all();


        return redirect(route('webinar.type'));
    }

    public function edit($id)
    {
        $type = WebinarType::find($id);

        $data = [
            'pageTitle' => trans('/admin/main.edit'),
            'type' => $type,
        ];

        return view('admin.webinar_type.create', $data);
    }

    public function update($id, Request $request)
    {
        //
    }

    public function delete($id)
    {
        $type = WebinarType::find($id);
        $type->delete();
        return redirect(route('webinar.type'));
    }
}

<?php

namespace aaran\Website\Controller;

use aaran\Website\Models\ContactModel;
use BinaryTorch\LaRecipe\Http\Controllers\Controller;
use Illuminate\Http\Request;


class Contact extends Controller
{
    public function store_message(Request $request)
    {
        $contactModel=new ContactModel();
        $contactModel->name=$request->name;
        $contactModel->email=$request->email;
        $contactModel->phone=$request->phone;
        $contactModel->message=$request->message;
        $contactModel->save();

        return redirect()->back()->with('success', 'Your message has been sent!');
    }
}

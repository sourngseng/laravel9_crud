<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function index()
    {
        echo "Index controller";
    }

     public function getName()
    {
        echo "This is my Student Name";
    }

    public function contact(){
        $data['contacts']=array("Long Dara","Keo Thida","Song Nimal");
        // dd($data);

        return view('contact',$data);
    }
}

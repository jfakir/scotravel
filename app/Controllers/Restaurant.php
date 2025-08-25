<?php

namespace App\Controllers;

class Restaurant extends BaseController
{
    public function view()
    {
        return view('restaurants/view');
    }

    public function manage()
    {
        $data['travelers'] = session()->trip_users;
        $data['trip_id'] = session()->trip_id;

        return view('restaurants/manage',$data);
    }
}
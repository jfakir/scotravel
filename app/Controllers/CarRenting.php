<?php

namespace App\Controllers;

class CarRenting extends BaseController
{
    public function view()
    {
        return view('carrentings/view');
    }

    public function manage()
    {
        $data['travelers'] = session()->trip_users;
        $data['trip_id'] = session()->trip_id;

        return view('carrentings/manage',$data);
    }
}

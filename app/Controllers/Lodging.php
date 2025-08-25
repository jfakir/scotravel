<?php

namespace App\Controllers;

class Lodging extends BaseController
{
    public function view()
    {
        return view('lodgings/view');
    }

    public function manage()
    {
        $data['travelers'] = session()->trip_users;
        $data['trip_id'] = session()->trip_id;

        return view('lodgings/manage',$data);
    }
}

<?php

namespace App\Controllers;

class Transportation extends BaseController
{
    public function view()
    {
        return view('transportations/view');
    }

    public function manage()
    {
        $data['travelers'] = session()->trip_users;
        $data['trip_id'] = session()->trip_id;

        return view('transportations/manage',$data);
    }
}

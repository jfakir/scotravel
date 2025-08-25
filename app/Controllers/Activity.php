<?php

namespace App\Controllers;

class Activity extends BaseController
{
    public function view()
    {
        return view('activities/view');
    }

    public function manage()
    {
        $data['travelers'] = session()->trip_users;
        $data['trip_id'] = session()->trip_id;
        return view('activities/manage',$data);
    }
}

<?php

namespace App\Libraries;

class Notification
{
    public function notification($data)
    {
        return view('components/notification/notification',$data);
    }

    public function notificationSM()
    {
        return view('components/notification/notificationSM');
    }
}

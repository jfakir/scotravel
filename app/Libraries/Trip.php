<?php

namespace App\Libraries;

class Trip
{
    public function menuBar($data)
    {
        return view('components/trip/menu',$data);
    }

    public function banner($data)
    {
        return view('components/trip/banner',$data);
    }

    public function dashboardSwiperCard($data)
    {
        return view('components/trip/dashboardSwiperCard', $data);
    }

    public function dateSeparator($data)
    {
        return view('components/trip/dateSeparator', $data);
    }

    public function carRentingPlanTimeline($data)
    {
        return view('components/trip/carRentingPlanTimeline', $data);
    }
    public function activityPlanTimeline($data)
    {
        return view('components/trip/activityPlanTimeline', $data);
    }
    public function restaurantPlanTimeline($data)
    {
        return view('components/trip/restaurantPlanTimeline', $data);
    }
    public function flightPlanTimeline($data)
    {
        return view('components/trip/flightPlanTimeline', $data);
    }

    public function layoverSeparator($data)
    {
        return view('components/trip/layoverSeparator', $data);
    }

    public function lodgingPlanTimeline($data)
    {
        return view('components/trip/lodgingPlanTimeline', $data);
    }
    public function transportationPlanTimeline($data)
    {
        return view('components/trip/transportationPlanTimeline', $data);
    }
    public function note($data)
    {
        return view('components/trip/note', $data);
    }
}

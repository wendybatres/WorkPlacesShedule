<?php

namespace App\Http\Controllers;

use App\Models\workplacesshedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserWorkPlaceSchedule;
use App\Http\Controllers\workplacessheduleController;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(request $request)
    {


        $currentDate = Carbon::today();
        $daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $calendarWeeks = $this->getCalendarWeeks($currentDate);
        $users = User::all();

        return view('home')
            ->with('workplacesshedule', workplacesshedule::all())
            ->with('currentDate' , $currentDate)
            ->with('daysOfWeek' , $daysOfWeek)
            ->with('calendarWeeks' , $calendarWeeks)
            ->with('users' , $users)
            ->with('currentMonth' , $currentDate->format('F Y'))
            ->with('modalVisible' , false)
            ->with('mostrarError' , false)
            ->with('errorMessage' , '');
        
    }


    private function getCalendarWeeks($date)
    {
        $weeks = [];
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $currentDay = $startOfMonth->copy()->startOfWeek();

        while ($currentDay->isBefore($endOfMonth->copy()->endOfWeek())) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = $currentDay->copy();
                $currentDay->addDay();
            }
            $weeks[] = $week;
        }

        return $weeks;
    }
}

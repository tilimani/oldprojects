<?php

namespace App\Http\Controllers;

/*
* Notifications
*/
use App\Notifications\UserChangeDate;
use App\Notifications\ManagerChangeDate;
use App\Notifications\ChangeData as ChangeDate;


/*
* Models
*/
use App\BookingDate;
use App\Booking;
use App\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bookingdates.index', [
            'bookingDates' => BookingDate::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $bookingDate = New BookingDate();
            $bookingDate->user_date = $request->user_date;
            $bookingDate->manager_date = $request->manager_date;
            $bookingDate->vico_date = $request->vico_date;
            $bookingDate->validation = (isset($request->validation))? true:false;
            $bookingDate->booking_id = $request->booking_id;
            $bookingDate->save();
            DB::commit();
        }catch(Error $e) {} //posiblemente el id de booking no existe
        return redirect()->route('bookingdate.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookingDate  $bookingDate
     * @return \Illuminate\Http\Response
     */
    public function show(BookingDate $bookingDate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  booking_id id del booking a mostrar
     * @return \Illuminate\Http\Response
     */
    public function userEdit($booking_id)
    {
        $booking = Booking::find($booking_id);
        $user = User::findOrFail($booking->user_id);
        $house_id = $booking->room->house->id;

        $date_bool = true;

        // earliest day of move-out is today + required dates warning
        $days_needed = $booking->room->house->house_rules()
            ->where('rule_id', 4)->first()->description;
        $dates_required = Carbon::now()->addDays($days_needed);
        $date_of_salida = Carbon::parse($booking->date_to);
        if ($booking->bookingDate) {
            $user_date = $booking->bookingDate->user_date;
            $manager_date = $booking->bookingDate->manager_date;
            $vico_date = $booking->bookingDate->vico_date;
            if ($manager_date <> $booking->bookingDate->vico_date){
                $date_bool = false;
            }
        }
        else {
            $user_date = $booking->date_to;
            $manager_date = $user_date;
            $vico_date = $user_date;
            $bookingDate = new BookingDate();
            $bookingDate->booking_id = $booking->id;
            $booking->bookingDate = $bookingDate;
            $bookingDate->save();
        }



        return view('bookingdates.user_edit', compact('user', 'house_id','dates_required','date_of_salida', 'date_bool', 'manager_date', 'user_date', 'booking', 'days_needed'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  booking_id id del booking a mostrar
     * @return \Illuminate\Http\Response
     */
    public function managerEdit($booking_id)
    {
        $booking = Booking::find($booking_id);
        $user = User::findOrFail($booking->user_id);
        $house_id = $booking->room->house->id;

        // earliest day of move-out is today + required dates warning
        $date_bool = true;
        $dates_required = Carbon::now()
            ->addDays(30);
        $date_of_salida = Carbon::parse($booking->date_to);
        if ($booking->bookingDate) {
            $user_date = $booking->bookingDate->user_date;
            $manager_date = $booking->bookingDate->manager_date;
            $vico_date = $booking->bookingDate->vico_date;
            if ($manager_date <> $booking->bookingDate->vico_date){
                $date_bool = false;
            }
        } else {
            $user_date = $booking->date_to;
            $manager_date = $user_date;
            $vico_date = $user_date;
            $bookingDate = new BookingDate();
            $bookingDate->booking()->associate($booking);
            $booking->bookingDate = $bookingDate;
            $bookingDate->save();
        }

        return view(
            'bookingdates.manager_edit',
            compact(
                'user',
                'house_id',
                'dates_required',
                'date_of_salida',
                'date_bool',
                'manager_date',
                'vico_date',
                'user_date',
                'booking'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Cristian edit by Andres Cano <andresfe98@gmail.com>
     *
     */
    public function update(Request $request,$booking_date_id)
    {
        DB::beginTransaction();
        $bookingDate = BookingDate::find($booking_date_id);
        $bookingDate->user_date = $request->user_date;
        $bookingDate->manager_date = $request->manager_date;
        $bookingDate->vico_date = $request->vico_date;
        $bookingDate->validation = ($request->validation == 1)? true: false;
        $bookingDate->save();

        if ($bookingDate->validation) {
            $booking = Booking::find($bookingDate->booking_id);
            $booking->date_to = $bookingDate->vico_date;
            $booking->save();
            //Redirects to the booking
            // return redirect()->route('payments_admin', $booking->id);
        }
        DB::commit();
        //Middleware redirects  to the user's booking
        // return redirect()->route('payments_admin', 1);

        // rediect bookingDate index
        return redirect()->route('bookingdate.index');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function updateUser(Request $request, $booking_date_id)
    {
        // Get bookingDate
        $bookingDate = BookingDate::find($booking_date_id);

        // Get booking, manager, admin models and notify
        $booking = $bookingDate->booking;
        if($bookingDate->user_date != $request->user_date)
        {
            $manager = $booking->manager();
            $manager->notify(new UserChangeDate($booking));
            $admin = User::find(1);
            $admin->notify(new ChangeDate($booking,$is_user = true));
        }

        // Updating bookingDate
        $bookingDate->user_date = $request->user_date;

        $returnStatement = 'Cambio enviado. Estamos esperando la respuesta del dueño de la casa.';

        if ($bookingDate->user_date === $bookingDate->manager_date){

            $booking = Booking::find($bookingDate->booking_id);
            $booking->date_to = $bookingDate->vico_date;
            $booking->save();

            $bookingDate->vico_date = $bookingDate->user_date;
            $returnStatement = 'Cambio guardado.';
        }

        $bookingDate->save();

        return back()->with('message_sent', $returnStatement);
        #return redirect('/booking/admin/'.$bookingDate->Booking->User->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function updateManager(Request $request,$booking_date_id)
    {
        // Get bookingDate
        $bookingDate = BookingDate::find($booking_date_id);

        // Get booking, manager, admin models and notify
        $booking = $bookingDate->booking;
        if($bookingDate->manager_date != $request->manager_date)
        {
            $user = $booking->User;
            $user->notify(new ManagerChangeDate($booking, $request->manager_date));
            $admin = User::find(1);
            $admin->notify(new ChangeDate($booking,$is_user = true));
        }

        // Updating bookingDate
        $bookingDate->manager_date = $request->manager_date;

        $returnStatement = 'Cambio enviado. Estamos esperando la respuesta de '.$booking->user->name.".";

        if ($bookingDate->user_date === $bookingDate->manager_date){
            
            $booking = Booking::find($bookingDate->booking_id);
            $booking->date_to = $bookingDate->vico_date;
            $booking->save();

            $bookingDate->vico_date = $bookingDate->manager_date;
            $returnStatement = 'Cambio guardado.';
        }

        $bookingDate->save();


        return back()->with('message_sent', $returnStatement);
        #return redirect('/booking/show/'.$bookingDate->booking_id);

    }
    /**
     * Update the validation column.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Cristian
     */
    public function validation(Request $request)
    {
        $bookingDate = BookingDate::find($request->booking_date_id);
        $bookingDate->validation = ($request->validation == 1)? true: false;
        $bookingDate->save();
        return redirect()->route('bookingdate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingDate  $bookingDate
     * @return \Illuminate\Http\Response
     */
    public function destroy($booking_date_id)
    {
        BookingDate::find($booking_date_id)->delete();
        return redirect()->route('bookingdate.index');

    }
}

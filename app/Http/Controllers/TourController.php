<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\tour;
use App\tour_date;
use App\booking;
use DB;

class TourController extends Controller
{
    public function index(){
            //grab all tour information 
            $tours = tour::all();        
            return view('Tour.index', compact('tours'));
    }

    public function edit($id){
        //fetch tour according to id
        $tour = tour::whereKey($id)->get();
        $dates = tour_date::where('tour_id', '=', $id)->get();
        return view('Tour.edit')->with(compact('tour', 'dates'));
    }

    public function viewBooking(){
        //booking id, tour name, tour date, number of passengers, actions
        $bookings = booking::all(); //it includes booking id and tour_date which will be used when rendering page

        //get tour name
        $tourNames = [];
        $numberOfPassengers = [];
        for($i = 0; $i < sizeof($bookings); $i++) {
            array_push($tourNames,(DB::table('tours')->where('id', '=', $bookings[$i]->tour_id)->first()->name));
            //number of passengers
            array_push($numberOfPassengers, DB::table('booking_paseengers')
                ->select(DB::raw('count(*) as numberPassenger'))
                ->where('booking_id', '=', $bookings[$i]->id)->first()->numberPassenger);
        }

        return view('Tour.viewbooking')->with(compact('bookings', 'tourNames', 'numberOfPassengers'));
    }

    public function bookingEdit($id){
        //bookingid -> $id
        //get tour name
        $tourName = DB::select("select name from tours where id in (select tour_id from bookings where id = ?)", [$id])[0];

        //get tour date and status -> grab booking
        $booking = DB::table('bookings')->where('id', '=', $id)->first();

        //get tour_dates for options
        $tourDates = DB::table('tour_dates')->where('tour_id', '=', $booking->tour_id)->get();

        //get passengers
        $passenger =  DB::select("select * from passengers where id in (select passenger_id from booking_paseengers where booking_id = ?)", [$id]);

        //special requests
        $specialRequests = DB::select('select special_request from booking_paseengers where booking_id = ?', [$id]);

       // dd($specialRequests);
//        dd($passenger);
//       dd($tourDates);
//        dd($booking);
     //   dd($tourName);

        return view('Tour.bookingedit')->with(compact('tourName', 'booking', 'tourDates', 'passenger', 'specialRequests'));
    }

    public function bookSave($id, Request $request){
        //bookings table
        $bookingId = DB::table('bookings')->insertGetId([
            'tour_id' => $id,
            'tour_date' => $request->tourdate,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        //passengers and booking_passengers table

        for($i = 0; $i < sizeof($request->givenname); $i++) {
            $passengerId = DB::table('passengers')->insertGetId([
                'given_name' => $request->givenname[$i],
                'surname' => $request->surname[$i],
                'email' => $request->email[$i],
                'mobile' => $request->mobile[$i],
                'passport' => $request->passport[$i],
                'birth_date' => $request->dateofbirth[$i],
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('booking_paseengers')->insert([
                'booking_id' => $bookingId,
                'passenger_id' => $passengerId,
                'special_request' => $request->specialrequest[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        return redirect('/tour');
    }

    public function saveEdit($id, Request $request) {
       // dd($request);
        //validate input
        $this->validate($request, [
            'name' => 'required',
            'itinerary' => 'required',
            'dates.*' => 'required'
        ]);

        //dd($request);

        //update tour
        DB::table('tours')->where('name', $request->name)->update([
            'itinerary' => $request->itinerary
        ]);

        //update tour_dates
        foreach($request->originalDates as $key => $originalDates) {
            DB::table('tour_dates')->where(function($query) use ($id, $originalDates){
                $query->where('tour_id', '=', $id)
                ->where('date', '=', $originalDates);
            })->update([
                'date' => $request->dates[$key],
                'status' => ($request->statusInput[$key] == "Enable")? 1 : 0,
                'updated_at' => Carbon::now()
            ]);
        }

        //insert new dates if there have
        for($i = sizeof($request->originalDates); $i < sizeof($request->dates); $i++) {
            DB::table('tour_dates')->insert([
                'tour_id' => $id,
                'date' => $request->dates[$i],
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return redirect('/tour');
    }

    public function book($id) {
        //fetch tour name
        $tour = tour::whereKey($id)->first();

        //fetch tour dates
        //$dates = DB::table('tour_dates')->where('tour_id', '=', $id)->get();
        $dates = DB::table('tour_dates')->where('tour_id', '=', $id)
            ->where('status', '=', 1)->get();

        //show view with data
        return view('Tour.book')->with(compact('tour', 'dates'));
    }

    public function saveBookingEdit($id, Request $request) {
        //dd($request);

        //update booking tour_date and status
        if($request->status == "Submitted")
            $status = 1;
        else
            $status = 0;
        DB::table('bookings')->where('id', '=', $id)->update([
            'tour_date' => $request->tourdate,
            'status' => $status
        ]);

        //readyToDelete readyToUpdate
        if($request->readyToDelete) {
            foreach($deletedElement as $deletedId) {
                DB::table('booking_paseengers')->where('booking_id', '=', $id)
                    ->where('passenger_id', '=', $deletedId)->delete();
            }
        }
        //readyToUpdate and insert new passengers
        for($i = 0; $i < sizeof($request->givenname); $i++) {
            //update exist passenger(s)
            if($i < sizeof($request->readyToUpdate)){
                DB::table('passengers')->where('id', '=', $request->readyToUpdate[$i])->update([
                    'given_name' => $request->givenname[$i],
                    'surname' => $request->surname[$i],
                    'email' => $request->email[$i],
                    'mobile' => $request->mobile[$i],
                    'passport' => $request->passport[$i],
                    'birth_date' => $request->dateofbirth[$i],
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);
                //update special request
                DB::table('booking_paseengers')->where('booking_id', '=', $id)
                    ->where('passenger_id', '=', $request->readyToUpdate[$i])->update([
                        'special_request' => $request->specialrequest[$i]
                    ]);
            }else{
                //insert new passenger(s)
                $insertId = DB::table('passengers')->insertGetId([
                    'given_name' => $request->givenname[$i],
                    'surname' => $request->surname[$i],
                    'email' => $request->email[$i],
                    'mobile' => $request->mobile[$i],
                    'passport' => $request->passport[$i],
                    'birth_date' => $request->dateofbirth[$i],
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                DB::table('booking_paseengers')->where('booking_id', '=',  $id)
                    ->insert([
                        'booking_id' => $id,
                        'passenger_id' => $insertId,
                        'special_request' => $request->specialrequest[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

            }
        }

        return redirect('/tour');
    }

    public function create($id = null, Request $request){ 
        if($request->method() === 'POST') {
            $this->validate(request(),[
                'name' => 'required|unique:tours,name',
                'itinerary' => 'required',
                'dates.*' => 'required',
            ]);
            //insert data to tours
            $insertId = DB::table("tours")->insertGetId([
                "name" => $request->name,
                "itinerary" => $request->itinerary,
                "status" => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            //insert data to dates
            foreach($request->dates as $date) {
                DB::table("tour_dates")->insert([
                    "tour_id" => $insertId,
                    "date" => $date,
                    "status" => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            return redirect('/tour');
        }else{
            if($id != null) 
                var_dump($id);
            return view('Tour.create');
        }
    }
}

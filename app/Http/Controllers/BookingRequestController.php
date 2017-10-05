<?php

namespace App\Http\Controllers;

use App\BookingPayment;
use App\BookingRequest;
use App\ExperienceResources;
use Illuminate\Http\Request;
use App\Experience;
use Carbon\Carbon;
use App\Messenger\Models\Message;
use App\Messenger\Models\Participant;
use App\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;
use Illuminate\Support\Facades\View;
use Stripe\Stripe;
use Stripe\Charge;

class BookingRequestController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function requests()
    {
        // All threads, ignore deleted/archived participants
        //$threads = Thread::getAllLatest()->get();

        // All threads that user is participating in
         $threads = Thread::forUser(Auth::id())->get();
        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        return view('booking.requests', compact('threads'));
    }

    public function calculate(Request $request){
        $all = $request->get("booking");
        $oExp = Experience::find($all["experience_id"]);
        $adults = isset($all["adults"]) ? $all["adults"] : 0;
        $children = isset($all["children"]) ? $all["children"] : 0;
        $extras = isset($all["extras"]) ? $all["extras"] : [];
        $calculated = $oExp->calculate_price($adults,$children,$extras);
        $ret = [];
        $ret["price"] = "€".($calculated["adults_price"]+$calculated["children_price"]+$calculated["extras_price"]);
        echo json_encode($ret);
    }

    public function create(Request $request){
        $all = $request->get('booking');
        $oExp = Experience::find($all["experience_id"]);
        $oUser = Auth::user();

        if(!$oExp) return;

        $sku = $oExp->getAttribute("sku");
        $number_adults = 0;
        $price_adults = 0;

        if(isset($all["adults"])){
            $number_adults = $all["adults"];
            $price_adults = $oExp->calculate_price($number_adults)["adults_price"];
        }

        $number_children = 0;
        $price_children = 0;

        if(isset($all["children"])){
            $number_children = $all["children"];
            $price_children = $oExp->calculate_price(0,$number_children)["children_price"];
        }


        $aDate = explode(",",$all["date_pref"]);
        $dates = json_encode($aDate);

        $extras = json_encode([]);
        $price_extras = 0;
        if(isset($all["extras"])){
            $extras = json_encode($all["extras"]);
            foreach($all["extras"] as $res){
                $oRes = ExperienceResources::find($res);
                $price_extras += $oRes->cost;
            }
        }

        $transportation = 0;
        $accommodation = 0;



        $oBooking = BookingRequest::create([
            "user_id" => $oUser->id,
            "sku" => $sku,
            "number_adults" => $number_adults,
            "number_children" => $number_children,
            "dates" => $dates,
            "extras" => $extras,
            "transportation"  => $transportation,
            "accommodation" => $accommodation,
            "price_adults" => $price_adults,
            "price_children" => $price_children,
            "price_extras" => $price_extras,
            "accepted" => 0,
            "closed" => 0
        ]);

        if(!$oBooking){
            redirect("/experiences")->with("message","Failed");
        }
        $thread = Thread::create(
            [
                'booking_request' => $oBooking->id,
            ]
        );

        $message = isset($all["message"]) ? $all["message"] : "";

        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => $oUser->id,
                'body'      => $message
            ]
        );

        // Sender
        Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => $oUser->id,
                'last_read' => new Carbon,
            ]
        );

        $aRecipients =[];
        $admins = $oExp->admin(true);
        foreach($admins as $admin){
            $aRecipients[] = $admin->id;
        }

        // Recipients
        $thread->addParticipant($aRecipients);

        return redirect(route('booking'));

    }

    /**
     * Shows a message thread with booking.
     *
     * @param $id
     * @return mixed
     */
    public function thread($id,Request $request)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect(route('booking'));
        }

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = Auth::user()->id;
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        $thread->markAsRead($userId);

        $oBooking = $thread->booking_request();
        if($oBooking->closed){
            Session::flash('error', "This booking has been closed");
            return redirect()->route('booking')->with('success','Payment Successful');
        }
        $latest = $thread->getLatestMessageAttribute()->id;

        $request->session()->put('oBooking',$oBooking);

        return view('booking.show', compact('thread', 'users','oBooking','latest'));
    }

    /**
     * Shows a message thread only.
     *
     * @param $id
     * @return mixed
     */
    public function messages($id,Request $request)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect(route('booking'));
        }

        //dd($request->get("booking"));

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = Auth::user()->id;
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        $thread->markAsRead($userId);
        $thread->booking_request()->toArray();
        $reload = false;
        if($thread->booking_request()->toArray() != $request->get("booking")){
            $reload = true;
        }
        $messages= $thread->messages;
        $latest = $thread->getLatestMessageAttribute()->id;

        $view = View::make('booking.partials.messages', compact('messages', 'users','latest'));


        $ret = [
            "view" => $view->render(),
            "reload"    => $reload
        ];


        return json_encode($ret);
    }



    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update_messaging($id,Request $request)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect('bookingrequest');
        }

        $thread->activateAllParticipants();
        $thread->updated_at = new Carbon;
        $thread->save();


        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::id(),
                'body'      => ($request->get('message')),
            ]
        );

        // Add replier as a participant
        $participant = Participant::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
            ]
        );
        $participant->last_read = new Carbon;
        $participant->save();

        //return redirect('bookingrequest/' . $id);
        $messages= $thread->messages;
        $latest = $thread->getLatestMessageAttribute()->id;

        return view('booking.partials.messages', compact('messages','latest'));
    }

    /**
     * Edits booking on current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update_booking(Request $request)
    {
        $all = $request->get("booking");
        $oBooking = BookingRequest::find($all["booking_id"]);

        $oExp = $oBooking->experience();

        $number_adults = 0;
        $price_adults = 0;

        if(isset($all["adults"])){
            $number_adults = $all["adults"];
            $price_adults = $oExp->calculate_price($number_adults)["adults_price"];
        }

        $number_children = 0;
        $price_children = 0;

        if(isset($all["children"])){
            $number_children = $all["children"];
            $price_children = $oExp->calculate_price(0,$number_children)["children_price"];
        }

        $aDate = explode(",",$all["date_pref"]);
        $dates = json_encode($aDate);

        $extras = json_encode([]);

        $extras_price = 0;
        if(isset($all["extras"])){
            $extras = json_encode($all["extras"]);
            foreach($all["extras"] as $res){
                $oRes = ExperienceResources::find($res);
                $extras_price += $oRes->cost;
            }
        }

        $transportation = 0;
        $accommodation = 0;

        $oBooking->price_adults = $price_adults;
        $oBooking->price_children = $price_children;
        $oBooking->price_extras = $extras_price;
        $oBooking->transportation = $transportation;
        $oBooking->accommodation = $accommodation;
        $oBooking->number_adults = $number_adults;
        $oBooking->number_children = $number_children;
        $oBooking->dates = $dates;
        $oBooking->extras = $extras;
        $oBooking->save();

        if (array_key_exists("accept_booking", $request->all())) {
            $oBooking->accept();
        }else{
            $oBooking->deaccept();
        }

        return redirect('bookingrequest/' . $oBooking->id);

    }

    public function payment(Request $request){

        if(!$request->session()->has('oBooking')){
            return redirect()->route('booking');
        }

        $oBooking = $request->session()->get('oBooking');


        $oBooking = BookingRequest::find($oBooking->id);

        $request->session()->forget('oBooking');


        $oExp = $oBooking->experience();

        if(!$oBooking->accepted){
            return redirect('/bookingrequest/'.$oBooking->id)->with('error','The booking request has been changed. Payment failed. You have not been charged');
        }

        if($oBooking->closed){
            return redirect('/bookingrequest/'.$oBooking->id)->with('error','This booking is closed. Payment failed. You have not been charged');
        }

        $api_key = config('services.stripe.secret');
        Stripe::setApiKey($api_key);

        try {
            $oCharge = Charge::create([
                'amount' => $oBooking->total()*100, // this is in cents (1 means 0.01cents)
                'currency' => 'eur',
                'card' => $request->get('reservation')["stripe_token"],
                'description' => $oExp->title
            ]);
                $oPayment = new BookingPayment();
                $oPayment->booking_id = $oBooking->id;
                $oPayment->name = $request->get('reservation')["name"];
                $oPayment->payment_id = $oCharge->id;
                $oPayment->amount = $oBooking->total();
                $oPayment->purchase_note = $oExp->purchase_note;
                $oPayment->serialized_booking = serialize($oBooking);
                Auth::user()->orders()->save($oPayment);
                $oBooking->close();
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect('/bookingrequest/'.$oBooking->id)->with('error',$e->getMessage());
        }
        Session::flash('success','Payment Successful');
        return redirect()->route('booking')->with('success','Payment Successful');
    }
}
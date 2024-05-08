<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\RecivedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function index()
    {
        RecivedMail::query()->update(['seen' => 1]);
        $messages = RecivedMail::all();
        return view('admin.contact-message.index', compact('messages'));
    }

    public function sendReply(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'max:255'],
            'message' => 'required',
        ]);


        try {
            $contact = Contact::where('language', 'pt')->first();

            /** Send Mail */
            Mail::to($request->email)->send(new ContactMail($request->subject, $request->message, $contact->email));

            $makeReplied = RecivedMail::query()->find($request->message_id);

            $makeReplied->replied = 1;
            $makeReplied->save();

            toast(__('Message Sent Successfully'), 'success');
        } catch (\Throwable $th) {
            toast(__($th->getMessage()), 'error');
        }

        return redirect()->back();
    }
}

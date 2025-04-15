<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReply;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $contacts = match($status) {
            'replied' => Contact::replied()->latest()->paginate(10),
            'not_replied' => Contact::notReplied()->latest()->paginate(10),
            default => Contact::latest()->paginate(10),
        };
        
        return view('admin.contacts.index', compact('contacts', 'status'));
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for replying to the contact.
     */
    public function replyForm(Contact $contact)
    {
        return view('admin.contacts.reply', compact('contact'));
    }

    /**
     * Send reply to the contact.
     */
    public function sendReply(Request $request, Contact $contact)
    {
        // Validate the request
        $request->validate([
            'subject' => 'required|string|max:255',
            'reply' => 'required|string',
        ]);

        try {
            // Send the email
            Mail::to($contact->email)->send(new ContactReply($contact, $request->subject, $request->reply));
            
            // Update contact status if mark_as_replied is checked
            if ($request->has('mark_as_replied')) {
                $contact->status = 1; // Marked as replied
                $contact->save();
                
                // Save reply to database if you have a replies table
                if (class_exists('App\Models\ContactReply')) {
                    $contactReply = new \App\Models\ContactReply();
                    $contactReply->contact_id = $contact->id;
                    $contactReply->subject = $request->subject;
                    $contactReply->message = $request->reply;
                    $contactReply->save();
                }
            }
            
            return redirect()->route('admin.contacts.show', $contact->id)
                ->with('success', 'Phản hồi đã được gửi thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể gửi phản hồi. Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the contact status.
     */
    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);
        
        $contact->update([
            'status' => $request->status
        ]);
        
        return redirect()->back()
            ->with('success', 'Contact status updated successfully.');
    }

    /**
     * Remove the specified contact.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}

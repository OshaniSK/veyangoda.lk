<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the contact form and company details.
     */
    public function index()
    {
        return view('contacts.index');
    }

    /**
     * Validate input, save to DB, and redirect with success message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $validated['ip_address'] = $request->ip();

        Contact::create($validated);

        return back()->with('success', 'We received your message! Our team will get back to you shortly.');
    }

    /**
     * Admin: List all contact submissions.
     */
    public function adminIndex()
    {
        $contacts = Contact::latest()->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Admin: Delete a contact request.
     */
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        
        return back()->with('success', 'Contact message deleted successfully.');
    }
}

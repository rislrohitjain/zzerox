<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::withTrashed();

        if ($request->has('trashed') && $request->input('trashed') == '1') {
            $query->onlyTrashed();
        }

        $subscribers = $query->latest('subscribed_at')->paginate(20);

        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete(); // Soft delete

        return redirect()->back()->with('success', 'Subscriber soft deleted successfully.');
    }

    public function restore($id)
    {
        $subscriber = Subscriber::withTrashed()->findOrFail($id);
        $subscriber->restore();

        return redirect()->back()->with('success', 'Subscriber restored successfully.');
    }

    public function forceDelete($id)
    {
        $subscriber = Subscriber::withTrashed()->findOrFail($id);
        $subscriber->forceDelete();

        return redirect()->back()->with('success', 'Subscriber permanently deleted.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsFormSubmission;
use Illuminate\Http\Request;

class CmsFormController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'contact');
        $submissions = CmsFormSubmission::where('form_type', $type)
            ->latest()
            ->paginate(20);

        $unreadCount = CmsFormSubmission::where('form_type', $type)->where('is_read', false)->count();

        return view('admin.cms.forms.index', compact('submissions', 'type', 'unreadCount'));
    }

    public function show(CmsFormSubmission $submission)
    {
        if (!$submission->is_read) {
            $submission->markAsRead();
        }

        return view('admin.cms.forms.show', compact('submission'));
    }

    public function markAsRead(CmsFormSubmission $submission)
    {
        $submission->markAsRead();

        return back()->with('success', 'Marqué comme lu.');
    }

    public function destroy(CmsFormSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.cms.forms.index', ['type' => $submission->form_type])
            ->with('success', 'Soumission supprimée.');
    }
}

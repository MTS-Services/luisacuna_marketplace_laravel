<?php


namespace App\Http\Controllers\Admin;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;

class EmailTemplateController extends Controller
{

    protected $masterView = 'backend.admin.pages.templates.email-templates';

    public function index()
    {
        return view($this->masterView);
    }
    public function show($id)
    {

        return view($this->masterView,  compact('id'));

    }

    public function create()
    {

        return view($this->masterView);
    }
       public function edit($id)
    {

        return view($this->masterView, compact('id'));
    }

    public function trash()
    {
        return view($this->masterView);
    }

}


//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'key' => 'required|string|unique:email_templates',
//             'name' => 'required|string|max:255',
//             'subject' => 'nullable|string|max:255',
//             'body' => 'nullable|string',
//             'variables' => 'nullable|json',
//         ]);

//         EmailTemplate::create($validated);
//         return redirect()->route('admin.email-templates.index')->with('success', 'Template created successfully.');
//     }

//     public function edit(EmailTemplate $emailTemplate)
//     {
//         return view('admin.email-templates.edit', ['template' => $emailTemplate]);
//     }

//     public function update(Request $request, EmailTemplate $emailTemplate)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'subject' => 'nullable|string|max:255',
//             'body' => 'nullable|string',
//             'variables' => 'nullable|json',
//         ]);

//         $emailTemplate->update($validated);
//         return redirect()->route('admin.email-templates.index')->with('success', 'Template updated successfully.');
//     }

//     public function destroy(EmailTemplate $emailTemplate)
//     {
//         $emailTemplate->delete();
//         return redirect()->route('admin.email-templates.index')->with('success', 'Template deleted.');
//     }
// }

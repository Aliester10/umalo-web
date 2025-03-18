<?php

namespace App\Http\Controllers\Admin\FAQ;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'questions' => 'required|string|max:255',
            'answers' => 'required|string',
        ]);

        Faq::create($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ created successfully.');
    }

    public function show($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.show', compact('faq'));
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'questions' => 'required|string|max:255',
            'answers' => 'required|string',
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ deleted successfully.');
    }
}

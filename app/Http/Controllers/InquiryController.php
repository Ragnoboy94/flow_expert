<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required',
            'position' => 'required',
            'surname' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'comments' => 'nullable',
        ]);

        $inquiry = Inquiry::create($validatedData);

        return response()->json(['message' => 'Ваш запрос успешно отправлен', 'inquiry_id' => $inquiry->id]);
    }

}

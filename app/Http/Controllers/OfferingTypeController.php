<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Model
use App\Models\OfferingType;

class OfferingTypeController extends Controller
{
    public function index(Request $request)
    {

        try {
            $query = OfferingType::query();

            if ($request->has("search") && $request->input("search")) {
                $search = $request->input("search");
                $query->where(function ($q) use ($search) {
                    $q->where("name", "like", "%" . $search . "%")
                        ->orWhere("description", "like", "%" . $search . "%");
                });
            }

            $offeringsTypes = $query->paginate(10);

            return view('offerings.index', compact('offeringsTypes'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('offerings.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'description' => 'max:255',
            ]);

            $offeringType = OfferingType::create([
                'name' => $validated['name'],
                'description' => $validated['description']
            ]);

            return redirect()->route('offerings')->with('success', 'Ofrenda Creada Correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($offeringType_id)
    {
        try {
            $offeringType = OfferingType::findOrFail($offeringType_id);

            return view('offerings.show', compact('offeringType'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'offeringType' => 'required'
            ]);

            $offeringType = OfferingType::findOrFail($validated['offeringType']);
            $offeringType->name = $validated['name'];
            $offeringType->description = $validated['description'];
            $offeringType->save();

            return redirect()->route('offerings')->with('success', 'Ofrenda Modificada Correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $validated = $request->validate([
                'offeringType' => 'required'
            ]);

            $offeringType = OfferingType::findOrFail($validated['offeringType']);
            $offeringType->delete();

            return redirect()->route('offerings')->with('success', 'Ofrenda ELiminada Correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Customer;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with('customer')->get();
        return view('proposals.index', compact('proposals'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('proposals.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        Proposal::create($request->all());
        return redirect()->route('proposals.index')->with('success', 'Proposal created successfully.');
    }

    public function edit(Proposal $proposal)
    {
        $customers = Customer::where('status', 'active')->get();
        return view('proposals.edit', compact('proposal', 'customers'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $proposal->update($request->all());
        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();
        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }

    public function updateStatus(Proposal $proposal, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $proposal->status = $request->status;
        $proposal->save();
        return redirect()->route('proposals.index')->with('success', 'Proposal status updated.');
    }
}
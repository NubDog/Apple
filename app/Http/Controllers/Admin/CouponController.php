<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        
        // Thống kê
        $totalCoupons = Coupon::count();
        $activeCoupons = Coupon::where('is_active', 1)->count();
        $expiredCoupons = Coupon::whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->count();
        $percentCoupons = Coupon::where('type', 'percent')->count();
        $fixedCoupons = Coupon::where('type', 'fixed')->count();
        
        return view('admin.coupons.index', compact(
            'coupons', 
            'totalCoupons', 
            'activeCoupons', 
            'expiredCoupons', 
            'percentCoupons', 
            'fixedCoupons'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:coupons'],
            'discount_type' => ['required', 'string', 'in:fixed,percentage'],
            'discount_value' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'boolean'],
            'minimum_purchase' => ['nullable', 'numeric'],
            'maximum_discount' => ['nullable', 'numeric'],
        ]);

        Coupon::create([
            'name' => $request->name,
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'minimum_purchase' => $request->minimum_purchase,
            'maximum_discount' => $request->maximum_discount,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:coupons,code,' . $coupon->id],
            'discount_type' => ['required', 'string', 'in:fixed,percentage'],
            'discount_value' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'boolean'],
            'minimum_purchase' => ['nullable', 'numeric'],
            'maximum_discount' => ['nullable', 'numeric'],
        ]);

        $coupon->update([
            'name' => $request->name,
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'minimum_purchase' => $request->minimum_purchase,
            'maximum_discount' => $request->maximum_discount,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        
        return response(['status' => 'success', 'message' => 'Coupon deleted successfully!']);
    }
    
    /**
     * Update status
     */
    public function updateStatus(Coupon $coupon)
    {
        $coupon->update(['status' => !$coupon->status]);
        
        return response(['status' => 'success', 'message' => 'Status updated successfully!']);
    }
    
    /**
     * Clone a coupon
     */
    public function clone(Coupon $coupon)
    {
        $newCoupon = $coupon->replicate();
        $newCoupon->code = $coupon->code . '-copy-' . Str::random(5);
        $newCoupon->name = $coupon->name . ' (Copy)';
        $newCoupon->save();
        
        return response(['status' => 'success', 'message' => 'Coupon cloned successfully!']);
    }
    
    /**
     * Bulk actions
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'exists:coupons,id']
        ]);

        Coupon::whereIn('id', $request->ids)->delete();
        
        return response(['status' => 'success', 'message' => 'Selected coupons deleted successfully!']);
    }
    
    /**
     * Bulk status update
     */
    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'exists:coupons,id'],
            'status' => ['required', 'boolean']
        ]);

        Coupon::whereIn('id', $request->ids)->update(['status' => $request->status]);
        
        return response(['status' => 'success', 'message' => 'Status updated successfully!']);
    }
} 
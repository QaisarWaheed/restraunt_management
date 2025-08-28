<?php

namespace App\Http\Controllers\API\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\Contact;
use App\Models\TableReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function showSubscriberEmail(Request $request)
    {
        try {
            $query = Subscriber::query();
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where('email', 'like', "%$search%") ;
            }
            $perPage = $request->get('per_page', 8);
            $subscribers = $query->orderByDesc('id')->paginate($perPage);
            return response()->json([
                'success' => true,
                'data' => $subscribers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not fetch subscribers. Try again later.'
            ], 500);
        }
    }
    public function showContactInfo(Request $request)
    {
        try {
            $query = Contact::query();
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('phone', 'like', "%$search%")
                      ->orWhere('subject', 'like', "%$search%")
                      ->orWhere('message', 'like', "%$search%")
                    ;
                });
            }
            $perPage = $request->get('per_page', 8);
            $contacts = $query->orderByDesc('id')->paginate($perPage);
            return response()->json([
                'success' => true,
                'data' => $contacts
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not fetch contact requests. Try again later.'
            ], 500);
        }
    }
    public function showReservationInfo(Request $request)
    {
        try {
            $query = TableReservation::query();
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('full_name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('phone_number', 'like', "%$search%")
                      ->orWhere('message', 'like', "%$search%")
                      ->orWhere('date', 'like', "%$search%")
                      ->orWhere('time', 'like', "%$search%")
                      ->orWhere('guests', 'like', "%$search%")
                    ;
                });
            }
            $perPage = $request->get('per_page', 8);
            $reservations = $query->orderByDesc('id')->paginate($perPage);
            return response()->json([
                'success' => true,
                'data' => $reservations
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not fetch reservations. Try again later.'
            ], 500);
        }
    }
} 
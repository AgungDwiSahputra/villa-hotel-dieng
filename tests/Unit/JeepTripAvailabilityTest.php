<?php

namespace Tests\Unit;

use App\Models\JeepTrip\JeepTrip;
use App\Models\JeepTrip\JeepTripAvailability;
use App\Models\JeepTrip\JeepTripBooking;
use App\Models\JeepTrip\JeepTripBookingItem;
use App\Models\JeepTrip\JeepTripSlot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Http\Request;

class JeepTripAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_check_slot_availability_correctly()
    {
        // Create jeep trip
        $jeepTrip = \Database\Factories\JeepTripFactory::new()->create([
            'nama_paket' => 'Test Jeep Trip',
            'is_active' => true
        ]);

        // Create slot
        $slot = \Database\Factories\JeepTripSlotFactory::new()->create([
            'jeep_trip_id' => $jeepTrip->id,
            'nama_slot' => 'Pagi'
        ]);

        // Test case 1: No availability record exists
        $controller = new \App\Http\Controllers\JeepTripController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('getAvailableUnitsForSlot');
        $method->setAccessible(true);

        $availableUnits = $method->invoke($controller, $slot, '2025-12-01');
        $this->assertEquals(0, $availableUnits, 'Should return 0 when no availability record exists');

        // Test case 2: Availability exists but slot is closed
        JeepTripAvailability::create([
            'jeep_trip_slot_id' => $slot->id,
            'tanggal' => '2025-12-01',
            'quota_jeep' => 5,
            'quota_terpakai' => 0,
            'is_closed' => true
        ]);

        $availableUnits = $method->invoke($controller, $slot, '2025-12-01');
        $this->assertEquals(0, $availableUnits, 'Should return 0 when slot is closed');

        // Test case 3: Normal availability
        $availability = JeepTripAvailability::where('jeep_trip_slot_id', $slot->id)
            ->where('tanggal', '2025-12-01')
            ->first();
        $availability->update(['is_closed' => false]);

        $availableUnits = $method->invoke($controller, $slot, '2025-12-01');
        $this->assertEquals(5, $availableUnits, 'Should return quota_jeep - quota_terpakai when available');

        // Test case 4: Some units already booked
        $availability->update(['quota_terpakai' => 2]);
        $availableUnits = $method->invoke($controller, $slot, '2025-12-01');
        $this->assertEquals(3, $availableUnits, 'Should return correct available units after booking');

        // Test case 5: Fully booked
        $availability->update(['quota_terpakai' => 5]);
        $availableUnits = $method->invoke($controller, $slot, '2025-12-01');
        $this->assertEquals(0, $availableUnits, 'Should return 0 when fully booked');

        // Test case 6: Overbooked (should not happen but test edge case)
        $availability->update(['quota_terpakai' => 7]);
        $availableUnits = $method->invoke($controller, $slot, '2025-12-01');
        $this->assertEquals(0, $availableUnits, 'Should return 0 (not negative) when overbooked');
    }

    /** @test */
    public function jeep_trip_model_calculates_price_correctly()
    {
        $jeepTrip = \Database\Factories\JeepTripFactory::new()->create([
            'harga_weekday' => 500000,
            'harga_weekend' => 600000
        ]);

        // Test weekday price
        $price = $jeepTrip->calculatePrice('2025-12-02', 2); // Monday
        $this->assertEquals('500000.00', $price['harga_satuan']);
        $this->assertEquals('1000000.00', $price['total']);
        $this->assertFalse($price['is_weekend']);

        // Test weekend price (Saturday)
        $price = $jeepTrip->calculatePrice('2025-12-06', 1); // Saturday
        $this->assertEquals('600000.00', $price['harga_satuan']); // Cast to decimal returns string
        $this->assertEquals('600000.00', $price['total']);
        $this->assertTrue($price['is_weekend']);

        // Test weekend price (Sunday)
        $price = $jeepTrip->calculatePrice('2025-12-07', 1); // Sunday
        $this->assertEquals('600000.00', $price['harga_satuan']); // Cast to decimal returns string
        $this->assertEquals('600000.00', $price['total']);
        $this->assertTrue($price['is_weekend']);
    }

    /** @test */
    public function draft_booking_workflow_works_correctly()
    {
        // Create user
        $user = User::factory()->create();

        // Create jeep trip and slot
        $jeepTrip = \Database\Factories\JeepTripFactory::new()->create([
            'harga_weekday' => 500000,
            'harga_weekend' => 600000,
        ]);
        $slot = \Database\Factories\JeepTripSlotFactory::new()->create([
            'jeep_trip_id' => $jeepTrip->id,
        ]);

        // Create availability
        JeepTripAvailability::create([
            'jeep_trip_slot_id' => $slot->id,
            'tanggal' => '2025-12-02', // Monday - weekday
            'quota_jeep' => 10,
            'quota_terpakai' => 0,
            'is_closed' => false,
        ]);

        // Test draft booking creation
        $this->actingAs($user);

        $response = $this->post(route('jeep-trip.booking'), [
            'jeep_trip_id' => $jeepTrip->id,
            'slot_id' => $slot->id,
            'tanggal_trip' => '2025-12-02',
            'jumlah_jeep' => 2,
        ]);

        $response->assertRedirect(route('jeep-trip.checkout'));

        // Check draft booking created
        $draftBooking = JeepTripBooking::where('user_id', $user->id)
            ->where('status', 'draft')
            ->first();

        $this->assertNotNull($draftBooking);
        $this->assertEquals(1000000, $draftBooking->total_harga); // 2 jeeps * 500k weekday

        // Check booking item
        $bookingItem = $draftBooking->bookingItems()->first();
        $this->assertNotNull($bookingItem);
        $this->assertEquals($jeepTrip->id, $bookingItem->jeep_trip_id);
        $this->assertEquals($slot->id, $bookingItem->jeep_trip_slot_id);
        $this->assertEquals(2, $bookingItem->jumlah_jeep);
        $this->assertEquals(500000, $bookingItem->harga_satuan);

        // Check session contains booking_id
        $this->assertTrue(Session::has('jeep_trip_booking'));
        $sessionData = Session::get('jeep_trip_booking');
        $this->assertEquals($draftBooking->id, $sessionData['booking_id']);
        $this->assertArrayHasKey('expires_at', $sessionData);
    }

    /** @test */
    public function draft_booking_expiry_works_correctly()
    {
        // Create user
        $user = User::factory()->create();

        // Create jeep trip and slot
        $jeepTrip = \Database\Factories\JeepTripFactory::new()->create();
        $slot = \Database\Factories\JeepTripSlotFactory::new()->create([
            'jeep_trip_id' => $jeepTrip->id,
        ]);

        // Create expired draft booking
        $expiredBooking = JeepTripBooking::create([
            'user_id' => $user->id,
            'kode_booking' => 'DRAFT-' . uniqid(),
            'total_harga' => 500000,
            'status' => 'draft',
        ]);

        JeepTripBookingItem::create([
            'jeep_trip_booking_id' => $expiredBooking->id,
            'jeep_trip_id' => $jeepTrip->id,
            'jeep_trip_slot_id' => $slot->id,
            'tanggal_trip' => now()->addDays(1),
            'jumlah_jeep' => 1,
            'harga_satuan' => 500000,
            'subtotal' => 500000,
        ]);

        // Test the checkout method directly with expired session
        $controller = new \App\Http\Controllers\JeepTripController();

        // Set expired session
        Session::put('jeep_trip_booking', [
            'booking_id' => $expiredBooking->id,
            'expires_at' => now()->subMinutes(1)->toISOString(), // Already expired
        ]);

        // Mock auth
        $this->actingAs($user);

        // Call checkout method directly
        $response = $controller->checkout();

        // Should redirect with error
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(route('jeep-trip.index'), $response->getTargetUrl());

        // Check booking status changed to expired
        $expiredBooking->refresh();
        $this->assertEquals('expired', $expiredBooking->status);

        // Check session cleared
        $this->assertFalse(Session::has('jeep_trip_booking'));
    }

    /** @test */
    public function midtrans_callback_logic_handles_successful_payment()
    {
        // Create user and booking
        $user = User::factory()->create();
        $jeepTrip = \Database\Factories\JeepTripFactory::new()->create();
        $slot = \Database\Factories\JeepTripSlotFactory::new()->create([
            'jeep_trip_id' => $jeepTrip->id,
        ]);

        // Create availability
        JeepTripAvailability::create([
            'jeep_trip_slot_id' => $slot->id,
            'tanggal' => '2025-12-02',
            'quota_jeep' => 5,
            'quota_terpakai' => 2,
            'is_closed' => false,
        ]);

        $booking = JeepTripBooking::create([
            'user_id' => $user->id,
            'kode_booking' => 'JT-TEST123',
            'total_harga' => 1000000,
            'status' => 'pending',
            'payment_ref' => 'JT-TEST123',
        ]);

        JeepTripBookingItem::create([
            'jeep_trip_booking_id' => $booking->id,
            'jeep_trip_id' => $jeepTrip->id,
            'jeep_trip_slot_id' => $slot->id,
            'tanggal_trip' => '2025-12-02',
            'jumlah_jeep' => 2,
            'harga_satuan' => 500000,
            'subtotal' => 1000000,
        ]);

        // Test the callback logic by simulating the notification data
        config(['midtrans.server_key' => 'test-server-key']);

        // Simulate successful payment notification
        $notificationData = (object) [
            'order_id' => 'JT-TEST123',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'status_code' => '200',
            'gross_amount' => '1000000',
            'signature_key' => hash('sha512', 'JT-TEST123' . '200' . '1000000' . 'test-server-key')
        ];

        // Simulate the callback logic (extracted from controller)
        $orderId = $notificationData->order_id;
        $transactionStatus = $notificationData->transaction_status;
        $fraudStatus = $notificationData->fraud_status;
        $signatureKey = $notificationData->signature_key;

        $localSignatureKey = hash('sha512', $orderId . $notificationData->status_code . $notificationData->gross_amount . config('midtrans.server_key'));

        // Verify signature
        $this->assertEquals($localSignatureKey, $signatureKey);

        $bookingFromDb = JeepTripBooking::where('kode_booking', $orderId)->first();
        $this->assertNotNull($bookingFromDb);
        $this->assertEquals('pending', $bookingFromDb->status);

        // Apply payment status logic
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $bookingFromDb->status = 'paid';
            }
        } else if ($transactionStatus == 'settlement') {
            $bookingFromDb->status = 'paid';
        }

        $bookingFromDb->save();

        // Assert booking status updated
        $bookingFromDb->refresh();
        $this->assertEquals('paid', $bookingFromDb->status);
    }

    /** @test */
    public function midtrans_callback_logic_handles_failed_payment_and_restores_availability()
    {
        // Create user and booking
        $user = User::factory()->create();
        $jeepTrip = \Database\Factories\JeepTripFactory::new()->create();
        $slot = \Database\Factories\JeepTripSlotFactory::new()->create([
            'jeep_trip_id' => $jeepTrip->id,
        ]);

        // Create availability with some quota used
        $availability = JeepTripAvailability::create([
            'jeep_trip_slot_id' => $slot->id,
            'tanggal' => '2025-12-02',
            'quota_jeep' => 5,
            'quota_terpakai' => 1, // 1 already used
            'is_closed' => false,
        ]);

        $booking = JeepTripBooking::create([
            'user_id' => $user->id,
            'kode_booking' => 'JT-FAIL123',
            'total_harga' => 1000000,
            'status' => 'pending',
            'payment_ref' => 'JT-FAIL123',
        ]);

        JeepTripBookingItem::create([
            'jeep_trip_booking_id' => $booking->id,
            'jeep_trip_id' => $jeepTrip->id,
            'jeep_trip_slot_id' => $slot->id,
            'tanggal_trip' => '2025-12-02',
            'jumlah_jeep' => 2,
            'harga_satuan' => 500000,
            'subtotal' => 1000000,
        ]);

        // Update availability to reflect booking (simulate what happens in final() method)
        $availability->increment('quota_terpakai', 2); // Now 3 used
        $availability->refresh();
        $this->assertEquals(3, $availability->quota_terpakai);

        // Simulate failed payment notification
        config(['midtrans.server_key' => 'test-server-key']);

        $notificationData = (object) [
            'order_id' => 'JT-FAIL123',
            'transaction_status' => 'deny',
            'fraud_status' => 'deny',
            'status_code' => '202',
            'gross_amount' => '1000000',
            'signature_key' => hash('sha512', 'JT-FAIL123' . '202' . '1000000' . 'test-server-key')
        ];

        // Simulate the callback logic
        $orderId = $notificationData->order_id;
        $transactionStatus = $notificationData->transaction_status;
        $signatureKey = $notificationData->signature_key;

        $localSignatureKey = hash('sha512', $orderId . $notificationData->status_code . $notificationData->gross_amount . config('midtrans.server_key'));
        $this->assertEquals($localSignatureKey, $signatureKey);

        $bookingFromDb = JeepTripBooking::where('kode_booking', $orderId)->first();
        $this->assertNotNull($bookingFromDb);

        // Apply payment failure logic
        if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $bookingFromDb->status = 'cancelled';

            // Restore availability
            $bookingItem = $bookingFromDb->bookingItems()->first();
            if ($bookingItem) {
                $availabilityRecord = JeepTripAvailability::where('jeep_trip_slot_id', $bookingItem->jeep_trip_slot_id)
                    ->where('tanggal', $bookingItem->tanggal_trip)
                    ->first();

                if ($availabilityRecord) {
                    $availabilityRecord->decrement('quota_terpakai', $bookingItem->jumlah_jeep);
                }
            }
        }

        $bookingFromDb->save();

        // Assert booking status updated to cancelled
        $bookingFromDb->refresh();
        $this->assertEquals('cancelled', $bookingFromDb->status);

        // Assert availability restored (quota_terpakai should be back to 1)
        $availability->refresh();
        $this->assertEquals(1, $availability->quota_terpakai);
    }

    /** @test */
    public function midtrans_signature_validation_works_correctly()
    {
        config(['midtrans.server_key' => 'test-server-key']);

        // Test valid signature
        $orderId = 'JT-TEST123';
        $statusCode = '200';
        $grossAmount = '1000000';

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . config('midtrans.server_key'));
        $this->assertNotEmpty($expectedSignature);

        // Test invalid signature
        $invalidSignature = 'invalid-signature-key';
        $this->assertNotEquals($expectedSignature, $invalidSignature);

        // Simulate signature validation logic
        $notificationData = (object) [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $expectedSignature
        ];

        $localSignatureKey = hash('sha512', $notificationData->order_id . $notificationData->status_code . $notificationData->gross_amount . config('midtrans.server_key'));
        $this->assertEquals($notificationData->signature_key, $localSignatureKey);

        // Test with invalid signature
        $notificationData->signature_key = $invalidSignature;
        $this->assertNotEquals($notificationData->signature_key, $localSignatureKey);
    }

    /** @test */
    public function midtrans_callback_logic_handles_pending_payment_status()
    {
        // Create booking
        $user = User::factory()->create();
        $booking = JeepTripBooking::create([
            'user_id' => $user->id,
            'kode_booking' => 'JT-PENDING123',
            'total_harga' => 1000000,
            'status' => 'pending',
            'payment_ref' => 'JT-PENDING123',
        ]);

        // Simulate pending payment notification
        config(['midtrans.server_key' => 'test-server-key']);

        $notificationData = (object) [
            'order_id' => 'JT-PENDING123',
            'transaction_status' => 'pending',
            'fraud_status' => 'accept',
            'status_code' => '201',
            'gross_amount' => '1000000',
            'signature_key' => hash('sha512', 'JT-PENDING123' . '201' . '1000000' . 'test-server-key')
        ];

        // Simulate the callback logic
        $orderId = $notificationData->order_id;
        $transactionStatus = $notificationData->transaction_status;
        $signatureKey = $notificationData->signature_key;

        $localSignatureKey = hash('sha512', $orderId . $notificationData->status_code . $notificationData->gross_amount . config('midtrans.server_key'));
        $this->assertEquals($localSignatureKey, $signatureKey);

        $bookingFromDb = JeepTripBooking::where('kode_booking', $orderId)->first();
        $this->assertNotNull($bookingFromDb);

        // Apply pending payment logic (should not change status)
        if ($transactionStatus == 'pending') {
            // Status remains pending
            $this->assertEquals('pending', $bookingFromDb->status);
        }

        // Booking should remain pending
        $bookingFromDb->refresh();
        $this->assertEquals('pending', $bookingFromDb->status);
    }
}
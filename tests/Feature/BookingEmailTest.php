<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\User;
use App\Mail\BoardingPassMail;
use App\Mail\BookingCancelledMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingEmailTest extends TestCase
{
    use RefreshDatabase;

    private $destination;
    private $user;
    private $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard destination for bookings
        $this->destination = Destination::create([
            'name' => 'Paris',
            'location' => 'France',
            'description' => 'City of lights.',
            'min_budget' => 600,
            'max_budget' => 2500,
            'best_months' => [5, 6, 7],
            'image_url' => 'https://example.com/paris.jpg'
        ]);

        $this->user = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->otherUser = User::create([
            'name' => 'Bob Jones',
            'email' => 'bob@example.com',
            'password' => bcrypt('password123'),
        ]);
    }

    /**
     * Test booking package creation auto-sends email.
     */
    public function test_booking_package_auto_sends_boarding_pass(): void
    {
        Mail::fake();

        $response = $this->actingAs($this->user)->post(route('bookings.store'), [
            'destination_id' => $this->destination->id,
            'customer_name' => 'Alice Smith',
            'customer_email' => 'alice@example.com',
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-10',
            'num_travelers' => 2,
        ]);

        $response->assertRedirect();
        
        $booking = Booking::where('customer_email', 'alice@example.com')->first();
        $this->assertNotNull($booking);

        Mail::assertSent(BoardingPassMail::class, function ($mail) use ($booking) {
            return $mail->hasTo('alice@example.com') && $mail->booking->id === $booking->id;
        });
    }

    /**
     * Test flight booking auto-sends email.
     */
    public function test_flight_booking_auto_sends_boarding_pass(): void
    {
        Mail::fake();

        $response = $this->actingAs($this->user)->post(route('flights.book'), [
            'airline' => 'Delta Air Lines',
            'flight_number' => 'DL-456',
            'departure_city' => 'New York',
            'destination_city' => 'Paris',
            'departure_code' => 'JFK',
            'destination_code' => 'CDG',
            'departure_date' => '2026-06-15',
            'price' => 520,
            'travelers' => 2,
            'customer_name' => 'Alice Smith',
            'customer_email' => 'alice@example.com',
        ]);

        $response->assertRedirect();

        $booking = Booking::where('customer_email', 'alice@example.com')->first();
        $this->assertNotNull($booking);

        Mail::assertSent(BoardingPassMail::class, function ($mail) use ($booking) {
            return $mail->hasTo('alice@example.com') && $mail->booking->id === $booking->id;
        });
    }

    /**
     * Test hotel booking auto-sends email.
     */
    public function test_hotel_booking_auto_sends_boarding_pass(): void
    {
        Mail::fake();

        $hotel = Hotel::create([
            'destination_id' => $this->destination->id,
            'name' => 'Eiffel View Suite',
            'location' => 'Paris, France',
            'description' => 'A wonderful hotel stay near the Eiffel Tower.',
            'type' => 'hotel',
            'price_per_night' => 150.00,
            'rating' => 4.8,
            'image_url' => 'https://example.com/hotel.jpg',
            'amenities' => ['Wifi', 'Pool', 'Restaurant'],
        ]);

        $response = $this->actingAs($this->user)->post(route('hotels.book', $hotel->id), [
            'customer_name' => 'Alice Smith',
            'customer_email' => 'alice@example.com',
            'start_date' => '2026-06-20',
            'end_date' => '2026-06-25',
            'travelers' => 2,
        ]);

        $response->assertRedirect();

        $booking = Booking::where('customer_email', 'alice@example.com')->first();
        $this->assertNotNull($booking);

        Mail::assertSent(BoardingPassMail::class, function ($mail) use ($booking) {
            return $mail->hasTo('alice@example.com') && $mail->booking->id === $booking->id;
        });
    }

    /**
     * Test booking cancellation updates status and auto-sends email.
     */
    public function test_booking_cancellation_updates_status_and_sends_email(): void
    {
        Mail::fake();

        $booking = Booking::create([
            'destination_id' => $this->destination->id,
            'customer_name' => 'Alice Smith',
            'customer_email' => 'alice@example.com',
            'start_date' => '2026-06-10',
            'end_date' => '2026-06-15',
            'num_travelers' => 1,
            'total_price' => 600,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($this->user)->post(route('bookings.cancel', $booking->booking_reference));

        $response->assertRedirect();
        
        $booking->refresh();
        $this->assertEquals('cancelled', $booking->status);

        Mail::assertSent(BookingCancelledMail::class, function ($mail) use ($booking) {
            return $mail->hasTo('alice@example.com') && $mail->booking->id === $booking->id;
        });
    }

    /**
     * Test guests are redirected when trying to access bookings.
     */
    public function test_guest_redirected_when_accessing_bookings(): void
    {
        // Accessing listing
        $response = $this->get(route('bookings.index'));
        $response->assertRedirect(route('login'));

        // Accessing specific confirmation
        $response = $this->get(route('bookings.confirmation', 'TS-REF123'));
        $response->assertRedirect(route('login'));

        // Accessing cancellation
        $response = $this->post(route('bookings.cancel', 'TS-REF123'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test a user cannot view another user's booking confirmation.
     */
    public function test_user_cannot_view_other_users_confirmation(): void
    {
        // Booking created for Alice
        $booking = Booking::create([
            'destination_id' => $this->destination->id,
            'customer_name' => 'Alice Smith',
            'customer_email' => 'alice@example.com',
            'start_date' => '2026-06-10',
            'end_date' => '2026-06-15',
            'num_travelers' => 1,
            'total_price' => 600,
            'status' => 'confirmed',
        ]);

        // Act as Bob and request Alice's confirmation page
        $response = $this->actingAs($this->otherUser)->get(route('bookings.confirmation', $booking->booking_reference));
        
        $response->assertStatus(403);
    }

    /**
     * Test a user cannot cancel another user's booking.
     */
    public function test_user_cannot_cancel_other_users_booking(): void
    {
        // Booking created for Alice
        $booking = Booking::create([
            'destination_id' => $this->destination->id,
            'customer_name' => 'Alice Smith',
            'customer_email' => 'alice@example.com',
            'start_date' => '2026-06-10',
            'end_date' => '2026-06-15',
            'num_travelers' => 1,
            'total_price' => 600,
            'status' => 'confirmed',
        ]);

        // Act as Bob and attempt to cancel Alice's booking
        $response = $this->actingAs($this->otherUser)->post(route('bookings.cancel', $booking->booking_reference));
        
        $response->assertStatus(403);
        
        // Assert booking is still confirmed
        $booking->refresh();
        $this->assertEquals('confirmed', $booking->status);
    }
}

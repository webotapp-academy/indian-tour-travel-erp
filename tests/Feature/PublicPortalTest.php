<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    private function getCountry(): Country
    {
        return Country::firstOrCreate(
            ['code' => 'IN'],
            ['name' => 'India', 'phone_code' => '+91', 'is_active' => true]
        );
    }

    public function test_home_page_displays_hero_and_featured_packages(): void
    {
        $country = $this->getCountry();

        $destination = Destination::create([
            'country_id' => $country->id,
            'name' => 'Kashmir Valley',
            'slug' => 'kashmir-valley',
            'type' => 'domestic',
            'is_active' => true,
        ]);

        TourPackage::create([
            'destination_id' => $destination->id,
            'title' => 'Paradise Kashmir Tour',
            'slug' => 'paradise-kashmir-tour',
            'package_code' => 'PKG-KASH-01',
            'duration_days' => 5,
            'duration_nights' => 4,
            'starting_price' => 24999,
            'adult_price' => 24999,
            'child_price' => 12999,
            'infant_price' => 4999,
            'is_featured' => true,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Kashmir Valley');
        $response->assertSee('Paradise Kashmir Tour');
    }

    public function test_packages_index_and_detail_page_render_successfully(): void
    {
        $country = $this->getCountry();

        $destination = Destination::create([
            'country_id' => $country->id,
            'name' => 'Goa Beaches',
            'slug' => 'goa-beaches',
            'type' => 'domestic',
            'is_active' => true,
        ]);

        $package = TourPackage::create([
            'destination_id' => $destination->id,
            'title' => 'Goa Sunset & Beach Escape',
            'slug' => 'goa-sunset-beach-escape',
            'package_code' => 'PKG-GOA-01',
            'duration_days' => 5,
            'duration_nights' => 4,
            'starting_price' => 14999,
            'adult_price' => 14999,
            'child_price' => 7999,
            'infant_price' => 2999,
            'is_active' => true,
        ]);

        $response = $this->get('/packages');
        $response->assertStatus(200);
        $response->assertSee('Goa Sunset & Beach Escape');

        $detailResponse = $this->get('/packages/'.$package->slug);
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Goa Sunset & Beach Escape');
        $detailResponse->assertSee('14,999');
    }

    public function test_destinations_catalog_page_renders(): void
    {
        $country = $this->getCountry();

        Destination::create([
            'country_id' => $country->id,
            'name' => 'Ladakh Heights',
            'slug' => 'ladakh-heights',
            'type' => 'domestic',
            'is_active' => true,
        ]);

        $response = $this->get('/destinations');
        $response->assertStatus(200);
        $response->assertSee('Ladakh Heights');
    }

    public function test_travel_service_pages_render_properly(): void
    {
        $services = [
            '/services',
            '/services/visa',
            '/services/passport',
            '/services/flights',
            '/services/hotels',
            '/services/trains',
            '/services/buses',
            '/services/custom-tour',
        ];

        foreach ($services as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }

    public function test_contact_inquiry_can_be_submitted(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Rohan Varma',
            'email' => 'rohan@example.com',
            'phone' => '9812345678',
            'subject' => 'Kerala Holiday Package Inquiry',
            'message' => 'Interested in 6 days luxury backwaters package for family of 4.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_newsletter_subscription_via_ajax(): void
    {
        $response = $this->postJson('/newsletter/subscribe', [
            'email' => 'subscriber@test.com',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertDatabaseHas('subscribers', [
            'email' => 'subscriber@test.com',
        ]);
    }

    public function test_package_booking_can_be_submitted_successfully(): void
    {
        $country = $this->getCountry();

        $destination = Destination::create([
            'country_id' => $country->id,
            'name' => 'Goa Beach',
            'slug' => 'goa-beach',
            'type' => 'domestic',
            'is_active' => true,
        ]);

        $package = TourPackage::create([
            'destination_id' => $destination->id,
            'title' => 'Goa Luxury Beach Escape',
            'slug' => 'goa-luxury-beach-escape-yacht-candolim',
            'package_code' => 'PKG-GOA-01',
            'duration_days' => 4,
            'duration_nights' => 3,
            'starting_price' => 19999,
            'adult_price' => 19999,
            'child_price' => 9999,
            'infant_price' => 2999,
            'is_active' => true,
        ]);

        $response = $this->post("/packages/{$package->slug}/book", [
            'departure_date' => now()->addDays(14)->toDateString(),
            'adults' => 2,
            'children' => 0,
            'infants' => 0,
            'customer_name' => 'Paban Jyoti Bhuyan',
            'customer_email' => 'zzubizubi@gmail.com',
            'customer_phone' => '+917002484119',
            'advance_payment_method' => 'pay_later',
            'lead_passenger_name' => 'Paban Jyoti Bhuyan',
            'lead_passenger_gender' => 'male',
            'lead_passenger_age' => 30,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('customers', [
            'email' => 'zzubizubi@gmail.com',
        ]);
        $this->assertDatabaseHas('bookings', [
            'package_id' => $package->id,
            'adults' => 2,
        ]);
    }
}

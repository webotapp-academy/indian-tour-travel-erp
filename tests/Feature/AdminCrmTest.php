<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Lead;
use App\Models\Quotation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrmTest extends TestCase
{
    use RefreshDatabase;

    private function createAdminUser(): User
    {
        $role = Role::firstOrCreate(['slug' => 'super_admin'], ['name' => 'Super Administrator', 'is_system' => true]);

        $user = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'active',
        ]);
        $user->roles()->attach($role->id);

        return $user;
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $customerUser = User::factory()->create([
            'role' => 'customer',
            'status' => 'active',
        ]);

        $response = $this->actingAs($customerUser)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard_and_see_kpis(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Pipeline');
    }

    public function test_admin_can_view_leads_and_create_lead(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get('/admin/leads');
        $response->assertStatus(200);
        $response->assertSee('Prospect Name');

        $createResponse = $this->actingAs($admin)->post('/admin/leads', [
            'name' => 'Amitabh Bachchan',
            'email' => 'amitabh@example.com',
            'phone' => '9820011223',
            'category' => 'holiday_package',
            'destination' => 'Switzerland',
            'budget' => 500000,
            'adults' => 2,
            'source' => 'website',
            'status' => 'new',
            'priority' => 'high',
        ]);

        $createResponse->assertRedirect();
        $this->assertDatabaseHas('leads', [
            'email' => 'amitabh@example.com',
            'destination' => 'Switzerland',
        ]);
    }

    public function test_admin_can_convert_lead_to_customer(): void
    {
        $admin = $this->createAdminUser();

        $lead = Lead::create([
            'lead_number' => 'LD-2025-099',
            'name' => 'Siddharth Roy',
            'email' => 'siddharth@example.com',
            'phone' => '9833012345',
            'service_type' => 'package',
            'destination' => 'Dubai Luxury',
            'status' => 'contacted',
            'priority' => 'high',
        ]);

        $convertResponse = $this->actingAs($admin)->post('/admin/leads/'.$lead->id.'/convert');

        $convertResponse->assertRedirect();
        $this->assertDatabaseHas('customers', [
            'email' => 'siddharth@example.com',
        ]);
        $this->assertDatabaseHas('leads', [
            'id' => $lead->id,
            'status' => 'converted',
        ]);
    }

    public function test_admin_can_view_customers_directory(): void
    {
        $admin = $this->createAdminUser();

        Customer::create([
            'customer_code' => 'CUST-0099',
            'name' => 'Vikram Seth',
            'email' => 'vikram@example.com',
            'phone' => '9988776655',
            'type' => 'b2c',
        ]);

        $response = $this->actingAs($admin)->get('/admin/customers');

        $response->assertStatus(200);
        $response->assertSee('Vikram Seth');
        $response->assertSee('CUST-0099');
    }

    public function test_admin_can_view_quotations_and_stream_pdf(): void
    {
        $admin = $this->createAdminUser();

        $customer = Customer::create([
            'customer_code' => 'CUST-0098',
            'name' => 'Kavita Krishnan',
            'email' => 'kavita@example.com',
            'phone' => '9876500112',
            'type' => 'b2c',
        ]);

        $quotation = Quotation::create([
            'customer_id' => $customer->id,
            'created_by' => $admin->id,
            'quotation_number' => 'QTN-2025-001',
            'title' => 'Golden Triangle Heritage Tour',
            'destination' => 'Jaipur, Agra, Delhi',
            'service_type' => 'package',
            'adults' => 2,
            'children' => 0,
            'infants' => 0,
            'package_price' => 75000,
            'tax_amount' => 3750,
            'total_amount' => 78750,
            'status' => 'sent',
            'valid_until' => now()->addDays(15)->toDateString(),
        ]);

        $listResponse = $this->actingAs($admin)->get('/admin/quotations');
        $listResponse->assertStatus(200);
        $listResponse->assertSee('QTN-2025-001');

        $pdfResponse = $this->actingAs($admin)->get('/admin/quotations/'.$quotation->id.'/pdf');
        $pdfResponse->assertStatus(200);
        $this->assertEquals('application/pdf', $pdfResponse->headers->get('Content-Type'));
    }

    public function test_admin_can_view_reports_and_system_settings(): void
    {
        $admin = $this->createAdminUser();

        $reportResponse = $this->actingAs($admin)->get('/admin/reports');
        $reportResponse->assertStatus(200);
        $reportResponse->assertSee('Lead Conversion Funnel');

        $settingsResponse = $this->actingAs($admin)->get('/admin/settings');
        $settingsResponse->assertStatus(200);
        $settingsResponse->assertSee('System & Agency Settings');
    }

    public function test_admin_can_schedule_lead_followup(): void
    {
        $admin = $this->createAdminUser();

        $lead = Lead::create([
            'lead_number' => 'LEAD-2026-9999',
            'name' => 'Vikramaditya Sharma',
            'email' => 'vikram@example.com',
            'phone' => '+919876543210',
            'destination' => 'Goa Beach Holiday',
            'category' => 'package',
            'priority' => 'high',
            'status' => 'new',
        ]);

        $response = $this->actingAs($admin)->post("/admin/leads/{$lead->id}/followup", [
            'followup_date' => now()->addDays(2)->format('Y-m-d\TH:i'),
            'remarks' => 'Call client to confirm hotel booking and flight tickets',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('lead_followups', [
            'lead_id' => $lead->id,
            'user_id' => $admin->id,
            'remarks' => 'Call client to confirm hotel booking and flight tickets',
        ]);
        $this->assertDatabaseHas('lead_activities', [
            'lead_id' => $lead->id,
            'type' => 'call',
            'summary' => 'Follow-up Scheduled',
        ]);
    }
}

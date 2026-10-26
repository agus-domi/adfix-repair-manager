<?php

namespace Tests\Feature;

use App\Enums\RepairStatus;
use App\Models\Client;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepairManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_repairs_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('repairs.index'));

        $response->assertOk();
    }

    public function test_can_create_repair_with_new_client(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('repairs.store'), [
            'client_name' => 'Juan Perez',
            'client_phone' => '123456789',
            'device' => 'iPhone 12',
            'issue' => 'Pantalla rota',
            'estimated_price' => 15000,
            'status' => RepairStatus::PENDIENTE->value,
            'received_at' => now()->toDateString(),
        ]);

        $response->assertRedirect(route('repairs.index'));
        $this->assertDatabaseHas('clients', ['name' => 'Juan Perez', 'phone' => '123456789']);
        $this->assertDatabaseHas('repairs', ['device' => 'iPhone 12', 'issue' => 'Pantalla rota']);
    }

    public function test_repair_and_summary_pages_render(): void
    {
        $user = User::factory()->create();
        $client = Client::create(['name' => 'Carlos', 'phone' => '555555555']);
        $repair = Repair::create([
            'client_id' => $client->id,
            'device' => 'Moto G',
            'issue' => 'No enciende',
            'estimated_price' => 5000,
            'status' => RepairStatus::COMPLETADO,
            'received_at' => now(),
            'delivered_at' => now(),
        ]);

        $this->actingAs($user)->get(route('repairs.show', $repair))->assertOk();
        $this->actingAs($user)->get(route('repairs.edit', $repair))->assertOk();
        $this->actingAs($user)->get(route('clients.show', $client))->assertOk();
        $this->actingAs($user)->get(route('summary.index'))->assertOk();
    }

    public function test_can_update_repair_status(): void
    {
        $user = User::factory()->create();
        $client = Client::create(['name' => 'Maria', 'phone' => '987654321']);
        $repair = Repair::create([
            'client_id' => $client->id,
            'device' => 'Samsung S21',
            'issue' => 'Bateria',
            'estimated_price' => 8000,
            'status' => RepairStatus::PENDIENTE,
            'received_at' => now(),
        ]);

        $response = $this->actingAs($user)->patch(route('repairs.updateStatus', $repair), [
            'status' => RepairStatus::EN_PROCESO->value,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('repairs', ['id' => $repair->id, 'status' => RepairStatus::EN_PROCESO->value]);
    }
}

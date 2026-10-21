<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HostManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_reach_the_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');

        $this->post('/dashboard/update', [
            'host' => 'Web', 'ip' => 'fjellserver.no', 'port' => 443, 'rank' => 1,
        ])->assertRedirect('/login');

        $this->assertDatabaseCount('hosts', 0);
    }

    public function test_a_host_can_be_added_with_valid_input(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/dashboard/update', [
                'host' => 'Web', 'ip' => 'https://fjellserver.no', 'port' => 443, 'rank' => 1,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('hosts', [
            'name' => 'Web', 'ip' => 'https://fjellserver.no', 'port' => '443', 'rank' => '1',
        ]);
    }

    public function test_invalid_host_input_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/dashboard/update', [
                'host' => 'Bad', 'ip' => 'file:///etc/passwd', 'port' => 70000, 'rank' => 'first',
            ])
            ->assertSessionHasErrors(['ip', 'port', 'rank']);

        $this->actingAs(User::factory()->create())
            ->post('/dashboard/update', [
                'host' => 'Bad', 'ip' => 'user:pass@internal.host', 'port' => 80, 'rank' => 1,
            ])
            ->assertSessionHasErrors(['ip']);

        $this->assertDatabaseCount('hosts', 0);
    }

    public function test_removing_a_host_deletes_it_and_its_status_rows(): void
    {
        $id = DB::table('hosts')->insertGetId([
            'name' => 'Web', 'ip' => 'fjellserver.no', 'port' => '443', 'rank' => '7',
        ]);
        DB::table('status')->insert([
            'host' => 'Web', 'up_down' => 'online', 'rank' => '7', 'created_at' => now(), 'down_count' => '0',
        ]);

        $this->actingAs(User::factory()->create())
            ->post('/dashboard/host/'.$id)
            ->assertRedirect();

        $this->assertDatabaseMissing('hosts', ['id' => $id]);
        $this->assertDatabaseCount('status', 0);
    }

    public function test_editing_a_host_requires_an_existing_id(): void
    {
        $id = DB::table('hosts')->insertGetId([
            'name' => 'Web', 'ip' => 'fjellserver.no', 'port' => '443', 'rank' => '1',
        ]);

        $this->actingAs(User::factory()->create())
            ->post('/dashboard/hostedit/update', [
                'id' => $id + 1, 'host' => 'Web', 'ip' => 'fjellserver.no', 'port' => 80, 'rank' => 1,
            ])
            ->assertSessionHasErrors(['id']);

        $this->actingAs(User::factory()->create())
            ->post('/dashboard/hostedit/update', [
                'id' => $id, 'host' => 'Web2', 'ip' => 'fjellserver.no', 'port' => 80, 'rank' => 2,
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('hosts', ['id' => $id, 'name' => 'Web2', 'port' => '80', 'rank' => '2']);
    }

    public function test_publishing_an_incident_stores_it_and_posts_to_discord(): void
    {
        config(['discord.DISCORD_WEBHOOK' => 'https://discord.com/api/webhooks/123/abc']);
        Http::fake();

        $this->actingAs(User::factory()->create())
            ->post('/dashboard', [
                'name' => 'Vedlikehold', 'description' => 'Planlagt', 'category' => 'fix', 'signatur' => 'Drift',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('info', ['name' => 'Vedlikehold', 'category' => 'fix']);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://discord.com/api/webhooks/123/abc'
                && str_ends_with($request['embeds'][0]['title'], ' Vedlikehold');
        });
    }

    public function test_an_incident_is_never_posted_to_a_non_discord_url(): void
    {
        config(['discord.DISCORD_WEBHOOK' => 'https://evil.example/collect']);
        Http::fake();

        $this->actingAs(User::factory()->create())
            ->post('/dashboard', [
                'name' => 'Test', 'description' => 'x', 'category' => 'good', 'signatur' => 'y',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('info', ['name' => 'Test']);
        Http::assertNothingSent();
    }

    public function test_unknown_incident_categories_are_rejected(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/dashboard', [
                'name' => 'Test', 'description' => 'x', 'category' => 'other', 'signatur' => 'y',
            ])
            ->assertSessionHasErrors(['category']);

        $this->assertDatabaseCount('info', 0);
    }
}

<?php
namespace Tests\Feature\Roles;

use App\User;

use Tests\Facades\UserFactory;
use Tests\TestCase;

/**
 * Class CreateTest
 * @package Tests\Feature\Roles
 */
class CreateTest extends TestCase
{
    private const URI = 'v1/roles/create';

    /**
     * @var User
     */
    private $admin;

    /**
     * @var array
     */
    private $roleData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = UserFactory::withTokens()->asAdmin()->create();

        $this->roleData = ['name' => 'time-traveler'];
    }

    public function test_create()
    {
        $this->assertDatabaseMissing('role', $this->roleData);

        $response = $this->actingAs($this->admin)->postJson(self::URI, $this->roleData);

        $response->assertSuccess();
        $this->assertDatabaseHas('role', $this->roleData);
        $this->assertDatabaseHas('role', $response->json('res'));
    }

    public function test_unauthorized()
    {
        $response = $this->postJson(self::URI);

        $response->assertUnauthorized();
    }
}

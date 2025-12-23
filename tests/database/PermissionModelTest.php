<?php

namespace Tests\Database;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\UserPermissionModel;


final class PermissionModelTest extends CIUnitTestCase
{
  use DatabaseTestTrait;

  // Configuration des tests
  protected $migrate = true;
  protected $refresh = true;
  protected $DBGroup = 'tests';
  protected $namespace = 'App';

  private UserPermissionModel $permissionModel;

  private int $adminId;
  private int $userId;

  protected function setUp(): void
  {
    parent::setUp();

    $this->permissionModel = new UserPermissionModel();
    $this->adminId = 1;
    $this->userId = 2;
  }

  public function testCanCreatePermission()
  {
    $data = [
      'name' => 'Moderator',
      'slug' => 'moderator',
    ];

    $permissionId = $this->permissionModel->insert($data);
    $this->assertIsInt($permissionId);

    $permission = $this->permissionModel->find($permissionId);
    $this->assertNotNull($permission);
    $this->assertEquals('moderator', $permission['slug']);
  }

  public function testCanReadPermission()
  {
    $permissionId = $this->permissionModel->insert([
      'name' => 'Moderator',
      'slug' => 'moderator',
    ]);
    $permission = $this->permissionModel->find($permissionId);
    $this->assertNotNull($permission);
    $this->assertEquals('Moderator', $permission['name']);
  }
}

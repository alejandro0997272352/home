<?php

namespace Tests\Feature;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSubjectManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_subjects_list()
    {
        Subject::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/materias');

        $response->assertStatus(200);
        $response->assertViewIs('admin.materias.index');
    }

    public function test_admin_can_view_create_subject_form()
    {
        $response = $this->actingAs($this->admin)->get('/admin/materias/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.materias.create');
    }

    public function test_admin_can_create_subject()
    {
        $response = $this->actingAs($this->admin)->post('/admin/materias', [
            'nombre' => 'Matemáticas Discretas',
            'codigo' => 'MAT-202',
            'area' => 'Matemáticas',
            'creditos' => 6,
            'descripcion' => 'Curso de matemáticas discretas',
        ]);

        $response->assertRedirect('/admin/materias');
        $this->assertDatabaseHas('subjects', ['codigo' => 'MAT-202']);
    }

    public function test_admin_can_edit_subject()
    {
        $subject = Subject::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/materias/{$subject->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.materias.edit');
    }

    public function test_admin_can_update_subject()
    {
        $subject = Subject::factory()->create(['nombre' => 'Old Name']);

        $response = $this->actingAs($this->admin)->put("/admin/materias/{$subject->id}", [
            'nombre' => 'Updated Name',
            'codigo' => $subject->codigo,
            'area' => $subject->area,
            'creditos' => $subject->creditos,
        ]);

        $response->assertRedirect('/admin/materias');
        $this->assertDatabaseHas('subjects', [
            'id' => $subject->id,
            'nombre' => 'Updated Name',
        ]);
    }

    public function test_admin_can_delete_subject()
    {
        $subject = Subject::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/materias/{$subject->id}");

        $response->assertRedirect('/admin/materias');
        $this->assertModelMissing($subject);
    }

    public function test_admin_can_search_subjects()
    {
        Subject::factory()->create(['nombre' => 'Álgebra Lineal']);
        Subject::factory()->create(['nombre' => 'Cálculo']);

        $response = $this->actingAs($this->admin)->get('/admin/materias?search=Álgebra');

        $response->assertStatus(200);
    }

    public function test_admin_can_filter_subjects_by_area()
    {
        Subject::factory()->create(['area' => 'Matemáticas']);
        Subject::factory()->create(['area' => 'Física']);

        $response = $this->actingAs($this->admin)->get('/admin/materias?area=Matemáticas');

        $response->assertStatus(200);
    }

    public function test_admin_can_view_import_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/materias/importar');

        $response->assertStatus(200);
        $response->assertViewIs('admin.materias.import');
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_registro_valido_guarda_usuario_con_contrasena_hasheada(): void
    {
        $response = $this->postJson(route('registro.procesar'), [
            'name' => 'Ana Test',
            'email' => 'ana@example.com',
            'edad' => 20,
            'password' => 'secreto123',
            'password_confirmation' => 'secreto123',
        ]);

        $response->assertCreated()
            ->assertJsonPath('ok', true);

        $this->assertDatabaseHas('users', [
            'email' => 'ana@example.com',
            'name' => 'Ana Test',
            'edad' => 20,
        ]);

        $usuario = User::where('email', 'ana@example.com')->firstOrFail();
        $this->assertNotSame('secreto123', $usuario->password);
    }

    public function test_registro_rechaza_email_repetido_y_edad_menor_a_18(): void
    {
        User::factory()->create(['email' => 'ana@example.com']);

        $this->postJson(route('registro.procesar'), [
            'name' => 'Otra Ana',
            'email' => 'ana@example.com',
            'edad' => 20,
            'password' => 'secreto123',
            'password_confirmation' => 'secreto123',
        ])->assertUnprocessable()->assertJsonValidationErrors('email');

        $this->postJson(route('registro.procesar'), [
            'name' => 'Menor',
            'email' => 'menor@example.com',
            'edad' => 17,
            'password' => 'secreto123',
            'password_confirmation' => 'secreto123',
        ])->assertUnprocessable()->assertJsonValidationErrors('edad');
    }

    public function test_perfil_requiere_autenticacion_y_usuario_puede_actualizarlo(): void
    {
        $this->get('/perfil')->assertRedirect('/login');

        $usuario = User::factory()->create(['edad' => 22]);

        $this->actingAs($usuario)
            ->putJson(route('perfil.actualizar'), [
                'name' => 'Nombre Actualizado',
                'edad' => 23,
            ])
            ->assertOk()
            ->assertJsonPath('usuario.name', 'Nombre Actualizado');

        $this->assertDatabaseHas('users', [
            'id' => $usuario->id,
            'name' => 'Nombre Actualizado',
            'edad' => 23,
        ]);
    }
}

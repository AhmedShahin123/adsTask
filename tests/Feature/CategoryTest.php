<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    /** @test */
    public function testIndexReturnsDataInValidFormat() {

    $this->json('get', 'api/v1/categories')
         ->assertStatus(Response::HTTP_OK)
         ->assertJsonStructure(
             [
                 'data' => [
                     '*' => [
                         'id',
                         'name',
                         'created_at',
                         'updated_at'
                     ]
                 ]
             ]
         );
  }

      public function testCategoryIsCreatedSuccessfully() {

        $payload = [
            'name' => 'test category',
        ];
        $this->json('post', 'api/v1/category', $payload)
             ->assertStatus(200)
             ->assertJsonStructure(
                 [
                     'data' => [
                         'id',
                         'name',
                         'created_at',
                         'updated_at'
                     ]
                 ]
             );
        $this->assertDatabaseHas('categories', $payload);
    }




}

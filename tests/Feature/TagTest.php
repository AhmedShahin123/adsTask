<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Tag;

class TagTest extends TestCase
{

    /** @test */
    public function testIndexReturnsDataInValidFormat() {

    $this->json('get', 'api/v1/tags')
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

  public function testTagIsCreatedSuccessfully() {

    $payload = [
        'name' => 'test tag',
    ];
    $this->json('post', 'api/v1/tag', $payload)
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
    $this->assertDatabaseHas('tags', $payload);
}


}

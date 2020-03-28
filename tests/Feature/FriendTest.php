<?php

namespace Tests\Feature;

use App\Friend;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FriendTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_send_a_friend_request()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        $response = $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        $friendRequest = Friend::first();
        $this->assertNotNull($friendRequest);
        $this->assertEquals($anotherUser->id, $friendRequest->friend_id);
        $this->assertEquals($user->id, $friendRequest->user_id);

        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => null,
                ]
            ],
            'links' => [
                'self' => url('/users/' . $anotherUser->id),
            ]
        ]);
    }

    /** @test */
    public function only_valid_user_can_be_friend_requested()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/friend-request', [
            'friend_id' => 123,
        ])->assertStatus(404);

        $this->assertNull(Friend::first());
        $response->assertJson([
            'errors' =>  [
                'code' => 404,
                'title' => 'User Not Found',
                'detail' => 'Unable to locate user information.'
            ]
        ]);
    }

    /** @test */
    public function friend_request_can_be_accepted()
    {
        //start friend request to anotherUser
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        //end request to anotherUser


        //login with accont anotherUser(actingAs) kemudian accept friend request
        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/friend-request-response', [
                'user_id' => $user->id, //memastikan merupakan valid friend request
                'status' => 1, //
            ])->assertStatus(200);

        $friendRequest = Friend::first(); //merupakan friend request yang complited ->first() memastikan itu adalah model bukan collection
        $this->assertNotNull($friendRequest->confirmed_at); //friend request complited maka akan menghasilkan timestamp waktu konfirmasi dan hasilnya tidak null
        $this->assertInstanceOf(Carbon::class, $friendRequest->confirmed_at);
        $this->assertEquals(now()->startOfSecond(), $friendRequest->confirmed_at);
        $this->assertEquals(1, $friendRequest->status);
        $response->assertJson([
            'data' => [
                'type' => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes' => [
                    'confirmed_at' => $friendRequest->confirmed_at->diffForHumans(),
                ]
            ],
            'links' => [
                'self' => url('/users/' . $anotherUser->id),
            ]
        ]);
    }

    /** @test */
    public function only_valid_friend_request_can_be_accepted()
    {
        /* fungsi test ini untuk memastikan hanya user valid yang dapat diterima oleh requestnya */
        $anotherUser = factory(User::class)->create();
        $response = $this->actingAs($anotherUser, 'api')
            ->post('/api/friend-request-response', [
                'user_id' => 123, //memastikan merupakan valid friend request
                'status' => 1, //
            ])->assertStatus(404);

        $this->assertNull(Friend::first());
        $response->assertJson([
            'errors' =>  [
                'code' => 404,
                'title' => 'Friend Request Not Found',
                'detail' => 'Unable to locate request with the given information.'
            ]
        ]);
    }

    /** @test */
    public function only_the_recipient_can_accept_a_friend_request()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();
        $this->post('/api/friend-request', [
            'friend_id' => $anotherUser->id,
        ])->assertStatus(200);

        //third user yang mencoba meng-accept request (invalid request)
        $response = $this->actingAs(factory(User::class)->create(), 'api')
            ->post('/api/friend-request-response', [
                'user_id' => $user->id,
                'status' => 1,
            ])->assertStatus(404);


        $friendRequest = Friend::first();
        $this->assertNull($friendRequest->confirmed_at);
        $this->assertNull($friendRequest->status);
        $response->assertJson([
            'errors' =>  [
                'code' => 404,
                'title' => 'Friend Request Not Found',
                'detail' => 'Unable to locate request with the given information.'
            ]
        ]);
    }

    //validation Rule untuk friend request
    //rule1 friend_id is required

    /** @test */
    public function a_friend_id_is_required_for_friend_request()
    {
        $response = $this->actingAs($user = factory(User::class)->create(), 'api')
            ->post('/api/friend-request', [
                'friend_id' => '',
            ])->assertStatus(422);

        //turn back into assoc array from json
        $responseString = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('friend_id', $responseString['errors']['meta']);
    }


    //rule2 pada untuk friend request response bahwa user_id dan status adalah required

    /** @test */
    public function a_user_id_and_status_is_required_for_friend_request_responses()
    {
        $response = $this->actingAs($user = factory(User::class)->create(), 'api')
            ->post('/api/friend-request-response', [
                'user_id' => '',
                'status' => '',
            ])->assertStatus(422);


        $responseString = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('user_id', $responseString['errors']['meta']);
        $this->assertArrayHasKey('status', $responseString['errors']['meta']);
    }

    //end validation

    /** @test */
    public function a_friendship_is_retrived_when_fetching_the_profile()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        //create friend request
        $friendRequest = Friend::create([
            'user_id' => $user->id,
            'friend_id' => $anotherUser->id,
            'confirmed_at' => now()->subDay(),
            'status' => 1,
        ]);

        $this->get('/api/users/' . $anotherUser->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'friendship' => [
                            'data' => [
                                'friend_request_id' => $friendRequest->id,
                                'attributes' => [
                                    'confirmed_at' => '1 day ago',
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function an_inverse_friendship_is_retrived_when_fetching_the_profile()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $anotherUser = factory(User::class)->create();

        //create friend request
        $friendRequest = Friend::create([
            'friend_id' => $user->id,
            'user_id' => $anotherUser->id,
            'confirmed_at' => now()->subDay(),
            'status' => 1,
        ]);

        $this->get('/api/users/' . $anotherUser->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'friendship' => [
                            'data' => [
                                'friend_request_id' => $friendRequest->id,
                                'attributes' => [
                                    'confirmed_at' => '1 day ago',
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }
}

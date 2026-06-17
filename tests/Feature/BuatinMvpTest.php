<?php

use App\Models\CustomOrder;
use App\Models\Seller;
use App\Models\User;

it('lets a new account create its own store without touching the demo store', function () {
    $this->seed();

    $demo = Seller::where('slug', 'disyanz3d')->firstOrFail();
    $newUser = User::factory()->create();

    $this->actingAs($newUser)->post(route('seller.start.store'), [
        'brand_name' => 'Kue Custom Andi',
        'category' => 'Kue custom',
        'whatsapp' => '082260638053',
        'location' => 'Surabaya',
        'description' => 'Menerima pesanan kue ulang tahun custom.',
    ])->assertRedirect(route('seller.dashboard'));

    $demo->refresh();

    expect($demo->brand_name)->toBe('Disyan 3D Studio')
        ->and($demo->user_id)->not->toBe($newUser->id)
        ->and(Seller::where('slug', 'kue-custom-andi')->where('user_id', $newUser->id)->exists())->toBeTrue();
});

it('requires login before reaching the seller dashboard', function () {
    $this->seed();

    $this->get(route('seller.dashboard'))->assertRedirect(route('login'));
});

it('only resolves the store owned by the logged-in account', function () {
    $this->seed();

    $demo = Seller::where('slug', 'disyanz3d')->firstOrFail();
    $strangerWithoutStore = User::factory()->create();

    // A logged-in account with no store of its own must not fall through to the demo store.
    $this->actingAs($strangerWithoutStore)
        ->get(route('seller.dashboard'))
        ->assertRedirect(route('seller.start'));
});

it('lets a seller select a subscription plan for the freemium MVP', function () {
    $this->seed();

    $seller = Seller::where('slug', 'disyanz3d')->firstOrFail();

    $this->actingAs($seller->user)->post(route('seller.subscription.update'), [
        'plan' => 'starter',
    ])->assertRedirect();

    $seller->refresh();

    expect($seller->plan)->toBe('starter')
        ->and($seller->subscription_status)->toBe('active');
});

it('lets a seller add a custom product to the public catalog and order form', function () {
    $this->seed();

    $seller = Seller::where('slug', 'disyanz3d')->firstOrFail();

    $this->actingAs($seller->user)->post(route('seller.products.store'), [
        'name' => 'Lampu nama custom',
        'category' => 'Merchandise',
        'description' => 'Lampu meja dengan nama dan bentuk custom.',
        'starting_price' => 175000,
        'is_featured' => '1',
    ])->assertRedirect();

    $this->assertDatabaseHas('products', [
        'seller_id' => $seller->id,
        'name' => 'Lampu nama custom',
        'category' => 'Merchandise',
        'starting_price' => 175000,
        'is_featured' => true,
    ]);

    $this->get(route('public.store', $seller))
        ->assertOk()
        ->assertSee('Lampu nama custom')
        ->assertSee('Merchandise');

    $this->get(route('public.order.create', $seller))
        ->assertOk()
        ->assertSee('Pilih produk acuan dari katalog')
        ->assertSee('Tipe pesanan custom yang ingin dibuat')
        ->assertSee('Lampu nama custom');
});

it('limits free sellers to three products before upgrade', function () {
    $this->seed();

    $user = User::factory()->create();
    $seller = Seller::create([
        'user_id' => $user->id,
        'brand_name' => 'Stiker Custom Andi',
        'slug' => 'stiker-custom-andi',
        'category' => 'Stiker custom',
        'whatsapp' => '082260638053',
        'plan' => 'free',
        'subscription_status' => 'active',
    ]);

    foreach (['Produk 1', 'Produk 2', 'Produk 3'] as $name) {
        $seller->products()->create([
            'name' => $name,
            'category' => 'Stiker',
            'description' => 'Produk test',
            'starting_price' => 10000,
            'is_featured' => true,
        ]);
    }

    $this->actingAs($user)->post(route('seller.products.store'), [
        'name' => 'Produk 4',
        'category' => 'Stiker',
        'description' => 'Produk tambahan',
        'starting_price' => 15000,
        'is_featured' => '1',
    ])->assertSessionHasErrors('name');

    $this->assertDatabaseMissing('products', [
        'seller_id' => $seller->id,
        'name' => 'Produk 4',
    ]);
});

it('lets a customer submit a custom order and view the summary', function () {
    $this->seed();

    $seller = Seller::where('slug', 'disyanz3d')->firstOrFail();
    $product = $seller->products()->firstOrFail();

    $response = $this->post(route('public.order.store', $seller), [
        'customer_name' => 'Andi Test',
        'customer_whatsapp' => '081234567891',
        'product_id' => $product->id,
        'product_type' => 'Mini figure custom',
        'material' => 'PLA',
        'size' => '12 cm',
        'color' => 'Hitam',
        'quantity' => 2,
        'budget' => 'Rp300.000',
        'notes' => 'Test pesanan dari automated test.',
    ]);

    $order = $seller->customOrders()->latest('id')->firstOrFail();

    $response->assertRedirect(route('orders.summary', $order));
    $this->get(route('orders.summary', $order))->assertOk()->assertSee($order->order_code);
    $this->get(route('orders.status', $order))->assertOk()->assertSee('Status Pesanan');

    expect($order->estimated_price)->toBe($product->starting_price * 2);
});

it('lets a seller update order and payment statuses', function () {
    $this->seed();

    $seller = Seller::where('slug', 'disyanz3d')->firstOrFail();
    $order = CustomOrder::create([
        'seller_id' => $seller->id,
        'order_code' => 'BID-TEST01',
        'customer_name' => 'Disyan',
        'customer_whatsapp' => '081234567890',
        'product_type' => 'Prototype casing',
        'quantity' => 1,
        'estimated_price' => 90000,
        'status' => 'waiting_payment',
        'payment_status' => 'unpaid',
    ]);

    $this->actingAs($seller->user)->patch(route('seller.orders.update', $order), [
        'status' => 'processing',
        'payment_status' => 'paid',
    ])->assertRedirect();

    $order->refresh();

    expect($order->status)->toBe('processing')
        ->and($order->payment_status)->toBe('paid');
});

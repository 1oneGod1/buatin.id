<?php

use App\Models\CustomOrder;
use App\Models\Seller;

it('lets a seller add a custom product to the public catalog and order form', function () {
    $this->seed();

    $seller = Seller::where('slug', 'disyanz3d')->firstOrFail();

    $this->post(route('seller.products.store'), [
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

    $this->patch(route('seller.orders.update', $order), [
        'status' => 'processing',
        'payment_status' => 'paid',
    ])->assertRedirect();

    $order->refresh();

    expect($order->status)->toBe('processing')
        ->and($order->payment_status)->toBe('paid');
});

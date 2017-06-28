# reworker-api-php
reworder integration

$reworker_product1 = new ReworkerProduct('123', '1', '1');
        $reworker_product2 = new ReworkerProduct('123', '2', '2');

        $reworker_order = new ReworkerOrder();
        $reworker_order->set_order_phone('89188865427')
            ->set_products([$reworker_product1, $reworker_product2]);

        $reworker = new Reworker('123', '123');
        $response = $reworker->createOrder($reworker_order);

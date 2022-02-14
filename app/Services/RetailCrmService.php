<?php

namespace App\Services;

use RetailCrm\Api\Client;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Model\Entity\Orders\Items\Offer;
use RetailCrm\Api\Model\Entity\Orders\Items\OrderProduct;
use RetailCrm\Api\Model\Entity\Orders\Order;
use RetailCrm\Api\Model\Filter\Store\ProductFilterType;
use RetailCrm\Api\Model\Request\Orders\OrdersCreateRequest;
use RetailCrm\Api\Model\Request\Store\ProductsRequest;
use RetailCrm\Api\Model\Response\Orders\OrdersCreateResponse;

class RetailCrmService {
    protected Client $client;

    public function __construct()
    {
        $this->client = SimpleClientFactory::createClient(
            config('retailcrm.api_url'),
            config('retailcrm.api_key'),
        );
    }

    public function getProductOffers(array $data): array {
        $request = new ProductsRequest();
        $request->filter = new ProductFilterType();

        $request->filter->name = $data['article'];
        $request->filter->manufacturer = $data['manufacturer'];

        $response = $this->client->store->products($request);

        return $response->products[0]->offers;
    }

    public function createOrder(array $data): OrdersCreateResponse {
        $ordersCreateRequest = new OrdersCreateRequest();
        $offer = new Offer();
        $item = new OrderProduct();
        $order = new Order();

        $offer->id = $data['productOfferId'];

        $item->offer = $offer;

        $order->lastName = $data['lastName'];
        $order->firstName = $data['firstName'];
        $order->patronymic = $data['patronymic'];
        $order->status = $data['status'];
        $order->orderType = $data['orderType'];
        $order->site = $data['site'];
        $order->orderMethod = $data['orderMethod'];
        $order->number = $data['number'];
        $order->customerComment = $data['customerComment'];
        $order->items = [$item];

        $ordersCreateRequest->order = $order;

        return $this->client->orders->create($ordersCreateRequest);
    }
}

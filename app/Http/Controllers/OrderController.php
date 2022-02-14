<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\RetailCrmService;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;

class OrderController extends Controller
{
    protected RetailCrmService $retailCrmService;

    public function __construct(RetailCrmService $retailCrmService)
    {
        $this->retailCrmService = $retailCrmService;
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(OrderRequest $request)
    {
        $validatedData = $request->validated();
        $fullName = explode(' ', $validatedData['fullName']);
        $productData = [
            'article' => $validatedData['article'],
            'manufacturer' => $validatedData['manufacturer'],
        ];
        $orderData = [
            'lastName' => $fullName[0],
            'firstName' => $fullName[1],
            'patronymic' => $fullName[2],
            'customerComment' => $validatedData['customerComment'],
            'status' => 'trouble',
            'orderType' => 'fizik',
            'site' => 'test',
            'orderMethod' => 'test',
            'number' => '20072000',
        ];

        try {
            $orderData['productOfferId'] = $this->retailCrmService
                ->getProductOffers($productData)[0]->id;
        } catch (ApiExceptionInterface $ex) {
            return back()->with('status', $ex->getMessage());
        }

        try {
            $this->retailCrmService->createOrder($orderData);
        } catch (ApiExceptionInterface $ex) {
            return back()->with('status', $ex->getMessage());
        }

        return back()->with('status', 'Заказ успешно создан!');
    }
}

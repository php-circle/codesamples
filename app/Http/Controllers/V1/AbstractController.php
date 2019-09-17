<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Factories\ApiResponse\ApiResponseFactoryInterface;

abstract class AbstractController
{
    /**
     * @var \App\Factories\ApiResponse\ApiResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * AbstractController constructor.
     *
     * @param \App\Factories\ApiResponse\ApiResponseFactoryInterface $responseFactory
     */
    public function __construct(ApiResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }
}

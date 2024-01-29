<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PetController extends Controller
{
    /**
     * @var ApiService
     */
    private $apiService;

    public function __construct()
    {
        $this->apiService = new ApiService();
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application
    {
        return view('welcome');
    }

    /**
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     * @throws Exception
     */
    public function show(int $id): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $response = $this->apiService->makeGetRequest(env('PETS_API_URL') . $id);

        $pet = json_decode($response->getBody()->getContents(), true);

        return view('show_pet', compact('pet'));
    }

    /**
     * @param int $id
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     * @throws Exception
     */
    public function edit(int $id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $response = $this->apiService->makeGetRequest(env('PETS_API_URL') . $id);

        $pet = json_decode($response->getBody()->getContents(), true);

        return view('edit_pet', compact('pet'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function showCreatePetForm(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('create_pet');
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function searchForm(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('search');
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function delete(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('delete');
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function uploadFoto(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('upload_image');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Requests\Contact\ShowContactRequest;
use App\Http\Requests\Contact\IndexContactRequest;
use App\Http\Services\ContactServiceInterface;

class ContactController extends Controller
{
    public function __construct(ContactServiceInterface $contactService)
    {
        $this->middleware('auth');
        $this->contactService = $contactService;
    }

    public function index(IndexContactRequest $request)
    {
        $request->validated();

        $response = $this->contactService->index($request->group_id, $request->search, $request->per_page);

        return view('contact.grid', $response);
    }

    public function show(ShowContactRequest $request)
    {
        $request->validated();

        $response = $this->contactService->show($request->id);

        return view('contact.form', $response);
    }

    public function store(StoreContactRequest $request)
    {
        $request->validated();

        $contact = $this->contactService->store(
            $request->name,
            $request->name_file,
            $request->groups,
            $request->phones,
            $request->addresses
        );

        return response($contact, 200);
    }

    public function update(UpdateContactRequest $request, int $id)
    {
        $request->validated();

        $contact = $this->contactService->update(
            $id,
            $request->name,
            $request->name_file,
            $request->groups,
            $request->phones,
            $request->addresses
        );

        return response($contact, 200);
    }

    public function destroy(int $id)
    {
        try {
            $this->contactService->destroy($id);

            return response([], 200);
        } catch (\Throwable $exception) {
            return response("Ocorreu um erro ao realizar a opereção", 500);
        }
    }
}

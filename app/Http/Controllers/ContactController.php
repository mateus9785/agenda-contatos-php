<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\IndexContactRequest;
use App\Http\Requests\Contact\ShowContactRequest;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Services\ContactServiceInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ContactController extends Controller implements HasMiddleware
{
    private ContactServiceInterface $contactService;

    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    /**
     * Cria uma nova intância do controller e faz injeção de dependência dos services
     *
     * @return void
     */
    public function __construct(ContactServiceInterface $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Método de mostrar vários contatos.
     *
     * @param  App\Http\Requests\Contact\IndexContactRequest  $request
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function index(IndexContactRequest $request)
    {
        $request->validated();

        $response = $this->contactService->index($request->group_id, $request->search, $request->per_page);

        return view('contact.grid', $response);
    }

    /**
     * Método de mostrar contato.
     *
     * @param  App\Http\Requests\Contact\ShowContactRequest  $request
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function show(ShowContactRequest $request)
    {
        $request->validated();

        $response = $this->contactService->show($request->id);

        return view('contact.form', $response);
    }

    /**
     * Método de cadastrar contato.
     *
     * @param  App\Http\Requests\Contact\StoreContactRequest  $request
     * @return Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Método de alterar contato.
     *
     * @param  App\Http\Requests\Contact\UpdateContactRequest  $request
     * @return Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Método de apagar contato.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->contactService->destroy($id);

            return response([], 200);
        } catch (\Throwable $exception) {
            return response('Ocorreu um erro ao realizar a opereção', 500);
        }
    }
}

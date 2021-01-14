<?php
$group_id = isset($_GET['group_id']) && !empty($_GET['group_id']) ? $_GET['group_id'] : '';
$page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : '';
$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : '';
?>

<script>
    var baseUrl = '<?php echo env('
    APP_URL '); ?>';

    function deleteContact(id) {
        let data = {
            _token: $("[name='_token']").val()
        }

        requestAjax("DELETE", `${baseUrl}/contact/${id}`, data, function() {
            window.location.reload(false);
        })
    }

    function editeContact(id) {
        window.location.href = `${baseUrl}/contact/form?id=${id}`;
    }

    function changeGroup(element, page) {
        let group_id = $(element).val();
        var page = "<?php echo $page; ?>";
        var search = $("#search").val();

        window.location.href = `${baseUrl}/contact?group_id=${group_id}&page=${page}&search=${search}`;
    }

</script>

@extends('layouts.app')

@section('content')
    <div class="row size-all-screen">
        @include('layouts.sidebar')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Contatos</h1>
            </div>
            <div class="container">
                <div class="float-right mt-2 mb-2">
                    <a href="/contact/form" class="btn btn-success">Novo contato</a>
                </div>
                <div class="row">
                    @include('contact.autocomplete', ['all_contacts' => $all_contacts])
                    <div class="col-4">
                        <label for="group" class="form-label">Grupo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                            <select class="form-select" id="group"
                                onchange="changeGroup(this, {{ $contacts->currentPage() }})">
                                <option value="" {{ !$group_id ? 'selected' : '' }}>Todos</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" {{ $group_id == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row justify-content-center table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Editar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$contacts->total())
                                    <tr>
                                        <td class="text-center" colspan="4">Nenhum registro encontrado...</td>
                                    </tr>
                                @endif
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td>
                                            <div class="table-image-contact">
                                                <span
                                                    class="contact-name-letter">{{ strtoupper(trim($contact->name))[0] }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $contact->name }}</td>
                                        <td>
                                            <button class="btn btn-success" onclick="editeContact({{ $contact->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" {{ $contact->is_user_contact ? 'disabled' : '' }}
                                                onclick="deleteContact({{ $contact->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        @include('components.paginate', ['paginator' => $contacts])
                    </div>
                </div>
            </div>
        </main>
        @include('layouts.footer')
    </div>
@endsection

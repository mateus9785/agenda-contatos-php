<script>
    var baseUrl = '<?php echo env('APP_URL'); ?>';
    var idGroupEdited = null;

    function deleteGroup(id) {
        let data = {
            _token: $("[name='_token']").val()
        }

        requestAjax("DELETE", `${baseUrl}/group/${id}`, data, function() {
            window.location.reload(false);
        })
    }

    function saveGroup() {
        if (idGroupEdited)
            saveEditionGroup()
        else
            registerGroup();
    }

    function registerGroup() {
        let data = {
            name: $("#name").val(),
            _token: $("[name='_token']").val()
        }

        requestAjax("POST", `${baseUrl}/group`, data, function() {
            window.location.reload(false);
        })
    }

    function saveEditionGroup() {
        let data = {
            name: $("#name").val(),
            _token: $("[name='_token']").val()
        }

        requestAjax("PUT", `${baseUrl}/group/${idGroupEdited}`, data, function() {
            window.location.reload(false);
        })
    }

    function editeGroup(id, name) {
        idGroupEdited = id;
        $("#name").val(name);
        $("#cancel-edition").css("display", "block");
        $('.btn-group').attr("disabled", true);
    }

    function cancelEdition() {
        idGroupEdited = null;
        $("#name").val("");
        $("#cancel-edition").css("display", "none");
        $('.btn-group').attr("disabled", false);
    }

    function showContacts(id) {
        window.location.href = `${baseUrl}/contact?/contact?group_id=${id}&page=1&search=`;
    }

</script>

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Grupos de contatos</h1>
                </div>
                <div class="container">
                    <div class="col-md-8 d-flex" id="form-register-group">
                        <input class="form-control me-2 col-md-8" type="text" id="name" name="name" placeholder="Nome">
                        <button class="btn btn-outline-success col-md-2 mr-2"
                            onclick="saveGroup()">Salvar</button>
                        <button class="btn btn-outline-danger col-md-2" id="cancel-edition" style="display: none;"
                            onclick="cancelEdition()">Cancelar</button>
                    </div>
                    </form>
                    <div class="mt-3">
                        <div class="row justify-content-center table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Visualizar</th>
                                        <th>Editar</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$groups->total())
                                        <tr>
                                            <td class="text-center" colspan="4">Nenhum registro encontrado...</td>
                                        </tr>
                                    @endif
                                    @foreach ($groups as $group)
                                        <tr>
                                            <td>{{ $group->name }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-group" onclick="showContacts({{ $group->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-group"
                                                    onclick="editeGroup({{ $group->id }}, '{{ $group->name }}')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-group"
                                                    onclick="deleteGroup({{ $group->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            @include('components.paginate', ['paginator' => $groups])
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

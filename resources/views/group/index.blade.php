<script>
    var idGroupEdited;

    function deleteGroup(id) {
        $.ajax({
            url: `http://127.0.0.1:8000/api/group/${id}`,
            method: "DELETE",
            success: function(response) {
                debugger;
                alert("Grupo deletado com sucesso");
            },
            error: function(err) {
                debugger;
                alert("Erro ", err);
            }
        });

        return false;
    }

    function saveGroup() {

    }

    function editeGroup(id, name) {
        document.getElementById("name").value = name;
        idGroupEdited = id;
        document.getElementById("cancel-edition").style.display = "block";
        let buttons = document.getElementsByClassName('btn-group');
        for (i = 0; i < buttons.length; i++) {
            buttons[i].disabled = true;
        }
    }

    function cancelEdition() {
        idGroupEdited = null;
        document.getElementById("name").value = "";
        document.getElementById("cancel-edition").style.display = "none";
        let buttons = document.getElementsByClassName('btn-group');
        for (i = 0; i < buttons.length; i++) {
            buttons[i].disabled = false;
        }
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
                    <div class="col-md-8 d-flex">
                        <input class="form-control me-2 col-md-8" type="text" name="name" id="name" placeholder="Nome">
                        <button class="btn btn-outline-success col-md-2 mr-2" onclick="saveGroup()">Salvar</button>
                        <button class="btn btn-outline-danger col-md-2" style="display: none;" id="cancel-edition" onclick="cancelEdition()">Cancelar</button>
                    </div>
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
                                    @foreach ($response->data as $group)
                                        <tr>
                                            <td>{{ $group->name }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-group">
                                                    <i class="fas fa-eye">
                                                        <button>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-group"
                                                    onclick="editeGroup({{ $group->id }}, '{{ $group->name }}')">
                                                    <i class="fas fa-edit">
                                                        <button>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-group"
                                                    onclick="deleteGroup({{ $group->id }})">
                                                    <i class="fas fa-trash-alt">
                                                        <button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            @include('components.paginate', ['response' => $response])
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

<script>
    let array_position_edition = null;
    var baseUrl = '<?php echo env('APP_URL '); ?>';
    var contact_id = '<?php echo isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : null; ?>';

    function createListenerVariable(valueVariable) {
        return {
            valueVariable,
            listener: function(val) {},
            set value(val) {
                this.valueVariable = val;
                this.listener(val);
            },
            get value() {
                return this.valueVariable;
            },
            registerListener: function(listener) {
                this.listener = listener;
            }
        }
    }

    let phones_saved = @json($contact['phones']).map(x => x.name);
    let groups_saved = @json($contact['contact_groups']).map(x => { return {
            id: x.group_id,
            name: x.name
        }});
    let addresses_saved = @json($contact['addresses']).map(x => { return {
        cep: x.cep,
        complement: x.complement,
        street: x.street,
        number: x.number,
        city: x.city,
        province: x.province,
        neighborhood: x.neighborhood
    }});

    var groups = createListenerVariable(groups_saved),
        phones = createListenerVariable(phones_saved),
        addresses = createListenerVariable(addresses_saved);

    addresses.registerListener(function(listAddress) {
        $("#table-body-address").empty();
        if (listAddress.length) {
            listAddress.forEach((address, i) => {
                let {
                    cep,
                    complement,
                    street,
                    number,
                    city,
                    province,
                    neighborhood
                } = address;
                $("#table-body-address").append(`
                    <tr>
                        <td>${street}, ${number} - ${neighborhood} - ${city}/${province}</td>
                        <td>${complement}</td>
                        <td>${cep}</td>
                        <td>
                            <button class="btn btn-success btn-group btn-address" onclick="editeAddress(${i})">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-group btn-address" onclick="deleteAddress(${i})">
                                <i class="fas fa-trash-alt"></i>
                            </button>                
                        </td>
                    </tr>
                `)
            });
        } else {
            $("#table-body-address").append(`
                <tr>
                    <td class="text-center" id="not-register" colspan="5">Nenhum registro encontrado</td>
                </tr>`)
        }
    });

    function searchZipCode() {
        let cep = $("#cep").val();
        let url = `https://viacep.com.br/ws/${cep.replace(/\D/g, "")}/json/`
        requestAjax("GET", url, null, function(response) {
            let {
                bairro,
                logradouro,
                uf,
                localidade,
                complemento
            } = response;
            $("#street").val(logradouro);
            $("#neighborhood").val(bairro);
            $("#city").val(localidade);
            $("#province").val(uf);
            $("#complement").val(complemento);
        })
    }

    function addAddress() {
        let cep = $("#cep").val();
        let number = $("#number").val();
        let street = $("#street").val();
        let neighborhood = $("#neighborhood").val();
        let city = $("#city").val();
        let province = $("#province").val();
        let complement = $("#complement").val();

        if (!number || !street || !neighborhood || !city) {
            message_alert('Preencha todos os campos, por favor', 'alert-warning');
            return;
        }

        $(".input-address").val("");

        let address = {
            cep,
            number,
            street,
            neighborhood,
            city,
            province,
            complement
        }

        if (array_position_edition != null)
            addresses.value = [...addresses.value.filter((_, i) => array_position_edition != i), address];
        else
            addresses.value = [...addresses.value, address];

        $("#cancel-edition").addClass("d-none");
    }

    function editeAddress(i) {
        let {
            cep,
            number,
            street,
            neighborhood,
            city,
            province,
            complement
        } = addresses.value[i];

        $("#cep").val(cep);
        $("#number").val(number);
        $("#street").val(street);
        $("#neighborhood").val(neighborhood);
        $("#city").val(city);
        $("#province").val(province);
        $("#complement").val(complement);

        $(".btn-address").attr("disabled", true);
        $("#cancel-edition").removeClass("d-none");

        array_position_edition = i;
    }

    function deleteAddress(i) {
        addresses.value = addresses.value.filter((_, index) => index != i);
    }

    function cancelEdition() {
        $(".input-address").val("");
        $("#cancel-edition").addClass("d-none");
        $(".btn-address").attr("disabled", false);
        array_position_edition = null;
    }

    function saveContact() {
        if (contact_id)
            saveEditionGroup()
        else
            registerContact();
    }

    function registerContact() {
        let data = {
            name: $("#name").val(),
            phones: phones.value,
            groups: groups.value.map(group => group.id),
            addresses: addresses.value,
            _token: $("[name='_token']").val(),
        }

        requestAjax("POST", `${baseUrl}/contact`, data, function() {
            window.location.href = `${baseUrl}/contact?group_id=&page=1&search=`;
        })
    }

    function saveEditionGroup() {
        let data = {
            name: $("#name").val(),
            phones: phones.value,
            groups: groups.value.map(group => group.id),
            addresses: addresses.value,
            _token: $("[name='_token']").val(),
        }

        requestAjax("PUT", `${baseUrl}/contact/${contact_id}`, data, function() {
            window.location.href = `${baseUrl}/contact?group_id=&page=1&search=`;
        })
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
                    <h1 class="h2">Dados do Contato</h1>
                </div>
                <div class="container">
                    <div class="row g-3">
                        <div>
                            <div class="row g-3 mb-2">
                                <div class="col-sm-6">
                                    <label for="name" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="name" placeholder=""
                                        value="{{ $contact['data']->name ?? '' }}">
                                </div>
                                <div class="col-sm-6">
                                    @include('contact.image')
                                </div>
                            </div>
                            @include('contact.fones', ["phones" => $contact['phones']])
                            @include('contact.groups', ["contact_groups" => $contact['contact_groups']])
                            <div class="row mb-2">
                                <div class="col-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-location-arrow"></i>
                                            </span>
                                        </div>
                                        <input type="number" placeholder="CEP" class="form-input form-control input-address"
                                            value="" id="cep">
                                        <div class="input-group-append">
                                            <button type="button" class="table-search-button btn btn-secondary"
                                                onclick="searchZipCode()">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="number" class="form-label">Número</label>
                                    <input type="number" class="form-control input-address" id="number">
                                </div>

                                <div class="col-4">
                                    <label for="street" class="form-label">Rua</label>
                                    <input type="text" class="form-control input-address" id="street">
                                </div>

                                <div class="col-3">
                                    <label for="neighborhood" class="form-label">Bairro</label>
                                    <input type="text" class="form-control input-address" id="neighborhood">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <label for="city" class="form-label">Cidade</label>
                                    <input type="text" class="form-control input-address" id="city">
                                </div>

                                <div class="col-3">
                                    <label for="province" class="form-label">Estado</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-map"></i></span>
                                        <select class="form-select" id="province" required>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province }}">{{ $province }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="complement" class="form-label">Complemento</label>
                                    <input type="text" class="form-control input-address" id="complement">
                                </div>
                            </div>

                            <div class="float-right mt-2 mb-2">
                                <button type="button" class="btn btn-success" onclick="addAddress()">Adicionar
                                    endereço</button>
                                <button id="cancel-edition" type="button" class="btn btn-danger d-none"
                                    onclick="cancelEdition()">Cancelar</button>
                            </div>

                            <div class="mt-3">
                                <div class="row justify-content-center table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Endereço</th>
                                                <th>Complemento</th>
                                                <th>Cep</th>
                                                <th>Editar</th>
                                                <th>Excluir</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body-address">
                                            @if (!sizeof($contact['addresses']))
                                                <tr>
                                                    <td class="text-center" id="not-register" colspan="5">Nenhum registro
                                                        encontrado</td>
                                                </tr>
                                            @endif
                                            @foreach ($contact['addresses'] as $i => $address)
                                                <tr>
                                                    <td>{{ $address->street }}, {{ $address->number }} -
                                                        {{ $address->neighborhood }} -
                                                        {{ $address->city }}/{{ $address->province }}</td>
                                                    <td>{{ $address->complement }}</td>
                                                    <td>{{ $address->cep }}</td>
                                                    <td>
                                                        <button class="btn btn-success btn-group btn-address"
                                                            onclick="editeAddress(${i})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger btn-group btn-address"
                                                            onclick="deleteAddress(${i})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="float-right mt-2">
                                <button class="btn btn-success" onclick="saveContact()">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

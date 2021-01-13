<script>
    phones.registerListener(function(listPhones) {

        $("#phones-numbers").empty();
        if (listPhones.length) {
            listPhones.forEach((phone, i) => {
                $("#div-phones").removeClass("d-none");
                $("#phones-numbers").append(`
            <div class="p-1 m-1 rounded div-phone-number"
                style="background-color: #e5e4e2;">
                <span class="number-phone">${phone}</span>
                <span class="bg-danger text-white rounded-circle pl-2 pr-2 pt-1 pb-1"
                    onclick="removePhone(${i})">
                    <i class="fas fa-times"></i>
                </span>
            </div>`)
            });
        } else {
            $("#div-phones").addClass("d-none");
        }
    });

    function addPhone() {
        let phone = $("#phone").val();
        phone = phone.replace(/\D/g, "").replace(/^0/, "");

        if (!phone) {
            message_alert('Preencha o número do telefone, por favor', 'alert-warning');
            return;
        }

        phones.value = [...phones.value, phone];

        $("#phone").val("");
    }

    function removePhone(i) {
        phones.value = phones.value.filter((_, index) => index != i);
    }

    function changePhone(element) {
        let phone = $(element).val();
        $(element).val(maskPhone(phone));
    }

</script>

<div class="row g-3 mb-3">
    <div class="col-6">
        <label for="phone" class="form-label">Telefone</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
            <input type="text" class="form-control" maxlength="15" id="phone" onkeyup="changePhone(this)">
        </div>
    </div>
    <div class="d-flex align-items-end mb-1 col-md-3">
        <button type="button" class="btn btn-success" onclick="addPhone()">Adicionar
            contato</button>
    </div>
</div>
<div class="row g-3 mb-2">
    <div class="col-12 {{ sizeof($phones) ? "" : "d-none" }}" id="div-phones">
        <div class="col-12 border border-secundary p-3 d-flex" id="phones-numbers">
            @foreach ($phones as $i => $phone)
                <div class="p-1 m-1 rounded div-phone-number" style="background-color: #e5e4e2;">
                    <span class="number-phone">{{ $phone->name }}</span>
                    <span class="bg-danger text-white rounded-circle pl-2 pr-2 pt-1 pb-1"
                        onclick="removePhone(${i})">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>

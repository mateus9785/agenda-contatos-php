<script>
    groups.registerListener(function(listGroups) {
        $("#groups-info").empty();
        if (listGroups.length) {
            listGroups.forEach(group => {
                $("#div-groups").removeClass("d-none");
                $("#groups-info").append(`
                    <div class="p-1 m-1 rounded div-group-info" style="background-color: #e5e4e2;">
                        <span class="info-group">${group.name}</span>
                        <span class="bg-danger text-white rounded-circle pl-2 pr-2 pt-1 pb-1"
                            onclick="removeGroup(${group.id})">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                `)
            });
        } else {
            $("#div-groups").addClass("d-none");
        }
    });

    function removeGroup(id) {
        groups.value = groups.value.filter((group) => group.id != id);
    }

    function addGroup() {
        let id = $("#group").val();
        let name = $("#group option:selected").text();
        if (groups.value.find(group => group.id == id)) {
            message_alert('Esse grupo já foi inserido, verifique!', 'alert-warning');
            return;
        }

        let group = {
            id,
            name
        }
        groups.value = [...groups.value, group]
    }

</script>

<div class="row g-3 mb-3">
    <div class="col-6">
        <label for="group" class="form-label">Grupo</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-users"></i></span>
            <select class="form-select" id="group" required>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="d-flex align-items-end mb-1 col-md-3">
        <button type="button" class="btn btn-success" onclick="addGroup()">Adicionar
            grupo</button>
    </div>
</div>
<div class="row g-3 mb-2">
    <div class="col-12 {{ sizeof($contact_groups) ? "" : "d-none" }}" id="div-groups">
        <div class="col-12 border border-secundary p-3 d-flex" id="groups-info">
            @foreach ($contact_groups as $i => $contact_group)
                <div class="p-1 m-1 rounded div-group-info" style="background-color: #e5e4e2;">
                    <span class="info-group">{{ $contact_group->name }}</span>
                    <span class="bg-danger text-white rounded-circle pl-2 pr-2 pt-1 pb-1"
                        onclick="removeGroup('{{ $contact_group->group_id }}')">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>

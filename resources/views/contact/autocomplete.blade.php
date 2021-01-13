<?php 
    $group_id = isset($_GET['group_id']) && !empty($_GET['group_id']) ? $_GET['group_id'] : "";
    $page =  isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : "";
    $search =  isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : "";
?>

<div class="col-4">
    <label for="group" class="form-label">Busca</label>
    <div class="input-group">
        <div class="input-group">
            <input type="text" value="{{ $search }}" id="search" class="form-input form-control input-address text-uppercase">
            <div id="search-autocomplete-list" class="autocomplete-items"></div>
            <div class="input-group-append">
                <button type="button" class="btn btn-secondary" onclick="searchContacts()">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function searchContacts(){
        var baseUrl = '<?php echo env('APP_URL '); ?>';
        var group_id = $("#group").val();
        var page = "<?php echo $page; ?>";
        var search = $("#search").val();

        window.location.href = `${baseUrl}/contact?group_id=${group_id}&page=${page}&search=${search}`;
    }

    function optionAutocompleteClick(text) {
        $("#search").val(text);
        $("#search-autocomplete-list").empty();
    }

    function autocomplete(array) {
        var currentFocus;
        array = array.map(x => x.toUpperCase());

        $("#search").keyup(function() {

            value = this.value.toUpperCase();

            $("#search-autocomplete-list").empty();

            if (!value)
                return false;

            currentFocus = -1;
            array.forEach(item => {
                if (item.indexOf(value) != -1) {
                    let text = item.replaceAll(value, `<strong>${value}</strong>`);

                    $("#search-autocomplete-list").append(`
                        <div onclick="optionAutocompleteClick('${item}')">
                            ${text}
                            <input type='hidden' value="${item}">
                        </div>
                    `);
                }
            });
        })
    }

    var contacts_names = @json($contacts_names);

    autocomplete(contacts_names);

</script>

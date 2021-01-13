<script>
    async function addImage(target) {
        if (!target.files || !target.files.length) return;

        let file = target.files[0];

        image = {
            name: file.name,
            file,
            urlImage: URL.createObjectURL(file),
        };

        $("#div-image").removeClass("d-none");
        $(".contact-name-letter img").attr("src", image.urlImage);
    }

    function removeImage() {
        image = null;
        $("#div-image").addClass("d-none");
        $("#profile-image").val("")
    }

</script>

<div class="d-flex">
    <div id="div-image" class="d-none">
        <span class="position-absolute bg-danger text-white rounded-circle pl-2 pr-2 pt-1 pb-1"
            onclick="removeImage(this)">
            <i class="fas fa-times"></i>
        </span>
        <div class="table-image-contact">
            <span class="contact-name-letter">
                <img class="image-contact" src="">
            </span>
        </div>
    </div>
    <div class="ml-3">
        <label for="profile-image" class="form-label">Imagem de perfil:</label>
        <input type="file" class="form-control" id="profile-image" onChange="addImage(this)">
    </div>
</div>

<script>
    let selectable = document.querySelector('.zone-selectable'),
        btnSave = document.querySelector('.btnSave'),
        btnDelete = document.querySelector('.btnDelete'),
        input = document.querySelector('#zoneInput'),
        editForm = document.querySelector('#updateZone'),
        deleteForm = document.querySelector('#deleteZone'),
        inputHelp = document.querySelector('#zoneInputHelpBlock');

    selectable.addEventListener('click', function(e){
        input.disabled = false;
        input.focus();
        inputHelp.classList.remove('d-none');
        btnSave.classList.remove('d-none');
    });

    input.addEventListener('focusout', function(e){
        inputHelp.classList.add('d-none');
    });

    btnSave.addEventListener('click', function(e) {
        editForm.submit();
    });

    btnDelete.addEventListener('click', function(e){
        e.preventDefault();
        if (confirm('¿Estás seguro?')) {
            deleteForm.submit();
        }
    });
</script>

<script>
    let neighborhoodInput = document.querySelector('#neighborhoodInput'),
        confirmation_neighborhoodInput = document.querySelector('#confirmation_neighborhoodInput');

    neighborhoodInput.addEventListener('keypress', function(e){

        confirmation_neighborhoodInput.value = neighborhoodInput.value;
    });
    neighborhoodInput.addEventListener('focusout', function(e){

        confirmation_neighborhoodInput.value = neighborhoodInput.value;
    });
</script>

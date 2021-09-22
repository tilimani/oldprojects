<script type="text/javascript">
    let nextBtn = document.getElementById('nextBtn'),
        prevBtn = document.getElementById('prevBtn'),
        nameInput = document.getElementById('nameInput'),
        dateto = document.getElementById('dateto'),
        denyMale = document.getElementById('denyMale'),
        denyFemale = document.getElementById('denyFemale'),
        country = document.getElementById('country'),
        stepsSubmit = document.getElementById('stepsSubmit'),
        options = document.getElementsByClassName('option'),
        denyOptions = document.getElementsByClassName('denyOptions'),
        denyBtn = document.getElementById("denyBtn"),
        unavailableCollapse = document.getElementById("unavailableCollapse"),
        profileCollapse = document.getElementById("profileCollapse"),
        unavailableCollapseBtn = document.getElementById("unavailableCollapseBtn"),
        profileCollapseBtn = document.getElementById("profileCollapseBtn"),
        denyFormInputs = document.getElementById('formInputs').querySelectorAll('.form-control'),
        bookingPass = document.getElementById('bookingPass'),
        bookingPassBtn = document.getElementById('bookingPassBtn'),
        errorMsg = document.getElementById('errorMsg'),

        tabs = document.getElementsByClassName("tab"),
        currentTab = 0,
        localStorageTime = "modalTime",

        configTutoShowBookings = {
            steps: [
                {
                    element: '.tuto-step1',
                    title: 'Confirma la disponibilidad de la habitación:',
                    content: 'Empieza a responder tus solicitudes. Aquí puedes confirmar si la habitación esta disponible o no.',
                    arrow: 'top'
                },
                {
                    element: '.chat-box',
                    title: 'Empieza a conversar:',
                    content: 'Si el estudiante te ha hecho preguntas las puedes responder a través de la función del chat.',
                    arrow: 'top'
                },
                {
                    element: '.tuto-step3',
                    title: '¿Quién soy yo?:',
                    content: 'Conoce la persona que quiere vivir en tu casa, próximamente te daremos más información.',
                    arrow: 'bottom'
                },
                {
                    element: '.tuto-step4',
                    title: '¿Cual es la habitación?:',
                    content: 'La persona quiere ocupar esta habitación, si no está disponible por favor rechaza la solicitud.',
                    arrow: 'bottom'
                }
            ]
        }

    window.onload = init;

    function init(){
        $('#btnIssues').click();
        showTab(currentTab);
        events();
        $('input').keypress(function(e){
            if(e.which == 13){
                return false;
            }
        });
    }

    function events(){
        nextBtn.addEventListener('click', nextStep);
        prevBtn.addEventListener('click', prevStep);
        nameInput.addEventListener('blur', replaceName);
        country.addEventListener('input', function(){ restoreInputClasses('form-control requiredInput')});
        nameInput.addEventListener('input', function(){ restoreInputClasses('form-control requiredInput')});
        dateto.addEventListener('input', function(){ restoreInputClasses('form-control form-control-sm requiredInput d-inline-block w-50')});
        denyMale.addEventListener('click', nextStep);
        denyFemale.addEventListener('click', nextStep);
        bookingPassBtn.addEventListener('click', validatePass);
        bookingPass.addEventListener('focus', (e)=> {

            bookingPass.classList.remove('wrong');
            errorMsg.classList.remove('errorMsg');

        });

        Array.from(denyFormInputs).forEach((elem)=>{
            elem.addEventListener("keyup",(e)=>{
            if(e.keyCode==13){ nextStep() }}
            )
        });

        Array.from(options).forEach((element)=>element.addEventListener('click',(e)=>denyOptions[0].style.display ="none"));
        try{
            denyBtn.addEventListener('click',(e)=>{
                denyOptions[0].style.display ="";
                unavailableCollapse.className="multi-collapse collapse";
                profileCollapse.className="multi-collapse collapse";
            });
        } catch(e){
            console.log(e);
        }
        unavailableCollapseBtn.addEventListener('click', function(e) {alternate(unavailableCollapse,profileCollapse)});
        profileCollapseBtn.addEventListener('click', function(e) {alternate(profileCollapse,unavailableCollapse)});
    }

    function validatePass(){
        let number = 0.0;
        let pass = number.slice(number.length-4);
        number = number.toString();

        if (bookingPass.value == pass) {
            $('#authBookingsModal').modal('hide');
            let actualDate = new Date();
            let actualHour = actualDate.getHours();
            localStorage.setItem(localStorageTime,new Date(actualDate.setHours(actualHour+1)));
        } else {
            bookingPass.classList.add('wrong');
            errorMsg.classList.add('errorMsg');
        }
    }

    function alternate(elemShow,elemHide){
        elemShow.className="multi-collapse collapse show";
        elemHide.className="multi-collapse collapse";
    }

    function restoreInputClasses(classes){
        event.target.className = classes;
    }

    function shake(x,y,element){
        element.style.transform = "translate("+x+"px, "+y+"px)"
    }

    function wrong(element){
        for(let i = 0 ; i <= 6 ; i++){
            setTimeout(shake,100*i,(i%2*2-1)*20,0,element );
            setTimeout(shake, 100 * 6, 0, 0,element);
        }
    }

    function validate(){

        let elemsTab = document.getElementsByClassName("tab")[currentTab];
        let requiredInputs = elemsTab.getElementsByTagName('input');
        let requiredSelects = elemsTab.getElementsByTagName('select');
        let radioInputsChecked = 0 ;
        let areThereRadio = false;
        let valid = true;

        for(let i=0;i<requiredInputs.length;i++){
            if(requiredInputs[i].disabled!=true && requiredInputs[i].type!='radio'){
                if(requiredInputs[i].value==""){
                    requiredInputs[i].className += " invalid"
                    wrong(requiredInputs[i]);
                    valid = false;
                }
            }
            if(requiredInputs[i].type=='radio'){
                areThereRadio = true;
                if(requiredInputs[i].checked==false){
                    radioInputsChecked++;
                }
            }
        }
        if(areThereRadio){
            if (radioInputsChecked == requiredInputs.length) {
                elemsTab.className += " requiredInput";
                wrong(elemsTab);
                valid=false;
            } else {
                elemsTab.className = 'tab';
                valid=true;
            }
        }
        if (requiredSelects.length>0){
            for(let i=0;i<requiredSelects.length;i++){
                if (requiredSelects[i].value=="0") {
                    requiredSelects[i].className += " invalid";
                    wrong(requiredSelects[i]);
                    valid=false;
                }
            }
        }

        return valid;
    }

    function showTab(numTab) {
        let tab = document.getElementsByClassName("tab");
        tab[numTab].style.display = "block";
        if (numTab == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline-block";
        }
        if (numTab == (tab.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Finalizar";
        } else {
            document.getElementById("nextBtn").innerHTML = "Continuar";
        }
        fixStepIndicator(numTab);
    }

    function nextStep() {

        if (!validate()) return false;

        if((tabs.length)-1 == currentTab){
            stepsSubmit.click();
            return;
        }
        tabs[currentTab].className +=" slide";
        setTimeout(function(){
            tabs[currentTab].style.display ="none";
            currentTab = currentTab + 1;
            showTab(currentTab);
            setTimeout(function(){ tabs[currentTab].className ="tab"},50);
        },1000);
    }

    function prevStep(){
        tabs[currentTab].className +=" show";
        setTimeout(function(){
            tabs[currentTab].style.display = "none";
            currentTab = currentTab - 1;
            showTab(currentTab);
            setTimeout(function(){
                tabs[currentTab].className ="tab"
            },100);
        },1000);
    }

    function fixStepIndicator(numTab) {
        // This function removes the "active" class of all steps...
        let i, steps = document.getElementsByClassName("step");
        for (i = 0; i < steps.length; i++) {
            steps[i].className = steps[i].className.replace(" active", "");
        }
        steps[numTab].className += " active";
    }

    function replaceName(){
        let name = event.target.value;
        let replace = document.getElementsByClassName('currentHomemate');
        for (let i = 0; i < replace.length; i++) {
            replace[i].innerHTML = name;
        }
    }

    //Adjust height of textarea for chat
    function textAreaAdjust(o) {
        o.style.height = "1px";
        o.style.height = (25+o.scrollHeight)+"px";
    }

    //On Focus on textarea for chat make other rows unsticky
    let $width = $(window).width();
    $( "#chat-textarea" ).focus(function() {
        $( '.delete-fixed-bottom' ).removeClass( "fixed-bottom" );
        //add sticky to textarea in mobile
        if($width < 960){
            $( '.add-fixed-bottom' ).addClass( "fixed-bottom" );
        }
    });

    //On Focus Out on textarea for chat make other rows sticky
    $( "#chat-textarea" ).focusout(function() {
        $( '.delete-fixed-bottom' ).addClass( "fixed-bottom" );
        //add sticky to textarea in mobile
        if($width < 960){
            $( '.add-fixed-bottom' ).removeClass( "fixed-bottom" );
        }
    });
    let form;
    $(".AcceptButton").each(function(){
        $(this).on('click',function () {
            let valueForm=$(this).attr('value-form');
            $("."+valueForm).submit();
            $("#loader_modal").modal('show');
        });
    });

    $(".CancelButton").each(function(){
        $(this).on('click',function () {
            let valueForm=$(this).attr('value-form');
            $("."+valueForm).submit();
            $("#loader_modal").modal('show');
        });
    });

</script>


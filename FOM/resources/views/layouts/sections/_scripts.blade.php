<script>
  var checkExternalAccount=@php if(Auth::check()){echo Auth::user()->externalAccount;}else{echo '0';}@endphp;
  //check if user is logged in termsandconditions -scripts
  var logged="@php if(Auth::check()){echo '1';} else{echo '0';}@endphp";
  var currentRoute = "{{ Request::is('termsandconditions/*') or Request::is('questions/*')}}";
  var checkName="@php if(Auth::check()){echo Auth::user()->name;} else{echo '0';}@endphp";
  var checkMail="@php if(Auth::check()){echo Auth::user()->email;} else{echo '0';}@endphp";

  let configBrand = {
      steps:[
        {
          element: '.navbar-brand',
          title: 'Bienvenido a VICO:',
          content: 'Queremos que siempre tengas la mejor experiencia. Por eso, estamos en constante evolución. Ahora somos ¡VICO - Vivir entre amigos!',
          arrow: 'top'
        }
      ]
  }


  //Check if the account was created by Facebook or Google
  if(checkExternalAccount == 1){
    document.getElementById("CompleteRegister").innerHTML+="<button data-toggle='modal' data-target='#CompleteRegister' id='modalCR' data-dismiss='modal' class='btn-link hide'></button>"
      if(checkName != 0){
      var fullNameIndex = checkName.indexOf(" ");  // Gets the first index where a space occours of the name
      var firstName = checkName.substr(0, fullNameIndex); // Gets the first part before space of name
      var lastName = checkName.substr(fullNameIndex + 1);  // Gets the second part after space of name
      document.getElementById("nameCR").value=firstName;
      document.getElementById("lastnameCR").value=lastName;
      }
      if(checkMail.split('vico_2019_01_09').length > 1){
                 document.getElementById("emailCR").value=''; //set fakeemail to null
      }
      $("#modalCR").click();
  }

  //Error messages for Login or Email already in Use
  var error=document.getElementById("errorMessage");
  if(error != undefined){
    document.getElementById("openLoginModal").click();
  }
  var email_taken=document.getElementById("email_taken");
  if(email_taken != undefined){
    $("#CreateAccount").modal('show');
  }

  var error_social=document.getElementById("error_social");
  var error_mail_paswwd=document.getElementById("error_mail_paswwd");
  if(error_social != undefined || error_mail_paswwd != undefined){
    $("#mlogin").modal('show');
  }

  // Open Modal to accept the new terms and conditions of the use of the website
  // termsandconditions -scripts
  function updateTermsAndCondition(){
    //Show only if user is logged in
    if(logged == 1){
      $.ajax({
        type:'GET',
        url:'/termsandconditions/update',
        success: function(data){
          if(data === '1'){
            $("#TermsAndConditions").modal('show');
          }
        }
      });
    }
  }

  window.onload= ()=>{
    if(currentRoute != '1'){
      updateTermsAndCondition(); //trigger function onload. termsandconditions -scripts
    }
  }

  $('#sendAcceptTaC').on('click',function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    if($('#acceptTaC').is(':checked')){
      $.ajax({
        url: '/termsandconditions/store',
        type: 'POST',
        data: {
          _token: CSRF_TOKEN,
          TyC: $("#acceptTaC").val()},
          success: function (data) {
            $("#TermsAndConditions").modal('hide');
          }
        });
    }
    else{
      $("#errorTaC").show();
    }
  });

  function registerManager(){
    var dial=document.getElementsByClassName("selected-dial-code");
    var phone=document.getElementById("manager-cellphone").value;
    $("#manager-cellphone").value=dial[1].innerHTML+phone;
    $("#manager-btnregister").click({
      utillsScript: "node_modules/intl-tel-input/build/js/utils.js"
    });
  }

  // let languageFlag,
  //     classFlag,
  //     buttonClass,
  //     buttonText,
  //     selectedLanguage,
  //     selectedElement;

  // if(sessionStorage.getItem('language') == null ){
  //   $('.flag').parent().prev().children()[0].innerHTML = '<i class="flagstrap-icon flagstrap-co" style="margin-right: 20px;"></i>';
  //   sessionStorage.setItem('language', '<i class="flagstrap-icon flagstrap-co" style="margin-right: 20px;"></i>');

  // }else{
  //   $('.flag').parent().prev().children()[0].innerHTML = sessionStorage.getItem('language');
  // }

  // $('.flag').on('click',async function(e){

  //   selectedLanguage = sessionStorage.getItem("language");
  //   if(selectedLanguage != undefined || selectedLanguage != null){
  //     if(e.target.classList.contains('flag')){

  //       languageFlag = $(e.target).children().attr('data-val');
  //       classFlag = $(e.target).children().children()[0].classList[1];
  //       buttonClass =  $(e.target).parent().prev().children().children()[0].classList[1];
  //       buttonText = $(e.target).parent().prev().children()[0].outerText;

  //       $(e.target).parent().prev().children().children().removeClass(buttonClass).addClass(classFlag);

  //       sessionStorage.setItem('language', $(e.target).parent().prev().children()[0].innerHTML);
  //       let formChangeLanguage=document.getElementById('changeLanguageForm');
  //       let inputChangeLanguage=document.getElementById('languageInput');
  //       inputChangeLanguage.value=languageFlag;
  //       formChangeLanguage.submit();

  //     }
  //     else{
  //       selectedElement = (e.target.parentElement.classList.contains('flag')) ? e.target.parentElement : e.target.parentElement.parentElement;

  //       if(selectedElement.classList.contains('flag')){
  //         languageFlag = $(selectedElement).children().attr('data-val');
  //         classFlag = $(selectedElement).children().children()[0].classList[1];
  //         buttonClass =  $(selectedElement).parent().prev().children().children()[0].classList[1];
  //         buttonText = $(selectedElement).parent().prev().children()[0].outerText;

  //         $(selectedElement).parent().prev().children().children().removeClass(buttonClass).addClass(classFlag);

  //         sessionStorage.setItem('language', $(selectedElement).parent().prev().children()[0].innerHTML);
  //         let formChangeLanguage=document.getElementById('changeLanguageForm');
  //         let inputChangeLanguage=document.getElementById('languageInput');
  //         inputChangeLanguage.value=languageFlag;
  //         formChangeLanguage.submit();
  //       }

  //     }
  //   }
  // });


  // let locale={{\Config::get('app.locale')}}

</script>
<script type="text/javascript">

  /**
  * This function create the needed elements to init the tutorial
  * @param {JSON} config JSON with the steps, titles and descriptions
  */
  function configTuto(config) {
    let elemHighlighter = document.createElement('div');
    elemHighlighter.classList.add('tuto-highlighter','active');
    document.body.appendChild(elemHighlighter);

    let elemBack = document.createElement('div');
    elemBack.classList.add('tuto-background','active');
    document.body.appendChild(elemBack);

    let elemCover = document.createElement('div');
    elemCover.classList.add('tuto-cover','active');
    document.body.appendChild(elemCover);

    highlighter = document.querySelector('.tuto-highlighter');
    bckgnd = document.querySelector('.tuto-background');
    cover = document.querySelector('.tuto-cover');

    startTuto(config,0);
  }

  /**
  * This function init the tutorial by creating a popover and a highligher acording with
  * the configuration JSON and an index
  * @param {JSON} config JSON with the steps, titles and descriptions
  * @param {number} index Step index
  */
  function startTuto( config, index ) {

    let delay = 300;
    let objPopover = config['steps'][index];
    let template =
      '<div class="popover tuto-target tuto-popover" role="tooltip" style="z-index:1103">\
        <div class="arrow"></div>\
        <div class="popover-body"></div>\
      </div>';

    let serialize = JSON.stringify(config);
    let info =
      `<h3>${objPopover.title}</h3>\
      <p>${objPopover.content}</p>\
      <button id="tuto-next" onclick='continueTuto(${serialize},${index})'
        class="form-control btn btn-success">
          ${config['steps'].length-1 == index ? 'Terminar':'Siguiente'}
      </button>`;

    let elementName = objPopover.element;
    let element = document.querySelector(elementName);
    let elementPosition = element.getBoundingClientRect();

    setTimeout(()=>{
        element.classList.add('tuto-target');
    },delay);

    highlighter.style.width = `${elementPosition.width+8}px`;
    highlighter.style.height = `${elementPosition.height+8}px`;
    highlighter.style.top = `${elementPosition.top-8 + window.scrollY}px`;
    highlighter.style.left = `${elementPosition.left-8}px`;

    $(highlighter).popover({
      animation:true,
      delay: delay,
      trigger: 'click',
      placement: objPopover.arrow,
      html:true,
      template: template,
      content: info
    });

    highlighter.click();

    if(!element.classList.contains('fixed-bottom')){

      setTimeout(()=>{
        $('html, body').animate({
          scrollTop: `${elementPosition.top}px`
        }, 'slow');
      },delay);
    }
  }

  /**
  * this function call the startTuto function to show the next step or finish the tutorial
  * @param {number} index Last step index
  */
  function continueTuto(config, index) {
    document.querySelector(config['steps'][index].element).classList.remove('tuto-target');

    $(highlighter).popover('dispose');
    if (index === config['steps'].length-1) {
      highlighter.classList.remove('active');
      bckgnd.classList.remove('active');
      cover.classList.remove('active');
    }
    else {
      startTuto(config,index+1);
    }
  }

  function getAvailableCities(current_city){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/api/currentCities`,
        datatType: 'json',
        type: 'GET',
        success: function (response) {
          localStorage.setItem('countries',JSON.stringify(response));
          setAvailableCities(response,current_city);
        },
        error: function (err) {
            console.log(err);

        }
    });
  }
  function getCurrentCity() {
      $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/api/city`,
            datatType: 'json',
            type: 'GET',
            success: function (response){
              localStorage.clear();
              if(localStorage.getItem('countries') != undefined){
                setAvailableCities(JSON.parse(localStorage.getItem('countries')),response[0]);
              }else{
                getAvailableCities(response[0]);
              }
            },
            error: function (err){
                console.log(err);
            }
      });
  }

  function setAvailableCities(countries,current_city) {
    cities_select = document.querySelector('#cities-select');
    countries.forEach(country => {
        let country_element = document.createElement('optgroup');
        country_element.setAttribute('label',country.name);
        country.cities.forEach(city =>{
            let city_element = document.createElement('option');
            city_element.setAttribute('value',city.city_code);
            if(city.city_code == current_city.city_code){
                city_element.setAttribute('selected',true);
            }
            city_element.textContent = city.name;
            country_element.append(city_element);
        });
        cities_select.append(country_element);
    });
  }
  $(document).ready(function() {
  
  if(window.location.href.indexOf('#contactVICO') != -1) {
    $('#dropdownNavContact').addClass('open-dropdown');
  }
  
  });
</script>

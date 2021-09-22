<script type="text/javascript">
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


  if (localStorage.getItem('firstTimeBrand') === null) {
      document.querySelector('.navbar').classList.remove('vico-navbar');
      document.querySelector('.navbar').style="background:#3A3A3A";
      localStorage.setItem('firstTimeBrand',true);
      configTuto(configBrand);
      console.log("no hay localstorage");
    }

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
</script>
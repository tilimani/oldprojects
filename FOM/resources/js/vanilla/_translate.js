/**
 * This method translate a especific test
 * @param text: text to translate
 * @param source: language source from the text sended
 * @param target: language target from the text sended
 * @return ajax function that call the google server to translate the text
 * @author Josue Esneider Fernandez Martinez
 */
function translateText(text,source,target){    
    return $.ajax({
        url: '/translate',
        type: "POST",
        dataType: "json",
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            textInfo : text,
            targetInfo : target,
            sourceInfo: source,            
        }        
    });    
}

/**
 * This method translate the text inside in a element
 * @param elementText: text to translate
 * @param element: element to insert translated text
 * @param source: language source from the text sended
 * @param target: language target from the text sended
 * @author Josue Esneider Fernandez Martinez
 */
function translateElement(elementText,element,source,target){
    let currentTest=elementText.innerText.split('\n'); //split the text inside the element
    // element.innerText=""; //set the inner Text from the element to null
    for(let i=0;i<currentTest.length;i++){
      let resp=translateText(currentTest[i],source,target);//call the function to translate  a text
      resp.done((data) => {        
        let text=data.text;
        element.innerHTML+=text;//add the new text to the innerText element
        if(text != ""){
          element.innerHTML+="<br>";
        }
      });
      resp.fail((data) => {
        console.log(data);
      });
    }
}

/**
 * This method set a event to the switchs on the view
 * @author Josue Esneider Fernandez Martinez
 */
function setTranslateSwitchs(){
  
    let switchsTranslate=document.getElementsByClassName('switch-translate'); // get all switch from the pages to translate de texts    
    if(switchsTranslate != undefined){
      let textsTranslate=document.getElementsByClassName('text-to-translate');// get all text to translate
      let textsTranslated = document.getElementsByClassName('translated-text');
      for(let i=0;i<switchsTranslate.length;i++){
        switchsTranslate[i].addEventListener('change',() =>{           
          for(let j=0;j<textsTranslate.length;j++){            
            if(textsTranslate[j].getAttribute('id-text') == switchsTranslate[i].getAttribute('id-text')){
              let source;
              let target;
              if(!switchsTranslate[i].checked){
                // source=target; //get the lang of the page                  
                // target=document.documentElement.lang; //get the lang of the page
                textsTranslate[j].style.display = "block";
                textsTranslated[j].style.display = "none";                
              } else{
                
                source='es';                 
                target=document.documentElement.lang; //get the lang of the page    
                textsTranslate[j].style.display = "none";         
                textsTranslated[j].style.display = "block";                    
              }
              if(source != target){
                if(textsTranslated[j].innerHTML == ""){
                  translateElement(textsTranslate[j],textsTranslated[j],source,target);  //translate the element
                  textsTranslate[j].innerHTML=textsTranslate[j].innerHTML.toString().replace(/- /g,'- \n');
                  textsTranslate[j].innerHTML=textsTranslate[j].innerHTML.toString().replace(/&quot;/g,'"');
                }
              }
            }
          }
        });
      }
    }
}

function translateAutoText(){
  let texts=document.getElementsByClassName('auto-text-translate');
  let source='es';
  let target=document.documentElement.lang;
  if(source != target){
    for(let i=0;i<texts.length;i++){
      translateElement(texts[i],source,target);
      texts[i].innerHTML=texts[i].innerHTML.toString().replace(/- /g,'- \n');
      texts[i].innerHTML=texts[i].innerHTML.toString().replace(/&quot;/g,'"');
    }
  }
}

$(document).ready(function(){
    setTranslateSwitchs();
    translateAutoText();
  });
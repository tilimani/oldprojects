require('file-loader?name=[name].[ext]!./index.html');
import './css/style.css'



// get second minute and hour hands
const hourHand = document.querySelector('.hour-hand');
const minHand = document.querySelector('.min-hand');
const secondHand = document.querySelector('.second-hand');

const now = new Date();
var hour = timeToDeg(now.getHours());
var min = timeToDeg(now.getMinutes());
var second = timeToDeg(now.getSeconds());
const ogsec = second;

function timeToDeg(time){
  return ((time/60*360) + 90);
}

// get the time and apply it to
function setTime(){
  second += 6;
  hour += 1/600;
  min += 1/10;

  // apply to rotate
  secondHand.style.transform = "rotate(" + second + "deg)";
  minHand.style.transform = "rotate(" + min + "deg)";
  hourHand.style.transform = "rotate(" + hour + "deg)";

}
setTime();


setInterval(setTime, 1000);

// logic for calculator app which is a project for edX course

// changing symbol handler

var current = '';
var holder;
var func = '';

function updateHolder() {
  // if holder is empty
  if (!holder) {holder = parseInt(current);}

  // if holder has something in it
  else {calculation();}

  // display current output
  $('#display').val(holder);

  // reset current data
  current = '';
}

$('button').click(function () {
  current += String(this.value);
  $('#display').val(current);
});

$("#addButton").click(function(){
  updateHolder();
  func = 'add';

});

$("#subtractButton").click(function(){
  updateHolder();
  func = 'subtract';
});

$("#multiplyButton").click(function(){
  updateHolder();
  func = 'multiply';
});

$("#divideButton").click(function(){
  updateHolder();
  func = 'divide';
});

$("#clearButton").click(function(){
  current = '';
  holder = null;
});

$("#equalsButton").click(function(){
  calculation(func);
  $('#display').val(holder);
  current = holder;
  holder = null;
});

// Updater for the holder
function calculation(){
  switch(func) {
    case 'add':
      holder =  holder + parseInt(current);
      break;

    case 'subtract':
      holder = holder - parseInt(current);
      break;

    case 'divide':
      holder = holder / parseInt(current);
      break;

    case 'multiply':
      holder = holder * parseInt(current);
      break;
    }
}

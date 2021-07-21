// start timer
var seconds = 1200;
function secondPassed() {
var minutes = Math.round((seconds - 30)/60);
var remainingSeconds = seconds % 60;
if (remainingSeconds < 10) {
    remainingSeconds = "0" + remainingSeconds; 
}
document.getElementById('countdown').innerHTML = minutes + ":" +    remainingSeconds;
if (seconds == 0) {
    clearInterval(countdownTimer);
    document.getElementById('startForm').submit();
    
} else if (seconds <10){
    document.getElementById('countdown').style.color='red';
    seconds--;
}
else {    
    seconds--;
}
}
var countdownTimer = setInterval('secondPassed()', 1000);


// hide the last two option when question is true and false
var elems = document.getElementsByClassName('hide');
for (var i=0;i<elems.length;i+=1){
    if(!elems[i].value){
  elems[i].style.display = 'none';
    }
}


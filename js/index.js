/* ARROW SLIDE */
let running = false;

/* FRONT */
var button = document.getElementById('right-arrow');
button.onclick = function () {
    var container = document.querySelector(".slider");
    container.scrollLeft += 424;
};

let hover = false;
/* button.addEventListener("mouseenter", function (){
    hover = true;
    var element = document.querySelector(".slider");
    var direction = "right";
    var speed = 1;
    var step = 1;
    var slideTimer = setInterval(function(){
        if(direction == 'left'){
            element.scrollLeft -= step;
        } else {
            element.scrollLeft += step;
        }
        if(!hover){
            window.clearInterval(slideTimer);
        }
    }, speed);
}) */

button.addEventListener("mouseleave", function (){
    hover = false;
})

/* BACK */
var back = document.getElementById('left-arrow');
back.onclick = function () {
    var container = document.querySelector(".slider");
    container.scrollLeft -= 424;
};

/* back.addEventListener("mouseenter", function (){
    hover = true;
    var element = document.querySelector(".slider");
    var direction = "left";
    var speed = 1;
    var step = 1;
    var slideTimer = setInterval(function(){
        if(direction == 'left'){
            element.scrollLeft -= step;
        } else {
            element.scrollLeft += step;
        }
        if(!hover){
            window.clearInterval(slideTimer);
        }
    }, speed);
}) */

back.addEventListener("mouseleave", function (){
    hover = false;
})

/* HELP */
function sideScroll(element,direction,speed,distance,step){
    scrollAmount = 0;
    var slideTimer = setInterval(function(){
        running = true;
        if(direction == 'left'){
            element.scrollLeft -= step;
        } else {
            element.scrollLeft += step;
        }
        scrollAmount += step;
        if(scrollAmount >= distance){
            window.clearInterval(slideTimer);
            running = false;
        }
    }, speed);
}

/* LIKE */
let likeBtn = document.querySelector(".heart")

likeBtn.addEventListener("click", function (){
    if(likeBtn.matches(".liked")) likeBtn.src = "./res/team/heart_empty.png";
    if(!likeBtn.matches(".liked")) likeBtn.src = "./res/team/heart_full.png";
    likeBtn.classList.toggle("liked")
})

let commentInp = document.querySelector(".comment-input")

commentInp.addEventListener("focus", function () {
    let element = document.querySelector("html")
    setTimeout(function () {
        element.scrollTop += element.scrollHeight;
    }, 275)
});


/* COMMENT SUBMIT */

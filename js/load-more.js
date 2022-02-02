const nextBtn = document.querySelector(".load-more")
const table = document.querySelector("#matches")
const numClass = document.querySelector(".num")

nextBtn.addEventListener("click", clickHandler)

async function clickHandler () {
    let num = numClass.id;
    const resp = await fetch(`./lib/load_more.php?num=${parseInt(num)+5}`)
    const text = await resp.text();
    table.innerHTML = text;
    numClass.id = (parseInt(numClass.id)+5);

    let element = document.querySelector("html");
    element.scrollTop += element.scrollHeight;

    /* console.log(parseInt(numClass.classList[1]), numClass.id); */
    if(parseInt(numClass.id)+10 >= parseInt(numClass.classList[1])){
        nextBtn.style.display = "none";
    }
}
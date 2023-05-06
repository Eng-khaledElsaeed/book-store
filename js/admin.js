//--------------------- toggle content in admin page
let user_icons=document.querySelector(".user_face");
let user_arrow=document.querySelector(".user_arrow");
let user_info=document.querySelector(".user_info");
user_icons.addEventListener("click",()=>{
user_info.classList.toggle("show");
user_arrow.classList.toggle("fa-chevron-right");
});


let sidebar_logo=document.querySelector(".sidebar_logo");
let side_arrow=document.querySelector(".sidebar_logo .side_arrow");
let sidenav=document.querySelector(".sidenav");
let dashboard_layout=document.querySelector(".dashboard_layout");
sidebar_logo.addEventListener("click",()=>{
    side_arrow.classList.toggle("fa-chevron-right");
    sidenav.classList.toggle("small");
    dashboard_layout.classList.toggle("small");
})



let main_item= document.querySelector(".main_item");
let side_item= document.querySelectorAll(".side_item");
side_item.forEach(element => {
    if(main_item.classList.contains(element.dataset.content)){
        element.classList.add("active")  
    }
});



let menu_icon=document.querySelector(".menu-icon");
let sidenav__close=document.querySelector(".sidenav__close");
// Open the side nav on click
menu_icon.addEventListener("click",()=>{
    sidenav.classList.toggle("active");
})
// Close the side nav on click
sidenav__close.addEventListener("click",()=>{
    sidenav.classList.toggle("active");
})



function session_timeout(){
    var interval;
    ['mousemove', 'keydown'].forEach(function(e) {
        window.addEventListener(e,()=>{
            clearInterval(interval);
            var coutdown = 30 * 60; // After 30 minutes session expired  (mouse button click code)
            interval = setInterval(function () {
                --coutdown;
                if (coutdown === 0) {
                    Swal.fire({
                        type: 'warning',
                        title: 'Your session has expired. Do you want to Extend ?',
                        timer: 1000*60,            
                        confirmButtonText: 'yes,please',
                        confirmButtonColo: '#3085d6',
                        showDenyButton: true,
                        denyButtonText: `No,i finished`,
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: 'you can work now',
                                // width:'fit-content',
                                animation: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                  toast.addEventListener('mouseenter', Swal.stopTimer)
                                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                              })
                        }else{
                            const xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange= function() {
                                if(this.readyState == 4 && this.status == 200){
                                    window.location.reload();
                                }
                            }
                            xhttp.open("GET", window.location+"?timeout='logout'",true);
                            xhttp.send();                          
                        }
                    })
            
                }
            }, 1000);

        });
    });
}

(()=>{
    session_timeout();

})


// let message_block=document.getElementById("message_block");
// let message_count=document.querySelector(".message_count");

// message_count.addEventListener('click',()=>{
//     message_block.classList.toggle("active");
// })

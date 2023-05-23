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
            }, 10000);

        });
    });
}


function CRUD_message(msg){
    console.log(msg);
    switch (msg.type) {
        case "success":
            if(msg.page=="same_window"){
                Swal.fire({
                    icon: 'success',
                    title: msg.title,
                    animation: true,
                    position: 'center',
                }).then((result)=>{
                    if(result.isConfirmed){
                        window.location.href = window.location.href.split('?').shift();
                    }
                });
            }else{
                Swal.fire({
                    icon: 'success',
                    title: msg.title,
                    animation: true,
                    position: 'center',
                }).then((result)=>{
                    if(result.isConfirmed){
                        window.location.href = msg.page;
                    }
                });
            }
            
                break;
        case "error":
            Swal.fire({
                icon: 'error',
                title: msg.title,
                // width:'fit-content',
                animation: true,
                position: 'center',
                });
                break;
        default:
            break;
        }
}


// update table data
function update_product(){
    let updatebtns=document.getElementsByClassName("update_btn");
    for (let i = 0; i < updatebtns.length; i++){
            updatebtns[i].addEventListener('click', ()=>{
            let id=updatebtns[i].getAttribute('data-product-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't to update product ID:#"+id+"!",
                icon: 'warning',
                width: 'fit-content',
                padding: '1em',
                position:'center',
           
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: 'confirm',
                confirmButtonColor: '#3085d6',
              }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href="update-product.php?update_prod_id="+id;
                }
              })
        });
    }
}

function delete_product(){
    let deletebtns=document.getElementsByClassName('delete_btn');
    for (let i = 0; i < deletebtns.length; i++){
        deletebtns[i].addEventListener('click', ()=>{
        let id=deletebtns[i].getAttribute('data-product-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't to delete product ID:#"+id+"!",
            icon: 'warning',
            width: 'fit-content',
            padding: '1em',
            position:'center',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'confirm',
            confirmButtonColor: '#3085d6',
          }).then((result) => {
              if (result.isConfirmed) {
                window.location.href='?delete_prod_id='+id;
            }
          })
    });
}
};

(()=>{
    session_timeout();
});

delete_product();
update_product();



function search(val) {
    if (val.trim() !== '') {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
        }
        };
        xhr.open('post', 'category.php?search_val='+ val, true);
        xhr.send();
    }
}
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


// // Set up SVG and chart dimensions
// var svgWidth = 400;
// var svgHeight = 400;
// var chartMargin = { top: 20, right: 10, bottom: 20, left: 10 };
// var chartWidth = svgWidth - chartMargin.left - chartMargin.right;
// var chartHeight = svgHeight - chartMargin.top - chartMargin.bottom;

// // Create SVG element
// var svg = d3.select("#product-chart")
//   .attr("width", svgWidth)
//   .attr("height", svgHeight);

// // Create chart group
// var chart = svg.append("g")
//   .attr("transform", "translate(" + chartMargin.left + "," + chartMargin.top + ")");

// // Define data
// var data = [
//   { category: 'Category 1', products: 10 },
//   { category: 'Category 2', products: 20 },
//   { category: 'Category 3', products: 15 }
// ];

// // Create x and y scales
// var xScale = d3.scaleBand()
//   .range([0, chartWidth])
//   .padding(0.1)
//   .domain(data.map(function(d) { return d.category; }));
  
// var yScale = d3.scaleLinear()
//   .range([chartHeight, 0])
//   .domain([0, d3.max(data, function(d) { return d.products; })]);

// // Create x and y axes
// var xAxis = d3.axisBottom(xScale);
// var yAxis = d3.axisLeft(yScale);

// // Add x axis to chart
// chart.append("g")
//   .attr("class", "x axis")
//   .attr("transform", "translate(0," + chartHeight + ")")
//   .call(xAxis);

// // Add y axis to chart
// chart.append("g")
//   .attr("class", "y axis")
//   .call(yAxis);

// // Create bars
// chart.selectAll(".bar")
//   .data(data)
//   .enter().append("rect")
//   .attr("class", "bar")
//   .attr("x", function(d) { return xScale(d.category); })
//   .attr("y", function(d) { return yScale(d.products); })
//   .attr("height", function(d) { return chartHeight - yScale(d.products); })
//   .attr("width", xScale.bandwidth());
// Load data from server
d3.json("data.php", function(data) {

// Set up chart dimensions
var margin = {top: 20, right: 20, bottom: 30, left: 40},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

// Create x and y scales
var x = d3.scaleBand()
    .range([0, width])
    .padding(0.1)
    .domain(data.map(function(d) { return d.category; }));

var y = d3.scaleLinear()
    .range([height, 0])
    .domain([0, d3.max(data, function(d) { return d.products; })]);

// Create x and y axes
var xAxis = d3.axisBottom(x);

var yAxis = d3.axisLeft(y)
    .ticks(10, "%");

// Create chart SVG element
var svg = d3.select("#product-chart")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");

// Add bars to chart
svg.selectAll(".bar")
    .data(data)
    .enter().append("rect")
    .attr("class", "bar")
    .attr("x", function(d) { return x(d.category); })
    .attr("width", x.bandwidth())
    .attr("y", function(d) { return y(d.products); })
    .attr("height", function(d) { return height - y(d.products); });

// Add x axis to chart
svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis);

// Add y axis to chart
svg.append("g")
    .attr("class", "y axis")
    .call(yAxis);

});
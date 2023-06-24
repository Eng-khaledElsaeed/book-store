let books_table=document.getElementById("books_table");

function book_fill(page=1,search_value=""){
    let xhr=new XMLHttpRequest();
    xhr.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            let json_data = JSON.parse(this.responseText);
            let status=json_data.status;
            let data=json_data.data;
            let num_pages=json_data.num_pages;
            let start_rec=json_data.start_rec;
            let curr_page=json_data.curr_page;
            let next_page=json_data.next_page;
            let next_page_disable=json_data.next_page_disable;
            let privious_page=json_data.privious_page;
            let privious_page_disable=json_data.privious_page_disable;
            // Calculating the starting record number
            let slno = start_rec + 1;     
            let html_data = "";
            if(status){
                if(data.length >0){
                    data.forEach((item)=>{
                        html_data +=
                        `
                        <tr id='row-${item.prod_id}'>
                        <td>${slno++}</td>
                        <td>${item.prod_name}</td>
                        <td>${item.category_name}</td>
                        <td>${item.prod_quant}</td>
                        <td>${item.price}</td>
                        <td>${item.status}</td>
                        <td><img src='${item.prod_imag_url}' alt=''></td>
                        <td><button type='button' id='update_btn-${item.prod_id}' class='update_btn' data-value='book' data-id='${item.prod_id}' onclick='updateElement(${item.prod_id});'>update</button></td>
                        <td><button type='button' id='delete_btn-${item.prod_id}' class='delete_btn' data-value='book' data-id='${item.prod_id}' onclick='deleteElement(${item.prod_id});'>delete</button></td>
                        </tr>
                        `
                    });
                    let start=Math.max(1,curr_page-3);
                    let end=Math.min(num_pages,curr_page+3);
                    let searchValue=document.getElementById("searchValue").value;
                      
                    html_data+=
                    `
                    <div class='table_pagnetion'>
                        <div></div>
                        <div class='paginations_controles'>
                        `;
        
                        if (privious_page_disable) {
                            html_data+="<span style='color: #878787;cursor: auto;'>&lt; previous</span>";
                        } else {
                            html_data+=`<a href='javascript:category_fill(page=${privious_page},search_value="${searchValue}")'>&lt; previous</a>`;
                        }
        
        
                        for (let i = start; i <= end; i++) {
                            if (i == curr_page) {
                                html_data+=`<span style='color:white;background: #878787;padding: 5px;border-radius: 50%;font-size: 17px;'>${i}</span>`;
                            } else {
                                html_data+=`<a href='javascript:category_fill(page=${i},search_value="${searchValue}")' class='page-link'>${i}</a>`;
                            }
                        };
        
                        if (next_page_disable) {
                            html_data+="<span style='color: #878787;cursor: auto;'>next &gt;</span>";
                        } else {
                            html_data+=`<a href='javascript:category_fill(page=${next_page},search_value="${searchValue}")'>next&gt;</a>`;
                        };
                        html_data+=
                        `
                            </div>
                            <div class="numper_of_pages">
                                <span>NO pages: ${num_pages}</span>
                            </div>
                        </div> 
                        `;
                    }
            }else{
                html_data="<tr><th colspan='7'><p style='color:red;text-align:center;'>no data found</p></th></tr>";
            }
            books_table.innerHTML = html_data;
        }
    }
    xhr.open("GET","ajax_books_search.php?search_value="+search_value+"&page="+page,true);
    xhr.send();
};
book_fill();

$(document).ready(function () {                
    $('#connection').submit(function (event) {
        event.preventDefault();                
        var form = document.getElementById('connection');
        var formData = new FormData(form);
       
        $.ajax({
            url: "/src/add.php",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == "Empty fields") {
                    let message = document.querySelector(".result-window");
                    message.classList.toggle("result-window_fail")
                    message.textContent = ':-('
                    setTimeout(() => {
                        message.classList.toggle("result-window_success_fail")
                    }, 2000);
                } else {
                    let message = document.querySelector(".result-window");
                    if (message.classList.contains("result-window_fail")) { 
                        message.classList.toggle("result-window_fail");
                    }
                    message.firstChild.textContent = 'Домены ВОЗМОЖНО добавлены :-)';
                    message.classList.toggle("result-window_success");
                    setTimeout(() => {
                        message.classList.toggle("result-window_success");
                    }, 2000);
                }
                

            },
            error: function (xhr, status, error) {                       
                let message = document.querySelector(".result-window");
                message.classList.toggle("result-window_fail")
                message.textContent = ':-(' + error
                setTimeout(() => {
                    message.classList.toggle("result-window_success_fail")
                }, 2000);
            }
        });
    });
});
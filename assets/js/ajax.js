function successAction(message){
    alert("Успех", message);
}

function errorAction(message){
    alert("Ошибка:", message);
}

function checkData(formData){

}

$(document).ready(function () {
    $('#connection').submit(function (event) {
        event.preventDefault();
        let formData = new FormData($('#connection')[0]);
        $.ajax({
            url: "/src/ResponseController.php",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                successAction(response)
            },
            error: function (xhr, status, error) {
                alert(xhr.status + " " + xhr.statusText);
            }
        });
    });
});
//((http|https):\/\/)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6} - ввод проверки
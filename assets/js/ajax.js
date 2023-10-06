function successAction(message){
    alert(message);
}

function errorAction(message){
    alert(message);
}

function checkData(formData){

}

$(document).ready(function () {
    $('#connection').submit(function (event) {
        event.preventDefault();
        let formData = new FormData($('#connection')[0]);
        $.ajax({
            url: "/src/yandexAPI.php",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                successAction(response)
            },
            error: function (xhr, status, error) {
                errorAction(error)
            }
        });
    });
});
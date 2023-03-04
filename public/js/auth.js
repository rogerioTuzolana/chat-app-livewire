
$("input").on('click',function() {
    let result = document.getElementById("resultBox");
    result.style.display = "none";
    let result2 = document.getElementById("resultBox2");
    result2.style.display = "none";
});

$('#exampleModal2').on('hide.bs.modal', function (event) {
    let result = document.getElementById("resultBox2");
    result.style.display = "none";
});


$("#btn-changePass").on('click',function() {
    $('form[name="formChangePass"]').submit(function (event) {
        event.preventDefault();
        let email = $(this).find("input#emailChange").val();
        let password = $(this).find("input#passwordChange").val();
        let cpassword = $(this).find("input#cpasswordChange").val();
        //alert( password+'   '+cpassword)
        //return;
        let result = document.getElementById("resultBoxChange");

        $('#change-spinner').addClass('spinner-border');
        $('#change-spinner').addClass('spinner-border-sm');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "/trocar-senha",
            type : 'PUT',
            data : {
                email: email,
                password: password,
                cpassword: cpassword,
            },
            dataType: 'json',
            async: false,
            /*beforeSend : function(){
                $("#result").html("Carregando...");
            }*/
        })
        .done(function(msg){  
            
            result.style.display = "none";
            //
            let message = msg.message;
            console.log(message);
            if (message == 'user') {
                window.location.href = 'home';
            }else if(message == 'admin' || message == 'edit'){
                window.location.href = '/admin/dashboard';
            }

        })
        .fail(function(msg){
            
            result.style.display = "block";
            //
            let data = JSON.parse(msg.responseText);
            
            if (data.errors.password != null || data.errors.cpassword) {
                $("#resultChange").html("Confirme a nova senha correctamente!");
            }else{
                $("#resultChange").html(data.message);
            }
            
                $('#change-spinner').removeClass('spinner-border')
                $('#change-spinner').removeClass('spinner-border-sm')
            
            
        });

    })
})

$("#btn-recover").on('click',function() {
    $('form[name="formRecover"]').submit(function (event) {
        event.preventDefault();
        //
        $('#recover-spinner').addClass('spinner-border');
        $('#recover-spinner').addClass('spinner-border-sm');

        let email = $(this).find("input#emailR").val();
        let result = document.getElementById("resultBoxRec");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "/esqueci-senha",
            type : 'POST',
            data : {
                email: email,
            },
            dataType: 'json',
            async: false,
            /*beforeSend : function(){
                $("#result").html("Carregando...");
            }*/
        })
        .done(function(msg){  
            $('#resultBoxRec').removeClass('alert-danger');
            $('#resultBoxRec').addClass('alert-success');
            result.style.display = "block";
            //
            let message = msg.message;
            $("#resultRec").html(message);

            /*setTimeout(
                $('#recover-spinner').removeClass('spinner-border'),
                $('#recover-spinner').removeClass('spinner-border-sm')
            , 9000);*/
        })
        .fail(function(msg){
            $('#resultBoxRec').removeClass('alert-success');
            $('#resultBoxRec').addClass('alert-danger');
            result.style.display = "block";
            //
            let data = JSON.parse(msg.responseText);
            $("#resultRec").html(data.message);
            
            //setTimeout(
                $('#recover-spinner').removeClass('spinner-border')//,
                $('#recover-spinner').removeClass('spinner-border-sm')
            //, 9000);
            
        });
    })
})

let countries;
let verifyBi='';



$("input").on('click',function() {
    let result = document.getElementById("resultBox");
    result.style.display = "none";

    let result2 = document.getElementById("resultBox2");
    result2.style.display = "none";

    let result5 = document.getElementById("resultBox5");
    result5.style.display = "none";

});


$("textarea").on('click',function() {
    let result3 = document.getElementById("resultBox3");
    result3.style.display = "none";
});



$('#exampleModal').on('hide.bs.modal', function (event) {
    let result = document.getElementById("resultBox");
    result.style.display = "none";
});


/*$('input').on('click',function() {
    let result3 = document.getElementById("resultBoxSendMsgBuy");
    result3.style.display = "none";
});*/

$("#btn-updateProfile").on('click',function() {
    $('form[name="formUpdateProfile"]').submit(function (event) {
        event.preventDefault();

        let email = $(this).find("input#email").val();
        let name = $(this).find("input#name").val();
        let contact = $(this).find("input#contact").val();

        let result = document.getElementById("resultBox2");
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "/conta/atualizarPerfil",
            type : 'POST',
            data : {
                email: email,
                name: name,
                contact: contact,
            },
            dataType: 'json',
            async: false,
        })
        .done(function(msg){  
            $('#resultBox2').removeClass('bg-danger');
            $('#resultBox2').addClass('bg-success');
            result.style.display = "block";
            //
            let message = msg.message;

            $("#result2").html(message);
            $('form[name="formUpdateProfile"]').reset();
        })
        .fail(function(msg){
            $('#resultBox2').removeClass('bg-success');
            $('#resultBox2').addClass('bg-danger');
            result.style.display = "block";
            //
            let data = JSON.parse(msg.responseText);
            $("#result").html(data.message);
        });

    }) 
});

$("input#exampleModal3").on('click',function() {
    let result3 = document.getElementById("resultBox3");
    result3.style.display = "none";
});

$('#exampleModal3').on('hide.bs.modal', function (event) {
    let result = document.getElementById("resultBox3");
    result.style.display = "none";
});


//Trocar senha
$("#btn-changePass").on('click',function() {
    $('form[name="formChangePassWord"]').submit(function (event) {
        event.preventDefault()
        //alert('ee')

        let oldPass = $('#passwordOld').val();
        let newPass = $('#passwordNew').val();
        let cPass = $('#passwordCNew').val();
        //alert();
        //return;
        //alert(sell_phone_id+": "+msg)
        let result = document.getElementById("resultBoxPw");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "/conta/trocar-senha",
            type : 'PUT',
            data:{
                oldPass: oldPass,
                newPass: newPass,
                cPass: cPass,
            },
            dataType: 'json',
            async: false,
        })
        .done(function(msg){ 
            //
            let message = msg.message;
            console.log(message);
    
            $('#resultBoxPw').removeClass('alert-danger');
            $('#resultBoxPw').addClass('alert-success');
            result.style.display = "block";
            //
            $("#resultPw").html(message);
        })
        .fail(function(msg){
            
            $('#resultBoxPw').removeClass('alert-success');
            $('#resultBoxPw').addClass('alert-danger');
    
            result.style.display = "block";
            //
            let data = JSON.parse(msg.responseText);

            if (data.errors.newPass != null || data.errors.cPass) {
                $("#resultPw").html("Confirme a nova senha correctamente!");
            }else{
                $("#resultPw").html(data.message);
            }
        });
        
    })
})

$(".notification").on('click',function() {
        //event.preventDefault()

        let notif_id = $(this).attr('data-notif');
        let id = "#notif-"+$(this).attr('data-id');
        let id2 = "#notif-top"+$(this).attr('data-id');
        //alert("ID: "+id);return;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "/conta/ver-notificacao",
            type : 'PUT',
            data:{
                notif_id: notif_id,
            },
            dataType: 'json',
            async: false,
        })
        .done(function(notification){ 
            //console.log(notification.title);

            $(id).removeClass('notif-color');
            $(id).addClass('notif-color-true');
            $(id2).removeClass('notif-color');
            $(id2).addClass('notif-color-true');
            $("#notif-title").html(notification.title);
            $("#notif-message").html(notification.message);
            $("#notif-count1").html(notification.count);
            $("#notif-count2").html(notification.count+" mensagens não lidas");
            $('#exampleModalNotif').modal('show')
        })
        .fail(function(msg){
            
        });

})


$(document).ready(function(){
    
    $('.money2').mask("#.##0,00", {reverse: true});
})

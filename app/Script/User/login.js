$(document).ready(function (){
    $("#loginform").on("submit",function (e){
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            error:function (e){
                console.log(e);
            },
            success: function(data)
            {
                if(data.Success){
                    $("#msg").addClass("success")
                    $("#msg").html(data.Message) // show response from the php script.
                    setTimeout( function (){
                        $("#msg").removeClass("success");
                        $("#msg").html('');
                        location.href=$("#baseurl").val()
                    },2000);
                    console.log("data");
                }else{
                    console.log(data);
                    $("#msg").addClass("error")
                    $("#msg").html(data.Message) // show response from the php script.
                    setTimeout( function (){
                        $("#msg").removeClass("error");
                        $("#msg").html('');
                    },3000);
                }
            }
        });

        return false;
    });
});
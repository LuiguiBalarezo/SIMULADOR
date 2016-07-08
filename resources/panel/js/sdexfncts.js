/**
 * Created by ucweb03 on 08/07/2016.
 */
$(document).ready(function(){
    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }
    //function getAbsolutePath() {
    //    var l = window.location;
    //    var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
    //    return base_url+"/";
    //}
    var base_url = getAbsolutePath();

    $("#btnSignIn").on("click", function(evt){
        evt.preventDefault();
        //$(location).attr("href", "<?php echo base_url().'admin'; ?>");
        if ( $("#txtEmail").val().length > 0 && $("#txtPassword").val().length > 0 ) {
            $.LoadingOverlay("show");
            var request = $.ajax({
                url: base_url+'signIn',
                type: "post",
                data: $("#Form").serialize(),
                dataType: 'json'
            });

            request.done(function( response ) {
                $.LoadingOverlay("hide");
                if (response.status) {
                    $(location).attr("href", response.data.url_redirect);
                } else {
                    swal("Error", response.message, "error");

                }
            });

            request.fail(function( jqXHR, textStatus ) {
                $.LoadingOverlay("hide");
                swal("Error", textStatus, "error");

            });
        } else {

            swal("Error", "Ingrese sus datos de usuario correctamente.", "error");

        }
    });


    $("#btnRegister").on("click", function(evt){
        evt.preventDefault();

        $.LoadingOverlay("show");
        var request = $.ajax({
            url: base_url+'registerIn',
            type: "post",
            data: $("#RegisterForm").serialize(),
            dataType: 'json'
        });

        request.done(function( response ) {
            $.LoadingOverlay("hide");
            if (response.status) {
                swal("Registro Completo", response.message, "success");
            } else {
                swal("Error", response.message, "error");
            }
        });
        request.fail(function( jqXHR, textStatus ) {
            $.LoadingOverlay("hide");
            swal("Error", textStatus, "error");

        });

    });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });








    $("#cbDepartamento").on("change",function(){
        var formData = new FormData();
        if($(this).val() != ''){
            formData.append("id", $(this).val());
            $("#cbProvincia").empty();
            $("#cbProvincia").append("<option value=''>PROVINCIA</option>");
            $("#cbDistrito").empty();
            $("#cbDistrito").append("<option value=''>DISTRITO</option>");
            var request = $.ajax({
                url: base_url + "getProvincias",
                type: "post",
                data: formData,
                contentType: false,
                processData: false
            });
            request.done(function(response) {
                if (response.status) {
                    for (var i = 0; i < response.data.length; i++) {
                        $("#cbProvincia").append("<option value='" + response.data[i].idProvincia + "'>" + response.data[i].nom_provincia + "</option>");
                    }
                } else {
                    swal("Error", response.message, "error");
                }
            });
            request.fail(function( jqXHR, textStatus ) {
                swal("Error", textStatus, "error");
            });
        }else{
            $("#cbProvincia").empty();
            $("#cbProvincia").append("<option value=''>PROVINCIA</option>");
        }


    });

    $("#cbProvincia").on("change",function(){
        var formData = new FormData();
        if($(this).val() != ''){
            formData.append("id", $(this).val());
            $("#cbDistrito").empty();
            $("#cbDistrito").append("<option value=''>DISTRITO</option>");
            var request = $.ajax({
                url: base_url + "getDistritos",
                type: "post",
                data: formData,
                contentType: false,
                processData: false
            });

            request.done(function(response) {
                if (response.status) {
                    for (var i = 0; i < response.data.length; i++) {
                        $("#cbDistrito").append("<option value='" + response.data[i].idDistrito + "'>" + response.data[i].nom_distrito + "</option>");
                    }
                } else {
                    swal("Error", response.message, "error");
                }
            });

            request.fail(function( jqXHR, textStatus ) {
                swal("Error", textStatus, "error");
            });
        }else{
            $("#cbDistrito").empty();
            $("#cbDistrito").append("<option value=''>DISTRITO</option>");
        }


    });


});
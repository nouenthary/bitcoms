$(function () {
    // set update ajax
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // loading api botcoin
    const getData = function () {
        let url = "/privacy-page?type=";
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                console.log(response[0]);
                //
                $.each(response[0], function (key, value) {
                    console.log(key);
                    console.log(value);
                    let $element = $(".cart-image").clone();
                    $(".image-box").append($element);
                });

                // $.each(response, function (key, value) {
                //     console.log(key);
                //     console.log(value[key]);
                //     // let $element = $(".cart-image").clone();
                //     // $(".image-box").append($element);
                // });

                //console.log(response);
                // fee
                // let { tradeffeepercent, widtrwfeepercent } = fee[0];
                // $("#tradeffeepercent").val(tradeffeepercent);
                // $("#widtrwfeepercent").val(widtrwfeepercent);
                // company
                // $("#nameweb").val(company[0].nameweb);
                // if (company[0].logo != null) {
                //     $(".view-logo").attr("src", company[0].logo);
                // }
                // contact us
                // let { phone, address, email, coutry, Description, city } =
                //     contact_us[0];
                // $("#phone").val(phone);
                // $("#address").val(address);
                // $("#email").val(email);
                // $("#coutry").val(coutry);
                // $("#Description").val(Description);
                // $("#city").val(city);
                // privacy
            },
            error: function (xhr) {
                console.log(JSON.stringify(xhr.responseText));
            },
        });
    };
    // call
    getData();

    // handle create or update
    $(document).on("click", "#btn-create", function (e) {
        e.preventDefault();

        let name = $(".language_name").val();

        if (name === "") {
            errorMessage("Please enter language ...", "");
            $(".language_name").focus();
            return;
        }

        var data = new FormData(jQuery("form")[0]);

        // data.append("file", $("#logo")[0].files[0]);

        // data.append("en", $("#en")[0].files[0]);

        $("#btn-create").attr("disabled", "");

        let method = "POST";

        let baseUrl = "/privacy-page";

        $.ajax({
            url: baseUrl,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: method,
            success: function (data) {
                $("#btn-create").removeAttr("disabled");

                $(".language_name").focus();

                $(".language_name").val("");

                successMessage(data.message, "");
            },
            error: function (xhr) {
                let data = JSON.parse(xhr.responseText);

                let { message, status } = data;

                if (status === false) {
                    for (let row in message) {
                        errorMessage(message[row][0], "");
                    }
                }
                $("#btn-create").removeAttr("disabled");
            },
        });
    });

    //
    function successMessage(text, options = "Welcome new title") {
        toastr.success(text, options, {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1,
        });
    }

    //
    function errorMessage(text, options = "Welcome new title") {
        toastr.error(text, options, {
            positionClass: "toast-top-right",
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            preventDuplicates: !0,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            tapToDismiss: !1,
        });
    }
});

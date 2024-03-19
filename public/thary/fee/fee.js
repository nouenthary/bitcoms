$(function () {
    // set update ajax
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // loading api botcoin
    const getData = function () {
        let url = "/fee-setting/show";
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                let { fee, company } = response;

                $("#tradeffeepercent").val(fee[0].tradeffeepercent);
                $("#widtrwfeepercent").val(fee[0].widtrwfeepercent);
                $("#nameweb").val(company[0].nameweb);
                if (company[0].logo != null) {
                    $(".view-logo").attr("src", company[0].logo);
                }
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

        let tradeffeepercent = $("#tradeffeepercent").val();
        let widtrwfeepercent = $("#widtrwfeepercent").val();

        if (tradeffeepercent < 0 || tradeffeepercent > 100) {
            errorMessage("Please trade fee 1-100", "");
            return;
        }

        if (tradeffeepercent === "") {
            errorMessage("Please enter trade fee ...", "");
            return;
        }

        if (widtrwfeepercent === "") {
            errorMessage("Please enter withdraw fee ...", "");
            return;
        }

        if (widtrwfeepercent < 0 || widtrwfeepercent > 100) {
            errorMessage("Please withdraw fee 1-100", "");
            return;
        }

        var data = new FormData(jQuery("form")[0]);

        jQuery.each(jQuery("#logo")[0].files, function (i, file) {
            data.append("file[]", file);
        });

        $("#btn-create").attr("disabled", "");

        let method = "POST";

        let baseUrl = "/fee-setting";

        $.ajax({
            url: baseUrl,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: method,
            success: function (data) {
                $("#btn-create").removeAttr("disabled");

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

    // input only number
    $(".number").keypress(function (event) {
        if (
            (event.which != 46 || $(this).val().indexOf(".") != -1) &&
            (event.which < 48 || event.which > 57)
        ) {
            event.preventDefault();
        }
    });

    $(".number").on("cut copy paste", function (e) {
        e.preventDefault();
    });

    //

    //update load preview currency qr code
    $("#logo").change(function () {
        readURLs(this);
    });

    // handle click
    function readURLs(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(".view-logo").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
});

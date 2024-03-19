$(function () {
    //
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //
    let baseUrl = "/wallet-address";

    // handle change name currency
    $(document).on("change", "#fkwallettileid", function () {
        let value = $(this).find(":selected").attr("key");
        $("#wallet_address").val(value);
    });

    //
    const getDataWallet = function () {
        let params = {
            option: "select",
            page: 1,
            size: 1000,
            order: "asc",
            column: "walletid",
        };

        let pramsUrl = Object.keys(params)
            .map(function (key) {
                return key + "=" + params[key];
            })
            .join("&");

        let baseUrl = "/wallet-title";

        $.ajax({
            type: "get",
            url: baseUrl + "?" + pramsUrl,
            dataType: "json",
            success: function (response) {
                let data = JSON.stringify(response.data);

                localStorage.removeItem("wallet_title");

                localStorage.setItem("wallets_title", data);
            },
            error: function (data) {
                console.log(data);
            },
        });
    };

    setInterval(function () {
        getDataWallet();
    }, 1000);

    let currency = "";

    function getWalletFromStorage() {
        let data = JSON.parse(localStorage.getItem("wallets_title"));

        let wallet = $(".w-searching").val();

        let dataSource = data;

        if (wallet.length > 0) {
            dataSource = data.filter((t) =>
                t.namecurency.toLowerCase().match(wallet)
            );
        }

        let wallets = [];
        $(".contacts-list").empty();
        $.each(dataSource.slice(0, 300), function (key, value) {
            let $element = $(".card-wallet").clone();
            $element.attr("wallet_id", value.walletid);
            $element.attr("wallet_address", value.walletaddress);
            $element.find(".w-name").text(value.namecurencywallet);
            $element.find(".w-name").text(value.namecurencywallet);
            $element.find(".w-currency").text(value.namecurency);
            $element.find(".w-image").attr("src", value.imagecurency);
            if (value.symbol === currency) {
                $element.addClass("bg-light");
            }
            wallets.push($element);
        });
        $(".contacts-list").append(wallets);
    }

    setInterval(function () {
        getWalletFromStorage();
    }, 1000);

    //
    $(document).on("keyup", ".w-searching", function () {
        getWalletFromStorage();
    });

    //
    $(document).on("click", ".card-wallet", function () {
        let $element = $(this).closest("div");
        let wallet_id = $element.attr("wallet_id");
        let wallet_address = $element.attr("wallet_address");
        let namecurency = $element.find(".w-currency").text();

        $("#fkwallettileid").val(wallet_id);
        $("#wallet_address").val(wallet_address);

        $(".card-wallet").removeClass("bg-light");
        currency = namecurency;
        $(this).addClass("bg-light");
    });

    // get card deposit
    const getData = function () {
        let params = {
            page: 1,
            size: 1000,
            order: "asc",
            column: "walletid",
        };

        let pramsUrl = Object.keys(params)
            .map(function (key) {
                return key + "=" + params[key];
            })
            .join("&");

        $.ajax({
            type: "get",
            url: baseUrl + "?" + pramsUrl,
            dataType: "json",
            success: function (response) {
                let data = response.data;

                $("#row-wallet").empty();

                $.each(data, function (key, value) {
                    let $element = $(".card-wallet-item:first").clone(true);

                    let balance = parseFloat(value.balance).toLocaleString();

                    $element.find(".text-balance").text(balance);

                    $element.find(".address").val(value.walletaddress);

                    $element.find(".text-currency").text(value.namecurency);

                    $element
                        .find(".text-name-currency")
                        .text(value.namecurencywallet);

                    $element
                        .find(".btn-deposit")
                        .attr("data-id", value.walletid);

                    $element
                        .find(".btn-deposit")
                        .attr("data-json", JSON.stringify(value));

                    $element.find(".qr-image").attr("src", "/" + value.qrimage);

                    $element
                        .find(".img-logo")
                        .attr("src", "" + value.imagecurency);

                    $element
                        .find(".image-currency-logo")
                        .attr("src", "" + value.imagecurency);

                    $("#row-wallet").append($element);
                });
            },
            error: function (data) {
                console.log(data);
            },
        });
    };

    getData();

    // update load preview currency logo
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#image-view-voucher").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // handle click
    $("#paymentvoucher").change(function () {
        readURL(this);
    });

    //
    $(document).on("click", "#btn-create-address", function () {
        $("#exampleModal").modal("show");
        $("#form-create").get(0).reset();
    });

    // open form create
    $(document).on("click", ".btn-deposit", function () {
        $("#modalDeposit").modal("show");

        let data_json = $(this).attr("data-json");

        let data = JSON.parse(data_json);

        let { fkuserid, namecurencywallet, qrimage, walletaddress, walletid } =
            data;

        $("#fkuserid").val(fkuserid);
        $("#fkwalletid").val(walletid);
        $("#namewallet").val(namecurencywallet);
        $("#walletaddr").val(walletaddress);
        $("#qrimage").val(qrimage);
        $(".text-address").text(walletaddress);

        document.getElementById("amount").focus();

        $("#image-view-voucher").attr(
            "src",
            "https://images.assetsdelivery.com/compings_v2/infadel/infadel1712/infadel171200119.jpg"
        );
        $("#image-view-qr").attr("src", "/" + qrimage);
    });

    // create wallet
    $(document).on("click", "#btn-create", function (e) {
        e.preventDefault();

        let data = $("#form-create").serializeArray();

        let fkwallettileid = $("#fkwallettileid").val();

        if (fkwallettileid === "" || fkwallettileid === 0) {
            error("Please choose wallet ...", "");
            return;
        }

        $("#btn-create").attr("disabled", "");

        $.ajax({
            type: "POST",
            url: baseUrl,
            data: data,
            success: function (data) {
                $("#exampleModal").modal("hide");

                $("#form-create").get(0).reset();

                $("#btn-create").removeAttr("disabled");

                success(data.message, "");
            },
            error: function (xhr) {
                let data = JSON.parse(xhr.responseText);
                let { message } = data;
                $("#btn-create").removeAttr("disabled");
                if (message) {
                    error(message, "Message Error");
                }
            },
        });

        getData();
    });

    // create deposit
    $(document).on("click", "#btn-create-deposit", function (e) {
        e.preventDefault();

        let data = new FormData($("#form-create-deposit")[0]);

        jQuery.each(jQuery("#paymentvoucher")[0].files, function (i, file) {
            data.append("file[]", file);
        });

        let amount = $("#amount").val();

        if (amount === "" || amount <= 0) {
            error("Please enter recharge amount", "Warning Message");
            $("#amount").focus();
            return;
        }

        let payment_voucher = $("#paymentvoucher").val();

        if (payment_voucher === "") {
            error("Please enter payment voucher ", "Warning Message");

            $("#paymentvoucher").focus();
            return;
        }

        $("#btn-create-deposit").attr("disabled", "");

        $.ajax({
            type: "POST",
            url: "/deposit",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                success(data.message, "");

                $("#modalDeposit").modal("hide");

                $("#form-create-deposit").get(0).reset();

                $("#btn-create-deposit").removeAttr("disabled");
            },
            error: function (xhr) {
                let data = JSON.parse(xhr.responseText);
                let { message, status } = data;
                if (status === false) {
                    for (let row in message) {
                        error(message[row][0], "Message Error");
                    }
                    return;
                }
                $("#btn-create-deposit").removeAttr("disabled");
            },
        });
    });

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
    $(document).on("click", ".fa-copy", function () {
        var range = document.createRange();
        range.selectNode(document.querySelector(".text-address"));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();

        success("data copied", "");
    });

    ///
    $(document).on("click", "#fa-copy", function () {
        let element = $(this).parent().find("input");
        var range = document.createRange();
        range.selectNode(element[0]);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();

        success("data copied", "");
    });

    // form create wallet
    $(document).on("click", ".fa-copy-form", function () {
        var range = document.createRange();
        range.selectNode(document.querySelector("#wallet_address")); //changed here
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();

        success("data copied", "");
    });

    function success(message, options = "") {
        toastr.success(message, options, {
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

    function error(message, text) {
        toastr.error(message, text, {
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

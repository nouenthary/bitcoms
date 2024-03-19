$(function () {
    //
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //
    let baseUrl = "/wallet-address";

    //
    $(document).on("click", ".card-wallet", function () {
        let $element = $(this).closest("div");

        let wallet_id = $element.attr("wallet_id");
        let wallet_address = $element.attr("wallet_address");

        $("#fkwallettileid").val(wallet_id);
        $("#wallet_address").val(wallet_address);

        $(".card-wallet").removeClass("bg-light");

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

                // push wallet to select

                // push wallet to select

                let fee = response.fee;

                $("#withdrawal").val(fee.widtrwfeepercent);
                $("#trade").val(fee.tradeffeepercent);

                let user = response.user;
                //console.log(user)
                $("#row-wallet").empty();
                $("#row-wallet-default").empty();

                //  wallet user
                let $elementUser = $(".card-wallet-item:first").clone(true);

                let balance = parseFloat(user.walletamount).toLocaleString();

                $elementUser.find(".text-balance").text(balance);

                $elementUser.find(".address").val(user.codeaddress);

                $elementUser.find(".text-currency").text("USTD");

                $elementUser.find(".text-name-currency").text("Default Wallet");

                $elementUser.find(".btn-deposit").attr("data-id", 0);

                let logo =
                    "https://png.pngtree.com/png-vector/20191129/ourmid/pngtree-image-upload-icon-photo-upload-icon-png-image_2047546.jpg";

                let wallet =
                    "https://png.pngtree.com/element_our/20190528/ourmid/pngtree-orange-wallet-icon-image_1168655.jpg";

                let json = {
                    imagecurency:
                        "https://png.pngtree.com/element_our/20190528/ourmid/pngtree-orange-wallet-icon-image_1168655.jpg",
                    namecurency: "USTD",
                    namecurencywallet: "Default Wallet",
                    qrimage: 0,
                    balance: user.walletamount,
                    withdrawid: 0,
                    walletid: "",
                    fkuserid: 0,
                    codeaddress: user.codeaddress,
                    codelink: user.codelink,
                };

                $elementUser
                    .find(".btn-deposit")
                    .attr("data-json", JSON.stringify(json));

                $elementUser
                    .find(".btn-deposit")
                    .attr("data-fee", JSON.stringify(fee));

                $elementUser.find(".qr-image").attr("src", logo);

                if (user.codelink !== null) {
                    $elementUser.find(".qr-image").attr("src", user.codelink);
                }

                $elementUser.find(".img-logo").attr("src", wallet);

                $elementUser.find(".image-currency-logo").attr("src", logo);

                $("#row-wallet-default").append($elementUser);
                // wallet
                $.each(data, function (key, value) {
                    //
                    $(".fkwalletid").append(
                        $("<option>", {
                            value: value.walletid,
                            text: value.namecurencywallet,
                        })
                    );
                    //

                    let $element = $(".card-wallet-item:first").clone(true);

                    let balance = parseFloat(value.balance).toLocaleString();

                    $element.find(".text-balance").text(balance);

                    $element.find(".address").val(value.codeaddress);

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

                    $element
                        .find(".btn-deposit")
                        .attr("data-fee", JSON.stringify(fee));

                    $element
                        .find(".qr-image")
                        .attr(
                            "src",
                            "https://png.pngtree.com/png-vector/20191129/ourmid/pngtree-image-upload-icon-photo-upload-icon-png-image_2047546.jpg" +
                                ""
                        );

                    if (value.codelink != null) {
                        $element.find(".qr-image").attr("src", value.codelink);
                    }

                    //console.log(value);

                    $element.find(".img-logo").attr("src", value.imagecurency);

                    //
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
                $("#image-view").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // handle click
    $("#codelink").change(function () {
        readURL(this);
    });

    //
    $(document).on("click", "#btn-create-address", function () {
        $("#exampleModal").modal("show");
        $("#form-create").get(0).reset();
    });

    // open form create
    $(document).on("click", ".btn-deposit", function () {
        //alert();
        // clear
        $("#modalDeposit").modal("show");

        let data_json = $(this).attr("data-json");
        let data = JSON.parse(data_json);

        let data_fee = $(this).attr("data-fee");
        let fee = JSON.parse(data_fee);

        $(".codeaddress").val("");
        $(".codelink").val("");
        $("#image-view").attr(
            "src",
            "https://images.assetsdelivery.com/compings_v2/infadel/infadel1712/infadel171200119.jpg"
        );
        //
        if (data.codeaddress != null) {
            $(".codeaddress").val(data.codeaddress);
        }
        //console.log(data);
        if (data.codelink != null) {
            $(".codelink").val(data.codelink);
            $("#image-view").attr("src", data.codelink);
            $("#codelink_default").val(data.codelink);
        }
        //

        //console.log(data);

        let { imagecurency, namecurency, namecurencywallet, qrimage, balance } =
            data;

        $("#image-view-voucher").attr(
            "src",
            "https://images.assetsdelivery.com/compings_v2/infadel/infadel1712/infadel171200119.jpg"
        );
        $("#image-view-qr").attr("src", "/storage/" + qrimage);

        let priceFee = fee.widtrwfeepercent;
        let totalamount =
            data.balance - (data.balance * fee.widtrwfeepercent) / 100;
        let totalFee = (data.balance * fee.widtrwfeepercent) / 100;

        //
        let json = {
            withdrawid: 0,
            fkwalletid: data.walletid,
            fkuserid: data.fkuserid,
            balance: data.balance,
            fee: priceFee,
            totalamount: totalamount,
            feeamount: totalFee,
            status: "pending",
        };

        for (let key in json) {
            $("input[name='" + key + "']").val(json[key]);
        }
        //
        $(".t-name").text(namecurencywallet);
        $(".t-balance").text(
            namecurencywallet +
                " = " +
                parseFloat(balance).toFixed(2) +
                " " +
                namecurency
        );
        $(".t-img-logo").attr("src", "" + imagecurency);

        $(".t-fee").text(parseFloat(fee.priceFee).toFixed(2));

        $(".t-total-amount").text(
            "Total Balance = " + parseFloat(totalamount).toFixed(2)
        );

        $(".t-total-fee").text(
            parseFloat(totalFee).toFixed(2) + " " + namecurency
        );
    });

    // create deposit
    $(document).on("click", "#btn-create-deposit", function (e) {
        e.preventDefault();

        let data = new FormData($("#form-create-deposit")[0]);

        let codeAddress = $("#codeaddress").val();

        if (codeAddress === "") {
            error("Please enter code address ...", "Warning Message");
            $("#codeaddress").focus();
            return;
        }

        jQuery.each(jQuery("#codelink")[0].files, function (i, file) {
            data.append("file[]", file);
        });

        let codeLink = $("#codelink").val();

        if (codeLink === "" && $("#codelink_default").val() === "") {
            error("Please enter code link ... ", "Warning Message");
            $("#codelink").focus();
            return;
        }
        //console.log($("#form-create-deposit").serializeArray());
        //return;

        $("#btn-create-deposit").attr("disabled", "");

        $.ajax({
            type: "POST",
            url: "/withdrawal",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                success(data.message, "");

                $("#modalDeposit").modal("hide");

                $("#form-create-deposit").get(0).reset();

                $("#btn-create-deposit").removeAttr("disabled");

                $("#image-view").attr(
                    "src",
                    "https://images.assetsdelivery.com/compings_v2/infadel/infadel1712/infadel171200119.jpg"
                );

                getData();
            },
            error: function (xhr) {
                $("#btn-create-deposit").removeAttr("disabled");
                let data = JSON.parse(xhr.responseText);
                let { message, status } = data;
                if (status === false) {
                    if (typeof message === "string") {
                        error(message, "Message Error");
                        return;
                    }

                    for (let row in message) {
                        error(message[row][0], "Message Error");
                    }

                    return;
                }
            },
        });
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
        let range = document.createRange();
        range.selectNode(element[0]);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();

        success("data copied", "");
    });

    // form create wallet
    $(document).on("click", ".fa-copy-form", function () {
        let range = document.createRange();
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

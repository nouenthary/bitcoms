$(function () {
    // loading api botcoin
    const getBitcons = function () {
        let url =
            "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=1000&page=1&sparkline=false&locale=en";

        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: function (response) {
                localStorage.setItem("wallets", JSON.stringify(response));
            },
            error: function (xhr) {
                console.log(JSON.stringify(xhr.responseText));
            },
        });
    };
    // call
    getBitcons();

    //
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //
    let baseUrl = "/wallet-address";

    //
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

                $("#fkwalletid").empty();
                $("#walletid").empty();
                $("#walletid").append("<option value=''>All</option>");
                $("#fkwalletid").append("<option value=''>All</option>");

                // wallet
                $.each(data, function (key, value) {
                    
                    //
                    $("#fkwalletid").append(
                        $("<option>", {
                            value: value.walletid,
                            text: value.namecurency.toUpperCase(),
                            name: value.namecurency,
                            balance: value.balance,
                            image: value.imagecurency,
                        })
                    );

                    $(".fkwalletid").append(
                        $("<option>", {
                            value: value.walletid,
                            text: value.namecurency.toUpperCase(),
                            name: value.namecurency,
                            balance: value.balance,
                            image: value.imagecurency,
                        })
                    );
                });
            },
            error: function (data) {
                console.log(data);
            },
        });
    };

    getData();

    $(document).on("change", "#fkwalletid", function () {
        let balance = $("option:selected", this).attr("balance");
        let image = $("option:selected", this).attr("image");
        let name = $("option:selected", this).attr("name");
        //
        $("#fromwalletname").val(name);
        $("#logofromwallet").val(image);
        $("#logotowallet").val(
            "https://www.pngitem.com/pimgs/m/456-4560596_tether-usdt-icon-tether-logo-png-transparent-png.png"
        );
        //
        let currentPrice = 0;

        let data = JSON.parse(localStorage.getItem("wallets"));

        if (data.length > 0) {
            currentPrice = data.filter((t) =>
                t.symbol.toLowerCase().match(name)
            )[0].current_price;
        }
        let total = currentPrice * balance;
        //
        $("#balance").val(balance);
        $("#amount").val(total);
        $("#exchange_price").val(currentPrice);
    });

    // create deposit
    $(document).on("click", "#btn-exchange", function (e) {
        e.preventDefault();

        let data = new FormData($("#form-create")[0]);

        let walletid = $("#fkwalletid").val();

        if (walletid === "") {
            errorMessage("Please choose wallet ...", "Warning Message");
            $("#fkwalletid").focus();
            return;
        }

        let balance = $("#balance").val();

        if (balance === "" || balance === 0) {
            errorMessage("Please enter balance ... ", "Warning Message");
            return;
        }

        let amount = $("#amount").val();

        if (amount === "" || amount === 0) {
            errorMessage("Please enter amount ... ", "Warning Message");
            return;
        }

        //console.log($("#form-create").serializeArray());
        //return;

        $("#btn-exchange").attr("disabled", "");

        $.ajax({
            type: "POST",
            url: "/transfer-coin",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                successMessage(data.message, "");

                $("#btn-exchange").removeAttr("disabled");

                $("#fkwalletid").val("");
                $("#amount").val(0);
                $("#balance").val(0);

                getData();

                table.draw();
            },
            error: function (xhr) {
                $("#btn-exchange").removeAttr("disabled");
                let data = JSON.parse(xhr.responseText);
                let { message, status } = data;
                if (status === false) {
                    if (typeof message === "string") {
                        errorMessage(message, "Message Error");
                        return;
                    }

                    for (let row in message) {
                        errorMessage(message[row][0], "Message Error");
                    }

                    return;
                }
            },
        });
    });

    // message
    function successMessage(message, options = "") {
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

    // massage
    function errorMessage(message, text) {
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

    //
    $(".my-date").datepicker({});

    $(document).on("change", ".my-date", function () {
        table.draw();
    });

    $(document).on("change", ".fkwalletid", function () {
        table.draw();
    });

    // datatable
    let table = $("#table-history").DataTable({
        searching: false,
        lengthChange: true,
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous:
                    '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
            },
        },
        processing: true,
        serverSide: true,
        ajax: {
            type: "POST",
            url: "/transfer-coins",
            data: function (p) {
                p.status = $("#p_status").val();
                p.wallet = $("#p_wallet").val();
                p.fkwalletid = $(".fkwalletid :selected").val();

                if ($("#start_date").val() !== "") {
                    let start_date = moment($("#start_date").val()).format(
                        "YYYY-MM-DD"
                    );
                    p.start_date = start_date + " 00:00:00";
                }

                if ($("#end_date").val() !== "") {
                    let end_date = moment($("#end_date").val()).format(
                        "YYYY-MM-DD"
                    );
                    p.end_date = end_date + " 23:00:00";
                }
            },
        },
        columns: [
            { data: "createdate", name: "createdate", render: datetime },

            {
                data: "towalletname",
                name: "towalletname",
                render: function (a, b, c) {
                    return (
                        images(c.imagecurency) +
                        "<span class='text-uppercase'>" +
                        c.namecurency +
                        " - " +
                        c.towalletname +
                        "</span>"
                    );
                },
            },
            {
                data: "imagecurency",
                name: "imagecurency",
                render: function () {
                    return '<span class="badge badge-sm badge-success">transfer</span>';
                },
            },

            {
                data: "amount",
                name: "amount",
                render: function (a, b, c) {
                    let amount = parseFloat(c.amount_transfer).toLocaleString();
                    return (
                        "<p class='text-black font-weight-bold text-uppercase'>" +
                        amount +
                        " " +
                        c.namecurency +
                        " </p> "
                    );
                },
            },

            {
                data: "total",
                name: "total",
                render: function (a, b, c) {
                    let amount = parseFloat(c.amount).toLocaleString();
                    return (
                        "<span class='text-primary font-weight-bold'>" +
                        amount +
                        " " +
                        " </span> " +
                        c.towalletname
                    );
                },
            },
        ],
        //responsive: true,
        order: [[2, "desc"]],
    });

    $(document).on("click", ".nav-item", function () {
        let status = $(this).attr("data-status");
        $("#p_status").val(status);
        table.draw();

        $(".nav-item").removeClass("active");
        $(this).addClass("active");
    });

    function images(src) {
        return (
            `
            <img class="rounded-circle img-click" width="30px" height="30px" src="` +
            src +
            `" alt="wallet-title">
        `
        );
    }

    function datetime(src, records, options) {
        let date = moment(options.start_date + " " + options.start_time);
        return date.format("YYYY-MM-DD HH:mm");
    }

    // image click handler
    $(document).on("click", ".img-click", function () {
        $("#modal-image").modal("show");
        $(".image-view-modal").attr("src", $(this).attr("src"));
    });

    // button filter
    $(document).on("click", ".btn-filter", function () {
        table.draw();
        //alert("filter");
    });

    // button clear filter
    $(document).on("click", ".btn-remove-filter", function () {
        $(".fkwalletid").val("");
        $("#start_date").val("");
        $("#end_date").val("");
        table.draw();
        //alert("remove");
    });
});

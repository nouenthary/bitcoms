//

$(function () {
    //
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    function chartTheme() {
        if ($("body").attr("data-theme-version") == "light") {
            return "Light";
        } else {
            return "Dark";
        }
    }
    function tradingfuture(symbol = "BTC") {
        let val = "BITSTAMP:" + symbol + "USD";

        new TradingView.widget({
            width: "100%",
            height: 516,
            symbol: val,
            interval: "D",
            timezone: "Etc/UTC",
            theme: chartTheme(),
            style: "1",
            locale: "en",
            toolbar_bg: "#f1f3f6",
            enable_publishing: false,
            withdateranges: true,
            hide_side_toolbar: false,
            allow_symbol_change: false,
            show_popup_button: true,
            popup_width: "1000",
            popup_height: "650",
            container_id: "tradingview_85dc0",
        });
    }

    var element = document.querySelector("body");
    var observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.attributeName === "data-theme-version") {
                tradingfuture();
            }
        });
    });
    observer.observe(element, {
        attributes: true,
    });

    $(window).on("load", function () {
        setTimeout(function () {
            tradingfuture();
        }, 1000);
    });
    //

    // loading api botcoin
    const getData = function () {
        let url =
            "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=1000&page=1&sparkline=false&locale=en";

        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: function (response) {
                setLocalStorage("wallets", response);

                let default_wallet = getLocalStorage("default_wallet");

                if (default_wallet === null) {
                    setLocalStorage("default_wallet", response[0]);
                }
            },
            error: function (xhr) {
                console.log(JSON.stringify(xhr.responseText));
            },
        });
    };
    // call

    //
    function getWalletFromStorage() {
        let data = getLocalStorage("wallets");

        let wallet = $(".w-searching").val();

        let dataSource = data;

        if (wallet.length > 0) {
            dataSource = data.filter((t) => t.name.toLowerCase().match(wallet));
        }

        let wallets = [];
        $(".contacts-list").empty();
        $.each(dataSource.slice(0, 300), function (key, value) {
            let $element = $(".card-wallet").clone();
            $element.find(".v-currcency-name").text(value.name);
            $element.find(".v-currcency").text(value.symbol);
            $element.find(".v-logo").attr("src", value.image);
            $element.find(".v-price").text(value.current_price);
            $element
                .find(".v-percent")
                .text(
                    parseFloat(value.price_change_percentage_24h).toFixed(2) +
                    " %"
                );

            $element.attr("data-json", JSON.stringify(value));
            wallets.push($element);
        });
        $(".contacts-list").append(wallets);
    }

    getData();
    getWalletFromStorage();

    //
    $(document).on("keyup", ".w-searching", function () {
        getWalletFromStorage();
    });

    $(document).on("click", ".card-wallet", function () {
        let data = $(this).attr("data-json");
        setLocalStorage("default_wallet", JSON.parse(data));
        $(".card-wallet").removeClass("bg-light");
        $(this).addClass("bg-light");
        //
        loadingMarket();
    });

    // get local storage
    function getLocalStorage(key) {
        let data = localStorage.getItem(key);
        return JSON.parse(data);
    }

    // set local storage
    function setLocalStorage(key, data) {
        localStorage.setItem(key, JSON.stringify(data));
    }

    //
    function loadingMarket() {
        let data = getLocalStorage("default_wallet");
        let wallet = parseFloat(data.current_price);
        $("#t-buy-more").text(wallet.toLocaleString());
        $("#t-buy-less").text(wallet.toLocaleString());
        $(".text-currcency").text(data.symbol);
        $(".text-current-price").text(wallet.toLocaleString());
        //
        $(".default-name").text(data.symbol + "/USTD");
        $(".v-logo-view").attr("src", data.image);

        $(".d-name").text(data.name);
        $(".d-current-price-percent").text(
            data.price_change_percentage_24h + " %"
        );
        //
        //  dataApi();
        tradingfuture(data.symbol);
    }

    loadingMarket();

    //
    function buttonBuy(type) {
        let trade_status = $("#trade-status").val();

        if (trade_status.toLowerCase() !== "done") {
            errorMessage("Please complete docuement", "");
            return;
        }
        //

        $("#feepercent").val(0);
        $("#feeamount").val(0);
        $("#totalamount").val(0);
        $("#wintrade").val("11");
        $("#tradetitle").val("");
        $("#timetrade").val("0");
        //
        $("#modal-create").modal("show");
        //
        $(".text-buy").text(type);
        if (type == "buy less") {
            $(".text-buy").removeClass("text-success");
            $(".text-buy").addClass("text-danger");
        }
        if (type == "buy more") {
            $(".text-buy").removeClass("text-danger");
            $(".text-buy").addClass("text-success");
        }
        //
        $("#tradetitle").val(type);
        //
        let date = moment().format("YYYY-MM-DD");
        let time = moment().format("HH:mm:ss");
        $("#dateupdate").val(date);
        $("#timeupdate").val(time);
        // get default wallet
        let data = getLocalStorage("default_wallet");
        //
        $("#namecurrency").val(data.symbol);
        $("#logocurrency").val(data.image);
        $("#lastprice").val(data.current_price);
        //
        loadingMarket();
        //
        getFee();
        //
        getUserWallet();
        //
        getUserTrade();
    }

    //
    $(document).on("click", ".btn-buy-less", function () {
        buttonBuy("buy less");
    });
    //
    $(document).on("click", ".btn-buy-more", function () {
        buttonBuy("buy more");
    });

    //
    $(document).on("click", ".btn-time", function () {
        $("#timetrade").val($(this).attr("data-time"));
        $(".btn-time").removeClass("btn-success");
        $(this).addClass("btn-success");
        //
        getFee();
        //
    });

    // fee
    function getFee() {
        $.ajax({
            url: "/get-fee",
            type: "get",
            success: function (response) {
                $("#feepercent").val(response);
                $(".text-fee").text(response);
                //
                total();
                //
            },
            error: function (xhr) {
                console.log(JSON.stringify(xhr.responseText));
            },
        });
    }

    // trade user
    function getUserTrade() {
        $.ajax({
            url: "/get-user-trade",
            type: "get",
            success: function (response) {
                $("#wintrade").val(response);
            },
            error: function (xhr) {
                console.log(JSON.stringify(xhr.responseText));
            },
        });
    }

    //
    function getUserWallet() {
        $.ajax({
            url: "/get-user-wallet",
            type: "get",
            success: function (response) {
                let wallet = parseFloat(response).toLocaleString();
                $(".text-balance").text(wallet);
            },
            error: function (xhr) {
                console.log(JSON.stringify(xhr.responseText));
            },
        });
    }

    getUserWallet();

    // total
    function total() {
        let fee = $("#feepercent").val();
        let amount = $("#amount").val();

        let feeamount = (amount * fee) / 100;
        let amounttotal = amount - (amount * fee) / 100;
        //
        $("#feeamount").val(feeamount);
        $("#totalamount").val(amounttotal);
        //
        $(".text-lot").text(amounttotal);
        $(".text-amount").text(amount);
        $(".text-fee-amount").text(feeamount);
        $(".text-amount-total").text(amounttotal);
    }

    var countDown = function (secondsRemaining) {
        secondsRemaining -= 1;
        if (secondsRemaining <= 0) {
            //execute
        } else {
            setTimeout(function () {
                countDown(secondsRemaining);
                $(".text-count-down").text(secondsRemaining);
                if (secondsRemaining <= 1) {
                    $("#modal-trade").modal("hide");
                }
            }, 1000);
        }
    };

    // create trade
    $(document).on("submit", "#form-create", function (e) {
        e.preventDefault();

        let data = new FormData($("#form-create")[0]);

        let amount = $("#amount").val();
        let balance = $(".text-balance:first").text();

        if (amount === "") {
            errorMessage("Please enter lot size ...", "Warning Message");
            $("#amount").focus();
            return;
        }

        if (balance == 0) {
            errorMessage("lot size " + balance + " ...", "Warning Message");
            $("#amount").focus();

            setTimeout(function () {
                location.href = "/wallet-page";
            }, 2000);

            return;
        }

        if (amount > balance) {
            errorMessage("lot size " + balance + " ...", "Warning Message");
            $("#amount").focus();
            return;
        }

        let timetrade = $("#timetrade").val();

        if (timetrade === "" || timetrade <= 0) {
            errorMessage("Please choose time  ...", "Warning Message");
            return;
        }

        //console.log($("#form-create").serializeArray());
        //return;

        $("#btn-create").attr("disabled", "");

        $.ajax({
            type: "POST",
            url: "/trade",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                //countDown(0);
                //clearInterval(countDown);
                successMessage(data.message, "");
                $("#btn-create").removeAttr("disabled");
                $("#amount").val(0);
                $("#modal-create").modal("hide");
                $("#modal-trade").modal("show");
                countDown(timetrade);
                $(".btn-time").removeClass("btn-success");
                //
                table.draw();
                //
                loadingMarket();

                getUserWallet();
            },
            error: function (xhr) {
                $("#btn-create").removeAttr("disabled");
                let data = JSON.parse(xhr.responseText);
                let { message, status } = data;
                if (status === false) {
                    if (typeof message === "string") {
                        errorMessage(message, " Error");
                        return;
                    }
                    for (let row in message) {
                        errorMessage(message[row][0], " Error");
                    }
                    return;
                }
            },
        });
    });

    //
    $(document).on("keypress", ".number", function () {
        total();
    });

    $(document).on("keydown", ".number", function () {
        total();
    });

    $(document).on("keyup", ".number", function () {
        total();
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
    $(document).on("click", ".btn-show-currency", function () {
        $("#modal-show-currcency").modal("show");
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
            url: "get-trade",
            data: function (p) {
                p.wintrade = $(".wintrade :selected").val();

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

                p.user = true;
            },
        },
        columns: [
            { data: "dateupdate", name: "dateupdate", render: datetime },

            {
                data: "namecurrency",
                name: "namecurrency",
                render: function (a, b, c) {
                    return (
                        images(c.logocurrency) +
                        "<span class='text-uppercase'>" +
                        c.namecurrency +
                        "</span>"
                    );
                },
            },

            {
                data: "tradetitle",
                name: "tradetitle",
                render: function (a, b, c) {
                    if (c.tradetitle == "buy less") {
                        return (
                            '<span class="badge badge-sm light badge-danger">' +
                            c.tradetitle +
                            "</span>"
                        );
                    }
                    return (
                        '<span class="badge badge-sm light badge-secondary">' +
                        c.tradetitle +
                        "</span>"
                    );
                },
            },

            {
                data: "timetrade",
                name: "timetrade",
                render: function (a, b, c) {
                    return "<span>" + c.timetrade + " s</span>";
                },
            },

            {
                data: "amount",
                name: "amount",
                render: function (a, b, c) {
                    let amount = parseFloat(c.amount).toLocaleString();
                    return (
                        "<p class='text-black font-weight-bold text-uppercase'>" +
                        amount +
                        " USTD" +
                        " </p> "
                    );
                },
            },

            {
                data: "totalamount",
                name: "totalamount",
                render: function (a, b, c) {
                    let amount = parseFloat(c.totalamount).toLocaleString();
                    return (
                        "<p class='text-black font-weight-bold text-uppercase'>" +
                        amount +
                        " USTD" +
                        " </p> "
                    );
                },
            },

            {
                data: "feepercent",
                name: "feepercent",
                render: function (a, b, c) {
                    let amount = parseFloat(c.feepercent).toLocaleString();
                    return (
                        "<span class='text-danger font-weight-bold'>" +
                        amount +
                        " %</span> "
                    );
                },
            },

            {
                data: "feeamount",
                name: "feeamount",
                render: function (a, b, c) {
                    let amount = parseFloat(c.feeamount).toLocaleString();
                    return (
                        "<span class='text-primary font-weight-bold text-uppercase'>" +
                        amount +
                        " USTD" +
                        " </span> "
                    );
                },
            },

            {
                data: "wintrade",
                name: "wintrade",
                render: function (a, b, c) {
                    if (c.wintrade === "win") {
                        return (
                            '<span class="badge badge-sm light badge-success">' +
                            c.wintrade +
                            "</span>"
                        );
                    }
                    return (
                        '<span class="badge badge-sm light badge-danger">' +
                        c.wintrade +
                        "</span>"
                    );
                },
            },

            {
                data: "lastprice",
                name: "lastprice",
                render: function (a, b, c) {
                    let amount = parseFloat(c.lastprice).toLocaleString();
                    return (
                        "<span class='text-danger font-weight-bold'>" +
                        amount +
                        "</span> "
                    );
                },
            },

            {
                data: "status",
                name: "status",
                render: function (a, b, c) {
                    return (
                        '<span class="badge badge-sm light badge-secondary">' +
                        c.status +
                        "</span>"
                    );
                },
            },
        ],
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
        let date = moment(options.dateupdate + " " + options.timeupdate);
        return date.format("YYYY-MM-DD HH:mm");
    }

    $(".my-date").datepicker({});

    $(document).on("change", ".my-date", function () {
        table.draw();
    });

    $(document).on("change", ".wintrade", function () {
        table.draw();
    });

    // image click handler
    $(document).on("click", ".img-click", function () {
        $("#modal-image").modal("show");
        $(".image-view-modal").attr("src", $(this).attr("src"));
    });

    // button filter
    $(document).on("click", ".btn-filter", function () {
        table.draw();
    });

    // button clear filter
    $(document).on("click", ".btn-remove-filter", function () {
        $("#start_date").val("");
        $("#end_date").val("");
        $(".wintrade").val("");
        table.draw();
    });
});

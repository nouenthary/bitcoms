$(function () {
    // key local
    let tabIndexKey = "tab_index";
    // set ajax request
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    // tab click
    $(document).on("click", ".main-tab", function () {
        let tabIndex = $(this).attr("data-value");
        $(".main-tab").removeClass("bg-light");
        $(this).addClass("bg-light");
        getTabIndex(tabIndex);
        setLocalStorage(tabIndexKey, tabIndex);
        setLocalStorage("id", "");
    });
    // tab list view index change
    function getTabIndex(index) {
        if (index == 1) {
            $(".list-withdraw").css("display", "none");
            $(".list-deposit").css("display", "none");
            $(".list-users").css("display", "block");
        }
        if (index == 2) {
            $(".list-users").css("display", "none");
            $(".list-deposit").css("display", "none");
            $(".list-withdraw").css("display", "block");
        }
        if (index == 3) {
            $(".list-users").css("display", "none");
            $(".list-withdraw").css("display", "none");
            $(".list-deposit").css("display", "block");
        }
    }
    // tab index key
    let tabIndex = getLocalStorage(tabIndexKey);
    getTabIndex(tabIndex);
    $(".main-tab").removeClass("bg-light");
    $(".main-tab")
        .eq(tabIndex - 1)
        .addClass("bg-light");
    // click status
    $(document).on("click", ".btn-status", function () {
        let status = $(this).text();
        $(".btn-status").removeClass("active");
        $(this).addClass("active");

        if (status == "All") {
            status = "";
        }
        $(".status").val(status);
        reloadTable();
        setLocalStorage('id', '');
    });
    // reload table
    function reloadTable() {
        let tabIndex = getLocalStorage(tabIndexKey);

        if (tabIndex == 1) {
            table.draw();
            getCountUserRegister();
        }
        //
        if (tabIndex == 2) {
            tableWithdraw.draw();
            getCountWithdraw();
        }
        //
        if (tabIndex == 3) {
            tableDeposit.draw();
            getCountDeposit();
        }
    }
    // filter //
    $(document).on("click", ".item-user", function () {
        $(".item-user").removeClass("bg-light");
        $(this).addClass("bg-light");
        $(".reference_code").val($(this).attr("code"));
        $(".userid").val($(this).attr("id"));
        reloadTable();
    });
    // click reference code
    $(document).on("click", ".btn-reference-code", function () {
        $(".userid").val("");
        reloadTable();
    });
    // get user seleted
    const getDataUser = function () {
        $.ajax({
            type: "get",
            url: "/users-select" + "?name=" + $(".get-users").val(),
            dataType: "json",
            success: function (response) {
                let data = response;

                if (response.length === 0) {
                    $(".dlab-scroll-user").removeClass("height370");
                }

                if (response.length > 0) {
                    $(".dlab-scroll-user").addClass("height370");
                }

                $(".f-count").text(response.length);

                // wallet
                $(".dlab-scroll-user").empty();
                $.each(data, function (key, value) {
                    //
                    let $element = $(".item-user:first").clone(true);

                    $element.attr("id", value.id);

                    $element.attr("code", value.code);

                    $element.find(".f-name").text(value.name);

                    $element.find(".f-code").text(value.code);

                    $element.find(".f-image").attr("src", value.image);

                    $(".dlab-scroll-user").append($element);
                });
            },
            error: function (data) {
                console.log(data);
            },
        });
    };
    // handle search user
    $(document).on("keyup", ".get-users", function () {
        getDataUser();
    });
    // on focus
    $(document).on("focus", ".get-users", function () {
        $(".dlab-scroll-user").addClass("height370");
        getDataUser();
    });
    // click clear user
    $(document).on("click", ".btn-clear", function () {
        $(".dlab-scroll-user").empty();
        $(".dlab-scroll-user").removeClass("height370");
        $(".f-count").text(0);
        $(".userid").val("");
        $(".reference_code").val("");
        $(".status").val("");
        reloadTable();
    });
    // filter //

    //
    const getCountUserRegister = function () {
        $.ajax({
            type: "get",
            url: "/count-user-confirmations?status=" + $(".status").val(),
            dataType: "json",
            success: function (response) {
                $(".user-count").text(parseFloat(response).toLocaleString());
            },
            error: function (data) {
                console.log(data);
            },
        });
    };

    //
    const getCountWithdraw = function () {
        $.ajax({
            type: "get",
            url: "/count-withdraw-confirmations",
            dataType: "json",
            success: function (response) {
                $(".withdraw-count").text(
                    parseFloat(response).toLocaleString()
                );
            },
            error: function (data) {
                console.log(data);
            },
        });
    };
    //
    const getCountDeposit = function () {
        $.ajax({
            type: "get",
            url: "/count-deposit-confirmations",
            dataType: "json",
            success: function (response) {
                $(".deposit-count").text(parseFloat(response).toLocaleString());
            },
            error: function (data) {
                console.log(data);
            },
        });
    };
    //
    function loadViewCount() {
        getCountUserRegister();
        getCountWithdraw();
        getCountDeposit();
    }
    //
    loadViewCount();
    //
    setInterval(function () {
        loadViewCount();
    }, 50000);

    //
    function getLocalStorage(key) {
        return localStorage.getItem(key);
    }

    //
    function setLocalStorage(key, value) {
        localStorage.setItem(key, value);
    }

    // datatable
    let table = $(".table-users").DataTable({
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
            url: "get-user-confirmations",
            data: function (p) {
                p.userid = $(".userid").val();
                p.status = $(".status").val();
                p.reference_code = $(".reference_code").val();
                p.id = getLocalStorage("id");
            },
        },
        columns: [
            {
                data: "id",
                name: "id",
                render: function (a, b, c) {
                    if (c.uderconfirmid == null) {
                        let json = JSON.stringify(c);
                        return (
                            `<button class='btn btn-primary btn-xs btn-review' data-json='` +
                            json +
                            `'>Review</button> `
                        );
                    }
                    return "";
                },
            },
            {
                data: "dateupdate",
                name: "dateupdate",
                render: datetime,
            },
            {
                data: "name",
                name: "name",
                render: function (a, b, c) {
                    return (
                        images(c.image) +
                        "<span class='text-uppercases'>" +
                        c.name +
                        "</span>"
                    );
                },
            },

            {
                data: "sex",
                name: "sex",
            },

            {
                data: "email",
                name: "email",
            },

            {
                data: "phone",
                name: "phone",
            },

            {
                data: "status",
                name: "status",
                render: function (a, b, c) {
                    if (c.status === "review") {
                        return (
                            `<div class="badge badge-sm badge-primary">` +
                            c.status +
                            `</div>`
                        );
                    }

                    if (c.status === "cancel") {
                        return (
                            `<div class="badge badge-sm badge-danger">` +
                            c.status +
                            `</div>`
                        );
                    }

                    return (
                        `<div class="badge badge-sm badge-success">` +
                        c.status +
                        `</div>`
                    );
                },
            },

            {
                data: "user_confirm",
                name: "user_confirm",
                render: function (a, b, c) {
                    if (c.uderconfirmid == null || c.uderconfirmid == "") {
                        return "";
                    }
                    return (
                        images(c.image_confirm) +
                        "<span class='text-uppercases'>" +
                        c.user_confirm +
                        "</span>"
                    );
                },
            },

            {
                data: "confirmdate",
                name: "confirmdate",
                render: datetimes,
            },
        ],
    });

    function images(src) {
        return (
            `
            <img class="rounded-circle img-click" width="30px" height="30px" src="` +
            src +
            `" alt="" onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbqIQzxuWNieQfyP_k7MgZScr2H2RrDlHZX0nlhh2B5sxPunjMOtMOvyLtcKz5heABjts&usqp=CAU';">
        `
        );
    }

    function datetime(src, records, options) {
        if (options.dateupdate == null) {
            return "";
        }
        let date = moment(options.dateupdate + " " + options.timeupdate);
        return date.format("YYYY-MM-DD HH:mm");
    }

    function datetimes(src, records, options) {
        if (options.confirmdate == null) {
            return "";
        }
        let date = moment(options.confirmdate + " " + options.confirmtime);
        return date.format("YYYY-MM-DD HH:mm");
    }

    //
    $(document).on("click", ".btn-review", function () {
        $("#modal-create").modal("show");
        let data = JSON.parse($(this).attr("data-json"));
        $(".d-name").text(data.name);
        $(".d-email").text(data.email);
        $(".d-date").text(data.dateupdate + " " + data.timeupdate);
        $(".d-phone").text(data.phone);
        $(".d-address").text(
            data.address + " " + data.city + " " + data.country
        );
        $(".d-image-front").attr("src", data.frontimage);
        $(".d-image-back").attr("src", data.backimage);

        $(".d-image").attr("src", data.image);
        $(".btn-approve").attr("id", data.id);
        $(".btn-cancel").attr("id", data.id);
    });
    //
    $(document).on("click", ".btn-approve", function (e) {
        e.preventDefault();
        let id = $(this).attr("id");
        postDatatToApi(id, "done", "/post-user-confirmation");
    });
    //
    $(document).on("click", ".btn-cancel", function (e) {
        e.preventDefault();
        let id = $(this).attr("id");
        postDatatToApi(id, "document", "/post-user-confirmation");
    });
    // post data
    function postDatatToApi(id, status, url) {
        var data = new FormData();
        data.append("id", id);
        data.append("status", status);

        $(".btn-approve").attr("disabled", "");
        $(".btn-cancel").attr("disabled", "");

        $(".btn-confirm-deposit").attr("disabled", "");
        $(".btn-reject-deposit").attr("disabled", "");

        $(".btn-confirm-withdraw").attr("disabled", "");
        $(".btn-reject-withdraw").attr("disabled", "");
        $.ajax({
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: "POST",
            success: function (data) {
                $("#modal-create").modal("hide");
                $(".btn-approve").removeAttr("disabled");
                $(".btn-cancel").removeAttr("disabled");
                // table.draw();
                //
                $("#modal-deposit").modal("hide");
                $(".btn-confirm-deposit").removeAttr("disabled", "");
                $(".btn-reject-deposit").removeAttr("disabled", "");
                //tableDeposit.draw();
                //
                $("#modal-withdraw").modal("hide");
                $(".btn-confirm-withdraw").removeAttr("disabled", "");
                $(".btn-reject-withdraw").removeAttr("disabled", "");
                //tableWithdraw.draw();
                //
                alertSuccess(data.message);
                setLocalStorage("id", "");
                loadViewCount();
                reloadTable();
                removeNotifications();
            },
            error: function (xhr) {
                let data = JSON.parse(xhr.responseText);

                let { message } = data;

                alertError(message);
                $(".btn-approve").removeAttr("disabled");
                $(".btn-confirm-deposit").removeAttr("disabled", "");
                $(".btn-confirm-withdraw").removeAttr("disabled", "");
                $(".btn-cancel").removeAttr("disabled");
                $(".btn-reject-deposit").removeAttr("disabled", "");
                $(".btn-reject-withdraw").removeAttr("disabled", "");
            },
        });
    }
    //
    function removeNotifications() {
        let index = getLocalStorage("index");
        $(".list-alert").eq(index).remove();
        setLocalStorage("index", "");
        $(".my-bagge").text($(".list-alert").length);
    }
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

    //
    function percentage(val) {
        return "<span class='text-success'>" + val + "%</span> ";
    }

    // withdraw----------------------------------------------------------------
    let tableWithdraw = $(".table-withdraw").DataTable({
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
            url: "/get-withdraw-confirmations",
            data: function (p) {
                p.userid = $(".userid").val();
                p.status = $(".status").val();
                p.reference_code = $(".reference_code").val();
                p.id = getLocalStorage("id");
            },
        },
        columns: [
            {
                data: "id",
                name: "id",
                render: function (a, b, c) {
                    if (c.confirmuserid == null) {
                        let json = JSON.stringify(c);
                        return (
                            `<button class='btn btn-primary btn-xs btn-withdraw' data-json='` +
                            json +
                            `'>Confirm</button> `
                        );
                    }
                    return "";
                },
            },
            {
                data: "dateupdate",
                name: "dateupdate",
                render: function (a, b, c) {
                    if (c.createdate == null) {
                        return "";
                    }
                    let date = moment(c.createdate + " " + c.createtime);
                    return date.format("YYYY-MM-DD HH:mm");
                },
            },
            {
                data: "name",
                name: "name",
                render: function (a, b, c) {
                    return (
                        images(c.image) +
                        "<span class='text-uppercases'>" +
                        c.name +
                        "</span>"
                    );
                },
            },
            {
                data: "imagecurency",
                name: "imagecurency",
                render: function (a, b, c) {
                    if (c.fkwalletid == null) {
                        return `
                            <a class="market-title d-flex align-items-center" href="javascript:void(0);">
                            <div class="market-icon">
                            <img class="rounded-circle img-click" width="30px" height="30px" src="https://static.vecteezy.com/system/resources/previews/006/059/910/original/dollar-icon-american-currency-symbol-illustration-usd-coin-free-vector.jpg" alt="wallet-title">
                            </div>
                            <h5 class="mb-0 ms-2 text-uppercase">USTD</h5>
                            <span class="text-muted ms-2">Default</span>
                        </a>
                       `;
                    }
                    return (
                        `
                        <a class="market-title d-flex align-items-center" href="javascript:void(0);">
                        <div class="market-icon">
                        <img class="rounded-circle img-click" width="30px" height="30px" src="` +
                        c.imagecurency +
                        `" alt="wallet-title">
                        </div>
                        <h5 class="mb-0 ms-2 text-uppercase">` +
                        c.namecurency +
                        `</h5>
                        <span class="text-muted ms-2">` +
                        c.namecurencywallet +
                        `</span>
                        </a>
                        `
                    );
                },
            },
            {
                data: "balance",
                name: "balance",
                render: function (a, b, c) {
                    return a + " USDT";
                },
            },
            {
                data: "totalamount",
                name: "totalamount",
                render: function (a, b, c) {
                    return a + " USDT";
                },
            },
            { data: "fee", name: "fee", render: percentage },
            {
                data: "feeamount",
                name: "feeamount",
                render: function (a, b, c) {
                    return a + " USDT";
                },
            },
            {
                data: "codelink",
                name: "codelink",
                render: function (a, b, c) {
                    return (
                        `
                        <a class="market-title d-flex align-items-center" href="javascript:void(0);">
                        <div class="market-icon">
                        <img style="border-radius: 5px" class="rounded-circless img-click" width="30px" height="30px" src="` +
                        c.codelink +
                        `" alt="wallet-title">
                        </div>

                        `
                    );
                },
            },
            {
                data: "status",
                name: "status",
                render: function (a, b, c) {
                    if (c.status === "pending") {
                        return (
                            `<div class="badge badge-sm badge-primary">` +
                            c.status +
                            `</div>`
                        );
                    }

                    if (c.status === "reject") {
                        return (
                            `<div class="badge badge-sm badge-danger">` +
                            c.status +
                            `</div>`
                        );
                    }

                    return (
                        `<div class="badge badge-sm badge-success">` +
                        c.status +
                        `</div>`
                    );
                },
            },
            {
                data: "user_confirm",
                name: "user_confirm",
                render: function (a, b, c) {
                    if (c.userconfirmid == null || c.userconfirmid == "") {
                        return "";
                    }
                    return (
                        images(c.image_confirm) +
                        "<span class='text-uppercases'>" +
                        c.user_confirm +
                        "</span>"
                    );
                },
            },
            {
                data: "confirmdate",
                name: "confirmdate",
                render: function (a, b, c) {
                    if (c.confirmuserid == null) {
                        return "";
                    }
                    let date = moment(c.confirmdate + " " + c.confirmtime);
                    return date.format("YYYY-MM-DD HH:mm");
                },
            },
        ],
    });

    $(document).on("click", ".btn-withdraw", function () {
        $("#modal-withdraw").modal("show");
        let data = JSON.parse($(this).attr("data-json"));

        $(".w-name").text(data.name);

        $(".w-currcency").text("USDT");
        if (data.fkwalletid != null) {
            $(".w-currcency").text(data.namecurencywallet);
        }

        $(".w-amount").text(data.balance + " USDT".toUpperCase());
        if (data.fkwalletid != null) {
            $(".w-amount").text(
                data.balance + " " + data.namecurency.toUpperCase()
            );
        }

        $(".w-wallet-address").val(data.codeaddress);

        $(".w-image").attr("src", data.image);
        $(".w-logo").attr(
            "src",
            "https://static.vecteezy.com/system/resources/previews/006/059/910/original/dollar-icon-american-currency-symbol-illustration-usd-coin-free-vector.jpg"
        );
        if (data.fkwalletid != null) {
            $(".w-logo").attr("src", data.imagecurency);
        }
        $(".w-qr-code").attr("src", data.codelink);

        $(".btn-confirm-withdraw").attr("id", data.withdrawid);
        $(".btn-reject-withdraw").attr("id", data.withdrawid);
    });
    //
    $(document).on("click", ".btn-confirm-withdraw", function (e) {
        e.preventDefault();
        let id = $(this).attr("id");
        postDatatToApi(id, "done", "/post-withdraw-confirmations");
    });
    //
    $(document).on("click", ".btn-reject-withdraw", function (e) {
        e.preventDefault();
        let id = $(this).attr("id");
        postDatatToApi(id, "reject", "/post-withdraw-confirmations");
    });

    //
    function alertSuccess(message = "Created successfully") {
        Swal.fire({
            position: "top-end",
            title: message,
            text: "You need to pay extra amount",
            icon: "success",
            showConfirmButton: false,
            timer: 3000,
        });
    }

    //
    function alertError(message = "Something went wrong!") {
        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Oops...",
            text: message,
        });
    }

    // withdraw----------------------------------------------------------------

    // deposit----------------------------------------------------------------
    let tableDeposit = $(".table-deposit").DataTable({
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
            url: "/get-deposit-confirmations",
            data: function (p) {
                p.userid = $(".userid").val();
                p.status = $(".status").val().toString().toLowerCase();
                p.reference_code = $(".reference_code").val();
                p.id = getLocalStorage("id");
            },
        },
        columns: [
            {
                data: "id",
                name: "id",
                render: function (a, b, c) {
                    if (c.userconfirmid == null) {
                        let json = JSON.stringify(c);
                        return (
                            `<button class='btn btn-primary btn-xs btn-deposit' data-json='` +
                            json +
                            `'>Confirm</button> `
                        );
                    }
                    return "";
                },
            },
            {
                data: "dateupdate",
                name: "dateupdate",
                render: datetime,
            },
            {
                data: "name",
                name: "name",
                render: function (a, b, c) {
                    return (
                        images(c.image) +
                        "<span class='text-uppercases'>" +
                        c.name +
                        "</span>"
                    );
                },
            },

            {
                data: "namecurencywallet",
                name: "namecurencywallet",
                render: function (a, b, c) {
                    return (
                        `
                  <a class="market-title d-flex align-items-center" href="javascript:void(0);">
                  <div class="market-icon">
                  <img class="rounded-circle img-click" width="30px" height="30px" src="` +
                        c.imagecurency +
                        `" alt="wallet-title">
                  </div>
                  <h5 class="mb-0 ms-2 text-uppercase">` +
                        c.namecurency +
                        `</h5>
                  <span class="text-muted ms-2">` +
                        c.namecurencywallet +
                        `</span>
                </a>
                  `
                    );
                },
            },

            {
                data: "status",
                name: "status",
                render: function (a, b, c) {
                    if (c.status === "pending") {
                        return (
                            `<div class="badge badge-sm badge-primary">` +
                            c.status +
                            `</div>`
                        );
                    }

                    if (c.status === "reject") {
                        return (
                            `<div class="badge badge-sm badge-danger">` +
                            c.status +
                            `</div>`
                        );
                    }

                    return (
                        `<div class="badge badge-sm badge-success">` +
                        c.status +
                        `</div>`
                    );
                },
            },

            {
                data: "amout",
                name: "amout",
                render: function (a, b, c) {
                    let amount = parseFloat(c.amout).toLocaleString();
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
                    return (
                        `
                        <a class="market-title d-flex align-items-center" href="javascript:void(0);">
                        <div class="market-icon">
                        <img style="border-radius: 5px" class="rounded-circless img-click" width="30px" height="30px" src="` +
                        c.paymentvoucher +
                        `" alt="wallet-title">
                        </div>
                    
                        `
                    );
                },
            },
            {
                data: "qrimage",
                name: "qrimage",
                render: function (a, b, c) {
                    return (
                        `
                        <a class="market-title d-flex align-items-center" href="javascript:void(0);">
                        <div class="market-icon">
                        <img style="border-radius: 5px" class="rounded-circless img-click" width="30px" height="30px" src="` +
                        c.qrimage +
                        `" alt="wallet-title">
                        </div>
                    
                        `
                    );
                },
            },

            {
                data: "user_confirm",
                name: "user_confirm",
                render: function (a, b, c) {
                    if (c.userconfirmid == null || c.userconfirmid == "") {
                        return "";
                    }
                    return (
                        images(c.image_confirm) +
                        "<span class='text-uppercases'>" +
                        c.user_confirm +
                        "</span>"
                    );
                },
            },

            {
                data: "confirmdate",
                name: "confirmdate",
                render: datetimes,
            },
        ],
    });
    //
    $(document).on("click", ".btn-deposit", function () {
        $("#modal-deposit").modal("show");
        let data = JSON.parse($(this).attr("data-json"));

        $(".dd-name").text(data.name);
        $(".dd-currcency").text(data.namecurencywallet);
        $(".dd-amount").text(data.amout + " " + data.namecurency.toUpperCase());
        $(".dd-wallet-address").val(data.walletaddr);

        $(".dd-image").attr("src", data.image);
        $(".dd-logo").attr("src", data.imagecurency);
        $(".dd-qr-code").attr("src", data.qrimage);
        $(".dd-voucher").attr("src", data.paymentvoucher);

        $(".btn-confirm-deposit").attr("id", data.depositid);
        $(".btn-reject-deposit").attr("id", data.depositid);
    });
    //
    $(document).on("click", ".btn-confirm-deposit", function (e) {
        e.preventDefault();
        let id = $(this).attr("id");
        postDatatToApi(id, "done", "/post-deposit-confirmation");
    });
    //
    $(document).on("click", ".btn-reject-deposit", function (e) {
        e.preventDefault();
        let id = $(this).attr("id");
        postDatatToApi(id, "reject", "/post-deposit-confirmation");
    });
    //
    $(document).on("click", ".fa-copy", function () {
        var range = document.createRange();
        range.selectNode(document.querySelector(".dd-wallet-address"));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();
        successMessage("data copied", "");
    });

    // deposit----------------------------------------------------------------

    // image click handler
    $(document).on("click", ".img-click", function () {
        $("#modal-image").modal("show");
        $(".image-view-modal").attr("src", $(this).attr("src"));
    });
});

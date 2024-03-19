$(function () {
    // set update ajax
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(".my-date").datepicker({ defaultDate: null });

    $(document).on("change", ".my-date", function () {
        table.draw();
        tableWallet.draw();
    });

    $(document).on("change", ".fkwalletid", function () {
        table.draw();
        tableWallet.draw();
    });

    // base url api
    let baseUrl = "/withdrawals";

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
            url: baseUrl,
            data: function (p) {
                p.status = $("#p_status").val();
                p.wallet = $("#p_wallet").val();
                p.walletid = $(".fkwalletid").val();

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
        order: [[2, "desc"]],
        columns: [
            // { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "createdate", name: "createdate", render: datetime },
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
            { data: "codeaddress", name: "codeaddress", render: address },
            { data: "codelink", name: "codelink", render: images },
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
        ],
    });

    $(document).on("click", ".nav-item", function () {
        let status = $(this).attr("data-status");
        $("#p_status").val(status);
        table.draw();

        $(".nav-item").removeClass("active");
        $(this).addClass("active");

        tableWallet.draw();
    });

    function percentage(val) {
        return "<span class='text-success'>" + val + "%</span> ";
    }

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
        let date = moment(options.createtime + " " + options.createdate);
        return date.format("YYYY-MM-DD HH:mm");
    }

    function nameWallet(src, records, options) {
        return (
            `
            <div>
                <h5 class="mb-0 ms-2 text-uppercase text- font-weight-bold">` +
            options.namecurency +
            `</h5>
                <span class="text-muted ms-2">` +
            options.namecurencywallet +
            `</span>
            </div>
        `
        );
    }

    function address(src, records, options) {
        let text = "";
        if (options.walletaddress !== undefined) {
            text = options.walletaddress.substring(0, 10) + " ...";
        }
        return text;
    }

    function status(src, records, options) {
        if (options.status == "pending") {
            return `<span class="badge badge-warning badge-sm badge-sm">Pending<span class="ms-1 fas fa-stream"></span></span>`;
        }
        return `<span class="badge badge-success badge-sm">Done<span class="ms-1 fa fa-check"></span></span>`;
    }

    // image click handler
    $(document).on("click", ".img-click", function () {
        $("#modal-image").modal("show");
        $(".image-view-modal").attr("src", $(this).attr("src"));
    });

    // my wallet
    let tableWallet = $("#table-history-wallet").DataTable({
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
            url: baseUrl + "-wallet",
            data: function (p) {
                p.status = $("#p_status").val();
                p.wallet = $("#p_wallet").val();
                p.walletid = $(".fkwalletid").val();

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
        order: [[2, "desc"]],
        columns: [
            { data: "createdate", name: "createdate", render: datetime },
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
                data: "codeaddress",
                name: "codeaddress",
                render: function (a, b, c) {
                    return a + " ";
                },
            },
            { data: "codelink", name: "codelink", render: images },
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
        ],
    });
});

$(function () {
    // datatable
    let table = $("#table-history-a1").DataTable({
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
                p.userid = $("#fkuserid").val();
                p.referrercode = $("#referrercode").val();

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

            // {
            //     data: "status",
            //     name: "status",
            //     render: function (a, b, c) {
            //         return (
            //             '<span class="badge badge-sm light badge-secondary">' +
            //             c.status +
            //             "</span>"
            //         );
            //     },
            // },
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
            `" alt="" onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbqIQzxuWNieQfyP_k7MgZScr2H2RrDlHZX0nlhh2B5sxPunjMOtMOvyLtcKz5heABjts&usqp=CAU';">
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

    //
    // filter //
    $(document).on("click", ".item-user", function () {
        $(".item-user").removeClass("bg-light");
        $(this).addClass("bg-light");
        $("#fkuserid").val($(this).attr("id"));
        $("#referrercode").val($(this).attr("code"));
        table.draw();
    });

    //

    $(document).on("click", ".btn-reference-code", function () {
        $("#fkuserid").val("");
        table.draw();
    });

    //
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
    //
    $(document).on("keyup", ".get-users", function () {
        getDataUser();
    });
    //
    $(document).on("focus", ".get-users", function () {
        $(".dlab-scroll-user").addClass("height370");
        getDataUser();
    });
    //
    $(document).on("click", ".btn-clear", function () {
        $(".dlab-scroll-user").empty();
        $(".dlab-scroll-user").removeClass("height370");
        $(".f-count").text(0);
        $("#fkuserid").val("");
        $("#referrercode").val("");
        table.draw();
    });
    // filter //
});

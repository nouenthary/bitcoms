$(function () {
    // set update ajax
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // base url api
    let baseUrl = "/wallet-title";

    // datatable
    let table = $("#data-table-view").DataTable({
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
        ajax: baseUrl,
        columns: [
            { data: "timeupdate", name: "timeupdate", render: datetime },
           
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
            { data: "walletaddress", name: "walletaddress", render: address },
            { data: "qrimage", name: "qrimage", render: image },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
                render: action,
            },
        ],
    });

    // image
    function image(src) {
        return (
            `
            <img class="rounded-circles img-click" width="30px" height="30px" src="` +
            src +
            `" alt="wallet-title">
        `
        );
    }

    function datetime(src, records, options) {
        let date = moment(options.timeupdate + " " + options.dateupdate);
        return date.format("YYYY-MM-DD HH:mm");
    }

    function address(src, records, options) {
        let text = options.walletaddress.substring(0, 10) + " ...";
        return options.walletaddress;
    }

    // image click handler
    $(document).on("click", ".img-click", function () {
        $("#modal-image").modal("show");
        $(".image-view-modal").attr("src", $(this).attr("src"));
    });

    // action buttons
    function action(id) {
        return (
            `
             <div class="d-flex">
                <a class="btn btn-primary shadow btn-xs sharp me-1" data-id="` +
            id +
            `" id="btn-update-modal">
                    <i class="fas fa-pencil-alt"></i>
                </a>
             </div>
        `
        );
    }

    // update handle click
    $(document).on("click", "#btn-update-modal", function () {
        $("#exampleModal").modal("show");

        $("#btn-create").text("Submit");
        $("#form-title").text("Update Wallet Title");

        $("#walletid").val($(this).attr("data-id"));

        $.ajax({
            type: "get",
            url: baseUrl + "/" + $(this).attr("data-id"),
            success: function (response) {
                let {
                    walletid,
                    imagecurency,
                    namecurency,
                    namecurencywallet,
                    walletaddress,
                    qrimage,
                } = response.data;

                $("#walletid").val(walletid);

                $("#namecurency").val(namecurency);

                $("#walletaddress").val(walletaddress);

                $("#image-view-qr").attr("src", "/" + qrimage);

                $("#imagecurency").val(imagecurency);

                $("#namecurencywallet").val(namecurencywallet);

                currency = namecurency;

                getWalletFromStorage();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            },
        });
    });

    // handle delete
    $(document).on("click", "#btn-delete-modal", function () {
        $("#modal-delete").modal("show");
        $("#btn-delete-confirm").attr("data-id", $(this).attr("data-id"));
    });

    // handle confirmation delete
    $(document).on("click", "#btn-delete-confirm", function () {
        var data = new FormData();

        data.append("walletid", $(this).attr("data-id"));

        $.ajax({
            url: baseUrl + "/delete",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: "POST",
            type: "POST",
            success: function (data) {
                $("#modal-delete").modal("hide");

                table.ajax.reload();

                success(data.message, "");
            },
            error: function (xhr) {
                let data = JSON.parse(xhr.responseText);

                alert(data);
            },
        });
    });

    //update load preview currency qr code
    $("#qrimage").change(function () {
        readURLs(this);
    });

    // handle click
    function readURLs(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#image-view-qr").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // handle change name currency
    $(document).on("change", "#namecurencywallet", function () {
        let value = $(this).find(":selected").attr("key");
        $("#namecurency").val(value);
        let image = $(this).find(":selected").attr("image");
        $("#imagecurency").val(image);
        $("#image-view").attr("src", image);
    });

    // loading api botcoin
    const getData = function () {
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
    getData();

    let currency = "";

    function getWalletFromStorage() {
        let data = JSON.parse(localStorage.getItem("wallets"));

        let wallet = $(".w-searching").val();

        let dataSource = data;

        if (wallet.length > 0) {
            dataSource = data.filter((t) => t.name.toLowerCase().match(wallet));
        }

        let wallets = [];
        $(".contacts-list").empty();
        $.each(dataSource.slice(0, 300), function (key, value) {
            let $element = $(".card-wallet").clone();
            $element.find(".w-name").text(value.name);
            $element.find(".w-currency").text(value.symbol);
            $element.find(".w-image").attr("src", value.image);
            if (value.symbol === currency) {
                $element.addClass("bg-light");
            }
            wallets.push($element);
        });
        $(".contacts-list").append(wallets);
    }

    getWalletFromStorage();

    //
    $(document).on("keyup", ".w-searching", function () {
        getWalletFromStorage();
    });

    //
    $(document).on("click", ".card-wallet", function () {
        let $element = $(this).closest("div");
        let imagecurency = $element.find(".w-image").attr("src");
        let namecurencywallet = $element.find(".w-name").text();
        let namecurency = $element.find(".w-currency").text();

        $("#imagecurency").val(imagecurency);
        $("#namecurencywallet").val(namecurencywallet);
        $("#namecurency").val(namecurency);

        $(".card-wallet").removeClass("bg-light");
        currency = namecurency;
        $(this).addClass("bg-light");
    });

    // open form create
    $(document).on("click", "#btn-open-form-create", function () {
        $("#exampleModal").modal("show");

        $("#btn-create").text("Submit");

        $("#form-title").text("Add Wallet Title");

        $("#form-create").get(0).reset();

        $("#walletid").val(0);

        $("#image-view-qr").attr(
            "src",
            "https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg"
        );

        currency = "";

        getWalletFromStorage();
    });

    // open form update
    $(document).on("click", "#btn-open-form-update", function () {
        $("#exampleModal").modal("show");
    });

    // handle create or update
    $(document).on("click", "#btn-create", function (e) {
        e.preventDefault();

        let walletid = $("#walletid").val();
        let imagecurency = $("#imagecurency").val();
        let namecurencywallet = $("#namecurencywallet").val();
        let namecurency = $("#namecurency").val();
        let walletaddress = $("#walletaddress").val();
        let qrimage = $("#qrimage").val();

        if (walletid === "") {
            error("Please choose wallet ...", "");
            return;
        }

        if (imagecurency === "") {
            error("Please choose wallet ...", "");
            return;
        }

        if (namecurencywallet === "") {
            error("Please choose wallet ...", "");
            return;
        }

        if (namecurency === "") {
            error("Please choose wallet ...", "");
            return;
        }

        if (walletaddress === "") {
            $(".needs-validation").addClass("was-validated");
            error("Please choose wallet ...", "");
            return;
        }

        if (qrimage === "" && walletid === 0) {
            $(".needs-validation").addClass("was-validated");
            error("Please choose qr image ...", "");
            return;
        }

        var data = new FormData(jQuery("form")[0]);

        jQuery.each(jQuery("#qrimage")[0].files, function (i, file) {
            data.append("file[]", file);
        });

        $("#btn-create").attr("disabled", "");

        let method = "POST";

        $.ajax({
            url: walletid > 0 ? baseUrl + "/update" : baseUrl,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: method,
            success: function (data) {
                $("#exampleModal").modal("hide");

                $("#form-create").get(0).reset();

                table.ajax.reload();

                $("#btn-create").removeAttr("disabled");

                success(data.message, "");

                currency = "";
            },
            error: function (xhr) {
                let data = JSON.parse(xhr.responseText);

                let { message, status } = data;

                if (status === false) {
                    for (let row in message) {
                        error(message[row][0], "");
                    }
                }
                $("#btn-create").removeAttr("disabled");
            },
        });
    });

    //
    $(document).on("click", ".fa-copy", function () {
        var range = document.createRange();
        range.selectNode(document.querySelector("#walletaddress")); //changed here
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();

        toastr.success("data copied", "", {
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
    });

    //
    function success(text, options = "Welcome new title") {
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
    function error(text, options = "Welcome new title") {
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

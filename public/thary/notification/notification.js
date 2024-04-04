$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // card alert
    function cardAlert(item) {
        let {index, id, type, image, date, name} = item;
        return (
            '<li class="list-alert" style="cursor: pointer;" data-id="' + id + '" data-index="' + index + '" data-type="' + type + '" >' +
            '<div class="timeline-panel">' +
            '<div class="media me-2">' +
            '<img alt="image" class="l-image" width="50" src="' + image + '">' +
            '</div>' +
            '<div class="media-body">' +
            '<h6 class="mb-1 l-name">' + name + '</h6>' +
            '<small class="d-block l-date">' + date + '</small>' +
            '</div>' +
            '</div>' +
            '</li>'
        );
    }

    // loading api botcoin
    const getData = function () {
        let url = "/notifications";
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                if (response.length === 0) {
                    $(".main-list-alert").empty();
                }

                if (response.length > 0) {
                    let data = response[0].sort(function (a, b) {
                        return (
                            new Date(b.date + " " + b.time) -
                            new Date(a.date + " " + a.time)
                        );
                    });

                    $(".main-list-alert").empty();
                    $.each(data, function (key, value) {
                        // let $element = $(".list-alert:first").clone(true);
                        // $element.attr("data-id", value.id);
                        // $element.attr("data-type", value.type);
                        // $element.attr("data-index", key);
                        // $element
                        //     .find(".l-name")
                        //     .text(value.name + " was added " + value.type);
                        // $element.find(".l-image").attr("src", value.image);
                        let date = moment(value.date + " " + value.time).format(
                            "DD MMMM YYYY - HH:mm A"
                        );
                        //$element.find(".l-date").text(date);
                        //$(".main-list-alert").append($element);

                        let item = {
                            index: key,
                            id: value.id,
                            type: value.type,
                            image: value.image,
                            date: date,
                            name: value.name + " was added " + value.type
                        };

                        $(".main-list-alert").append(cardAlert(item));

                    });
                    //$(".list-alert:first").remove();
                    $(".my-bagge").text(data.length);
                }
            },
            error: function (xhr) {
                console.log(JSON.stringify(xhr.responseText));
            },
        });
    };
    // call
    getData();
    setInterval(function () {
        getData();
    }, 10000);

    // link by alert
    $(document).on("click", ".list-alert", function () {
        let id = $(this).attr("data-id");
        let type = $(this).attr("data-type");
        let index = $(this).attr("data-index");
        let tabIndex = 0;
        if (type === "Register") {
            tabIndex = 1;
        } else if (type === "Withdraw") {
            tabIndex = 2;
        } else {
            tabIndex = 3;
        }
        localStorage.setItem("id", id);
        localStorage.setItem("tab_index", tabIndex);
        localStorage.setItem("index", index);
        location.href = "/main-confirmation";
    });

    // error image src
    let src = "https://z-p3-scontent.fpnh5-4.fna.fbcdn.net/v/t39.30808-1/305269291_207815158260505_7760767745558482299_n.png?_nc_cat=110&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeGSOMOIHopK-sA8KO7Ed9FWLbdGNu7_5jktt0Y27v_mOTDla7s48YMTIS2hoDRxSs9164-d64q6M7OW8H21X24A&_nc_ohc=MPvi3SWpbfEAX-wfS6p&_nc_ht=z-p3-scontent.fpnh5-4.fna&oh=00_AfDx-iU0ERWg_JGv1d7qSDkW9r_M-OPK0Lm7AsnsG5FPpw&oe=660FFCE8";
    $("img").on("error", function () {
        $(this).attr("src", src);
    });

});

$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

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

                    $.each(data, function (key, value) {
                        let $element = $(".list-alert:first").clone(true);

                        $element.attr("data-id", value.id);
                        $element.attr("data-type", value.type);
                        $element.attr("data-index", key);

                        $element
                            .find(".l-name")
                            .text(value.name + " was added " + value.type);

                        $element.find(".l-image").attr("src", value.image);

                        let date = moment(value.date + " " + value.time).format(
                            "DD MMMM YYYY - HH:mm A"
                        );

                        $element.find(".l-date").text(date);

                        $(".main-list-alert").append($element);
                    });
                    $(".list-alert:first").remove();
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
    // setInterval(function () {
    //     getData();
    // }, 5000);

    //
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
});

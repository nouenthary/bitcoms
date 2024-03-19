function chartTheme() {
    if ($("body").attr("data-theme-version") == "light") {
        return "Light";
    } else {
        return "Dark";
    }
}

//alert(11);

function tradingfuture() {
    let widget = new TradingView.widget({
        width: "100%",
        height: 516,
        symbol: "BITSTAMP:BTCUSD",
        interval: "D",
        timezone: "Etc/UTC",
        theme: chartTheme(),
        style: "1",
        locale: "en",
        toolbar_bg: "#f1f3f6",
        enable_publishing: false,
        withdateranges: true,
        hide_side_toolbar: true,
        hide_top_toolbar: true,
        hide_side_toolbar: false,
        hide_top_toolbar: false,
        // allow_symbol_change: true,
        show_popup_button: true,
        popup_width: "1000",
        popup_height: "650",
        container_id: "tradingview_85dc0",
        header_widget_buttons_mode: "fullsize",
        //symbol: "AAPL",
        //disabled_features: ["header_widget", "left_toolbar"],

        // subscribe(callback, options) {
        //     alert();
        //     console.log(callback);
        //     console.log(options);
        // },

        // symbol_search_complete: (symbol, searchResultItem) => {
        //     alert();
        //     return new Promise((resolve) => {
        //         alert();
        //         let symbol = getNewSymbol(symbol, searchResultItem);
        //         let name = getHumanFriendlyName(symbol, searchResultItem);
        //         resolve({ symbol: symbol, name: name });
        //     });
        // },
    });

    // widget.options.watchlist = [
    //     function (options) {
    //         console.log("tahry");
    //
    //         return "thary";
    //     },
    // ];

    //  console.log(widget);

    // widget._ready_handlers(function () {
    //     console.log(widget);
    // });
}

//window.addEventListener("DOMContentLoaded", tradingfuture, false);

// let element = document.querySelector("body");
// let observer = new MutationObserver(function (mutations) {
//     mutations.forEach(function (mutation) {
//         if (mutation.attributeName === "data-theme-version") {
//             setTimeout(function () {
// tradingfuture();
//             }, 1000);
//         }
//     });
// });

// observer.observe(element, {
//     attributes: true,
// });

// let element = document.querySelector('#header-toolbar-symbol-search');
//
// setTimeout(() =>{
//     console.log(element);
// }, 10000);

// window.onload = function () {
//     //var e = document.getElementById("db_info");
//     //e.innerHTML='Found you';
//     let element = document.querySelector("#header-toolbar-symbol-search");
//     console.log(element);
// };

// window.addEventListener("unload", function () {
//     let element = document.querySelector("#header-toolbar-symbol-search");
//     console.log(element);
//     // navigator.sendBeacon("/analytics", JSON.stringify(analyticsData));
// });

// $(document).ready(function () {
//     $(document).on('click','.listContainer-dlewR1s1',function(){
//         alert('')
//     });
// });

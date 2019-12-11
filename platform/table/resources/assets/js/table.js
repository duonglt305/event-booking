showTableLoading = function () {
    $("#table-builder-container").block({
        overlayCSS: {
            backgroundColor: "#ffffff9c",
            opacity: 0.8,
            zIndex: 9999999,
            cursor: "wait"
        },
        css: {
            border: 0,
            color: "#fff",
            padding: 0,
            zIndex: 9999999,
            backgroundColor: "transparent"
        },
        message: null
    });
};

hideTableLoading = function () {
    $("#table-builder-container").unblock();
};

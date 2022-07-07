const getDataPay = (url) => {
    fetch(url, {
        method: "GET",
    })
        .then((res) => res.text())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            let idcontent = document.getElementById("idcontent");
            idcontent.innerHTML = response;
            console.log("Success:", response);
        });
};

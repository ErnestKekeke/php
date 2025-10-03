
let id = 0;
let count = 5;
let btnAuto = document.getElementById('auto_btn');
let pMsg = document.getElementById('p_msg');
let updSec = document.getElementById('upd_sec');
let searchCity = document.getElementById('search_city');
let btnSearch = document.getElementById('search_btn');


let ct = document.getElementById("ct");
let lat = document.getElementById("lat");
let lon = document.getElementById("lon");
let d = document.getElementById("d");
let t = document.getElementById("t");
let T = document.getElementById("T");
let ws = document.getElementById("ws");
let wd = document.getElementById("wd");
let ds = document.getElementById("ds");


console.log(ct.innerHTML);
console.log(lat.innerHTML);
console.log(lon.innerHTML);
console.log(d.innerHTML);
console.log(t.innerHTML);
console.log(T.innerHTML);
console.log(ws.innerHTML);
console.log(wd.innerHTML);
console.log(ds.innerHTML);


btnSearch.addEventListener('click', function () {
    searchCity.value = searchCity.value.trim();
    var regCity = /^[a-zA-Z]{1,20}[a-zA-Z _]{1,20}[a-zA-Z]{1,20}$/;
    if (!regCity.test(searchCity.value)) {
        alert(searchCity.value + " City or Town, is invalid");
        return;
    }
    getWeather(searchCity.value);
})

btnAuto.addEventListener('dblclick', function () {
    if (btnAuto.value == 'stop') {
        btnAuto.innerHTML = "STOP";
        btnAuto.value = 'start';
        btnAuto.style.backgroundColor = "red";
        console.log("Weather auto update is running!");
        if (pMsg != null) pMsg.innerHTML = "";

        updSec.disabled = true;
        btnSearch.disabled = true;
        id = window.setInterval(weatherAuto, 1000 * parseInt(updSec.value));
    }
})

btnAuto.addEventListener('click', function () {
    if (btnAuto.value == 'start') {
        btnAuto.innerHTML = "START";
        btnAuto.value = 'stop';
        btnAuto.style.backgroundColor = "green";
        console.log("Weather auto update has STOP!");
        updSec.disabled = false;
        btnSearch.disabled = false;
        window.clearInterval(id);
    }
})



function getWeather(city) {
    // console.log("get weather update");

    let postData = new FormData()
    postData.append("city", city)

    const AJAX = new XMLHttpRequest()
    AJAX.open("POST", "./controllers./update_controller.php")
    AJAX.addEventListener('load', function () {
        // console.log(AJAX)           
        if (AJAX.readyState === 4 && AJAX.status === 200) {
            console.log(AJAX.response)
            let weatherString = AJAX.response.trim(); // ct, lat, lon, d, t, T, ws, wd, ds
            // console.log(weatherString == null ? "YES" : "NO");
            updateHtmlWeatherData(weatherString);
        }
    })
    AJAX.send(postData)
}


function weatherAuto() {
    // console.log("getting weather update");
    const AJAX = new XMLHttpRequest()
    AJAX.open("GET", "./controllers./auto_update_controller.php")

    AJAX.addEventListener('load', function () {
        // console.log(AJAX)           
        if (AJAX.readyState === 4 && AJAX.status === 200) {
            // console.log(AJAX.response);
            let weatherString = AJAX.response.trim(); // ct, lat, lon, d, t, T, ws, wd, ds
            // console.log(weatherString == null ? "YES" : "NO");
            updateHtmlWeatherData(weatherString);
        }
    })
    AJAX.send()
}


//.........
function updateHtmlWeatherData(inputString){
    // ct, lat, lon, d, t, T, ws, wd, ds
    if (inputString !== "") {
        let data = inputString.split(",");
        // console.log(data);
        ct.innerHTML = data[0];
        lat.innerHTML = data[1];
        lon.innerHTML = data[2];
        d.innerHTML = data[3];
        t.innerHTML = data[4];
        T.innerHTML = data[5];
        ws.innerHTML = data[6];
        wd.innerHTML = data[7];
        ds.innerHTML = data[8];
    }else{
        ct.innerHTML = "N/A";
        lat.innerHTML = "N/A";
        lon.innerHTML = "N/A";
        d.innerHTML = "N/A";
        t.innerHTML = "N/A";
        T.innerHTML = "N/A";
        ws.innerHTML = "N/A";
        wd.innerHTML = "N/A";
        ds.innerHTML = "N/A";
    }
}
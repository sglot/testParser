const URLS = {
    detail: '/detail-json?id=',
    filter: '/rating/list',
};

document.addEventListener("DOMContentLoaded", init());

function init() {
    let element = document.getElementById('dateInput');
    let maskOptions = {
        mask: '0000-00-00'
    };
    let mask = IMask(element, maskOptions);

}

let findDateBtn = document.getElementById('findDataBtn');
findDateBtn.onclick = (event) => {
    event.preventDefault();
    let dateInput = document.getElementById('dateInput');

    if (!dateInput) {
        console.error('dateInput не существует');
        return;
    }

    axios.get(URLS.filter + '?date=' + dateInput.value)
        .then(function (response) {
            // handle success
            let contentAjax = document.getElementById('content-ajax');
            if (!contentAjax) {
                console.error('contentAjax не существует');
                return;
            }
            contentAjax.innerHTML = response.data;
            console.log(response.data);
        })
        .catch(function (error) {
            // handle error
            console.log('Ошибка запроса к серверу в filterDate');
            console.log(error);
        })
};


function getDetail(originId) {

    let modal = document.getElementById('modal-content');

    if (!modal) {
        console.error('Элемент modal-content не существует');
        return;
    }

    axios.get(URLS.detail + originId)
        .then(function (response) {
            // handle success
            let res = 'Отсутствует';
            if (response.data.description) {
                res = response.data.description;
            }

            modal.innerText = res;
            console.log(modal);
            console.log(response.data);
        })
        .catch(function (error) {
            // handle error
            console.log('Ошибка запроса к серверу в getDetail');
            console.log(error);
        })
}


let count = 0;
let lastFilter = 'pos';

function fieldFilter(filter) {
    let dateInput = document.getElementById('dateInput');

    if (!dateInput) {
        console.error('dateInput не существует');
        return;
    }

    count = (filter === lastFilter ? ++count : 0);
    let sort = count % 2 === 0 ? 'asc' : 'desc';
    lastFilter = filter;

    axios.get(URLS.filter + '?date=' + dateInput.value + '&filter=' + filter + '&sort=' + sort)
        .then(function (response) {
            // handle success
            let contentAjax = document.getElementById('content-ajax');
            if (!contentAjax) {
                console.error('contentAjax не существует');
                return;
            }
            contentAjax.innerHTML = response.data;
            console.log(response.data);
        })
        .catch(function (error) {
            // handle error
            console.log('Ошибка запроса к серверу в filterDate');
            console.log(error);
        })
        .then(function () {
            // always executed
        });

}
Date.prototype.getWeek = function () {
    var onejan = new Date(this.getFullYear(), 0, 1);
    var today = new Date(this.getFullYear(), this.getMonth(), this.getDate());
    var dayOfYear = ((today - onejan + 86400000) / 86400000);
    week = (dayOfYear % 7) > 0 ? dayOfYear % 7 : 7;

    switch (week) {
        case 1: week = 'Lun'; break;
        case 2: week = 'Mar'; break;
        case 3: week = 'Mer'; break;
        case 4: week = 'Gio'; break;
        case 5: week = 'Ven'; break;
        case 6: week = 'Sab'; break;
        case 7: week = 'Dom'; break;
    }
    return week;
};

function metto_lo_zero(x) {
    x = (x < 10) ? '0' + x : x;
    return x;
}

function dateFromArray(arrayDate) {
    g = parseInt(arrayDate[0].charAt(0) + arrayDate[0].charAt(1))
    m = parseInt(arrayDate[1].charAt(0) + arrayDate[1].charAt(1))
    a = arrayDate[2];
    date = new Date(a, m - 1, g);
    return date;
}

function arrayDate(date) {
    array = [];
    array[0] = date.getDate();
    array[1] = date.getMonth() + 1;
    array[2] = date.getFullYear();

    array[0] = metto_lo_zero(array[0]);
    array[1] = metto_lo_zero(array[1]);
    return array;
}

function getGiorniSuccessivi(date, succ) {
    g = parseInt(date.getDate());
    m = parseInt(date.getMonth());
    a = parseInt(date.getFullYear());

    domani = new Date(a, m, g);
    domani.setDate(domani.getDate() + succ);

    return domani;
}

function rangeDate(date) {
    
    oggi=(date==null)?new Date():date;
    rangeDate=[];   
    succ = oggi;
    rangeDate[0]='oggi';
    for (i = 1; i < 8; i++) {
        succ = getGiorniSuccessivi(succ, 1);
        rangeDate[i]=succ.getWeek();
    }
    return rangeDate;
}


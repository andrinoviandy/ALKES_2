// var tgl1 = getVars("tgl1");
// var tgl2 = getVars("tgl2");
var mutasi = getVars("mutasi");

async function hitungBaris(keyword) {
    let jmll = 0;
    const page = getVars("page").replace('#', '');
    if (keyword == '') {
        if (tgl1 === undefined && tgl2 === undefined) {
            if (mutasi === undefined) {
                await $.get("json/" + page + ".php",
                    function (data) {
                        jmll = data;
                    }
                );
            } else {
                await $.get("json/" + page + ".php?mutasi" + mutasi,
                    function (data) {
                        jmll = data;
                    }
                );
            }
        } else {
            if (mutasi === undefined) {
                await $.get("json/" + page + ".php?tgl1=" + tgl1 + "&tgl2=" + tgl2,
                    function (data) {
                        jmll = data;
                    }
                );
            } else {
                await $.get("json/" + page + ".php?tgldari=" + tgl1 + "&tglsampai=" + tgl2 + "&mutasi" + mutasi,
                    function (data) {
                        jmll = data;
                    }
                );
            }
        }
    } else {
        if (tgl1 === undefined && tgl2 === undefined) {
            if (mutasi === undefined) {
                await $.get("json/" + page + ".php?cari=" + keyword,
                    function (data) {
                        jmll = data;
                    }
                );
            } else {
                await $.get("json/" + page + ".php?cari=" + keyword + "&mutasi" + mutasi,
                    function (data) {
                        jmll = data;
                    }
                );
            }
        } else {
            if (mutasi === undefined) {
                await $.get("json/" + page + ".php?cari=" + keyword + "&tgl1=" + tgl1 + "&tgl2=" + tgl2,
                    function (data) {
                        jmll = data;
                    }
                );
            } else {
                await $.get("json/" + page + ".php?cari=" + keyword + "&tgldari=" + tgl1 + "&tglsampai=" + tgl2 + "&mutasi" + mutasi,
                    function (data) {
                        jmll = data;
                    }
                );
            }
        }
    }
    jumlah_total = jmll;
}

async function loadMore(start, keyword) {
    await hitungBaris(keyword)
    const page = getVars("page").replace('#', '');
    // console.log('tgl1', tgl1);
    // console.log('tgl2', tgl2);
    if (keyword == '') {
        if (tgl1 === undefined && tgl2 === undefined) {
            if (mutasi === undefined) {
                $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&tampil=" + tampil,
                    function (data) {
                        $('#table').html(data);
                    }
                );
            } else {
                $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&tampil=" + tampil + "&mutasi=" + mutasi,
                    function (data) {
                        $('#table').html(data);
                    }
                );

            }
        } else {
            if (mutasi === undefined) {
                $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&tampil=" + tampil + "&tgl1=" + tgl1 + "&tgl2=" + tgl2,
                    function (data) {
                        $('#table').html(data);
                    }
                );
            } else {
                $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&tampil=" + tampil + "&tgl1=" + tgl1 + "&tgl2=" + tgl2 + "&mutasi=" + mutasi,
                    function (data) {
                        $('#table').html(data);
                    }
                );
            }
        }
    } else {
        if (tgl1 === undefined && tgl2 === undefined) {
            if (mutasi === undefined) {
                $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&tampil=" + tampil,
                    function (data) {
                        $('#table').html(data);
                    }
                );
            } else {
                $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&tampil=" + tampil + "&mutasi=" + mutasi,
                    function (data) {
                        $('#table').html(data);
                    }
                );
            }
        } else {
            if (mutasi === undefined) {
                $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&tampil=" + tampil + "&tgl1=" + tgl1 + "&tgl2=" + tgl2,
                    function (data) {
                        $('#table').html(data);
                    }
                );
            } else {
                $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&tampil=" + tampil + "&tgl1=" + tgl1 + "&tgl2=" + tgl2 + "&mutasi=" + mutasi,
                    function (data) {
                        $('#table').html(data);
                    }
                );
            }
        }
    }
    cekPaging(start)
    if (jumlah_total <= jumlah_limit) {
        dari.innerText = 1
        sampai.innerText = jumlah_total
    } else {
        if (start == 0) {
            dari.innerText = 1
            sampai.innerText = jumlah_limit
        }
        else {
            if (jumlah_total - start < jumlah_limit) {
                dari.innerText = start + 1
                sampai.innerText = jumlah_total
            } else {
                dari.innerText = start + 1
                sampai.innerText = start + jumlah_limit
            }
        }
    }
}
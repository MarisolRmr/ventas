function exportToPDF(tipo) {
    var maintable = document.getElementById('example');
    var pdfout = document.getElementById('pdfout');
    var doc = new jsPDF('p', 'pt', 'letter');
    var margin = 20;
    var scale = (doc.internal.pageSize.width - margin * 2) / document.body.clientWidth;
    var scale_mobile = (doc.internal.pageSize.width - margin * 2) / document.body.getBoundingClientRect();

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        doc.html(maintable, {
            x: margin,
            y: margin,
            html2canvas: {
                scale: scale,
                ignoreElements: function (element) {
                    return element.classList.contains('exclude-column');
                }
            },
            callback: function (doc) {
                doc.save(tipo + '.pdf');
            }
        });
    } else {
        doc.html(maintable, {
            x: margin,
            y: margin,
            html2canvas: {
                scale: scale,
                ignoreElements: function (element) {
                    return element.classList.contains('exclude-column');
                }
            },
            callback: function (doc) {
                doc.save(tipo + '.pdf');
            }
        });
    }
}


function exportToExcel(tipo) {
    const table = document.querySelector('.table');
    const ws = XLSX.utils.table_to_sheet(table);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Marcas');
    XLSX.writeFile(wb, tipo + '.xlsx');
}
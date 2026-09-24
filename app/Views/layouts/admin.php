<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - SMAN 1 Semarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800 font-sans">

    <!-- Sidebar -->
    <?= $this->include('partials/sidebar_admin') ?>

    <!-- Kontainer Utama -->
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
        
        <?= $this->include('partials/topbar_admin') ?>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            <?= $this->renderSection('content') ?>
        </main>

    </div>
<script>
// FUNGSI EXPORT EXCEL GLOBAL (Client-Side)
function exportToExcel(tableId, filename) {
    let table = document.getElementById(tableId);
    let html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    html += '<head><meta charset="UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    html += '<x:Name>Sheet 1</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>';
    html += '</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>';
    html += '<table border="1">';
    
    let rows = table.querySelectorAll('tr');
    rows.forEach(row => {
        // Jangan ekspor baris yang disembunyikan oleh filter
        if (row.style.display !== 'none') { 
            html += '<tr>';
            let cols = row.querySelectorAll('th, td');
            // Abaikan kolom terakhir (Aksi)
            let colCount = cols.length > 1 ? cols.length - 1 : cols.length; 
            
            for (let i = 0; i < colCount; i++) {
                // Bersihkan teks dari label-label berlebih
                let cellText = cols[i].innerText.replace(/Akun:|Belum Punya Akun/g, '').trim();
                html += `<td>${cellText}</td>`;
            }
            html += '</tr>';
        }
    });
    
    html += '</table></body></html>';
    
    let blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    let a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = filename + '_' + new Date().toISOString().slice(0,10) + '.xls';
    a.click();
}
</script>
</body>
</html>
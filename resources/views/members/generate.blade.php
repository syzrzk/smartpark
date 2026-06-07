@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="text-white mb-3">Generate QR Code Member</h4>

                    <div class="mb-3">
                        <label class="form-label text-white">Plat Nomor</label>
                        <input id="platInput" class="form-control" placeholder="e.g. B 1234 CD">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white">Warna QR (hex tanpa #)</label>
                        <input id="colorInput" class="form-control" placeholder="000000" value="000000">
                    </div>

                    <div class="mb-3 d-flex gap-2">
                        <button id="btnPreview" class="btn btn-primary">Preview QR</button>
                        <button id="btnDownload" class="btn btn-success" disabled>Download QR</button>
                        <button id="btnPrint" class="btn btn-secondary" disabled>Print</button>
                    </div>

                    <div id="previewWrap" class="mt-3 text-center" style="display:none;">
                        <div class="p-3 bg-white d-inline-block rounded">
                            <img id="qrPreviewImg" src="" alt="QR Preview">
                        </div>
                        <div class="mt-2 text-white" id="qrText"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function buildQrUrl(data, color) {
        const base = 'https://api.qrserver.com/v1/create-qr-code/';
        const size = '200x200';
        return `${base}?size=${size}&data=${encodeURIComponent(data)}&color=${color}&bgcolor=ffffff`;
    }

    document.getElementById('btnPreview').addEventListener('click', function(e){
        e.preventDefault();
        const plat = document.getElementById('platInput').value.trim();
        if (!plat) {
            alert('Masukkan plat nomor terlebih dahulu');
            return;
        }
        const color = (document.getElementById('colorInput').value || '000000').replace('#','');
        const qrData = `MEMBER-${plat}`;
        const url = buildQrUrl(qrData, color);
        const img = document.getElementById('qrPreviewImg');
        img.src = url;
        document.getElementById('qrText').textContent = qrData;
        document.getElementById('previewWrap').style.display = 'block';
        document.getElementById('btnDownload').disabled = false;
        document.getElementById('btnPrint').disabled = false;
    });

    document.getElementById('btnDownload').addEventListener('click', function(){
        const plat = document.getElementById('platInput').value.trim();
        const color = (document.getElementById('colorInput').value || '000000').replace('#','');
        const qrData = `MEMBER-${plat}`;
        const url = buildQrUrl(qrData, color);
        fetch(url)
            .then(r => r.blob())
            .then(blob => {
                const blobUrl = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = `QR_MEMBER_${qrData}.png`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(blobUrl);
            });
    });

    document.getElementById('btnPrint').addEventListener('click', function(){
        const img = document.getElementById('qrPreviewImg');
        const w = window.open('','_blank');
        w.document.write('<html><head><title>Print QR</title></head><body style="display:flex;align-items:center;justify-content:center">');
        w.document.write(`<img src="${img.src}" style="max-width:300px;">`);
        w.document.write('</body></html>');
        w.document.close();
        w.focus();
        w.print();
    });
</script>
@endsection
